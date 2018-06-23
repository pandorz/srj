<?php
namespace AppBundle\Form;

use AppBundle\Entity\Blog;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class BlogType
 * @package AppBundle\Form
 */
class BlogType extends AbstractType
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
                    'label'    => 'En-tête de l\'article',
                    'required' => false,
                    'attr'  => ['class' => 'js-form-image form-image']
                ]
            )
            ->add(
                'nom',
                TextType::class,
                [
                    'label'         => 'blog.nom',
                    'required'      => true,
                    'constraints'   => [
                        new NotBlank()
                    ]
                ]
            )
            ->add(
                'descriptionCourte',
                TextType::class,
                [
                    'label'         => 'blog.descriptionCourte',
                    'required'      => true,
                    'constraints'   => [
                        new NotBlank()
                    ]
                ]
            )
            ->add(
                'contenu',
                CKEditorType::class,
                [
                    'label'         => 'blog.contenu',
                    'required'      => true,
                    'config_name'   => 'article',
                    'constraints'   => [
                        new NotBlank()
                    ]
                ]
            );
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Blog::class]);
    }


    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_Blog';
    }
}
