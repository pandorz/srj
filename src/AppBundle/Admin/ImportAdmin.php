<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Import;
use AppBundle\Entity\UtilisateurDroits;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Validator\Constraints\File;

class ImportAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'admin_import';
    protected $baseRoutePattern = 'import';

    public $supportsPreviewMode = false;

    const PATH_EXAMPLE_FILE = 'medias/documents/';
    const NAME_EXAMPLE_FILE = 'import_membre.xlsx';

    protected $datagridValues = [
        '_sort_order'   => 'DESC',
        '_sort_by'      => 'timestampCreation',
    ];

    /**
     * Fields to be shown on lists
     *
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('fkUtilisateurDroit', 'many_to_one', [
                'label'     => 'import.liste.fkUtilisateurDroit',
                'route'     => ['name' => 'show'],
                'sortable'  => 'name'
            ])
            ->add('filename', 'text', array(
                'label'         => 'import.liste.nom_fichier'
            ))
            ->add('statutWithStyle', 'html', [
                'label' => 'import.liste.statut',
                'sortable'  => 'name'
            ])
            ->add('timestampCreation', 'datetime', [
                'label' => 'import.liste.timestamp_creation',
                'locale' => 'fr',
                'timezone' => 'Europe/Paris',
            ])
            ->add('utilisateurCreation', 'text', array(
                'label'         => 'import.liste.utilisateurCreation'
            ))
            ->add('_action', null, array(
                'actions' => array(
                    'import_objet' => array(
                        'template' => ':AdminCustom/button:import.html.twig',
                        'data'     => '1',
                    )
                )
            ))
        ;
    }

    /**
     * Fields to be shown on create/edit forms
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $fileExampleLink = realpath('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.
                'web').DIRECTORY_SEPARATOR.self::PATH_EXAMPLE_FILE.self::NAME_EXAMPLE_FILE;
        $formMapper
            ->with('Content', [
                'name'  => $this->trans('import.add_edit.details'),
                'description' => $this->trans(
                    'import.add_edit.details.description',
                    ['%url_file%' => $fileExampleLink]
                )
            ])
            ->add('fkUtilisateurDroit', 'sonata_type_model_autocomplete', [
                'class'     => UtilisateurDroits::class,
                'property'  => 'name',
                'label'     => 'import.liste.fkUtilisateurDroit',
                'placeholder' => $this->trans('import.placeholder.fkUtilisateurDroit'),
                'required'  => false
            ])
            ->add('file', 'file', array(
                'label'         => 'import.add_edit.file',
                'constraints'   => [new File(['mimeTypes' => Import::TYPE_MIME])]
            ))
            ->end();
    }


    /**
     * Fields to be shown on filter forms
     *
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('timestampCreation', null, [], null, [], ['label' => 'import.liste.timestamp_creation'])
            ->add('filename', null, [], null, [], ['label' => 'import.liste.nom_fichier'])
            ->add('statut')
            ->add('fkUtilisateurDroit', null, [], 'entity', [
                'class'         => UtilisateurDroits::class,
                'choice_label'  => 'name',
            ], ['label'     => 'import.liste.fkUtilisateurDroit'])
            ->add('utilisateurCreation', null, [], null, [], ['label' => 'import.liste.utilisateurCreation'])
        ;
    }

    /**
     * @param mixed $object
     *
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof Import && !is_null($object->getFilename())
            ? $object->getFilename()
            : $this->trans('import.add_edit.to_string');
    }

    /**
     * @param mixed $page
     */
    public function prePersist($page)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $page->setUtilisateurCreation($user->__toString());
        $page->setTimestampCreation(new \DateTime('now'));
        $page->setStatut(Import::STATUT_ATTENTE);
        $this->manageFileUpload($page);
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
        $collection->remove('delete');
        $collection->remove('edit');
        $collection->add('import_file', 'import/{id}');
    }

    /**
     * @param $objetAmdin
     */
    private function manageFileUpload($objetAmdin)
    {
        if ($objetAmdin->getFile()) {
            // update the Image to trigger file management
            $objetAmdin->refreshUpdated();
        }
    }
}
