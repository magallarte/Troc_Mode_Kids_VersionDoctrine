<?php

namespace App\Form;

use App\Entity\Kid;
use App\Entity\Member;
use App\Entity\School;
use App\Entity\Brands;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Form\FabricType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class KidType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('kidName', TextType::class, array('label'  => 'Nom :'))
            ->add('kidSurname', TextType::class, array('label'  => 'Prénom :'))
            ->add('kidParentList', EntityType::class, array(
                    'label'  => 'Ajouter un autre parent :',
                    'class' => 'App\Entity\Member',
                    'choice_label' => function ($parent){
                        return $parent->getMemberName().' '.$parent->getMemberSurname();
                    }))
            ->add('kidBirthday', BirthdayType::class, array(
                'label'  => 'Date de naissance :',
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
                'placeholder' => array(
                        'day' => 'Jour', 'month' => 'Mois', 'year' => 'Année',)
                ))
            ->add('kidSchoolId', EntityType::class, array(
                    'label'  => 'Ecole :',
                    'class' => 'App\Entity\School',
                    'choice_label' => 'schoolName',
                    'required' => false))
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Kid::class,
        ]);
    }
}
        