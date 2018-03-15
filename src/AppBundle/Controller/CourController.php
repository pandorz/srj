<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CourController
 * @package AppBundle\Controller
 */
class CourController extends BaseController
{
    public function generateGoogleCalendarAction($id)
    {
        $cour = $this->admin->getSubject();

        if (!$cour) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }

        $googleCalendar = $this->container->get('app.generate_calendar');
        $googleCalendar->newCalendar($cour);


        $this->addFlash(
            'sonata_flash_success',
            'Un nouveau calendrier a été créé dans le compte Google de l\'association'
        );

        return new RedirectResponse($this->admin->generateUrl('edit', ['id' => $id]));
    }
}
