<?php

namespace App\Form;
use App\Entity\Theme;
use App\Entity\Assortiment;
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

class AssortimentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => "Assortiment",
                'required' => false,
                'attr'=>[
                    'placeholder' => "Saisir le nom de l'assortiment",
                ],
                'constraints' => [
                    new Length([
                        'min' => 2, 
                        'max' => 50,
                        'minMessage' => "Nom trop court",
                        'maxMessage'=> "Nom trop long"
                    ]),
                    new NotBlank([
                        'message' => "Merci de saisir un nom d'assortiment."
                    ])
                ]
            ])

            ->add('couleur', ChoiceType::class,[
                'choices'=>[
                   'gold'=>'gold',
                   'silver'=>'silver'],
                'label'=> 'Couleur :',
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
                        'mimeTypesMessage' => 'Formats autorisés : jpg/jpeg/png',
                        'maxSizeMessage'=> 'Taille maximale: 5mo'
                    ])
                ]
            ])

            ->add('theme', EntityType::class, [
                'label' => "Choisir un thème",
                'class' => Theme::class, // On précise de quelle entité vient ce champ
                'choice_label' => 'nom',//on définit la valeur qui apparaitra dans la liste déroulante
                'required'=>false
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Assortiment::class,
        ]);
    }
}
