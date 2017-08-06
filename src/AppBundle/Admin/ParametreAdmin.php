<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;


use AppBundle\Entity\Parametre;

class ParametreAdmin extends AbstractAdmin
{
    protected $baseRouteName    = 'admin_parametre';
    protected $baseRoutePattern = 'parametre';

    public $supportsPreviewMode = false;



    /**
     * Fields to be shown on lists
     *
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('nom', 'text', [
                'label' => 'parametre.liste.nom'
            ])   
            ->add('_action', null, array(
                'actions' => array(
                    'edit' => array()
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
                'name'          => $this->trans('parametre.with.details'),
                'class'         => 'col-md-12'
            ]);
        $parametre = $this->getSubject();
        if (!($parametre instanceof Parametre) || empty($parametre->getNom())) {
            $formMapper->add('nom', 'text', [
                    'label' => 'parametre.nom',
                    'attr'  => [
                        'placeholder' => 'parametre.placeholder.nom'
                    ]
                ]);
        }
        $formMapper->add('value', 'text', [
                'label' => 'parametre.value',
                'attr'  => [
                    'placeholder' => 'parametre.placeholder.value'
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
            ->add('nom')
            ->add('utilisateurCreation')
            ->add('utilisateurModification');
    }

    /**
     * Fields to be shown on filter forms
     *
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nom');
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
        return $object instanceof Parametre
            ? $object->getNom()
            : $this->trans('parametre.add_edit.to_string');
    }
}
