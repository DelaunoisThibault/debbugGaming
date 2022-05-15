<?php

namespace App\Form;

use App\Entity\BugFix;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SearchBugWithBugFixFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('resolved', ChoiceType::class, [
                'required' => false,
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BugFix::class,
            'method' => 'GET',
            'csrf_protection' => false,
            "allow_extra_fields" => true
        ]);
    }
}
