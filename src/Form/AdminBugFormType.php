<?php

namespace App\Form;

use App\Entity\Bug;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminBugFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titleBug')
            ->add('subtitleBug')
            ->add('smallTextBug')
            ->add('descriptionTextBug')
            ->add('descriptionImgBug')
            ->add('severityBug')
            ->add('frequencyBug')
            ->add('published')
            ->add('idGame')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bug::class,
        ]);
    }
}
