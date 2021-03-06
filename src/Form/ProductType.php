<?php

namespace App\Form;

use App\Entity\Theme;
use App\Entity\Produit;
use App\Entity\Assortiment;
use App\Entity\Souscategorie;
use App\Form\AssortimentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
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
                'label'=>'Mati??re',
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

            ->add('photo', FileType::class, [
                'label' => "Uploader photo 1",
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
                        'mimeTypesMessage' => 'Formats autoris??s : jpg/jpeg/png'
                    ])
                ]
            ])

            ->add('photo2', FileType::class, [
                'label' => "Uploader photo 2",
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
                        'mimeTypesMessage' => 'Formats autoris??s : jpg/jpeg/png'
                    ])
                ]
            ])

            ->add('souscategorie', EntityType::class, [
                'label' => "Choisir une sous-cat??gorie",
                'class' => Souscategorie::class, // On pr??cise de quelle entit?? vient ce champ
                'choice_label' => 'nom'//on d??finit la valeur qui apparaitra dans la liste d??roulante
            ])

            ->add('assortiment', EntityType::class, [
                'label' => "Choisir une collection",
                'class' => Assortiment::class, // On pr??cise de quelle entit?? vient ce champ
                'choice_label' => 'nom',
                'multiple'=>true,
                'expanded'=>true
                
            ])

            ->add('theme', EntityType::class, [
                'label' => "Choisir un th??me",
                'class' => Theme::class, // On pr??cise de quelle entit?? vient ce champ
                'choice_label' => 'nom',//on d??finit la valeur qui apparaitra dans la liste d??roulante
                'required'=>false
            ])

            ->add('etat', ChoiceType::class,[
                'choices'=>[
                    'Rupture de stock' => true],
                'expanded'=>true,
                'label'=> 'Signaler une rupture de stock',
                'required'=>false
                
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
