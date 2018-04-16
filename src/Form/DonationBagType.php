<?php

namespace App\Form;

use App\Entity\DonationBag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DonationBagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('donationBag_date')
            ->add('donationBag_donator')
            ->add('donationBag_processStatus')
            ->add('donationBag_schoolStop')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DonationBag::class,
        ]);
    }
}
