<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextareaType::class,
                ['label' => 'Task title',
                    'required' => false,
                    'attr' => [
                        'name' => 'title',
                        'autocomplete' => 'off'
                    ]
                ]
            )
            ->add('publisher', TextareaType::class,
                ['label' => 'Publisher',
                    'required' => false,
                    'attr' => [
                        'name' => 'publisher',
                        'autocomplete' => 'off'
                    ]
                ])
            ->add('pages', IntegerType::class,
                ['label' => 'Pages',
                    'required' => false,
                    'attr' => [
                        'name' => 'pages',
                        'autocomplete' => 'off'
                    ]
                ])
            ->add('isPublished', CheckboxType::class, [
                'label' => 'Is Published?',
                'required' => false,
                'attr' => [
                    'autocomplete' => 'off',
                ]
            ])
            ->add('authors', CollectionType::class, [
                'entry_type' => AuthorType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
