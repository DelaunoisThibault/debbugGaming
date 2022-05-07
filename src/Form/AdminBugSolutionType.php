<?php

namespace App\Form;

use App\Entity\BugSolution;
use App\Entity\Bug;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class AdminBugSolutionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titleBugSolution')
            ->add('textBugSolution')
            ->add('imgBugSolution', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*'
                        ]
                    ])
                ]
            ])
            ->add('idBug', EntityType::class, [
                'class' => Bug::class,
                'choice_label' => 'titleBug'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BugSolution::class,
        ]);
    }
}
