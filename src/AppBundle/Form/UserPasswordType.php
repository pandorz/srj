<?php
namespace AppBundle\Form;

use AppBundle\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class UserPasswordType
 * @package AppBundle\Form
 */
class UserPasswordType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('POST')
            ->add('plainPassword', RepeatedType::class, [
                'type'              => PasswordType::class,
                'required'          => true,
                'invalid_message'   => 'update_password.not_similar',
                'first_options'  => [
                    'label' => 'update_password.label.password',
                    'constraints'   => [
                        new NotBlank(),
                        new Length(['min' => 8])
                    ],
                    'translation_domain' => 'front'
                ],
                'second_options' => [
                    'label' => 'update_password.label.confirm_password',
                    'translation_domain' => 'front'
                ]
            ])
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
