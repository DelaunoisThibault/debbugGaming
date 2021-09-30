<?php

namespace App\Form;

use App\Entity\Bug;
use App\Entity\Game;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BugFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titleBug')
            ->add('idGame', EntityType::class, [
                'class' => Game::class,
                'choice_label' => 'nameGame'
            ])

            ->add('subtitleBug')
            ->add('smallTextBug')
            ->add('descriptionTextBug')
            ->add('descriptionImgBug')
            ->add('severityBug')
            ->add('frequencyBug')
            ->add('bugSolutions', BugSolutionFormType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bug::class,
        ]);
    }
}
