<?php

namespace AppBundle\Admin;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;


use AppBundle\Entity\Atelier;
use AppBundle\Entity\Utilisateur;

class AtelierAdmin extends AbstractAdmin
{
    protected $baseRouteName    = 'admin_atelier';
    protected $baseRoutePattern = 'atelier';

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
                'label' => 'atelier.liste.nom'
            ])
            ->add('affiche', 'boolean', [
                'label' => 'atelier.liste.affiche',
            ])
            ->add('annule', 'boolean', [
                'label' => 'atelier.liste.annule',
            ])
            ->add('reserveMembre', 'boolean', [
                'label' => 'atelier.liste.annule',
            ])
            ->add('nbPlace', 'integer', [
                'label' => 'atelier.liste.nb_place',
            ])
            ->add('date', 'date', [
                'label' => 'atelier.liste.date',
                'sortable'  => 'name'
            ])
            ->add('dateLimite', 'date', [
                'label' => 'atelier.liste.dateLimite',
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
                'name'          => $this->trans('atelier.with.details'),
                'class'         => 'col-md-7'
            ])
            ->add('nom', 'text', [
                'label' => 'atelier.nom',
                'attr'  => [
                    'placeholder' => 'atelier.placeholder.nom'
                ]
            ])
            ->add('affiche', 'checkbox', [
                'label' => 'atelier.actif',
                'attr'  => [
                    'placeholder' => 'atelier.placeholder.actif'
                ],
                'required' => false
            ])
            ->add('annule', 'checkbox', [
                'label' => 'atelier.annule',
                'attr'  => [
                    'placeholder' => 'atelier.placeholder.annule'
                ],
                'required' => false
            ])
            ->add('reserveMembre', 'checkbox', [
                'label' => 'atelier.reserve_membre',
                'attr'  => [
                    'placeholder' => 'atelier.placeholder.reserve_membre'
                ],
                'required' => false
            ])
            ->add('nbPlace', 'integer', [
                'label' => 'atelier.nb_place',
                'attr'  => [
                    'placeholder' => 'atelier.placeholder.nb_place'
                ]
            ])
            ->add('prixMembre', 'text', [
                'label' => 'atelier.prixMembre',                
                'attr'  => [
                    'placeholder' => 'atelier.placeholder.prixMembre'
                ]
            ])
            ->add('prix', 'text', [
                'label' => 'atelier.prix',                
                'attr'  => [
                    'placeholder' => 'atelier.placeholder.prix'
                ]
            ])
            ->add('contenu', CKEditorType::class, [
                'label' => 'atelier.contenu',
                'attr'  => [
                    'placeholder' => 'atelier.placeholder.contenu'
                ]
            ])            
            ->end()
            ->with('Meta data', [
                'name'      => $this->trans('atelier.with.meta_data'),
                'class'     => 'col-md-5'
            ])
            ->add('superviseurs', 'sonata_type_model_autocomplete', [
                'class'     => Utilisateur::class,
                'property'  => 'slug',
                'label'     => 'atelier.superviseurs',
                'multiple'  => true,
                'placeholder' => 'atelier.placeholder.superviseurs'
            ])
            ->add('date', 'sonata_type_datetime_picker', [
                'label' => 'atelier.date',
                'attr'  => [
                    'placeholder' => $this->getTranslationLabel('atelier.placeholder.date')
                ]
            ])
            ->add('dateLimite', 'sonata_type_datetime_picker', [
                'label' => 'atelier.date_limite',
                'attr'  => [
                    'placeholder' => $this->getTranslationLabel('atelier.placeholder.date_limite')
                ]
            ])
            ->add('image', 'sonata_media_type', array(
                'label' => 'atelier.image',
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
        return $object instanceof Atelier
            ? $object->getNom()
            : $this->trans('atelier.add_edit.to_string');
    }
}
