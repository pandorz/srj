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
    protected $classnameLabel   = 'user';

    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);
        $listMapper
                ->add('parent', 'many_to_one', [
                'label'     => $this->trans('utilisateur.liste.parent', [], 'messages'),
                'route'     => ['name' => 'show'],
                'sortable'  => 'name'
            ]);
    }
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        $formMapper
            ->tab($this->trans('utilisateur.tab.sousUtilisateurs', [], 'messages'))
            ->with('content_sousUtilisateur', [
                'name'          => $this->trans('utilisateur.with.sousUtilisateurs', [], 'messages'),
                'description'   => $this->trans('utilisateur.with.description', [], 'messages')
            ])
            ->add('sousUtilisateurs', 'sonata_type_model_list', [
                'label'     => $this->trans('utilisateur.sousUtilisateurs', [], 'messages'),
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
                'choice_label'  => 'lastname',
            ])
            ->add('lastname')
            ->add('firstname');
    }
}
