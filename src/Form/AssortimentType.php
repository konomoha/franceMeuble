<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Assortiment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AssortimentType extends AbstractType
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
            ->add('produits', EntityType::class, [
                'label' => "Choisir une sous-catégorie",
                'class' => Produit::class, // On précise de quelle entité vient ce champ
                'choice_label' => 'nom'//on définit la valeur qui apparaitra dans la liste déroulante
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
