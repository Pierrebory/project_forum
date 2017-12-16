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


class AlumniType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('promo', TextType::class, array(
            'label' => 'Numéro de promo*',
            'attr' => array(
                'placeholder' => '1 chiffre'
            ),
            'required' => true,                      
            'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Length(array(
                    'min' => 1,
                    'max' => 2
               
                ))      
            )
        ));
        
     
        $builder->add('presentation', TextType::class, array(
            'label' => 'Présentation brève*',
            'attr' => array(
                'placeholder' => 'Au moins 10 caractères'
            ),
            'required' => true,                      
            'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Length(array(
                    'min' => 10,
                    'max' => 255,
                    'minMessage' => 'Votre présentation doit faire au moins 10 caractères.',
                    'maxMessage' => 'Votre nom ne doit pas faire plus de 255 caractères.'
                )),
                
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

        
         $builder->add('status', ChoiceType::class, array(
            'label' => 'Situation actuelle*', 
            'required' => true,                                       
            'choices' => array(
                'en recherche d\'emploi' => 'en recherche d\'emploi',
                'en emploi' => 'en emploi',
                'en formation' => 'en formation',
                'en auto-entrepreneur' =>'auto-entrepreneur',
                'autre' => 'autre'
            )
        ));  
        
        
        $builder->add('searchjob', TextType::class, array(
            'label' => 'Si vous êtes en recherche d\'emploi, quel type de poste recherchez-vous ?',
            'attr' => array(
                'placeholder' => 'poste recherché'
            ),     
            'required' => false,                  
            
            ));   

      
        $builder->add('searchtime', TextType::class, array( 
            'label' => 'Si vous avez trouvé un emploi, combien de temps avez-vous cherché ?',
            'attr' => array(
                'placeholder' => 'préciser le nombre de mois de recherche'
            ),     
            'required' => false,   
            ));   

        
        
        $builder->add('job', TextType::class, array(
            'label' => 'Si vous avez trouvé un emploi, quel est l\'intitulé de votre poste ?',
            'required' => false, 
            'attr' => array(
                'placeholder' => '90 caractères maximum'
            ),     
            'required' => false,                  
            
            ));   


        
        $builder->add('contract', ChoiceType::class, array(
            'label' => 'Type de contrat', 
            'required' => false,                                       
            'choices' => array(
                'CDI' => 'CDI',
                'CDD' => 'CDD',
                'Interim' => 'Interim',
                'auto-entrepreneur' =>'auto-entrepreneur'
                
            )
        ));  
        
        
        
        
        $builder->add('companytype', ChoiceType::class, array(
            'label' => 'Type d\'entreprise', 
            'required' => false,                                       
            'choices' => array(
                'ESN' => 'ESN',
                'Agence digitale/communication' => 'Agence digitale/communication',
                'start-up' => 'start-up',
                'autre' =>'autre'
                
            )
        ));  
        
        
        
         $builder->add('wage', ChoiceType::class, array(
            'label' => 'Cochez votre tranche de salaire annuel brut', 
            'required' => false,                                       
            'choices' => array(
                'moins de 25k€' => 'moins de 25k€',
                'entre 25k€ et 35 k€' =>  'entre 25k€ et 35 k€',
                'entre 36 et 45 k€' => 'entre 36 et 45 k€',
                'plus de 45 k€' => 'plus de 45 k€'
                
            )
        )); 
        
        
        
        $builder->add('companyname', TextType::class, array(
            'label' => 'Si vous avez trouvé un emploi, quel est le nom de votre societé ?',
            'required' => false, 
            'attr' => array(
                'placeholder' => '90 caractères maximum'
            ),     
            'required' => false,                  
            
            ));   

        
        $builder->add('linkedinurl', UrlType::class, array(
            'label' => 'Lien vers votre page LinkedIn',
            'required' => false, 
            'attr' => array(
                'placeholder' => 'lien URL'
            )    
            ));  
        
        
        
        $builder->add('cv', UrlType::class, array(
            'label' => 'Lien vers votre Cv en ligne',
            'required' => false, 
            'attr' => array(
                'placeholder' => 'lien URL'
            )    
            )); 
        
        
        
        $builder->add('sponsorship', ChoiceType::class, array(
            'label' => 'Souhaiteriez-vous devenir parrain/marraine d\'un nouvel élève Webforce3 ?', 
            'required' => false,                                       
            'choices' => array(
                'oui' => 'oui',
                'non' => 'non'
            )
        ));  
        
        
        $builder->add('alertjob', ChoiceType::class, array(
            'label' => 'Souhaitez-vous recevoir les nouvelles offres d\'emploi par email ?', 
            'required' => false,                                       
            'choices' => array(
                'oui' => 'oui',
                'non' => 'non'
            )
        ));  
    }
       
    public function getName()
    {
        return 'user';
    }

}

