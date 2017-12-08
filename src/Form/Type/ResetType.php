<?php

namespace WF3\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
//on détaille les types de champs dont on aura besoin
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Validator\Constraints as Assert;




class ResetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //on liste les champs qu'on veut rajouter
        $builder
            ->add('email', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Votre adresse email'
                ),
                'constraints' => new Assert\Email()
            ));
        }

    //à rajouter mais pour l'instant on s'en occupe pas
    public function getName()
    {
        return 'user';
    }
}