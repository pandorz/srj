<?php

namespace AppBundle\Admin;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;


use AppBundle\Entity\Actualite;
use AppBundle\Entity\Utilisateur;

class ActualiteAdmin extends AbstractAdmin
{
    protected $baseRouteName    = 'admin_actualite';
    protected $baseRoutePattern = 'actualite';

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
                'label' => 'actualite.liste.nom'
            ])
            ->add('affiche', 'boolean', [
                'label'     => 'actualite.liste.affiche',
                'editable'  => true
            ])
            ->add('datePublication', 'date', [
                'label'     => 'actualite.liste.datePublication'
            ])
            ->add('annule', 'boolean', [
                'label'     => 'actualite.liste.annule',
                'editable'  => true
            ])
            ->add('dateDebut', 'date', [
                'label'     => 'actualite.liste.dateDebut'
            ])
            ->add('dateFin', 'date', [
                'label'     => 'actualite.liste.dateFin'
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
                'name'          => $this->trans('actualite.with.details'),
                'class'         => 'col-md-7'
            ])
            ->add('nom', 'text', [
                'label' => 'actualite.nom',
                'attr'  => [
                    'placeholder' => 'actualite.placeholder.nom'
                ]
            ])
            ->add('affiche', 'checkbox', [
                'label' => 'actualite.actif',
                'attr'  => [
                    'placeholder' => 'actualite.placeholder.actif'
                ],
                'required' => false
            ])
            ->add('datePublication', 'sonata_type_datetime_picker', [
                'label' => 'actualite.datePublication',
                'dp_language'=>'fr',
                'format'=>'dd/MM/yyyy HH:mm',
                'attr'  => [
                    'placeholder' => $this->trans('actualite.placeholder.datePublication')
                ],
                'required' => false
            ])
            ->add('annule', 'checkbox', [
                'label' => 'actualite.annule',
                'attr'  => [
                    'placeholder' => 'actualite.placeholder.annule'
                ],
                'required' => false
            ])
            ->add('contenu', CKEditorType::class, [
                'label' => 'actualite.contenu',
                'attr'  => [
                    'placeholder' => 'actualite.placeholder.contenu'
                ]
            ])
            ->end()
            ->with('Meta data', [
                'name'      => $this->trans('actualite.with.meta_data'),
                'class'     => 'col-md-5'
            ])
            ->add('superviseurs', 'sonata_type_model_autocomplete', [
                'class'     => Utilisateur::class,
                'property'  => ['firstname','lastname'],
                'label'     => 'actualite.superviseurs',
                'multiple'  => true,
                'placeholder' => $this->trans('actualite.placeholder.superviseurs'),
                'required' => false
            ])
            ->add('dateDebut', 'sonata_type_datetime_picker', [
                'label' => 'actualite.date_debut',
                'dp_language'=>'fr',
                'format'=>'dd/MM/yyyy HH:mm',
                'attr'  => [
                    'placeholder' => $this->trans('actualite.placeholder.date_debut')
                ],
                'required' => false
            ])
            ->add('dateFin', 'sonata_type_datetime_picker', [
                'label' => 'actualite.date_fin',
                'dp_language'=>'fr',
                'format'=>'dd/MM/yyyy HH:mm',
                'attr'  => [
                    'placeholder' => $this->trans('actualite.placeholder.date_fin')
                ],
                'required' => false
            ])
            ->add('image', 'sonata_media_type', array(
                'label' => 'actualite.image',
                'provider' => 'sonata.media.provider.image',
                'context'  => 'image',
                'required' => false,
            ))
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
            ->add('affiche')
            ->add('annule')
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
                'label' => 'actualite.liste.nom'
            ])
            ->add('affiche', null, [
                'label' => 'actualite.liste.nom'
            ])
            ->add('annule', null, [
                'label' => 'actualite.liste.nom'
            ])
            ->add('dateDebut', null, [
                'label' => 'actualite.liste.dateDebut'
            ])
            ->add('dateFin', null, [
                'label' => 'actualite.liste.dateFin'
            ])
            ->add('datePublication', null, [
                'label' => 'actualite.liste.datePublication'
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
        return $object instanceof Actualite
            ? $object->getNom()
            : $this->trans('actualite.add_edit.to_string');
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
        $collection->add('clone', $this->getRouterIdParameter().'/clone');
    }
}
