<?php

namespace App\Form;

use App\Entity\Onglet;
use App\Entity\Blogpost;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class BlogpostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre',TextType::class,[
            'label' => 'Nom du blogpost',
            'required' => false,
            'attr' => [
                'placeholder' => 'Ecrire ici le nom...'
            ]
        ])
            ->add('contenu',CKEditorType::class,[
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ecrire la description ici'
                ]
            ])
            ->add('onglet',EntityType::class,[
                'label' => 'Choisir l\'onglet',
                'placeholder' => '-- Choisir --',
                'required' => false,
                'class' => Onglet::class
            ])
      
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Blogpost::class,
        ]);
    }
}
