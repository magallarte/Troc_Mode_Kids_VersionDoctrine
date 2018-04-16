<?php

namespace App\Form;

use App\Entity\Workshop;
use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface; 
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityRepository;
use App\Form\WorkshopType;
use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkshopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('workshop_date', DateTimeType::class, array(
                'label'  => 'Date et heure :',
                'widget' => 'choice',
                // pourquoi le format n'est pas pris en compte ?
                'format' => 'dd-MM-yyyy',
                'placeholder' => array(
                        'day' => 'Jour', 'month' => 'Mois', 'year' => 'Année',)
                ))
            ->add('workshop_theme', TextType::class, array('label'  => 'Thème : '))
            ->add('workshop_fee', MoneyType::class, array('label'  => 'Prix : '))
            ->add('workshop_place', TextareaType::class, array('label'  => 'Lieu :'))
            ->add('workshop_picture', TextType::class, array('label'  => 'Image :'))
            ->add('workshop_trainer', EntityType::class, array(
                'label'  => 'Formateur',
                'class' => Member::class,
                'query_builder' => function (\App\Repository\MemberRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->innerJoin('m.member_role', 'r', 'WITH', 'r.role_name = :role')
                        ->addselect('r')
                        ->orderBy('m.member_name', 'ASC')
                        ->setParameter('role', "formateur");
                 },
                'choice_label' => function ($trainers){
                 return $trainers->getMemberSurname().' '.$trainers->getMemberName();
                },
                ))
            ->add('workshop_trainees_list', EntityType::class, array(
                'label'  => 'Personnes inscrites',
                'class' => Member::class,
                'choice_label' => function ($members){
                 return $members->getMemberSurname().' '.$members->getMemberName();
                },
                'multiple'=>true
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Workshop::class,
        ]);
    }
}