<?php

namespace App\Form;

use App\Entity\Onglet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OngletType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name',TextType::class,[
            'label' => 'Nom de l\'onglet',
            'required' => false,
            'attr' => [
                'placeholder' => 'Ecrire ici le nom...'
            ]
        ])

        ->add('image_path',TextType::class,[
            'label' => 'Image de l\'onglet',
            'required' => false,
            'attr' => [
                'placeholder' => 'Ajouter le chemin de l\'image ici'
            ]

        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Onglet::class,
        ]);
    }
}
