<?php

namespace App\Form;

use App\Entity\Covoiturage;
use App\Entity\User;
use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class CovoiturageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_depart', null, [
                'widget' => 'single_text',
                
            ])
            ->add('heure_depart')
            ->add('lieu_depart')
            ->add('date_arrivee', null, [
                'widget' => 'single_text',
            ])
            ->add('heure_arrivee')
            ->add('lieu_arrivee')
            ->add('nb_place')
            ->add('prix_personne')
            ->add('voiture_id', EntityType::class, [
                'class' => Voiture::class,
                'choice_label' => 'modele',
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Covoiturage::class,
        ]);
    }
}
