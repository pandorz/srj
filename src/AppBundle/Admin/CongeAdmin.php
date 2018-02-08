<?php

namespace AppBundle\Admin;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Oh\GoogleMapFormTypeBundle\Form\Type\GoogleMapType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;


use AppBundle\Entity\Conge;
use AppBundle\Entity\Utilisateur;

class CongeAdmin extends AbstractAdmin
{
    protected $baseRouteName    = 'admin_conge';
    protected $baseRoutePattern = 'conge';

    public $supportsPreviewMode = false;

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
            ->addIdentifier('nom', 'text', [
                'label' => 'conge.liste.nom'
            ])
            ->add('dateDebut', 'date', [
                'label'     => 'conge.liste.dateDebut'
            ])
            ->add('dateFin', 'date', [
                'label'     => 'conge.liste.dateFin'
            ])
            ->add('_action', null, array(
                'actions' => array(
                    'edit' => array(),
                    'clone' => array(
                        'template' => ':AdminCustom/button:clone.html.twig',
                        'data'     => '1',
                    ),
                    'delete' => array(),
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
        $formMapper
            ->with('Content', [
                'name'          => $this->trans('conge.with.details'),
                'class'         => 'col-md-7'
            ])
            ->add('nom', 'text', [
                'label' => 'conge.nom',
                'attr'  => [
                    'placeholder' => 'conge.placeholder.nom'
                ]
            ])
            ->add('dateDebut', 'sonata_type_date_picker', [
                'label' => 'conge.dateDebut',
                'dp_language'=>'fr',
                'format'=>'dd/MM/yyyy',
                'attr'  => [
                    'placeholder' => $this->trans('conge.placeholder.dateDebut')
                ],
                'required' => true
            ])
            ->add('dateFin', 'sonata_type_date_picker', [
                'label' => 'conge.dateFin',
                'dp_language'=>'fr',
                'format'=>'dd/MM/yyyy',
                'attr'  => [
                    'placeholder' => $this->trans('conge.placeholder.dateFin')
                ],
                'required' => true
            ])
            ->end()
        ;
    }

    /**
     * Fields to be shown on show action
     *
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('nom')
            ->add('dateDebut')
            ->add('dateFin')
        ;
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
                'label' => 'conge.liste.nom'
            ])
            ->add('dateDebut', null, [
                'label' => 'conge.liste.dateDebut'
            ])
            ->add('dateFin', null, [
                'label' => 'conge.liste.dateFin'
            ])
        ;
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
        return $object instanceof Conge
            ? $object->getNom()
            : $this->trans('conge.add_edit.to_string');
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
        $collection->add('clone', $this->getRouterIdParameter().'/clone');
    }
}
