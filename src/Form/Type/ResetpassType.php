<?php

namespace WF3\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints as Assert;



class ResetpassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        ////////////////// MOT DE PASSE /////////////////////
        $builder->add('password', RepeatedType::class, array(       
            'type' => PasswordType::class,
            'label' => false,           
            'invalid_message' => 'Les mots de passe doivent être identiques.',
            'required' => true,
            'first_options'  => array('label' => 'Nouveau mot de passe', 'attr' => array('placeholder' => 'Au moins 4 caractères')),
            'second_options' => array('label' => 'Répetez le mot de passe', 'attr' => array('placeholder' => 'Identique au précédent')),
            'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Length(array(
                    'min' => 4,
                    'max' => 255,
                    'minMessage' => 'Votre mot de passe doit faire au moins 4 caractères.',
                    'maxMessage' => 'Votre mot de passe ne dois pas faire plus de 255 caractères.'
                ))
            )            
        ));    
    }

    public function getName()
    {
        return 'user';
    }
}

