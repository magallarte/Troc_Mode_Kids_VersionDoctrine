<?php

namespace App\Form;

use App\Entity\SchoolStop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SchoolStopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('schoolStop_date')
            ->add('schoolStop_school')
            // ->add('interest', CheckboxType::class, array(
            //     'label'  => 'Cà m\'intéresse',
            //     'mapped' => false
            //     ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SchoolStop::class,
        ]);
    }
}
