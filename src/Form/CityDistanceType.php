<?php

namespace App\Form;

use App\Entity\City;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CityDistanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('city1', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
            ])
            ->add('city2', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
            ])
            ->add('save', SubmitType::class, [ 'label' => 'Calculate' ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'city1' => null,
            'city2' => null,
        ]);
    }
}
