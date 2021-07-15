<?php

namespace App\Form;

use App\Entity\Bivouac;
use App\Entity\Categories;
use App\Entity\Region;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchBivouacType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mots', SearchType::class, [
                'label' => false,
                'attr' => [
                    'class' => '',
                    'placeholder' => 'Entrez un ou plusieurs môts clés'
                ],
                'required' => false,
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categories::class,
                'label' => false,
                'attr' => [
                    'class' => '',
                ],
                'required' => false,
            ])
            ->add('Rechercher', SubmitType::class, [
                'attr' => [
                    'class' => '',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
