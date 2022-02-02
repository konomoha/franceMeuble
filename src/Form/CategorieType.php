<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => "Nom de la catégorie",
                'attr'=>[
                    'placeholder'=> "Saisir le nom de la catégorie"
                ],
                'required'=>false,
                'constraints' => [
                    new Length([
                        'min' => 3, 
                        'max' => 15,
                        'minMessage' => "Nom trop court",
                        'maxMessage'=> "Nom trop long"
                    ]),
                    new NotBlank([
                        'message' => "Merci de sasir un nom de catégorie"
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr'=> [
                    'placeholder' => "Saisir la description de la catégorie",
                ],
                'required'=>false,
                'constraints'=>[
                    new NotBlank([
                        'message'=>"Merci de saisir une description"
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
