<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;


use AppBundle\Entity\CourReport;

class CourReportAdmin extends AbstractAdmin
{
    protected $baseRouteName    = 'admin_cour_report';
    protected $baseRoutePattern = 'cour_report';

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
            ->add('dateAnnule', 'date', [
                'label'     => 'cour_report.liste.dateAnnule'
            ])
            ->add('dateReport', 'date', [
                'label'     => 'cour_report.liste.dateReport'
            ])
            ->add('heureDebut', 'date', [
                'label'     => 'cour_report.liste.heureDebut',
                'format'=>'HH:mm',
            ])
            ->add('heureFin', 'date', [
                'label'     => 'cour_report.liste.heureFin',
                'format'=>'HH:mm',
            ])
            ->add('_action', null, array(
                'actions' => array(
                    'edit' => array(),
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
                'name'          => $this->trans('cour_report.with.reports')
            ])
            ->add('dateAnnule', 'sonata_type_date_picker', [
                'label' => 'cour_report.dateAnnule',
                'dp_language'=>'fr',
                'format'=>'dd/MM/yyyy',
                'attr'  => [
                    'placeholder' => $this->trans('cour_report.placeholder.dateAnnule')
                ],
                'required' => false
            ])
            ->add('dateReport', 'sonata_type_date_picker', [
                'label' => 'cour_report.dateReport',
                'dp_language'=>'fr',
                'format'=>'dd/MM/yyyy',
                'attr'  => [
                    'placeholder' => $this->trans('cour_report.placeholder.dateReport')
                ],
                'required' => false
            ])
            ->add('heureDebut', 'time', [
                'label' => 'cour_report.heure_debut',
                'attr'  => [
                    'placeholder' => $this->trans('cour_report.placeholder.heure_debut')
                ],
                'required' => false
            ])
            ->add('heureFin', 'time', [
                'label' => 'cour_report.heure_fin',
                'attr'  => [
                    'placeholder' => $this->trans('cour_report.placeholder.heure_fin')
                ],
                'required' => false
            ])
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
            ->add('heureDebut')
            ->add('heureFin')
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
            ->add('heureDebut')
            ->add('heureFin')
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
        return $object instanceof CourReport
            ? $object->getNom()
            : $this->trans('cour_report.add_edit.to_string');
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
    }
}
