<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class DemandeAccesAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'admin_demande_acces';
    protected $baseRoutePattern = 'demande_acces';

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
            ->add('numeroMembre', 'text', [
                'label' => 'demande_acces.liste.numeroMembre',
                'sortable' => 'name'
            ])
            ->add('timestampCreation', 'date', [
                'label' => 'demande_acces.liste.timestampCreation'
            ])
            ->add('_action', null, array(
                'actions' => array(
                    'delete' => array(),
                    'accept' => array(
                        'template' => ':AdminCustom/button:accept.html.twig',
                        'data'     => '1',
                    )
                )
            ));
    }

    /**
     * Fields to be shown on show action
     *
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('numeroMembre')
            ->add('timestampCreation');
    }

    /**
     * Fields to be shown on filter forms
     *
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('numeroMembre', null, [
                'label' => 'demande_acces.liste.numeroMembre'
            ])
            ->add('timestampCreation', null, [
                'label' => 'demande_acces.liste.timestampCreation'
            ]);
    }


    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'delete', 'export', 'batch'));
        $collection->add('accept', 'accept/{id}');
    }
}
