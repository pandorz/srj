<?php

namespace AppBundle\Controller;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
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
     * @throws \Exception
     */
    public function importFileAction($id)
    {
        if (!is_numeric($id) || empty($id)) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }

        $importService = $this->get('app.import');
        $importService->execute($id);

        return $this->redirectToRoute('admin_import_list');
    }
}
