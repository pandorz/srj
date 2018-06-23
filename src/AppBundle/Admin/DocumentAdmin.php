<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Actualite;
use AppBundle\Entity\Document;
use AppBundle\Entity\Tag;
use AppBundle\Entity\Utilisateur;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Workflow\Registry;
use Symfony\Component\Workflow\Workflow;

class DocumentAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'admin_document';
    protected $baseRoutePattern = 'document';

    public $supportsPreviewMode = false;

    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by' => 'timestampCreation',
    ];

    /**
     * Fields to be shown on lists
     *
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nom', 'text', [
                'label' => 'document.liste.nom'
            ])
            ->add('_action', null, array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                )
            ));
    }

    /**
     * Fields to be shown on create/edit forms
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Content', [
                'name' => $this->trans('document.with.details'),
                'class' => 'col-md-7',
                'description' => $this->trans('document.add_edit.details.description')
            ])
            ->add('nom', 'text', [
                'label' => 'document.nom',
                'attr' => [
                    'placeholder' => 'document.placeholder.nom'
                ]
            ])
            ->add('file', 'sonata_media_type', array(
                'label' => 'document.file',
                'provider' => 'sonata.media.provider.file',
                'context' => 'file',
                'required' => true,
                'help' => $this->trans('document.helper.file')
            ))
            ->end();
    }

    /**
     * Fields to be shown on show action
     *
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('nom');
    }

    /**
     * Fields to be shown on filter forms
     *
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nom', null, [
                'label' => 'document.liste.nom'
            ]);
    }

    /**
     * @param mixed $page
     */
    public function prePersist($page)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $page->setUtilisateurCreation($user->__toString());
        $page->setTimestampCreation(new \DateTime('now'));
    }

    /**
     * @param mixed $page
     */
    public function preUpdate($page)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $page->setUtilisateurModification($user->__toString());
        $page->setTimestampModification(new \DateTime('now'));
    }

    /**
     * @param mixed $object
     *
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof Actualite
            ? $object->getNom()
            : $this->trans('document.add_edit.to_string');
    }


    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
    }
}
