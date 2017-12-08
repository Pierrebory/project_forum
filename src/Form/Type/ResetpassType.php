<?php

namespace WF3\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints as Assert;



class ResetpassType extends RegisterType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildform($builder, $options);
        $builder->remove('username')->remove('lastname')->remove('firstname')->remove('email')->remove('phone')->remove('city')->remove('role')->remove('date_register');   

/*        $builder->remove('lastname');     
        $builder->remove('firstname');     
        $builder->remove('email');     
        $builder->remove('phone');     
        $builder->remove('city');     
        $builder->remove('role');    */ 
    }   

    public function getName()
    {
        return 'user';
    }
}

