<?php

namespace App\Form;

use App\Entity\DeliveryBag;
use Symfony\Component\Form\AbstractType;
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
            ->add('deliveryBag_buyer')
            ->add('deliveryBag_processStatus')
            ->add('deliveryBag_delivery')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DeliveryBag::class,
        ]);
    }
}
