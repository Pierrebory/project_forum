<?php

namespace WF3\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints as Assert;


class JoboffersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder->add('title', TextType::class, array(
            'label' => 'Intitulé du poste',
            'attr' => array(
                'placeholder' => '100 caractères maximum'
            ),
            'required' => true,                      
            'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Length(array(
                    'min' => 5,
                    'max' => 100,
                    
                ))      
            )
        ));
        
     
       $builder->add('company', TextType::class, array(
            'label' => 'Société',
            'attr' => array(
                'placeholder' => '90 caractères maximum'
            ),
            'required' => true,                      
            'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Length(array(
                    'min' => 2,
                    'max' => 90,
                    
                ))      
            )
        ));

        
        
        
        $builder->add('city', TextType::class, array(
            'label' => 'Ville',
            'attr' => array(
                'placeholder' => 'Indiquez la ville et le département entre paranthèses'
            ),
            'required' => true,                      
            'constraints' => array(
                new Assert\NotBlank(),
                ))      
            );
      
        
        
        
        $builder->add('description', TextType::class, array(
            'label' => 'Description',
            'attr' => array(
                'placeholder' => 'Décrire le poste'
            ),
            'required' => true,                      
            'constraints' => array(
                new Assert\NotBlank(),
                ))      
            );
      
        
        
        
        $builder->add('skills', TextType::class, array(
            'label' => 'Compétences demandées',
            'attr' => array(
                'placeholder' => 'Compétences demandées'
            ),
            'required' => true,                      
            'constraints' => array(
                new Assert\NotBlank(),
                ))      
            );
      
        
        
        $builder->add('advantages', TextType::class, array(
            'label' => 'Salaire et avantages',
            'attr' => array(
                'placeholder' => 'Salaire et avantages'
            ),
            'required' => false,                      
            'constraints' => array(
                new Assert\NotBlank(),
                ))      
            );
      
    
         $builder->add('contract', ChoiceType::class, array(
            'label' => 'Type de contrat', 
            'required' => true,                                       
            'choices' => array(
                'CDI' => 'CDI',
                'CDD' => 'CDD',
                'indépendant' => 'indépendant',
            )
        ));   

       
        $builder->add('contractduration', TextType::class, array(
            'label' => 'si CDD, durée du CDD',
            'attr' => array(
                'placeholder' => 'durée du CDD en mois'
            ),
            'required' => false,                      
                ));
        
        
        $builder->add('timetable', ChoiceType::class, array(
            'label' => 'Durée hebdomadaire de temps de travail', 
            'required' => true,                                       
            'choices' => array(
                'Temps plein' => 'Temps plein',
                'Temps partiel' => 'Temps partiel',
            )
        )); 
        
        
        
        $builder->add('recruitername', TextType::class, array(
            'label' => 'Nom du recruteur',
            'attr' => array(
                'placeholder' => 'Nom du recruteur'
            ),
            'required' => true,                      
            'constraints' => array(
                new Assert\NotBlank(),
                ))      
            );
        
        
        $builder->add('recruitercontact', TextType::class, array(
            'label' => 'Contact du recruteur',
            'attr' => array(
                'placeholder' => 'Email du recruteur'
            ),
            'required' => true,                      
            'constraints' => array(
                new Assert\NotBlank(),
                ))      
            );
        
        
          
    }
       
    public function getName()
    {
        return 'user';
    }

}

