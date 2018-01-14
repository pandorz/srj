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


use AppBundle\Entity\Kouryukai;
use AppBundle\Entity\Utilisateur;

class KouryukaiAdmin extends AbstractAdmin
{
    protected $baseRouteName    = 'admin_kouryukai';
    protected $baseRoutePattern = 'kouryukai';

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
                'label' => 'kouryukai.liste.nom'
            ])
            ->add('affiche', 'boolean', [
                'label'     => 'kouryukai.liste.affiche',
                'editable'  => true
            ]) 
            ->add('datePublication', 'date', [
                'label'     => 'kouryukai.liste.datePublication'
            ])   
            ->add('annule', 'boolean', [
                'label'     => 'kouryukai.liste.annule',
                'editable'  => true
            ])
            ->add('reserveMembre', 'boolean', [
                'label'     => 'kouryukai.liste.reserveMembre',
                'editable'  => true
            ])
            ->add('nbPlace', 'integer', [
                'label' => 'kouryukai.liste.nbPlace',
            ])
            ->add('date', 'date', [
                'label'     => 'kouryukai.liste.date'
            ])
            ->add('dateLimite', 'date', [
                'label'     => 'kouryukai.liste.dateLimite'
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
                'name'          => $this->trans('kouryukai.with.details'),
                'class'         => 'col-md-7'
            ])
            ->add('nom', 'text', [
                'label' => 'kouryukai.nom',
                'attr'  => [
                    'placeholder' => 'kouryukai.placeholder.nom'
                ]
            ])
            ->add('affiche', 'checkbox', [
                'label' => 'kouryukai.actif',
                'attr'  => [
                    'placeholder' => 'kouryukai.placeholder.actif'
                ],
                'required' => false
            ])
            ->add('datePublication', 'sonata_type_datetime_picker', [
                'label' => 'kouryukai.datePublication',
                'dp_language'=>'fr',
                'format'=>'dd/MM/yyyy HH:mm',
                'attr'  => [
                    'placeholder' => $this->trans('kouryukai.placeholder.datePublication')
                ],
                'required' => false
            ])
            ->add('annule', 'checkbox', [
                'label' => 'kouryukai.annule',
                'attr'  => [
                    'placeholder' => 'kouryukai.placeholder.annule'
                ],
                'required' => false
            ])
            ->add('reserveMembre', 'checkbox', [
                'label' => 'kouryukai.reserve_membre',
                'attr'  => [
                    'placeholder' => 'kouryukai.placeholder.reserve_membre'
                ],
                'required' => false
            ])
            ->add('nbPlace', 'integer', [
                'label' => 'kouryukai.nbPlace',
                'attr'  => [
                    'placeholder' => 'kouryukai.placeholder.nbPlace'
                ],
                'required' => false
            ])
            ->add('contenu', CKEditorType::class, [
                'label' => 'kouryukai.contenu',
                'attr'  => [
                    'placeholder' => 'kouryukai.placeholder.contenu'
                ]
            ])            
            ->end()
            ->with('Meta data', [
                'name'      => $this->trans('kouryukai.with.meta_data'),
                'class'     => 'col-md-5 js-emplacement-container'
            ])
            ->add('urlInscription', 'url', [
                'label' => 'kouryukai.urlInscription',
                'attr'  => [
                    'placeholder' => 'kouryukai.placeholder.urlInscription'
                ],
                'required' => false
            ])
            ->add('superviseurs', 'sonata_type_model_autocomplete', [
                'class'     => Utilisateur::class,
                'property'  => ['firstname','lastname'],
                'label'     => 'kouryukai.superviseurs',
                'multiple'  => true,
                'placeholder' => $this->trans('kouryukai.placeholder.superviseurs'),
                'required' => false
            ])
            ->add('date', 'sonata_type_datetime_picker', [
                'label' => 'kouryukai.date',
                'dp_language'=>'fr',
                'format'=>'dd/MM/yyyy HH:mm',
                'attr'  => [
                    'placeholder' => $this->trans('kouryukai.placeholder.date')
                ],
                'required' => false
            ])
            ->add('dateLimite', 'sonata_type_datetime_picker', [
                'label' => 'kouryukai.date_limite',
                'dp_language'=>'fr',
                'format'=>'dd/MM/yyyy HH:mm',
                'attr'  => [
                    'placeholder' => $this->trans('kouryukai.placeholder.date_limite')
                ],
                'required' => false
            ])
            ->add('image', 'sonata_media_type', array(
                'label' => 'kouryukai.image',
                'provider' => 'sonata.media.provider.image',
                'context'  => 'image',
                'required' => false,
            ))
            ->add('adresse', 'text', [
                'label' => 'kouryukai.adresse',
                'attr'  => [
                    'placeholder'   => 'kouryukai.placeholder.adresse',
                    'class'         => 'js-data-emplacement'
                ],
                'required' => false
            ])
            ->add('codePostal', 'text', [
                'label' => 'kouryukai.cp',
                'attr'  => [
                    'placeholder'   => 'kouryukai.placeholder.cp',
                    'class'         => 'js-data-emplacement'
                ],
                'required' => false
            ])
            ->add('ville', 'text', [
                'label' => 'kouryukai.ville',
                'attr'  => [
                    'placeholder'   => 'kouryukai.placeholder.ville',
                    'class'         => 'js-data-emplacement'
                ],
                'required' => false
            ])
            ->add('latlng', GoogleMapType::class, [
                'label' => 'kouryukai.position',
                'lat_options' => [
                    'label' => 'kouryukai.latitude'
                ],
                'lng_options' => [
                    'label' => 'kouryukai.longitude'
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
                'label' => 'kouryukai.liste.nom'
            ])
            ->add('affiche', null, [
                'label' => 'kouryukai.liste.affiche'
            ])
            ->add('annule', null, [
                'label' => 'kouryukai.liste.annule'
            ])
            ->add('nbPlace', null, [
                'label' => 'kouryukai.liste.nbPlace'
            ])
            ->add('reserveMembre', null, [
                'label' => 'kouryukai.liste.reserveMembre'
            ])
            ->add('date', null, [
                'label' => 'kouryukai.liste.date'
            ])
            ->add('dateLimite', null, [
                'label' => 'kouryukai.liste.dateLimite'
            ])
            ->add('datePublication', null, [
                'label' => 'kouryukai.liste.datePublication'
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
        return $object instanceof Kouryukai
            ? $object->getNom()
            : $this->trans('kouryukai.add_edit.to_string');
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
        $collection->add('clone', $this->getRouterIdParameter().'/clone');
    }
}
