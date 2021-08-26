<?php

namespace App\Form;

use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom',null,[
                'label'=>' a',
                'attr' => [
                    'class'=> 'toto',
                    'placeholder'=>'prénom'
                    
                    ]
                ])
            ->add('nom')
            ->add('majeur',CheckboxType::class,
            [
                'mapped'=>false,
                'label'    => 'Etes vous majeur ?',
                'required' =>false
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
