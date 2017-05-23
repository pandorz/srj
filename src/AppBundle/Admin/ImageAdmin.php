<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Image;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Validator\Constraints\File;

class ImageAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $image = $this->getSubject();

        $formMapper
        ->add('alt', 'text', [
            'required'  => false,
            'label'     => 'image.add.alt'
        ]);

        $options = [
            'required'      => false,
            'label'         => 'image.add.file',
            'constraints'   => [new File([
                        'mimeTypes' => [
                                'image/png',
                                'image/jpeg',
                                'image/jpeg'
                            ]
                    ])]
        ];

        if ($image && ($webPath = $image->getUrl())) {
            // get the container so the full path to the image can be set
            $container = $this->getConfigurationPool()->getContainer();
            $fullPath = $container->get('request_stack')->getCurrentRequest()->getBasePath().'/'.$webPath;
            $options['help'] = '<img src="'.$ressource->getWebPath().'" class="admin-preview" />';
        }
        $formMapper
            ->add('file', 'file', $options);
        
    }

    public function toString($object)
    {
        return $object instanceof Image
            ? $object->getUrl()
            : $this->getTranslationLabel('image.add.to_string');
    }
}
