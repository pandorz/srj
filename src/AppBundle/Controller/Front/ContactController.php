<?php

namespace AppBundle\Controller\Front;

use AppBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ContactController
 * @package AppBundle\Controller\Front
 *
 * -------------------- *
 * @Route("/contact")
 * -------------------- *
 */
class ContactController extends BaseController
{

    /**
     * Contact
     *
     * -------------------- *
     * @Route("/", name="contact")
     * @Method({"GET", "POST"})
     * -------------------- *
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //-- Check Google Recaptcha
            try {
                $this->get('app.recaptcha')->check($request->request->get('g-recaptcha-response'));
            } catch (\Exception $e) {
                if ($e->getCode() == $this->get('app.recaptcha')->getCodeRecaptchaFailed()) {
                    $form->addError(
                        new FormError(
                            $this->getTranslator()->trans(
                                'general.error.grecaptcha.detected_as_robot',
                                [],
                                'validators'
                            )
                        )
                    );
                } else {
                    $form->addError(
                        new FormError(
                            $this->getTranslator()->trans(
                                'general.error.grecaptcha.error_on_verify',
                                [],
                                'validators'
                            )
                        )
                    );
                }
            }
            //--

            if ($form->isValid()) {
                $data = $form->getData();

                $retour_mail = $this->get('app.mailer')
                    ->setSubject($data['objet'])
                    ->setReplyTo($data['email'])
                    ->setTemplate(
                        'contact',
                        [
                            'title'     => $this->getTranslator()->trans('contact.mail.titre'),
                            'subtitle'  => $this->getTranslator()->trans('contact.mail.soustitre'),
                            'data'      => $data
                        ]
                    )
                    ->send();

                if ($retour_mail) {
                    $request
                        ->getSession()
                        ->getFlashBag()
                        ->add('success', 'Votre message a été envoyé');
                } else {
                    $request
                        ->getSession()
                        ->getFlashBag()
                        ->add('error', 'Erreur lors de l\'envoi de votre message. Réessayez ultérieument');
                }
            }
        }

        return $this->render('front/contact/contact.html.twig', ['form' => $form->createView()]);
    }
}
