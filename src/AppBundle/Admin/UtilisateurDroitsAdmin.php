<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\UserBundle\Admin\Entity\GroupAdmin;

class UtilisateurDroitsAdmin extends GroupAdmin
{
    protected $baseRouteName = 'admin_utilisateur_droits';
    protected $baseRoutePattern = 'utilisateur_droits';

    protected $classnameLabel = 'group';

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper): void
    {
        parent::configureListFields($listMapper);
        $listMapper
            ->add('estMembreBureau', 'boolean', [
                'label' => 'utilisateur_droit.liste.estMembreBureau',
                'editable' => true
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper): void
    {
        parent::configureFormFields($formMapper);

        $formMapper
            ->tab($this->trans('utilisateur_droit.tab.detail', [], 'messages'))
            ->with('Paramètres', [
                'name' => $this->trans('utilisateur_droit.with.parametre', [], 'messages'),
            ])
            ->add('estMembreBureau', 'checkbox', [
                'label' => 'utilisateur_droit.estMembreBureau',
                'attr' => [
                    'placeholder' => 'utilisateur_droit.placeholder.estMembreBureau'
                ],
                'required' => false
            ])
            ->end()
            ->end();
    }
}
