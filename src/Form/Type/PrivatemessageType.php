<?php

namespace WF3\Form\Type;


//les formulaires  vont toujours utiliser AbstractType et FormBuilderInterface
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
//on utilise le validator de symfony
use Symfony\Component\Validator\Constraints as Assert;


//la classe doit hériter de AbstractType
class PrivatemessageType extends AbstractType
{
    //on doit écrire la méthode buildForm
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //on liste les champs qu'on veut rajouter
        $builder
            ->add('message', TextAreaType::class, array(
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