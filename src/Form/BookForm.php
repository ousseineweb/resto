<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => "Your Name",
                    'class' => 'form-control',
                    'data-rule' => 'name',
                    'data-msg' => 'Please enter a valid Name'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => "Your Email",
                    'class' => 'form-control',
                    'data-rule' => 'email',
                    'data-msg' => 'Please enter a valid email'
                ]
            ])
            ->add('phone', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => "Your Phone",
                    'class' => 'form-control',
                    'data-rule' => 'phone',
                    'data-msg' => 'Please enter a valid phone'
                ]
            ])
            ->add('dateAt', DateType::class, [
                'label' => false,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'MM/dd/yyyy',
                'attr' => [
                    'placeholder' => "Date",
                    'class' => 'form-control js-datepicker',
                    'data-rule' => 'date',
                    'data-msg' => 'Please enter a valid date'
                ]
            ])
            ->add('timeAt', TimeType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => "Time",
                    'class' => 'form-control js-timepicker',
                    'data-rule' => 'time',
                    'data-msg' => 'Please enter a valid time'
                ]
            ])
            ->add('people', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => "Of people",
                    'class' => 'form-control',
                    'data-rule' => 'people',
                    'data-msg' => 'Please enter a valid people'
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => "Message",
                    'class' => 'form-control',
                    'data-rule' => 'message',
                    'data-msg' => 'Please enter a valid message',
                    'rows' => 5
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class
        ]);
    }

}