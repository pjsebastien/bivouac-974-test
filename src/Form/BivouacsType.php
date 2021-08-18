<?php

namespace App\Form;

use App\Entity\Bivouac;
use App\Entity\Categories;
use App\Entity\Region;
use App\Entity\Tag;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BivouacsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'border-1 border-gray-300 p-1 w-full'
                ]
            ])
            ->add('Categories', EntityType::class, [
                'class' => Categories::class,
                'label' => false,
                'attr' => [
                    'class' => 'border-1 border-gray-300 p-1 w-full'
                ]
            ])
            
            
            ->add('tags', EntityType::class, [
                'class' => Tag::class, 
                'choice_label' => 'name',
                'placeholder' => 'Tag',
                //En jouant avec les 2 de dessous on obtiens liste, case a caché ect... voi doc
                'multiple' => true,
                'expanded' => true,
                'label' => false,
                'attr' => [
                    'class' => ''
                ],
                'by_reference' => false,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC');
                }                    
            ])
            ->add('regions', EntityType::class, [
                'class' => Region::class, 
                'choice_label' => 'name',
                'placeholder' => 'Region',
                'multiple' => true,
                'expanded' => true,
                'label' => false, 
                'by_reference' => false,
                'query_builder' => function(EntityRepository $err){
                    return $err->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC');
                }                    
            ])
            ->add('lat', TextType::class, [
                'label' => false, 
                'required' => false,
                'attr' => [
                    'class' => 'border-1 border-gray-300 p-1 w-full',
                    'id' => 'lat'
                ]
            ])
            ->add('lon', TextType::class, [
                'label' => false, 
                'required' => false,
                'attr' => [
                    'class' => 'border-1 border-gray-300 p-1 w-full',
                    'id' => 'lon'
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => false, 
                'required' => true,
                'attr' => [
                    'class' => 'border-1 border-gray-300 p-1 w-full'
                ]
            ])
            
            ->add('adresse', TextType::class, [
                'label' => false, 
                'required' => false,
                'attr' => [
                    'class' => 'border-1 border-gray-300 p-1 w-full'
                ]
            ])
            ->add('itineraire', TextType::class, [
                'label' => false, 
                'required' => false,
                'attr' => [
                    'class' => 'border-1 border-gray-300 p-1 w-full'
                ]
            ])
            ->add('prix', TextType::class, [
                'label' => false, 
                'required' => false,
                'attr' => [
                    'class' => 'border-1 border-gray-300 p-1 w-full'
                ]
            ])
            ->add('lien', TextType::class, [
                'label' => false, 
                'required' => false,
                'attr' => [
                    'class' => 'border-1 border-gray-300 p-1 w-full'
                ]
            ])



            ->add('images', FileType::class, [
                'label' => false,
                'multiple' =>true,
                'mapped' =>false,
                'required' => false
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => [
                    'class'=> 'w-auto bg-green-500 hover:bg-green-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bivouac::class,
        ]);
    }
}
