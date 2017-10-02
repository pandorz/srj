<?php

namespace AppBundle\Controller;


use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class BaseController
 * @package AppBundle\Controller
 */
class BaseController extends Controller
{
    public function cloneAction($id)
    {
        $object = $this->admin->getSubject();

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }

        // Be careful, you may need to overload the __clone method of your object
        // to set its id to null !
        $clonedObject = clone $object;

        $clonedObject->setNom($object->getNom().' (Clone)');
        $clonedObject->setSlug($clonedObject->getSlug().'-clone');
        $clonedObject->setImage(null);

        $this->admin->create($clonedObject);

        $this->addFlash('sonata_flash_success', 'Duplication réussie');

        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}
