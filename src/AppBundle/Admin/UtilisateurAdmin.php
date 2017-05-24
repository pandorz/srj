<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\UserBundle\Admin\Entity\UserAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

use AppBundle\Entity\Utilisateur;

class UtilisateurAdmin extends UserAdmin
{
    protected $baseRouteName    = 'admin_utilisateur';
    protected $baseRoutePattern = 'utilisateur';

    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);
        $listMapper
                ->add('parent', 'many_to_one', [
                'label'     => 'utilisateur.liste.parent',
                'route'     => ['name' => 'show'],
                'sortable'  => 'name'
            ]);
    }
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        $formMapper
            ->tab($this->trans('utilisateur.tab.sousUtilisateurs'))
            ->with('content_sousUtilisateur', [
                'name'          => $this->trans('utilisateur.content.sousUtilisateurs'),
                'description'   => $this->trans('utilisateur.description.sousUtilisateurs')
            ])
            ->add('sousUtilisateurs', 'sonata_type_model_list', [
                'label'     => 'utilisateur.sousUtilisateurs',
                'required'  => false,
            ],[                
                'edit'          => 'inline',
                'inline'        => 'table',
                'sortable'      => 'position'           
            ])
            ->end()
            ->end();
        
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        parent::configureDatagridFilters($datagridMapper);
    
        $datagridMapper            
            ->add('parent', null, [], 'entity', [
                'class'         => Utilisateur::class,
                'choice_label'  => 'nom',
            ]);
    }
}
