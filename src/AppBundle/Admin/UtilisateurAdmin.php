<?php

namespace AppBundle\Admin;

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

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->addIdentifier('username')
            ->add('email')
            ->add('groups')
            ->add('enabled', null, array('editable' => true))
            ->add('createdAt');

        if ($this->isGranted('ROLE_ALLOWED_TO_SWITCH')) {
            $listMapper
                ->add('impersonating', 'string', array('template' => 'AdminCustom/template/impersonating.html.twig'));
        }
        $listMapper
                ->add('parent', 'many_to_one', [
                'label'     => $this->trans('utilisateur.liste.parent', [], 'messages'),
                'route'     => ['name' => 'show'],
                'sortable'  => 'name'
                ])
                ->add('estProfesseur', 'boolean', [
                    'label'     => 'utilisateur.liste.estProfesseur',
                    'editable'  => true
                ])
                ->add('accesSite', 'boolean', [
                    'label'     => 'utilisateur.liste.accesSite',
                    'editable'  => true
                ]);
    }
    
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $user = $this->getSubject();
        if ($user instanceof Utilisateur && !empty($user->getId()) && empty($user->getMembreNumero())) {
            $this
                ->getConfigurationPool()
                ->getContainer()
                ->get('session')
                ->getFlashBag()
                ->set('warning', $this->trans('utilisateur.membreNumero_empty'));
        }

        parent::configureFormFields($formMapper);

        $formMapper
            ->tab($this->trans('utilisateur.tab.profil', [], 'messages'))
            ->with('Détails', [
                'name'          => $this->trans('utilisateur.with.meta_data', [], 'messages'),
            ])
            ->add('estProfesseur', 'checkbox', [
                'label' => 'utilisateur.estProfesseur',
                'attr'  => [
                    'placeholder' => 'utilisateur.placeholder.estProfesseur'
                ],
                'required' => false
            ])
            ->add('accesSite', 'checkbox', [
                'label' => 'utilisateur.accesSite',
                'attr'  => [
                    'placeholder' => 'utilisateur.placeholder.accesSite'
                ],
                'required' => false
            ])
            ->add('membreTitre', 'text', [
                'label' => 'utilisateur.membreTitre',
                'attr'  => [
                    'placeholder' => 'utilisateur.placeholder.membreTitre'
                ],
                'required' => false
            ])
            ->add('membreNumero', 'text', [
                'label' => 'utilisateur.membreNumero',
                'attr'  => [
                    'placeholder' => 'utilisateur.placeholder.membreNumero'
                ],
                'required' => false
            ])
            ->add('prenomJaponais', 'text', [
                'label' => 'utilisateur.prenomJaponais',
                'attr'  => [
                    'placeholder' => 'utilisateur.placeholder.prenomJaponais'
                ],
                'required' => false
            ])
            ->add('nomJaponais', 'text', [
                'label' => 'utilisateur.nomJaponais',
                'attr'  => [
                    'placeholder' => 'utilisateur.placeholder.nomJaponais'
                ],
                'required' => false
            ])
            ->end()
            ->with('Sous utilisateur', [
                'name'          => $this->trans('utilisateur.with.sousUtilisateurs', [], 'messages'),
                'description'   => $this->trans('utilisateur.with.description', [], 'messages'),
                'class'         => 'col-md-4'
            ])
            ->add('sousUtilisateurs', 'sonata_type_model_list', [
                'label'     => $this->trans('utilisateur.sousUtilisateurs', [], 'messages'),
                'required'  => false,
            ], [
                'edit'          => 'inline',
                'inline'        => 'table',
                'sortable'      => 'position'
            ])
            ->end()
            ->with('Meta data', [
                'name'          => $this->trans('utilisateur.with.meta_data', [], 'messages'),
                'class'         => 'col-md-8'
            ])
            ->add('image', 'sonata_media_type', array(
                'label' => 'utilisateur.image',
                'provider' => 'sonata.media.provider.image',
                'context'  => 'image',
                'required' => false,
            ))
            ->end()
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
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

    public function prePersist($page): void
    {
        parent::prePersist($page);
        /** @var Utilisateur $page */
        if (empty($page->getMembreNumero())) {
            $this
                ->getConfigurationPool()
                ->getContainer()
                ->get('session')
                ->getFlashBag()
                ->set('warning', $this->trans('utilisateur.membreNumero_empty'));
        }
    }

    public function preUpdate($page): void
    {
        parent::preUpdate($page);
        /** @var Utilisateur $page */
        if (empty($page->getMembreNumero())) {
            $this
                ->getConfigurationPool()
                ->getContainer()
                ->get('session')
                ->getFlashBag()
                ->set('warning', $this->trans('utilisateur.membreNumero_empty'));
        }
    }
}
