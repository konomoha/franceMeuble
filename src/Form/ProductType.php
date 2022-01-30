<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Souscategorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'required'=> false,
                'constraints' => [
                    new NotBlank([
                        'message'=>"Veuillez renseigner le nom du produit."
                    ])
                ]
            ])

            ->add('couleur')

            ->add('matiere')

            ->add('longueur')

            ->add('largeur')

            ->add('hauteur')

            ->add('profondeur')

            ->add('diametre')

            ->add('prix')

            ->add('stock')

            ->add('photo')

            ->add('souscategorie', EntityType::class, [
                'label' => "Choisir une sosu-catégorie",
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
