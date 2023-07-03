<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Valid;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextareaType::class,
                ['label' => 'Task title',
                    'required' => false,
                    'attr' => [
                        'name' => 'title,'
                    ],
                    'empty_data' => null,
                ])
            ->add('title', TextareaType::class, [
                'label' => 'Book Title',
                'required' => false,
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'empty_data' => null,
            ])
            ->add('publisher', TextareaType::class, [
                'label' => 'Publisher',
                'required' => false,
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'empty_data' => null,
            ])
            ->add('isPublished', ChoiceType::class, [
                'label' => 'Is Published?',
                'required' => false,
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'choices' => [
                    'true' => true,
                    'false' => false,
                ],
            ])
//            ->add('createdAt',DateType::class,
//                ['label' => 'Book created at',
//                    'required' => false,
//                    'widget' => 'single_text',
//                    'attr' => [
//                        'name' => 'createdAt,'
//                    ],
//                    'empty_data' => null,
//                    'constraints' => [
//                        new Valid(),
//                        new NotBlank([
//                            'allowNull' => true,
//                        ]),
//                    ],
//                ])
            ->add('submit', SubmitType::class,
                ['label' => 'Search']);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
