<?php

namespace WF3\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Validator\Constraints as Assert;


class JoboffersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder->add('promo', TextType::class, array(
            'label' => 'Numéro de promo*',
            'attr' => array(
                'placeholder' => '1 chiffre'
            ),
            'required' => true,                      
            'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Length(array(
                    'min' => 1,
                    'max' => 2,
                    'Message' => 'La promo est un numéro.'
                ))      
            )
        ));
        
     
       

    
         $builder->add('skills', ChoiceType::class, array(
            'label' => 'Domaine(s) de prédilection*', 
            'required' => true,                                       
            'choices' => array(
                'Front-end' => 'front-end',
                'back-end' => 'back-end',
                'full-stack' => 'full-stack'
            )
        ));   

        
          
    }
       
    public function getName()
    {
        return 'user';
    }

}

