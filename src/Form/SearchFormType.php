<?php

namespace App\Form;

use App\Entity\Bug;
use App\Entity\BugFix;
use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descriptionTextBug', TextType::class, [
                'required' => false
            ])
            ->add('severityBug', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'choix de la sévérité :' => [
                        'Insignifiant' => 'Insignifiant',
                        'Faible' => 'Faible',
                        'Modéré' => 'Modéré',
                        'Fort' => 'Fort',
                        'Jeux condamné/lourdement impacté' => 'Jeux condamné/lourdement impacté'
                    ]
                ]
            ])
            ->add('frequencyBug', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'choix de la fréquence :' => [
                        'Exceptionnel' => 'Exceptionnel',
                        'Rare' => 'Rare',
                        'Peu courant' => 'Peu courant',
                        'Assez régulier' => 'Assez régulier',
                        'Fréquent' => 'Fréquent',
                        'Systématique' => 'Systématique'
                    ]
                ]
            ])
            ->add('idGame', EntityType::class, [
                'required' => false,
                'class' => Game::class,
                'choice_label' => 'nameGame'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bug::class,
            'method' => 'GET',
            'csrf_protection' => false,
            "allow_extra_fields" => true
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
