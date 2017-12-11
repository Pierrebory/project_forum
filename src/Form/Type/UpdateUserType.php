<?php

namespace WF3\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints as Assert;


class UpdateUserType extends RegisterType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        parent::buildform($builder, $options);
        $builder->remove('username')->remove('password')->remove('role');
    } 

    public function getName()
    {
        return 'user';
    }
}

