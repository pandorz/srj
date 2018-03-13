<?php

namespace AppBundle\Admin;

use AppBundle\Entity\CourDate;
use AppBundle\Entity\CourDetail;
use AppBundle\Entity\CourReport;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;


use AppBundle\Entity\Cour;
use AppBundle\Entity\Utilisateur;

class CourAdmin extends AbstractAdmin
{
    protected $baseRouteName    = 'admin_cour';
    protected $baseRoutePattern = 'cour';

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
            ->addIdentifier('titre', 'text', [
                'label' => 'cour.liste.titre'
            ])
            ->add('affiche', 'boolean', [
                'label'     => 'cour.liste.affiche',
                'editable'  => true
            ])
            ->add('datePublication', 'date', [
                'label'     => 'cour.liste.datePublication'
            ])
            ->add('annule', 'boolean', [
                'label'     => 'cour.liste.annule',
                'editable'  => true
            ])
            ->add('complet', 'boolean', [
                'label'     => 'cour.liste.complet',
                'editable'  => true
            ])
            ->add('bientotComplet', 'boolean', [
                'label'     => 'cour.liste.bientotComplet',
                'editable'  => true
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
            ->tab('Affichage')
                ->with('Content', [
                    'name'          => $this->trans('cour.with.content'),
                    'class'         => 'col-md-7'
                ])
                ->add('titre', 'text', [
                    'label' => 'cour.titre',
                    'attr'  => [
                        'placeholder' => 'cour.placeholder.titre'
                    ]
                ])
                ->add('affiche', 'checkbox', [
                    'label' => 'cour.actif',
                    'attr'  => [
                        'placeholder' => 'cour.placeholder.actif'
                    ],
                    'required' => false
                ])
                ->add('datePublication', 'sonata_type_datetime_picker', [
                    'label' => 'cour.datePublication',
                    'dp_language'=>'fr',
                    'format'=>'dd/MM/yyyy HH:mm',
                    'attr'  => [
                        'placeholder' => $this->trans('cour.placeholder.datePublication')
                    ],
                    'required' => false
                ])
                ->add('annule', 'checkbox', [
                    'label' => 'cour.annule',
                    'attr'  => [
                        'placeholder' => 'cour.placeholder.annule'
                    ],
                    'required' => false
                ])
                ->add('complet', 'checkbox', [
                    'label' => 'cour.complet',
                    'attr'  => [
                        'placeholder' => 'cour.placeholder.complet'
                    ],
                    'required' => false
                ])
                ->add('bientotComplet', 'checkbox', [
                    'label' => 'cour.bientotComplet',
                    'attr'  => [
                        'placeholder' => 'cour.placeholder.bientotComplet'
                    ],
                    'required' => false
                ])
                ->add('creneau', 'text', [
                    'label' => 'cour.creneau',
                    'attr'  => [
                        'placeholder' => 'cour.placeholder.creneau'
                    ],
                    'required' => false
                ])
                ->add('amorce', CKEditorType::class, [
                    'label' => 'cour.amorce',
                    'attr'  => [
                        'placeholder' => 'cour.placeholder.amorce'
                    ],
                    'required' => false
                ])
                ->add('prix', 'number', [
                    'label' => 'cour.prix',
                    'attr'  => [
                        'placeholder' => 'cour.placeholder.prix'
                    ],
                    'required' => false
                ])
                ->end()
                ->with('Meta data', [
                    'name'      => $this->trans('cour.with.meta_data'),
                     'class'     => 'col-md-5'
                ])
                ->add('titreNav', 'text', [
                    'label' => 'cour.titreNav',
                    'attr'  => [
                        'placeholder' => 'cour.placeholder.titreNav'
                    ]
                ])
                ->add('ancre', 'text', [
                    'label' => 'cour.ancre',
                    'attr'  => [
                        'placeholder' => 'cour.placeholder.ancre'
                    ]
                ])
                ->add('messageAnnulation', 'text', [
                    'label' => 'cour.messageAnnulation',
                    'attr'  => [
                        'placeholder' => 'cour.placeholder.messageAnnulation'
                    ],
                    'required' => false
                ])
                ->add('conditionParticuliere', 'text', [
                    'label' => 'cour.conditionParticuliere',
                    'attr'  => [
                        'placeholder' => 'cour.placeholder.conditionParticuliere'
                    ],
                    'required' => false
                ])
                ->add('note', 'text', [
                    'label' => 'cour.note',
                    'attr'  => [
                        'placeholder' => 'cour.placeholder.note'
                    ],
                    'required' => false
                ])
                ->add('professeurs', 'sonata_type_model_autocomplete', [
                    'class'     => Utilisateur::class,
                    'property'  => ['firstname','lastname'],
                    'label'     => 'cour.professeur',
                    'multiple'  => true,
                    'placeholder' => $this->trans('cour.placeholder.professeur'),
                    'required' => false,
                    'callback' => function ($admin, $property, $value) {
                        $datagrid       = $admin->getDatagrid();
                        $queryBuilder   = $datagrid->getQuery();
                        $queryBuilder
                            ->andWhere($queryBuilder->getRootAlias() . '.estProfesseur=:estProfesseur')
                            ->setParameter('estProfesseur', true)
                        ;
                        $datagrid->setValue('slug', null, $value);
                    },
                ])
                ->add('inscrits', 'sonata_type_model_autocomplete', [
                    'class'     => Utilisateur::class,
                    'property'  => ['firstname','lastname'],
                    'label'     => 'cour.users',
                    'multiple'  => true,
                    'placeholder' => $this->trans('cour.placeholder.users'),
                    'required' => false
                ])
                ->add('lienInscription', 'url', [
                    'label' => 'cour.lienInscription',
                    'attr'  => [
                        'placeholder' => 'cour.placeholder.lienInscription'
                    ],
                    'required' => false
                ])
                ->add('lienPdf', 'url', [
                    'label' => 'cour.lienPdf',
                    'attr'  => [
                        'placeholder' => 'cour.placeholder.lienPdf'
                    ],
                    'required' => false
                ])
                ->add('image', 'sonata_media_type', array(
                    'label' => 'cour.image',
                    'provider' => 'sonata.media.provider.image',
                    'context'  => 'image',
                    'required' => false,
                ))
                ->end()
                ->with('Détails', [
                    'name'      => $this->trans('cour.with.details')
                ])
                ->add('details', 'sonata_type_collection', [
                    'by_reference' => true,
                    'label'     => $this->trans('cour.details', [], 'messages'),
                    'required'  => false,
                ], [
                    'edit'          => 'inline',
                    'inline'        => 'table',
                    'sortable'      => 'position'
                ])
                ->end()
            ->end()
            ->tab('Calendrier')
                ->with('Dates', [
                    'name'      => $this->trans('cour.with.dates')
                ])
                ->add('dates', 'sonata_type_collection', [
                    'by_reference' => true,
                    'label'     => $this->trans('cour.dates', [], 'messages'),
                    'required'  => false,
                ], [
                    'edit'          => 'inline',
                    'inline'        => 'table',
                    'sortable'      => 'position'
                ])
                ->end()
                ->with('Annulations et Reports', [
                    'name'      => $this->trans('cour.with.reports')
                ])
                ->add('reports', 'sonata_type_collection', [
                    'by_reference' => true,
                    'label'     => $this->trans('cour.reports', [], 'messages'),
                    'required'  => false,
                ], [
                    'edit'          => 'inline',
                    'inline'        => 'table',
                    'sortable'      => 'position'
                ])
                ->end()
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
            ->add('titre')
            ->add('affiche')
            ->add('annule')
            ->add('complet')
            ->add('bientotComplet')
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
            ->add('titre')
            ->add('affiche')
            ->add('annule')
            ->add('complet')
            ->add('bientotComplet')
        ;
    }

    /**
     * @param mixed $page
     */
    public function prePersist($page)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $page->setUtilisateurCreation($user->__toString());
        $this->setDetails($page);
        $this->setDates($page);
        $this->setReports($page);
        $page->setTimestampCreation(new \DateTime('now'));
    }

    /**
     * @param mixed $page
     */
    public function preUpdate($page)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $page->setUtilisateurModification($user->__toString());
        $this->setDetails($page);
        $this->setDates($page);
        $this->setReports($page);
        $page->setTimestampModification(new \DateTime('now'));
    }

    /**
     * Lie les details au cours
     *
     * @param Cour $cours
     */
    private function setDetails(Cour &$cours)
    {
        $details = $cours->getDetails();
        if (!empty($details)) {
            foreach ($details as $detail) {
                if ($detail instanceof CourDetail && empty($detail->getCours())) {
                    $detail->setCours($cours);
                }
            }
        }
    }

    /**
     * Lie les dates au cours
     *
     * @param Cour $cours
     */
    private function setDates(Cour &$cours)
    {
        $dates = $cours->getDates();
        if (!empty($dates)) {
            foreach ($dates as $date) {
                if ($date instanceof CourDate && empty($date->getCours())) {
                    $date->setCours($cours);
                }
            }
        }
    }

    /**
     * Lie les reports au cours
     *
     * @param Cour $cours
     */
    private function setReports(Cour &$cours)
    {
        $reports = $cours->getReports();
        if (!empty($reports)) {
            foreach ($reports as $report) {
                if ($report instanceof CourReport && empty($report->getCours())) {
                    $report->setCours($cours);
                }
            }
        }
    }

    /**
     * @param mixed $object
     *
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof Cour
            ? $object->getTitre()
            : $this->trans('cour.add_edit.to_string');
    }

    /**
     * @param      $action
     * @param null $object
     *
     * @return array
     */
    public function configureActionButtons($action, $object = null)
    {
        $list = parent::configureActionButtons($action, $object);

        $cour  = $this->getSubject();

        // Edit case
        if ($cour instanceof Cour && !empty($cour->getId())) {
            $list['generateGoogleCalendar'] = array(
                'template' => ':AdminCustom/button:generateGoogleCalendar_list.html.twig',
            );
        }

        return $list;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
        $collection->add('clone', $this->getRouterIdParameter().'/clone');
        $collection->add('generateGoogleCalendar', $this->getRouterIdParameter().'/generateGoogleCalendar');
    }
}
