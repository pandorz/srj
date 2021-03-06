<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Evenement;
use AppBundle\Entity\Utilisateur;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class EvenementAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'admin_evenement';
    protected $baseRoutePattern = 'evenement';

    public $supportsPreviewMode = false;

    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by' => 'timestampCreation',
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
                'label' => 'evenement.liste.nom'
            ])
            ->add('affiche', 'boolean', [
                'label' => 'evenement.liste.affiche',
                'editable' => true
            ])
            ->add('datePublication', 'date', [
                'label' => 'evenement.liste.datePublication'
            ])
            ->add('annule', 'boolean', [
                'label' => 'evenement.liste.annule',
                'editable' => true
            ])
            ->add('dateDebut', 'date', [
                'label' => 'evenement.liste.dateDebut'
            ])
            ->add('dateFin', 'date', [
                'label' => 'evenement.liste.dateFin'
            ])
            ->add('_action', null, array(
                'actions' => array(
                    'edit' => array(),
                    'clone' => array(
                        'template' => ':AdminCustom/button:clone.html.twig',
                        'data' => '1',
                    ),
                    'delete' => array(),
                )
            ));
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
                'name' => $this->trans('evenement.with.details'),
                'class' => 'col-md-7'
            ])
            ->add('nom', 'text', [
                'label' => 'evenement.nom',
                'attr' => [
                    'placeholder' => 'evenement.placeholder.nom'
                ]
            ])
            ->add('affiche', 'checkbox', [
                'label' => 'evenement.actif',
                'attr' => [
                    'placeholder' => 'evenement.placeholder.actif'
                ],
                'required' => false
            ])
            ->add('datePublication', 'sonata_type_datetime_picker', [
                'label' => 'evenement.datePublication',
                'dp_language' => 'fr',
                'format' => 'dd/MM/yyyy HH:mm',
                'attr' => [
                    'placeholder' => $this->trans('evenement.placeholder.datePublication')
                ],
                'required' => false
            ])
            ->add('annule', 'checkbox', [
                'label' => 'evenement.annule',
                'attr' => [
                    'placeholder' => 'evenement.placeholder.annule'
                ],
                'required' => false
            ])
            ->add('contenu', CKEditorType::class, [
                'label' => 'evenement.contenu',
                'attr' => [
                    'placeholder' => 'evenement.placeholder.contenu'
                ]
            ])
            ->end()
            ->with('Meta data', [
                'name' => $this->trans('evenement.with.meta_data'),
                'class' => 'col-md-5'
            ])
            ->add('superviseurs', 'sonata_type_model_autocomplete', [
                'class' => Utilisateur::class,
                'property' => ['firstname', 'lastname'],
                'label' => 'evenement.superviseurs',
                'multiple' => true,
                'placeholder' => $this->trans('evenement.placeholder.superviseurs'),
                'required' => false
            ])
            ->add('dateDebut', 'sonata_type_datetime_picker', [
                'label' => 'evenement.date_debut',
                'dp_language' => 'fr',
                'format' => 'dd/MM/yyyy HH:mm',
                'attr' => [
                    'placeholder' => 'evenement.placeholder.date_debut'
                ],
                'required' => false
            ])
            ->add('dateFin', 'sonata_type_datetime_picker', [
                'label' => 'evenement.date_fin',
                'dp_language' => 'fr',
                'format' => 'dd/MM/yyyy HH:mm',
                'attr' => [
                    'placeholder' => 'evenement.placeholder.date_fin'
                ],
                'required' => false
            ])
            ->add('image', 'sonata_media_type', array(
                'label' => 'evenement.image',
                'provider' => 'sonata.media.provider.image',
                'context' => 'image',
                'required' => false,
            ))
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
            ->add('affiche')
            ->add('annule')
            ->add('dateDebut')
            ->add('dateFin');
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
                'label' => 'evenement.liste.nom'
            ])
            ->add('affiche', null, [
                'label' => 'evenement.liste.affiche'
            ])
            ->add('annule', null, [
                'label' => 'evenement.liste.annule'
            ])
            ->add('dateDebut', null, [
                'label' => 'evenement.liste.dateDebut'
            ])
            ->add('dateFin', null, [
                'label' => 'evenement.liste.dateFin'
            ])
            ->add('datePublication', null, [
                'label' => 'evenement.liste.datePublication'
            ]);
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
        return $object instanceof Evenement
            ? $object->getNom()
            : $this->trans('evenement.add_edit.to_string');
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
        $collection->add('clone', $this->getRouterIdParameter() . '/clone');
    }
}
