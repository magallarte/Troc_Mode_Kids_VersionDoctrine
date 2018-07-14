<?php

namespace App\Form;

use App\Entity\DeliveryBag;
use App\Entity\Member;
use App\Entity\Delivery;
use App\Entity\ProcessStatus;
use App\Entity\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeliveryBagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('deliveryBag_serviceFee')
            ->add('deliveryBag_buttonAmount')
            ->add('deliveryBag_buyDate')
            ->add('deliveryBag_deliveryFee')
            ->add('deliveryBag_deliveryDate')
            ->add('deliveryBag_buyer', EntityType::class, array(
                'label'  => 'Acheteur',
                'class' => 'App\Entity\Member',
                'choice_label' => 'MemberName'))
            ->add('deliveryBag_processStatus', EntityType::class, array(
                'label'  => 'Etape de préparation',
                'class' => 'App\Entity\ProcessStatus',
                'choice_label' => 'ProcessStatusName'))          
            ->add('deliveryBag_delivery', EntityType::class, array(
                'label'  => 'Type de livraison',
                'class' => 'App\Entity\Delivery',
                'choice_label' => 'DeliveryType'))  
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DeliveryBag::class,
        ]);
    }
}
