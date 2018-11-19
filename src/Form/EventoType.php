<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Doctrine\ORM\EntityRepository;


use App\Entity\Local;
use App\Entity\Categoria;

class EventoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', TextType::class)
            ->add('data', DateTimeType::class, array(
                'label' =>'Data e Hora',
                'placeholder' => array(
                    'year' => 'Ano', 'month' => 'Mês', 'day' => 'Dia',
                    'hour' => 'Hora', 'minute' => 'Minutos',
                )
            ))
            ->add('descricao', TextareaType::class, array(
                'label' =>'Descrição',
                'attr' => array('class' => 'tinymce'),
            ))
            ->add('categoria', EntityType::class, [
                'choice_label' => 'nome', 
                'class' =>  Categoria::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nome', 'ASC');
                },
            ])            
            ->add('local', EntityType::class, [
                'choice_label' => function(Local $local){
                    return $local->getNome().' em '.$local->getCidade()->getNome().' - '.$local->getCidade()->getEstado()->getSigla();
                }, 
                'class' =>  Local::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->orderBy('l.nome', 'ASC');
                },
            ])
                
            ->add('salvar', SubmitType::class, ['label' => 'Salvar']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => "\App\Entity\Evento"
        ]);
    }

}