<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if($options['userRegister'] == true)
        {
            $builder
                //POUR L'EMAIL, IL FAUDRA AJOUTER UNE CONTRAINTE QUI CONTRÔLE LE RESPECT DE LA CASSE!
                ->add('email', TextType::class,[
                    'required'=> false,
                    'constraints' => [
                        new Regex ([
                            'pattern'=>'/^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/',
                            'match'=>true,
                            'message'=> "Veuillez un email valide!"
                    ])
                    ]
                ])

                #################### CHECKBOX CONDITIONS GENERALES (fonctionnel, à ajouter si besoin)#############################################

                // ->add('agreeTerms', CheckboxType::class, [
                //     'mapped' => false,
                //     'constraints' => [
                //         new IsTrue([
                //             'message' => 'Veuillez accepter les conditions générales.',
                //         ]),
                //     ],
                // ])


                ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'required' => false,
                    'invalid_message' =>"Les mots de passe ne correspondent pas",
                    'options' =>[
                        'attr' =>[
                            'class' => 'password-field'
                    ]
                    ],
                    'first_options' => [
                        'label' => "Mot de passe"
                    ],
                    'second_options' =>[
                        'label'=>"Confirmer votre mot de passe"
                    ],
                    'constraints'=>[
                        new NotBlank([
                            'message'=>"Veuillez renseigner votre mot de passe."
                        ]),
                        new Length([
                            'min'=>8,
                            'minMessage' =>"Votre mot de passe doit contenir au minimum 8 caractères."
                        ])

                    ]

                ])
                
                ->add('nom', TextType::class,[
                    'required'=> false,
                    'constraints' => [
                        new NotBlank([
                            'message'=>"Veuillez renseigner votre nom."
                        ])
                    ]
                ])

                ->add('prenom', TextType::class,[
                    'required'=> false,
                    'constraints' => [
                        new NotBlank([
                            'message'=>"Veuillez renseigner votre prenom."
                        ])
                    ]
                ])

                ->add('adresse', TextType::class,[
                    'required'=> false,
                    'constraints' => [
                        new NotBlank([
                            'message'=>"Veuillez renseigner votre adresse."
                        ])
                    ]
                ])

                ->add('telephone', TextType::class,[
                    'required'=>false,
                    'constraints'=>[
                        //Regex qui prend en compte le '0' initial des numéros de tel
                        new Regex ([
                            'pattern'=>'/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/',
                            'match'=>true,
                            'message'=> "Veuillez entrer un numéro de téléphone valide"
                    ])
                    
                    ]
                ])

                ->add('codePostal', NumberType::class,[
                    'required'=>false,
                    'constraints'=>[
                        new Length([
                            'min' => 5, 
                            'max' => 5,
                            'minMessage' => "Veuillez entrer un code postal à 5 chiffres",
                            'maxMessage'=> "Veuillez entrer un code postal à 5 chiffres"
                        ]),
                    ]
                ])

                ->add('ville', TextType::class,[
                    'required'=> false,
                    'constraints' => [
                        new NotBlank([
                            'message'=>"Veuillez renseigner votre ville."
                        ])
                    ]
                ])

                ->add('avatar', FileType::class, [
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
                
                ->add('sexe', ChoiceType::class, [
                    'choices' => [
                        'Homme' => 'm',
                        'Femme' => 'f'                    
                    ],
                    // 'attr' => [
                    //     'style' => 'margin-left: 10px;'
                    // ],
                    'expanded' => true,
                    'multiple' => false,
                    'label' => 'Civilité' 
                ])
                    
            ;
        }

        elseif($options['userUpdate'] == true)
        {
            $builder
               
                ->add('nom', TextType::class,[
                    'required'=> false,
                    'constraints' => [
                        new NotBlank([
                            'message'=>"Veuillez renseigner votre nom."
                        ])
                    ]
                ])

                ->add('prenom', TextType::class,[
                    'required'=> false,
                    'constraints' => [
                        new NotBlank([
                            'message'=>"Veuillez renseigner votre prenom."
                        ])
                    ]
                ])

                ->add('adresse', TextType::class,[
                    'required'=> false,
                    'constraints' => [
                        new NotBlank([
                            'message'=>"Veuillez renseigner votre adresse."
                        ])
                    ]
                ])

                ->add('telephone', TextType::class,[
                    'required'=>false,
                    'constraints'=>[
                        //Regex qui prend en compte le '0' initial des numéros de tel
                        new Regex ([
                            'pattern'=>'/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/',
                            'match'=>true,
                            'message'=> "Veuillez entrer un numéro de téléphone valide"
                    ])
                    
                    ]
                ])

                ->add('codePostal', NumberType::class,[
                    'required'=>false,
                    'constraints'=>[
                        new Length([
                            'min' => 5, 
                            'max' => 5,
                            'minMessage' => "Veuillez entrer un code postal à 5 chiffres",
                            'maxMessage'=> "Veuillez entrer un code postal à 5 chiffres"
                        ]),
                    ]
                ])

                ->add('ville', TextType::class,[
                    'required'=> false,
                    'constraints' => [
                        new NotBlank([
                            'message'=>"Veuillez renseigner votre ville."
                        ])
                    ]
                ])

                ->add('dateNaissance', BirthdayType::class, [
                    'label' => "Date de Naissance",
                    'placeholder' => [
                        'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                    ],
                ])

                ->add('avatar', FileType::class, [
                    'label' => "Uploader une photo",
                    'mapped' => true, 
                    'data_class'=> null,
                    // 'required'=>false,
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
                
                ->add('sexe', ChoiceType::class, [
                    'choices' => [
                        'Homme' => 'm',
                        'Femme' => 'f'                    
                    ],
                    // 'attr' => [
                    //     'style' => 'margin-left: 10px;'
                    // ],
                    'expanded' => true,
                    'multiple' => false,
                    'label' => 'Civilité' 
                ])
                    
            ;
        }

        elseif($options['roleUpdate'] == true)
        {
            $builder
            ->add('roles', ChoiceType::class, [
                'choices'=>[
                    'Utilisateur'=>'',
                    'Administrateur'=>'ROLE_ADMIN'
                ],
                'expanded'=>false,
                'multiple'=>true,
                'label'=>"Définir le role de l'utilisateur"
                
            ])
            
            ->add('nom', TextType::class,[
                'required'=> false,
                'constraints' => [
                    new NotBlank([
                        'message'=>"Veuillez renseigner votre nom."
                    ])
                ]
            ])

            ->add('prenom', TextType::class,[
                'required'=> false,
                'constraints' => [
                    new NotBlank([
                        'message'=>"Veuillez renseigner votre prenom."
                    ])
                ]
            ])

            ->add('adresse', TextType::class,[
                'required'=> false,
                'constraints' => [
                    new NotBlank([
                        'message'=>"Veuillez renseigner votre adresse."
                    ])
                ]
            ])

            ->add('telephone', TextType::class,[
                'required'=>false,
                'constraints'=>[
                    //Regex qui prend en compte le '0' initial des numéros de tel
                    new Regex ([
                        'pattern'=>'/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/',
                        'match'=>true,
                        'message'=> "Veuillez entrer un numéro de téléphone valide"
                ])
                
                ]
            ])

            ->add('codePostal', NumberType::class,[
                'required'=>false,
                'constraints'=>[
                    new Length([
                        'min' => 5, 
                        'max' => 5,
                        'minMessage' => "Veuillez entrer un code postal à 5 chiffres",
                        'maxMessage'=> "Veuillez entrer un code postal à 5 chiffres"
                    ]),
                ]
            ])

            ->add('ville', TextType::class,[
                'required'=> false,
                'constraints' => [
                    new NotBlank([
                        'message'=>"Veuillez renseigner votre ville."
                    ])
                ]
            ])

            ->add('dateNaissance', BirthdayType::class, [
                'label' => "Date de Naissance",
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
            ])

            ->add('avatar', FileType::class, [
                'label' => "Uploader une photo",
                'mapped' => true, 
                'data_class'=> null,
                // 'required'=>false,
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
            
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'Homme' => 'm',
                    'Femme' => 'f'                    
                ],
                // 'attr' => [
                //     'style' => 'margin-left: 10px;'
                // ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Civilité' 
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'userRegister' => false,
            'userUpdate' => false,
            'roleUpdate'=> false
        ]);
    }
}
