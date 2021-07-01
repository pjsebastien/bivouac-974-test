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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class BivouacsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('content', CKEditorType::class)
            ->add('Categories', EntityType::class, [
                'class' => Categories::class
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class, 
                'choice_label' => 'name',
                'placeholder' => 'Tag',
                //En jouant avec les 2 de dessous on obtiens liste, case a caché ect... voi doc
                'multiple' => true,
                'expanded' => true,
                'label' => 'Tag', 
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
                'label' => 'Region', 
                'by_reference' => false,
                'query_builder' => function(EntityRepository $err){
                    return $err->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC');
                }                    
            ])
            



            ->add('images', FileType::class, [
                'label' => false,
                'multiple' =>true,
                'mapped' =>false,
                'required' => false
            ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bivouac::class,
        ]);
    }
}
