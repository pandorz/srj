<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class ImportController
 * @package AppBundle\Controller
 */
class ImportController extends BaseController
{
    /**
     * Route access to import one file, with his id of Import
     * Except if import isn't "waiting"
     *
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Doctrine\ORM\ORMException
     */
    public function importFileAction($id)
    {
        if (!is_numeric($id) || empty($id)) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }

        $importObjetController = $this->get('app.import');
        $importObjetController->importFile($id);

        return $this->redirectToRoute('admin_import_list');
    }
}
