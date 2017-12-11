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

        /////////////// EMAIL //////////////////
        $builder->add('email', TextType::class, array(
            'label' => 'Votre adresse email',
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
    }   


    //à rajouter mais pour l'instant on s'en occupe pas
    public function getName()
    {
        return 'user';
    }
}