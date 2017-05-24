<?php

namespace AppBundle\Admin;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;


use AppBundle\Entity\Sortie;
use AppBundle\Entity\Utilisateur;

class SortieAdmin extends AbstractAdmin
{
    protected $baseRouteName    = 'admin_sortie';
    protected $baseRoutePattern = 'sortie';

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
                'label' => 'sortie.liste.nom'
            ])
            ->add('affiche', 'boolean', [
                'label' => 'sortie.liste.affiche',
            ])
            ->add('annule', 'boolean', [
                'label' => 'sortie.liste.annule',
            ])
            ->add('reserveMembre', 'boolean', [
                'label' => 'sortie.liste.annule',
            ])
            ->add('nbPlace', 'integer', [
                'label' => 'sortie.liste.nb_place',
            ])
            ->add('date', 'date', [
                'label' => 'sortie.liste.date',
                'sortable'  => 'name'
            ])
            ->add('dateLimite', 'date', [
                'label' => 'sortie.liste.dateLimite',
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
                'name'          => $this->trans('sortie.add_edit.details'),
                'class'         => 'col-md-7'
            ])
            ->add('nom', 'text', [
                'label' => 'sortie.nom',
                'attr'  => [
                    'placeholder' => 'sortie.placeholder.nom'
                ]
            ])
            ->add('affiche', 'checkbox', [
                'label' => 'sortie.actif',
                'attr'  => [
                    'placeholder' => 'sortie.placeholder.actif'
                ]
            ])
            ->add('annule', 'checkbox', [
                'label' => 'sortie.annule',
                'attr'  => [
                    'placeholder' => 'sortie.placeholder.annule'
                ]
            ])
            ->add('reserveMembre', 'checkbox', [
                'label' => 'sortie.reserve_membre',
                'attr'  => [
                    'placeholder' => 'sortie.placeholder.reserve_membre'
                ]
            ])
            ->add('nbPlace', 'integer', [
                'label' => 'sortie.nb_place',
                'attr'  => [
                    'placeholder' => 'sortie.placeholder.nb_place'
                ]
            ])
            ->add('prix', 'text', [
                'label' => 'sortie.prix',                
                'attr'  => [
                    'placeholder' => 'sortie.placeholder.prix'
                ]
            ])
            ->add('contenu', CKEditorType::class, [
                'label' => 'sortie.contenu',
                'attr'  => [
                    'placeholder' => 'sortie.placeholder.contenu'
                ]
            ])            
            ->end()
            ->with('Meta data', [
                'name'      => $this->trans('sortie.add_edit.meta_data'),
                'class'     => 'col-md-5'
            ])
            ->add('superviseurs', 'sonata_type_model_autocomplete', [
                'class'     => Utilisateur::class,
                'property'  => 'slug',
                'label'     => 'sortie.superviseurs',
                'multiple'  => true,
                'placeholder' => 'sortie.placeholder.superviseurs'
            ])
            ->add('date', 'sonata_type_datetime_picker', [
                'label' => 'sortie.date',
                'attr'  => [
                    'placeholder' => $this->getTranslationLabel('sortie.placeholder.date')
                ]
            ])
            ->add('dateLimite', 'sonata_type_datetime_picker', [
                'label' => 'sortie.date_limite',
                'attr'  => [
                    'placeholder' => $this->getTranslationLabel('sortie.placeholder.date_limite')
                ]
            ])
            ->add('image', 'sonata_media_type', array(
                'label' => 'sortie.image',
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
            ->add('nbPlace')
            ->add('reserveMembre')
            ->add('prix')    
            ->add('date')
            ->add('dateLimite')    
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
            ->add('nbPlace')
            ->add('reserveMembre')
            ->add('prix')
            ->add('date')
            ->add('dateLimite')
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
        return $object instanceof Sortie
            ? $object->getNom()
            : $this->trans('sortie.add_edit.to_string');
    }
}
