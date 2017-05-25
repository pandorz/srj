<?php

namespace AppBundle\Admin;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;


use AppBundle\Entity\Cour;
use AppBundle\Entity\Utilisateur;

class CourAdmin extends AbstractAdmin
{
    protected $baseRouteName    = 'admin_cour';
    protected $baseRoutePattern = 'cour';

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
                'label' => 'cour.liste.nom'
            ])
            ->add('affiche', 'boolean', [
                'label' => 'cour.liste.affiche',
            ])
            ->add('annule', 'boolean', [
                'label' => 'cour.liste.annule',
            ])
            ->add('professeur', 'many_to_one', [
                'label'     => 'cour.liste.professeur',
                'route'     => ['name' => 'show'],
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
                'name'          => $this->trans('cour.with.details'),
                'class'         => 'col-md-7'
            ])
            ->add('nom', 'text', [
                'label' => 'cour.nom',
                'attr'  => [
                    'placeholder' => 'cour.placeholder.nom'
                ]
            ])
            ->add('affiche', 'checkbox', [
                'label' => 'cour.actif',
                'attr'  => [
                    'placeholder' => 'cour.placeholder.actif'
                ]
            ])
            ->add('annule', 'checkbox', [
                'label' => 'cour.annule',
                'attr'  => [
                    'placeholder' => 'cour.placeholder.annule'
                ]
            ])            
            ->add('contenu', CKEditorType::class, [
                'label' => 'cour.contenu',
                'attr'  => [
                    'placeholder' => 'cour.placeholder.contenu'
                ]
            ])            
            ->end() 
            ->with('Meta data', [
                'name'      => $this->trans('cour.with.meta_data'),
                 'class'     => 'col-md-5'
            ])
            ->add('professeur', 'sonata_type_model_autocomplete', [
                'class'     => Utilisateur::class,
                'property'  => 'slug',
                'label'     => 'cour.professeur',
                'multiple'  => false,
                'placeholder' => 'cour.placeholder.professeur'
            ])
            ->add('users', 'sonata_type_model_autocomplete', [
                'class'     => Utilisateur::class,
                'property'  => 'slug',
                'label'     => 'cour.users',
                'multiple'  => true,
                'placeholder' => 'cour.placeholder.users'
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
            ->add('affiche')
            ->add('annule')   
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
            ->add('professeur', null, [], 'entity', [
                'class'         => Utilisateur::class,
                'choice_label'  => 'nom',
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
        return $object instanceof Cour
            ? $object->getNom()
            : $this->trans('cour.add_edit.to_string');
    }
}
