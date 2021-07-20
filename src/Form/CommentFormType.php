<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Saisir votre nom...',
                    'class' => 'rounded-full w-full py-2 pl-4 pr-10 text-sm bg-gray-100 border border-transparent appearance-none rounded-tg placeholder-gray-400 focus:bg-white focus:outline-none focus:border-blue-500 focus:text-gray-900 focus:shadow-outline-blue'
                ]
            ])
            ->add('text', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Saisir votre commentaire...',
                    'class' => 'rounded-full mt-2 w-full py-2 pl-4 pr-10 text-sm bg-gray-100 border border-transparent appearance-none rounded-tg placeholder-gray-400 focus:bg-white focus:outline-none focus:border-blue-500 focus:text-gray-900 focus:shadow-outline-blue'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'envoyer',
                'attr' => [
                    'class' => 'inline-flex items-center h-8 px-3 m-2 text-white transition-colors duration-150 bg-green-500 rounded-lg focus:shadow-outline hover:bg-green-600',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
