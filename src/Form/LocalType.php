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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Doctrine\ORM\EntityRepository;


use App\Entity\Cidade;

class LocalType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', TextType::class)
            ->add('logradouro', TextType::class)
            ->add('numero', TextType::class)
            ->add('complemento', TextType::class)
            ->add('cidade', EntityType::class, [
                'choice_label' => function(Cidade $cidade){
                    return $cidade->getNome().' - '.$cidade->getEstado()->getSigla();
                }, 
                'class' =>  Cidade::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nome', 'ASC');
                },
            ])

            ->add('salvar', SubmitType::class, ['label' => 'Salvar']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => "\App\Entity\Local"
        ]);
    }

}