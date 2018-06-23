<?php
namespace AppBundle\Form;

use AppBundle\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class UtilisateurType
 * @package AppBundle\Form
 */
class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('POST')

            ->add('image', 'sonata_media_type', [
                    'provider' => 'sonata.media.provider.image',
                    'context'  => 'default',
                    'required' => false,
                    'attr'  => ['class' => 'js-form-image form-image']
                ]
            )
            ->add(
                'firstname',
                TextType::class,
                [
                    'label'         => 'form.label_firstname',
                    'required'      => true,
                    'constraints'   => [
                        new NotBlank()
                    ],
                    'translation_domain' => 'SonataUserBundle'
                ]
            )
            ->add(
                'lastname',
                TextType::class,
                [
                    'label'         => 'form.label_lastname',
                    'required'      => true,
                    'constraints'   => [
                        new NotBlank()
                    ],
                    'translation_domain' => 'SonataUserBundle'
                ]
            )
            ->add(
                'prenomJaponais',
                TextType::class,
                [
                    'label'         => 'utilisateur.prenomJaponais',
                    'required'      => false,
                    'constraints'   => [
                        new NotBlank()
                    ],
                    'translation_domain' => 'SonataUserBundle'
                ]
            )
            ->add(
                'nomJaponais',
                TextType::class,
                [
                    'label'         => 'utilisateur.nomJaponais',
                    'required'      => false,
                    'constraints'   => [
                        new NotBlank()
                    ],
                    'translation_domain' => 'SonataUserBundle'
                ]
            )
            ->add(
                'website',
                UrlType::class,
                [
                    'label'         => 'form.label_website',
                    'required'      => false,
                    'constraints'   => [
                        new NotBlank()
                    ],
                    'translation_domain' => 'SonataUserBundle'
                ]
            )
            ;
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Utilisateur::class]);
    }


    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_Utilisateur';
    }
}
