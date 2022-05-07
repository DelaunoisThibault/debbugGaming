<?php

namespace App\Form;

use App\Entity\Editor;
use App\Entity\Game;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminGameFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameGame')
            ->add('yearOfPublication')
            ->add('bugRating')
            ->add('idEditor', EntityType::class, [
                'class' => Editor::class,
                'choice_label' => 'editorName'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
