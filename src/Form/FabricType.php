<?php

namespace App\Form;

use App\Entity\Fabric;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class FabricType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fabric_name', TextType::class, array('label'  => 'Nom du tissu : '))
            // ->add('fabric_percentage')
            ->add('fabric_code', IntegerType::class, array(
                'label'  => '% ',
                'mapped' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fabric::class,
        ]);
    }
}
