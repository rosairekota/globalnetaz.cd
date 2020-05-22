<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Option;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label' => 'Titre'])
            ->add('description')
            ->add('surface')
            ->add('rooms', null, ['label' => 'Pièces'])
            ->add('bedrooms', null, ['label' => 'Chambres'])
            ->add('floor', null, ['label' => 'Etage'])
            ->add('price', null, ['label' => 'Prix'])
            ->add('heat', ChoiceType::class, ['label' => 'Type de Chauffage', 'choices' => $this->getChoices()])
            ->add('options', EntityType::class, [
                'class'         => Option::class,
                'choice_label'  => 'name',
                'multiple'      => true,
            ])
            ->add('imageFile', FileType::class, [
                'label'     => 'Choisir l\'image',
                'required'  => false
            ])
            ->add('city', null, ['label' => 'Ville'])
            ->add('adress', null, ['label' => 'Adresse'])
            ->add('postal_code', null, ['label' => 'Code Postal'])
            ->add('sold', null, ['label' => 'Solde']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
    public function getChoices()
    {
        $choises = Property::HEAT;
        $final_choces = [];
        foreach ($choises as $choice => $values) {
            $final_choces[$values] = $choice;
        }
        return $final_choces;
    }
}
