<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\KidType;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('memberName', TextType::class, array('label'  => 'Nom :'))
            ->add('memberSurname', TextType::class, array('label'  => 'Prénom :'))
            ->add('memberAddress1', TextType::class, array('label'  => 'Adresse :'))
            ->add('memberAddress2', TextType::class, array('label'  => 'Adresse (complément) :'))
            ->add('memberZipCode', TextType::class, array('label'  => 'Code Postal :'))
            ->add('memberCity', TextType::class, array('label'  => 'Ville :'))
            ->add('memberTel', TelType::class, array('label'  => 'Téléphone :'))
            ->add('memberEmail', EmailType::class, array('label'  => 'email :'))
            ->add('memberPassword', PasswordType::class, array('label'  => 'Mot de passe :'))
            ->add('memberButtonWallet', HiddenType::class, array('data'  => '0'))
            // ->add('memberRole', HiddenType::class, array('data'  => 'visiteur'))
            ->add('memberKidCount',IntegerType::class, array('label'  => 'Nombre d\'enfants :'))
            ->add('memberKidList', CollectionType::class, array(
                    'label'  => 'Enfant :',
                    'entry_type' => KidType::class,
                    'allow_add'=> true,
                    'allow_delete' => true
            ))
            ->add('memberSubscription', ChoiceType::class, array(
                'label'  => 'Abonnement à la newsletter',
                'expanded'=> true,
                'choices' => array(
                    'Oui' => true,
                    'Non' => false
                )))
            ->add('memberExpertise', TextType::class, array('label'  => 'Compétence que vous pouvez mettre à disposition:'))
            ->add('memberLevel', RangeType::class, array('label'  => 'Niveau en couture:'))
            // ->add('save', SubmitType::class, array('label' => 'Créez votre profil'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
        