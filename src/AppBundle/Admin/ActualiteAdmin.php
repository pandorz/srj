<?php

namespace AppBundle\Admin;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;


use AppBundle\Entity\Actualite;
use AppBundle\Entity\Utilisateur;

class ActualiteAdmin extends AbstractAdmin
{
    protected $baseRouteName    = 'admin_actualite';
    protected $baseRoutePattern = 'actualite';

    public $supportsPreviewMode = false;



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
                'label' => 'actualite.liste.affiche',
            ])
            ->add('annule', 'boolean', [
                'label' => 'actualite.liste.annule',
            ])
            ->add('dateDebut', 'date', [
                'label' => 'actualite.liste.dateDebut',
                'sortable'  => 'name'
            ])
            ->add('dateFin', 'date', [
                'label' => 'actualite.liste.dateFin',
                'sortable'  => 'name'
            ])
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
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
                ]
            ])
            ->add('annule', 'checkbox', [
                'label' => 'actualite.annule',
                'attr'  => [
                    'placeholder' => 'actualite.placeholder.annule'
                ]
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
                'property'  => 'slug',
                'label'     => 'actualite.superviseurs',
                'multiple'  => true,
                'placeholder' => 'actualite.placeholder.superviseurs'
            ])
            ->add('dateDebut', 'sonata_type_datetime_picker', [
                'label' => 'actualite.date_debut',
                'attr'  => [
                    'placeholder' => $this->getTranslationLabel('actualite.placeholder.date_debut')
                ]
            ])
            ->add('dateFin', 'sonata_type_datetime_picker', [
                'label' => 'actualite.date_fin',
                'attr'  => [
                    'placeholder' => $this->getTranslationLabel('actualite.placeholder.date_fin')
                ]
            ])
            ->add('image', 'sonata_media_type', array(
                'label' => 'actualite.image',
                'provider' => 'sonata.media.provider.image',
                'context'  => 'image'
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
            ->add('utilisateurCreation')
            ->add('utilisateurModification')
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
            ->add('affiche')
            ->add('annule')
            ->add('dateDebut')
            ->add('dateFin')
        ;
    }

    /**
     * @param mixed $page
     */
    public function prePersist($page)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $page->setUtilisateurCreation($user->__toString());
    }

    /**
     * @param mixed $page
     */
    public function preUpdate($page)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $page->setUtilisateurModification($user->__toString());
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
}
