<?php

namespace WF3\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//on utilise le validator de symfony
use Symfony\Component\Validator\Constraints as Assert;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('image', FileType::class, array(
                'constraints'     => array(
                                        new Assert\Image(),
                                        new Assert\Length(array(
                                            'min' => 2,
                                            'minMessage' => 'le auteur doit faire au moins 5 caractères'
                                        ))
                                    )
             ))
            ->add('Rechercher', SubmitType::class);
    }

    public function getName()
    {
        return 'user';
    }
}
