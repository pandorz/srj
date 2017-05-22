<?php

namespace AppBundle\Admin;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use AppBundle\Entity\DateCalendrier;
use AppBundle\Entity\Utilisateur;

class EvenementAdmin extends AbstractAdmin
{
    protected $baseRouteName    = 'admin_evenement';
    protected $baseRoutePattern = 'evenement';

    public $supportsPreviewMode = false;



    /**
     * Fields to be shown on lists
     *
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nom', TextType::class, [
                'label' => 'evenement.liste.nom'
            ])
            ->add('affiche', 'boolean', [
                'label' => 'evenement.liste.affiche',
            ])
            ->add('annule', 'boolean', [
                'label' => 'evenement.liste.annule',
            ])
            ->add('date', 'many_to_one', [
                'label' => 'evenement.liste.date',
                'sortable'  => 'name'
            ])
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
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
                'name'          => $this->trans('evenement.add_edit.details'),
                'class'         => 'col-md-7'
            ])
            ->add('nom', TextType::class, [
                'label' => 'evenement.nom',
                'attr'  => [
                    'placeholder' => 'evenement.placeholder.nom'
                ]
            ])
            ->add('affiche', 'checkbox', [
                'label' => 'evenement.actif',
                'attr'  => [
                    'placeholder' => 'evenement.placeholder.actif'
                ]
            ])
            ->add('annule', 'checkbox', [
                'label' => 'evenement.annule',
                'attr'  => [
                    'placeholder' => 'evenement.placeholder.annule'
                ]
            ])
            ->add('contenu', CKEditorType::class, [
                'label' => 'evenement.contenu',
                'attr'  => [
                    'placeholder' => 'evenement.placeholder.contenu'
                ]
            ])            
            ->end()
            ->with('Meta data', [
                'name'      => $this->trans('evenement.add_edit.meta_data'),
                'class'     => 'col-md-5'
            ])
            ->add('superviseurs', 'sonata_type_model_autocomplete', [
                'class'     => Utilisateur::class,
                'property'  => 'slug',
                'label'     => 'evenement.superviseurs',
                'multiple'  => true,
                'placeholder' => 'evenement.placeholder.superviseurs'
            ])
            ->add('date', 'sonata_type_model_autocomplete', [
                'class'     => DateCalendrier::class,
                'property'  => 'date',
                'label'     => 'evenement.date',
                'placeholder' => 'evenement.placeholder.date'
            ])
            ->add('image', 'sonata_type_admin', [
                'delete' => false,
                'label' => 'evenement.image',
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
            ->add('utilisateurCreation')
            ->add('utilisateurModification')
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
            ->add('nom')
            ->add('affiche')
            ->add('annule')
            ->add('date', null, [], 'entity', [
                'class'         => DateCalendrier::class,
                'choice_label'  => 'date',
            ])
        ;
    }

    /**
     * @param mixed $page
     */
    public function prePersist($page)
    {
        $this->manageEmbeddedImageAdmins($page);
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $page->setUtilisateurCreation($user->__toString());
    }

    /**
     * @param mixed $page
     */
    public function preUpdate($page)
    {
        $this->manageEmbeddedImageAdmins($page);
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $page->setUtilisateurModification($user->__toString());
    }

    /**
     * @param $page
     */
    private function manageEmbeddedImageAdmins($page)
    {
        // Cycle through each field
        foreach ($this->getFormFieldDescriptions() as $fieldName => $fieldDescription) {
            // detect embedded Admins that manage Images
            if (hash_equals($fieldDescription->getType(), 'sonata_type_admin') &&
                ($associationMapping = $fieldDescription->getAssociationMapping()) &&
                hash_equals($associationMapping['targetEntity'], 'AppBundle\Entity\Image')
            ) {
                $getter = 'get'.$fieldName;
                $setter = 'set'.$fieldName;

                /** @var Ressource $image */
                $image = $page->$getter();

                if ($image) {
                    if ($image->getFile()) {
                        // update the Image to trigger file management
                        $image->setUrl($image->getFile()->getClientOriginalName());                        
                        $image->refreshUpdated();
                        $page->setImage($image);
                    } elseif (!$image->getFile() && !$image->getNomFichier()) {
                        // prevent Sf/Sonata trying to create and persist an empty Image
                        $page->$setter(null);
                    }
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
        return $object instanceof Musee
            ? $object->getNom()
            : $this->trans('evenement.add_edit.to_string');
    }
}
