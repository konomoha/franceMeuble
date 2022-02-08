<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Souscategorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SousCategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'required'=> false,
                'constraints' => [
                    new NotBlank([
                        'message'=>"Veuillez renseigner le nom de la sous-catégorie."
                    ])
                ]
            ])
            ->add('categorie', EntityType::class, [
                'label' => "Choisir une catégorie",
                'class' => Categorie::class, // On précise de quelle entité vient ce champ
                'choice_label' => 'nom'//on définit la valeur qui apparaitra dans la liste déroulante
            ])

            ->add('photo', FileType::class, [
                'label' => "Uploader une photo",
                'mapped' => true, 
                'data_class'=> null,
                'required'=> false,
                
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                            'image/gif'
                        ],
                        'mimeTypesMessage' => 'Formats autorisés : jpg/jpeg/png'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Souscategorie::class,
        ]);
    }
}
