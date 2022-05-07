<?php

namespace App\Form;

use App\Entity\BugFix;
use App\Entity\Bug;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AdminBugFixFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('resolved')
            ->add('majNumber')
            ->add('dateBugFix')
            ->add('bugId', EntityType::class, [
                'class' => Bug::class,
                'choice_label' => 'titleBug'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BugFix::class,
        ]);
    }
}
