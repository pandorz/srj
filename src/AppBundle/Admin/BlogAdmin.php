<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Actualite;
use AppBundle\Entity\Blog;
use AppBundle\Entity\Tag;
use AppBundle\Entity\Utilisateur;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Workflow\Registry;
use Symfony\Component\Workflow\Workflow;

class BlogAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'admin_blog';
    protected $baseRoutePattern = 'blog';

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
                'label' => 'blog.liste.nom'
            ])
            ->add('affiche', 'boolean', [
                'label' => 'blog.liste.affiche',
                'editable' => true
            ])
            ->add('datePublication', 'date', [
                'label' => 'blog.liste.datePublication'
            ])
            ->add('htmlState', 'html', array(
                'label'         => 'blog.liste.state'
            ))
            ->add('_action', null, array(
                'actions' => array(
                    'edit' => array(),
                    'clone' => array(
                        'template' => ':AdminCustom/button:clone.html.twig',
                        'data' => '1',
                    ),
                    'view' => array(
                        'template' => ':AdminCustom/button:view.html.twig',
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
        $serviceWorkflow = $this->getConfigurationPool()->getContainer()->get('app.workflow.blog');
        $blog            = $this->getSubject();
        $disabledAffiche = false;
        $state           = 'draft';

        if ($blog instanceof Blog) {
            if (!empty($blog->getCurrentPlace())) {
                $state = key(array_slice($blog->getCurrentPlace(), 0, 1));
            }

            if (!empty($blog->getId())) {
                $disabledAffiche = !$serviceWorkflow->canBePublished($blog);
            }
        }

        $formMapper
            ->with('Content', [
                'name' => $this->trans('blog.with.details'),
                'class' => 'col-md-7',
                'description' => $this->trans('blog.add_edit.details.description.'.$state)
            ])
            ->add('nom', 'text', [
                'label' => 'blog.nom',
                'attr' => [
                    'placeholder' => 'blog.placeholder.nom'
                ]
            ])
            ->add('affiche', 'checkbox', [
                'label' => 'blog.actif',
                'attr' => [
                    'placeholder' => 'blog.placeholder.actif'
                ],
                'required' => false,
                'disabled' => $disabledAffiche
            ])
            ->add('descriptionCourte', 'text', [
                'label' => 'blog.descriptionCourte',
                'attr' => [
                    'placeholder' => 'blog.placeholder.descriptionCourte'
                ]
            ])
            ->add('contenu', CKEditorType::class, [
                'label' => 'blog.contenu',
                'attr' => [
                    'placeholder' => 'blog.placeholder.contenu'
                ],
                'config_name' => 'news'
            ])
            ->end()
            ->with('Meta data', [
                'name' => $this->trans('blog.with.meta_data'),
                'class' => 'col-md-5'
            ])
            ->add('datePublication', 'sonata_type_datetime_picker', [
                'label' => 'blog.datePublication',
                'dp_language' => 'fr',
                'format' => 'dd/MM/yyyy HH:mm',
                'attr' => [
                    'placeholder' => $this->trans('blog.placeholder.datePublication')
                ],
                'required' => false
            ])
            ->add('image', 'sonata_media_type', array(
                'label' => 'blog.image',
                'provider' => 'sonata.media.provider.image',
                'context' => 'image',
                'required' => false,
                'help' => $this->trans('blog.helper.image')
            ))
            ->add('auteurs', 'sonata_type_model_autocomplete', [
                'class' => Utilisateur::class,
                'property' => ['firstname', 'lastname'],
                'label' => 'blog.auteur',
                'multiple' => true,
                'placeholder' => $this->trans('blog.placeholder.auteur'),
                'required' => false
            ])
            ->add('tags', 'sonata_type_model_autocomplete', [
                'class' => Tag::class,
                'property' => ['nom'],
                'label' => 'blog.tag',
                'multiple' => true,
                'placeholder' => $this->trans('blog.placeholder.tag'),
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
            ->add('affiche')
            ->add('datePublication');
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
                'label' => 'blog.liste.nom'
            ])
            ->add('affiche', null, [
                'label' => 'blog.liste.affiche'
            ])
            ->add('datePublication', null, [
                'label' => 'blog.liste.datePublication'
            ])
            ->add('currentPlace', null, [
                'label' => 'blog.liste.state'
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

    public function postUpdate($object)
    {
        /** @var Blog $object */
        if ($object->getAffiche()) {
            $this->getConfigurationPool()->getContainer()->get('app.workflow.blog')->publier($object);
        }
        parent::postUpdate($object);
    }

    /**
     * @param mixed $object
     *
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof Actualite
            ? $object->getNom()
            : $this->trans('blog.add_edit.to_string');
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

        $blog = $this->getSubject();

        // Edit case
        if ($blog instanceof Blog && !empty($blog->getId())) {
            $list['view'] = array(
                'template' => ':AdminCustom/button:view_list.html.twig',
            );
        }

        return $list;
    }


    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
        $collection->add('clone', $this->getRouterIdParameter() . '/clone');
        $collection->add('reject', $this->getRouterIdParameter() . '/rejeter');
        $collection->add('to_review', $this->getRouterIdParameter() . '/relecture');
        $collection->add('to_reopen', $this->getRouterIdParameter() . '/reouvrir');
        $collection->add('view', '/blog/article/{slug}/');
    }
}
