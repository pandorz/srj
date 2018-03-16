<?php
namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

/**
 * Class ContactType
 * @package AppBundle\Form
 */
class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('POST')
            ->add(
                'email',
                EmailType::class,
                [
                    'required' => true,
                    'label_attr' => ['class' => 'u-hiddenVisually'],
                    'attr' => [
                        'class' => 'fld',
                        'placeholder' => 'contact.placeholder.email'
                    ],
                    'label' => 'contact.email',
                    'constraints'   => [
                        new NotBlank(),
                        new Email(),
                    ]
                ]
            )
            ->add(
                'message',
                TextareaType::class,
                [
                    'required' => true,
                    'label_attr' => ['class' => 'fldLabel'],
                    'attr' => [
                        'class' => 'fld',
                        'placeholder' => 'contact.placeholder.message',
                        'rows' => 8
                    ],
                    'label' => 'contact.message',
                    'constraints'   => [
                        new NotBlank()
                    ]
                ]
            )
            ->add(
                'nom',
                TextType::class,
                [
                    'required' => true,
                    'label_attr' => ['class' => 'u-hiddenVisually'],
                    'attr' => ['class' => 'fld', 'placeholder' => 'contact.placeholder.nom'],
                    'label' => 'contact.nom',
                    'constraints'   => [
                        new NotBlank()
                    ]
                ]
            )
            ->add(
                'prenom',
                TextType::class,
                [
                    'required' => true,
                    'label_attr' => ['class' => 'u-hiddenVisually'],
                    'attr' => ['class' => 'fld', 'placeholder' => 'contact.placeholder.prenom'],
                    'label' => 'contact.prenom',
                    'constraints'   => [
                        new NotBlank()
                    ]
                ]
            )
            ->add(
                'objet',
                TextType::class,
                [
                    'required' => true,
                    'label_attr' => ['class' => 'u-hiddenVisually'],
                    'attr' => [
                        'class' => 'fld',
                        'placeholder' => 'contact.placeholder.sujet'
                    ],
                    'label' => 'contact.sujet',
                    'constraints'   => [
                        new NotBlank()
                    ]
                ]
            );
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_contact';
    }
}
