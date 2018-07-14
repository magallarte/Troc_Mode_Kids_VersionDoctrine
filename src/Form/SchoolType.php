<?php

namespace App\Form;

use App\Entity\School;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SchoolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('school_name')
            ->add('school_address1')
            ->add('school_address2')
            ->add('school_zip_code')
            ->add('school_city')
            ->add('school_director_gender')
            ->add('school_director_name')
            ->add('school_director_tel')
            ->add('school_director_email')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => School::class,
        ]);
    }
}
