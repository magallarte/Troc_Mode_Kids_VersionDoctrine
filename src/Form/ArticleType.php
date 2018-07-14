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
use App\Form\FabricType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionResolver\OptionResolver;

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
        // OPTION avec la création du formulaire  FABRIC imbriqué dans celui d ARTICLE
        //     ->add('article_fabric', CollectionType::class, array(
        //             'label'  => 'Composition :',
        //             'entry_type' => FabricType::class,
        //             'allow_add'=> true
        //     ))
            ->add('article_fabric', EntityType::class, array(
                    'label'  => 'Tissu :',
                    'class' => 'App\Entity\Fabric',
                    'multiple'=> 'true',
                    'choice_label' => 'FabricName'))
            ->add('article_buttonValue', MoneyType::class, array('label'  => 'Valeur "Boutons"  '))
            ->add('article_eurosValue', MoneyType::class, array('label'  => 'Valeur "Euros"  '))
            ->add('article_comments', TextareaType::class, array('label'  => 'Descriptif '))
            ->add('article_processStatus', EntityType::class, array(
                    'label'  => 'Etape de traitement :',
                    'class' => 'App\Entity\ProcessStatus',
                    'choice_label' => 'ProcessStatusName'))
            ->add('article_picture1', FileType::class, array('label' => 'Photo Recto(png)','data_class' => null))
            ->add('article_picture2', FileType::class, array('label' => 'Photo Verso (png)','data_class' => null))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
        