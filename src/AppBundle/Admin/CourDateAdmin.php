<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;


use AppBundle\Entity\CourDate;

class CourDateAdmin extends AbstractAdmin
{
    protected $baseRouteName    = 'admin_cour_date';
    protected $baseRoutePattern = 'cour_date';

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
                'label' => 'cour_date.liste.titre'
            ])
            ->add('jourFr', 'html', [
                'label' => 'cour_date.liste.jour',
            ])
            ->add('heureDebut', 'date', [
                'label'     => 'cour_date.liste.heureDebut',
                'format'=>'HH:mm',
            ])
            ->add('heureFin', 'date', [
                'label'     => 'cour_date.liste.heureFin',
                'format'=>'HH:mm',
            ])
            ->add('date', 'date', [
                'label'     => 'cour_date.liste.date'
            ])
            ->add('repetitionFr', 'html', [
                'label' => 'cour_date.liste.repetion',
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
                'name'          => $this->trans('cour_date.with.dates')
            ])
            ->add('nom', 'text', [
                'label' => 'cour_date.nom',
                'attr'  => [
                    'placeholder' => 'cour_date.placeholder.nom'
                ],
                'required' => true
            ])
            ->add('jour', 'choice', [
                'choices' => [
                    $this->trans('cour_date.jour.dimanche') => 0,
                    $this->trans('cour_date.jour.lundi')    => 1,
                    $this->trans('cour_date.jour.mardi')    => 2,
                    $this->trans('cour_date.jour.mercredi') => 3,
                    $this->trans('cour_date.jour.jeudi')    => 4,
                    $this->trans('cour_date.jour.vendredi') => 5,
                    $this->trans('cour_date.jour.samedi')   => 6,
                ],
                'label' => 'cour_date.jour',
                'attr' => [
                    'placeholder' => $this->trans('cour_date.placeholder.jour')
                ],
                'expanded' => false,
                'multiple' => false,
                'required' => true
            ])
            ->add('heureDebut', 'time', [
                'label' => 'cour_date.heure_debut',
                'attr'  => [
                    'placeholder' => $this->trans('cour_date.placeholder.heure_debut')
                ],
                'required' => true
            ])
            ->add('heureFin', 'time', [
                'label' => 'cour_date.heure_fin',
                'attr'  => [
                    'placeholder' => $this->trans('cour_date.placeholder.heure_fin')
                ],
                'required' => true
            ])
            ->add('date', 'sonata_type_date_picker', [
                'label' => 'cour_date.date',
                'dp_language'=>'fr',
                'format'=>'dd/MM/yyyy',
                'attr'  => [
                    'placeholder' => $this->trans('cour_date.placeholder.date')
                ],
                'required' => true
            ])
            ->add('repetition', 'choice', [
                'choices' => [
                    $this->trans('cour_date.repetition.aucune')    => 0,
                    $this->trans('cour_date.repetition.hebdo')     => 1,
                    $this->trans('cour_date.repetition.bihebdo')   => 2
                ],
                'label' => 'cour_date.repetition',
                'attr' => [
                    'placeholder' => $this->trans('cour_date.placeholder.repetition')
                ],
                'expanded' => false,
                'multiple' => false,
                'required' => true
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
            ->add('nom')
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
            ->add('nom')
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
        return $object instanceof CourDate
            ? $object->getNom()
            : $this->trans('cour_date.add_edit.to_string');
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
    }
}
