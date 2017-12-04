<?php

namespace AppBundle\Admin;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Oh\GoogleMapFormTypeBundle\Form\Type\GoogleMapType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;


use AppBundle\Entity\Atelier;
use AppBundle\Entity\Utilisateur;

class AtelierAdmin extends AbstractAdmin
{
    protected $baseRouteName    = 'admin_atelier';
    protected $baseRoutePattern = 'atelier';

    public $supportsPreviewMode = false;

    protected $datagridValues = [
        '_sort_order'   => 'DESC',
        '_sort_by'      => 'timestampCreation',
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
                'label' => 'atelier.liste.nom'
            ])
            ->add('affiche', 'boolean', [
                'label'     => 'atelier.liste.affiche',
                'editable'  => true
            ])
            ->add('datePublication', 'date', [
                'label'     => 'atelier.liste.datePublication'
            ])
            ->add('annule', 'boolean', [
                'label'     => 'atelier.liste.annule',
                'editable'  => true
            ])
            ->add('reserveMembre', 'boolean', [
                'label'     => 'atelier.liste.reserveMembre',
                'editable'  => true
            ])
            ->add('nbPlace', 'integer', [
                'label' => 'atelier.liste.nbPlace',
            ])
            ->add('date', 'date', [
                'label'     => 'atelier.liste.date'
            ])
            ->add('dateLimite', 'date', [
                'label'     => 'atelier.liste.dateLimite'
            ])
            ->add('_action', null, array(
                'actions' => array(
                    'edit' => array(),
                    'clone' => array(
                        'template' => ':AdminCustom/button:clone.html.twig',
                        'data'     => '1',
                    ),
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
            ->add('datePublication', 'sonata_type_datetime_picker', [
                'label' => 'atelier.datePublication',
                'dp_language'=>'fr',
                'format'=>'dd/MM/yyyy HH:mm',
                'attr'  => [
                    'placeholder' => $this->trans('atelier.placeholder.datePublication')
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
                'label' => 'atelier.nbPlace',
                'attr'  => [
                    'placeholder' => 'atelier.placeholder.nbPlace'
                ],
                'required' => false
            ])
            ->add('prixMembre', 'number', [
                'label' => 'atelier.prixMembre',                
                'attr'  => [
                    'placeholder' => 'atelier.placeholder.prixMembre'
                ],
                'required' => false
            ])
            ->add('prix', 'number', [
                'label' => 'atelier.prix',                
                'attr'  => [
                    'placeholder' => 'atelier.placeholder.prix'
                ],
                'required' => false
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
                'class'     => 'col-md-5 js-emplacement-container'
            ])
            ->add('urlInscription', 'url', [
                'label' => 'atelier.urlInscription',
                'attr'  => [
                    'placeholder' => 'atelier.placeholder.urlInscription'
                ],
                'required' => false
            ])
            ->add('superviseurs', 'sonata_type_model_autocomplete', [
                'class'     => Utilisateur::class,
                'property'  => ['firstname','lastname'],
                'label'     => 'atelier.superviseurs',
                'multiple'  => true,
                'placeholder' => $this->trans('atelier.placeholder.superviseurs'),
                'required' => false
            ])
            ->add('date', 'sonata_type_datetime_picker', [
                'label' => 'atelier.date',
                'dp_language'=>'fr',
                'format'=>'dd/MM/yyyy HH:mm',
                'attr'  => [
                    'placeholder' => $this->trans('atelier.placeholder.date')
                ],
                'required' => false
            ])
            ->add('dateLimite', 'sonata_type_datetime_picker', [
                'label' => 'atelier.date_limite',
                'dp_language'=>'fr',
                'format'=>'dd/MM/yyyy HH:mm',
                'attr'  => [
                    'placeholder' => $this->trans('atelier.placeholder.date_limite')
                ],
                'required' => false
            ])
            ->add('image', 'sonata_media_type', array(
                'label' => 'atelier.image',
                'provider' => 'sonata.media.provider.image',
                'context'  => 'image',
                'required' => false,
            ))
            ->add('adresse', 'text', [
                'label' => 'atelier.adresse',
                'attr'  => [
                    'placeholder'   => 'atelier.placeholder.adresse',
                    'class'         => 'js-data-emplacement'
                ],
                'required' => false
            ])
            ->add('codePostal', 'text', [
                'label' => 'atelier.cp',
                'attr'  => [
                    'placeholder'   => 'atelier.placeholder.cp',
                    'class'         => 'js-data-emplacement'
                ],
                'required' => false
            ])
            ->add('ville', 'text', [
                'label' => 'atelier.ville',
                'attr'  => [
                    'placeholder'   => 'atelier.placeholder.ville',
                    'class'         => 'js-data-emplacement'
                ],
                'required' => false
            ])
            ->add('latlng', GoogleMapType::class, [
                'label' => 'atelier.position',
                'lat_options' => [
                    'label' => 'atelier.latitude'
                ],
                'lng_options' => [
                    'label' => 'atelier.longitude'
                ],
                'attr'  => [
                    'class' => 'js-search-emplacement-container'
                ],
				'required' => false
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
            ->add('nbPlace')
            ->add('reserveMembre')
            ->add('prix')    
            ->add('date')
            ->add('dateLimite')
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
            ->add('nom', null, [
                'label' => 'atelier.liste.nom'
            ])
            ->add('affiche', null, [
                'label' => 'atelier.liste.affiche'
            ])
            ->add('annule', null, [
                'label' => 'atelier.liste.annule'
            ])
            ->add('nbPlace', null, [
                'label' => 'atelier.liste.nbPlace'
            ])
            ->add('reserveMembre', null, [
                'label' => 'atelier.liste.reserveMembre'
            ])
            ->add('prix', null, [
                'label' => 'atelier.liste.prix'
            ])
            ->add('prixMembre', null, [
                'label' => 'atelier.liste.prixMembre'
            ])
            ->add('date', null, [
                'label' => 'atelier.liste.date'
            ])
            ->add('dateLimite', null, [
                'label' => 'atelier.liste.dateLimite'
            ])
            ->add('datePublication', null, [
                'label' => 'atelier.liste.datePublication'
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
        return $object instanceof Atelier
            ? $object->getNom()
            : $this->trans('atelier.add_edit.to_string');
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
        $collection->add('clone', $this->getRouterIdParameter().'/clone');
    }
}
