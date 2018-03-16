<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class DemandeNewsletterAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'admin_demande_newsletter';
    protected $baseRoutePattern = 'demande_newsletter';

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
            ->add('email', 'text', [
                'label' => 'demande_newsletter.liste.email',
                'sortable' => 'name'
            ])
            ->add('timestampCreation', 'date', [
                'label' => 'demande_newsletter.liste.timestampCreation'
            ])
            ->add('_action', null, array(
                'actions' => array(
                    'delete' => array(),
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
            ->add('email')
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
            ->add('email', null, [
                'label' => 'demande_newsletter.liste.email'
            ])
            ->add('timestampCreation', null, [
                'label' => 'demande_newsletter.liste.timestampCreation'
            ]);
    }


    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'delete', 'export', 'batch'));
    }
}
