<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DemandeAcces;
use AppBundle\Entity\Utilisateur;
use AppBundle\Service\Import;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class DemandeAccesController
 * @package AppBundle\Controller
 */
class DemandeAccesController extends BaseController
{
    /**
     * @param $id
     * @return RedirectResponse
     */
    public function acceptAction($id)
    {
        /** @var DemandeAcces $demandeAcces */
        $demandeAcces = $this->admin->getSubject();

        if (!$demandeAcces) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }

        $em = $this->get('doctrine.orm.entity_manager');

        /** @var Utilisateur $user */
        $user = $em->getRepository(Utilisateur::class)->findOneByMembreNumero($demandeAcces->getNumeroMembre());

        if (!empty($user)) {
            try {
                $password = Import::generatePassword();

                $user->setAccesSite(true);
                $user->setEnabled(true);
                $user->setLocked(false);
                $user->setPassword($password);

                $em->persist($user);
                $em->remove($demandeAcces);
                $em->flush();

                $data['password'] = $password;

                $this->get('app.mailer')
                    ->setTo($user->getEmail())
                    ->setSubject('Activation de votre compte')
                    ->setTemplate(
                        'activation',
                        [
                            'title' => 'Votre demande a été accepté',
                            'subtitle' => 'Vous pouvez maintenant vous connecter',
                            'data' => $data
                        ]
                    )
                    ->send();

                $this->addFlash('sonata_flash_success', 'Activation du membre réussi');
            } catch (\Exception $e) {
                $this->addFlash('sonata_flash_error', $e->getMessage());
            }
        }
        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}
