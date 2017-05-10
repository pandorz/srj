<?php

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use AppBundle\Entity\DateCalendrier;
use Sonata\AdminBundle\Form\FormMapper;

class DateCalendrierAdmin extends AbstractAdmin
{
    /**
     * Fields to be shown on create/edit forms
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('date', 'sonata_type_datetime_picker', [
            'label' => 'date_calendrier.date',
            'attr'  => [
                'placeholder' => $this->getTranslationLabel('date_calendrier.date.placeholder')
            ]
        ])
        ;
    }       

    public function toString($object)
    {
        return $object instanceof DateCalendrier
            ? $object->getDate()
            : $this->getTranslationLabel('date_calendrier.add_edit.to_string');
    }
}
