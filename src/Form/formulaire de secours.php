            ->add('article_buttonValue', MoneyType::class, array('label'  => 'Valeur "Boutons" :'))
            ->add('article_eurosValue', MoneyType::class, array('label'  => 'Valeur "Euros" :'))
            ->add('article_comments', TextareaType::class, array('label'  => 'Descriptif :'))
            ->add('article_color', EntityType::class, array(
                    'label'  => 'Couleur :',
                    'class' => 'App\Entity\Color',
                    'multiple'=> 'true',
                    'choice_label' => 'ColorName'))
            ->add('article_brand', EntityType::class, array(
                    'label'  => 'Marque :',
                    'class' => 'App\Entity\Brand',
                    'choice_label' => 'BrandName'))
            ->add('article_type', EntityType::class, array(
                    'label'  => 'Catégorie de produit :',
                    'class' => 'App\Entity\Type',
                    'choice_label' => 'TypeName'))
            ->add('article_size', EntityType::class, array(
                    'label'  => 'Taille :',
                    'class' => 'App\Entity\Size',
                    'choice_label' => 'SizeName'))
            ->add('article_wearStatus', EntityType::class, array(
                    'label'  => 'Etat d\'usure :',
                    'class' => 'App\Entity\WearStatus',
                    'choice_label' => 'WearStatusName'))
            ->add('article_gender', EntityType::class, array(
                    'label'  => 'Sexe :',
                    'class' => 'App\Entity\Gender',
                    'choice_label' => 'GenderName'))
            ->add('article_processStatus', EntityType::class, array(
                    'label'  => 'Etape de traitement :',
                    'class' => 'App\Entity\ProcessStatus',
                    'choice_label' => 'ProcessStatus'))
            ->add('article_fabric', EntityType::class, array(
                    'label'  => 'Marque :',
                    'class' => 'App\Entity\Fabric',
                    'choice_label' => 'FabricName'))