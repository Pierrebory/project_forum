<?php

namespace WF3\Form\Type;

//les formulaires  vont toujours utiliser AbstractType et FormBuilderInterface
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
//on détaille les types de champs dont on aura besoin
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
//on utilise le validator de symfony
use Symfony\Component\Validator\Constraints as Assert;


//la classe doit hériter de AbstractType
class ContactType extends AbstractType
{
    //on doit écrire la méthode buildForm
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //on liste les champs qu'on veut rajouter
        $builder
            ->add('email', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Votre email'
                ),
                'constraints' => new Assert\Email()
            ))
            ->add('name', TextType::class, array(
                'label' => 'Nom',
                'attr' => array(
                    'placeholder' => 'Votre nom'
                ),
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 3,
                        'max' => 20,
                        'minMessage' => 'le titre doit faire au moins 3 caractères'
                    ))
                )
            ))
            ->add('subject', TextType::class, array(
                'label' => 'Sujet',
                'attr' => array(                    
                    'placeholder' => 'Sujet',
                )
            ))                
            ->add('message', TextType::class, array(
            'label' => 'Message',
            'attr' => array(
                    'placeholder' => 'Message'
                )))
            ;
    }

    //à rajouter mais pour l'instant on s'en occupe pas
    public function getName()
    {
        return 'user';
    }
}