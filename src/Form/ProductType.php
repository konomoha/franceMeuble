<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Souscategorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => "Nom du produit",
                'required' => false,
                'attr'=>[
                    'placeholder' => "Saisir le nom du produit",
                ],
                'constraints' => [
                    new Length([
                        'min' => 2, 
                        'max' => 50,
                        'minMessage' => "Nom trop court",
                        'maxMessage'=> "Nom trop long"
                    ]),
                    new NotBlank([
                        'message' => "Merci de saisir un nom de produit."
                    ])
                ]
            ])

            ->add('couleur', ChoiceType::class,[
                'choices'=>[
                   'noir'=>'noir',
                   'blanc'=>'blanc',
                   'bleu'=>'bleu',
                   'rouge'=>'rouge',
                   'vert'=>'vert',
                   'rose'=>'rose',
                   'turquoise'=>'turquoise'],
                'label'=> 'Couleur :',
                'required'=>false,
            ])

            ->add('matiere', ChoiceType::class,[
                'choices'=>[
                    'mousse'=>'mousse',
                    'marbre'=>'marbre',
                    'bois'=>'bois',
                    'cuir'=>'cuir'
                ],
                'label'=>'Matière',
                'required'=>false,
                'constraints' => [
                    new NotBlank([
                        'message'=>"Veuillez renseigner le nom du produit."
                    ])
                ]
            ])

            ->add('longueur', NumberType::class,[
                'label'=>'longueur',
                'required'=>false
                ])

            ->add('largeur', NumberType::class,[
                'label'=>'largeur',
                'required'=>false
                ])

            ->add('hauteur', NumberType::class,[
                'label'=>'hauteur',
                'required'=>false
                ])

            ->add('profondeur', NumberType::class,[
                'label'=>'profondeur',
                'required'=>false
                ])

            ->add('diametre', NumberType::class,[
                'label'=>'diametre',
                'required'=>false
                ])

            ->add('prix', NumberType::class,[
                'constraints' => [
                    new NotBlank([
                        'message'=>"Veuillez renseigner le prix du produit."
                    ])
                    ],
                    'required'=>false,
            ])

            ->add('stock', NumberType::class,[
                'constraints' => [
                    new NotBlank([
                        'message'=>"Veuillez renseigner la quantité du produit."
                    ])
                    ],
                    'required'=>false,
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

            ->add('souscategorie', EntityType::class, [
                'label' => "Choisir une sous-catégorie",
                'class' => Souscategorie::class, // On précise de quelle entité vient ce champ
                'choice_label' => 'nom'//on définit la valeur qui apparaitra dans la liste déroulante
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
