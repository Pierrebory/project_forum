<?php

namespace WF3\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints as Assert;


class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /////////////// NOM DE FAMILLE //////////////////
        $builder->add('username', TextType::class, array(
            'label' => 'Votre nom*',
            'attr' => array(
                'placeholder' => 'Au moins 2 caractères'
            ),
            'required' => true,            
            'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Length(array(
                    'min' => 2,
                    'max' => 45,
                    'minMessage' => 'Votre nom doit faire au moins 2 caractères.',
                    'minMessage' => 'Votre nom ne dois pas faire plus de 45 caractères.'
                )),
                new Assert\Regex(array(
                    'pattern' => '/\d/',
                    'match'   => false,
                    'message' => 'Votre nom ne doit pas contenir de chiffres.'    
                ))                
            )
        ));

        /////////////////// PRENOM /////////////////////////
        $builder->add('firstname', TextType::class, array(
            'label' => 'Votre prénom*',
            'attr' => array(
                'placeholder' => 'Au moins 2 caractères'
            ),
            'required' => true,            
            'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Length(array(
                    'min' => 2,
                    'max' => 45,
                    'minMessage' => 'Votre prénom doit faire au moins 2 caractères.',
                    'minMessage' => 'Votre prénom ne dois pas faire plus de 45 caractères.'
                )),
                new Assert\Regex(array(
                    'pattern' => '/\d/',
                    'match'   => false,
                    'message' => 'Votre prénom ne doit pas contenir de chiffres.'    
                ))                  
            )
        ));   


        /////////////// EMAIL //////////////////
        $builder->add('email', TextType::class, array(
            'label' => 'Votre email*',
            'attr' => array(
                'placeholder' => 'Au format exemple@domaine.com'
            ),
            'required' => true,            
            'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Email(array(
                    'checkMX' => true,
                    'message' => 'Votre adresse email n\'est pas valide.'                    
                ))
            )
        ));   

        ////////////////// MOT DE PASSE /////////////////////
        $builder->add('password', RepeatedType::class, array(       
            'type' => PasswordType::class,
            'attr' => array(
                'placeholder' => 'Au moins 4 caractères'
            ),            
            'invalid_message' => 'Les mots de passe doivent être identiques.',
            'required' => true,
            'first_options'  => array('label' => 'Votre mot de passe*'),
            'second_options' => array('label' => 'Répetez le mot de passe*'),
            'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Length(array(
                    'min' => 4,
                    'max' => 255,
                    'minMessage' => 'Votre mot de passe doit faire au moins 4 caractères.',
                    'minMessage' => 'Votre mot de passe ne dois pas faire plus de 255 caractères.'
                ))
            )            
        ));    


        ///////////// NUMERO DE TELEPHONE ///////////
        $builder->add('phone', TextType::class, array(
            'label' => 'Votre numéro de téléphone',
            'attr' => array(
                'placeholder' => 'Au format 0123456789'
            ),           
            'constraints' => array(            
                new Assert\Regex(array(
                    'pattern' => '/[0][1-9][0-9]{8}/',
                    'message' => 'Votre numéro de téléphone n\'est pas valide.'              
                ))
            )
        ));   

        ////////////////// VILLE ////////////////////
        $builder->add('city', TextType::class, array(
            'label' => 'Votre ville*',
            'attr' => array(
                'placeholder' => 'Au moins 2 caractères'
            ),           
            'required' => true,                            
            'constraints' => array(
                new Assert\Length(array(
                    'min' => 2,
                    'max' => 255,
                    'minMessage' => 'Votre ville doit faire au moins 2 caractères.',
                    'minMessage' => 'Votre ville ne dois pas faire plus de 255 caractères.'
                )),                   
                new Assert\Regex(array(
                    'pattern' => '/\d/',
                    'match'   => false,
                    'message' => 'Votre ville ne doit pas contenir de chiffres.'            
                ))
            )
        ));   


        //////////////////// ROLE ////////////////////
        $builder->add('role', ChoiceType::class, array(
            'label' => 'Qui êtes-vous ?*',           
            'attr' => array(
                'name' => 'role',
                'id' => 'role'
            ),                  
            'choices' => array(
                'un élève' => 'ROLE_USER',
                'un recruteur' => 'ROLE_ADMIN',
            )
        ));          

    }   

    public function getName()
    {
        return 'user';
    }
}

