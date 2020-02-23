<?php

namespace App\Form;

use App\Entity\Cartas;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('ataque')
            ->add('defensa')
            ->add('descripcion')
            ->add('foto', FileType::class, [
                'label' => 'Foto',
                'data_class' => null,
                'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cartas::class,
        ]);
    }
}
