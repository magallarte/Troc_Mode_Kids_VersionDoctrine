<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Brand;
use App\Entity\Color;
use App\Entity\Fabric;
use App\Entity\Gender;
use App\Entity\ProcessStatus;
use App\Entity\Season;
use App\Entity\Size;
use App\Entity\Type;
use App\Entity\WearStatus;
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
use Symfony\Component\Form\Extension\Core\Type\FabricType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('article_gender', EntityType::class, array(
                    'label'  => 'Sexe',
                    'class' => 'App\Entity\Gender',
                    'choice_label' => 'GenderName'))
            ->add('article_type', EntityType::class, array(
                    'label'  => 'Catégorie de produit ',
                    'class' => 'App\Entity\Type',
                    'choice_label' => 'TypeName'))
            ->add('article_season', EntityType::class, array(
                    'label'  => 'Saison ',
                    'class' => 'App\Entity\Season',
                    'multiple'=> true,
                    'expanded'=> true,
                    'choice_label' => 'SeasonName'))
            ->add('article_size', EntityType::class, array(
                    'label'  => 'Taille ',
                    'class' => 'App\Entity\Size',
                    'choice_label' => 'SizeName'))
            ->add('article_color', EntityType::class, array(
                    'label'  => 'Couleur ',
                    'class' => 'App\Entity\Color',
                    'multiple'=> 'true',
                    'choice_label' => 'ColorName'))
            ->add('article_brand', EntityType::class, array(
                    'label'  => 'Marque ',
                    'class' => 'App\Entity\Brand',
                    'choice_label' => 'BrandName'))
            ->add('article_wearStatus', EntityType::class, array(
                    'label'  => 'Etat d\'usure :',
                    'class' => 'App\Entity\WearStatus',
                    'choice_label' => 'WearStatusName'))
            ->add('article_fabric', EntityType::class, array(
                    'label'  => 'Composition :',
                    'class' => 'App\Entity\Fabric',
                    'expanded'=> true,
                    'multiple'=> true,
                    'choice_label' => 'FabricName'))
            // ->add('article_fabric', CollectionType::class, array(
            //         'label'  => 'Composition :',
            //         'entry_type' => ChoiceType::class,
            //         // these options are passed to each "email" type
            //         'entry_options' => $builder->create('article_fabric', FormType::class, array('by_reference' => true))
            //         ->add('composition', EntityType::class, array(
            //             'label'  => 'Composition :',
            //             'class' => 'App\Entity\Fabric',
            //             'choice_label' => 'FabricName'))
            //         ->add('percentage', ChoiceType::class, array(
            //         'entry_type' => PercentType::class,
            //         'entry_options' => array(
            //             'attr' => array('class' => 'email-box')))))
            // ->add('article_fabric2', CollectionType::class, array(
            //         'label'  => 'Composition en pourcentage :',
            //         'entry_type' => ChoiceType::class,
            //         'entry_options' => array(
            //             'choices' => array (
            //                 '5' => '5',
            //                 '10' => '10',
            //                 '20' => '20',
            //                 '30' => '30',
            //             ),
            //         'allow_add' => true,
            //         )))
            // ->add('article_fabric%', PercentType::class, array(
            //         'label'  => 'Marque :',
            //         'class' => 'App\Entity\Fabric',
            //         'choice_label' => 'FabricName'))
            // ->add(
            //         $builder->create('article_fabric', FormType::class, array('by_reference' => true))
            //         ->add('composition', EntityType::class, array(
            //             'label'  => 'Composition :',
            //             'class' => 'App\Entity\Fabric',
            //             'choice_label' => 'FabricName'))
            //         ->add('percentage', CollectionType::class, array(
            //         'entry_type' => PercentType::class,
            //         'entry_options' => array(
            //             'attr' => array('class' => 'email-box')))))
            //  ->add(
            //         $builder->create('article_fabric', FormType::class, array('by_reference' => true))
            //         ->add('composition', EntityType::class, array(
            //             'label'  => 'Composition :',
            //             'class' => 'App\Entity\Fabric',
            //             'choice_label' => 'FabricName'))
            //         ->add('pourcentage', ChoiceType::class, array(
            //             'label'  => 'Composition en pourcentage :',
            //             'choices' => array(
            //                 '5' => '5',
            //                 '10' => '10'))))
            ->add('article_buttonValue', MoneyType::class, array('label'  => 'Valeur "Boutons"  '))
            ->add('article_eurosValue', MoneyType::class, array('label'  => 'Valeur "Euros"  '))
            // ->add('article_comments', TextareaType::class, array('label'  => 'Descriptif '))
            ->add('article_processStatus', EntityType::class, array(
                    'label'  => 'Etape de traitement :',
                    'class' => 'App\Entity\ProcessStatus',
                    'choice_label' => 'ProcessStatusName'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
        