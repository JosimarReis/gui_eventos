<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UsuarioType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', TextType::class)
            ->add('email', TextType::class)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Senha'),
                'second_options' => array('label' => 'Repita a senha'),
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Perfil',
                'choices' => ["Administrador" => 'ROLE_SUPER_ADMIN',"Organizador" => 'ROLE_ADMIN', "Visitante" => 'ROLE_USER']
            ])
            ->add('salvar', SubmitType::class, ['label' => 'Salvar']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => "\App\Entity\Usuario"
        ]);
    }

}