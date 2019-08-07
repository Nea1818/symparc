<?php

namespace App\Form;

use App\Entity\ParcSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ParcSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address', null, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Code Postal...'
            ]])
            ->add('distance', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'choices' => [
                    'A 1 km près' => 1,
                    'A 5 km près' => 5,
                    'A 10 km près' => 10,
                ],
                'data' => '1'
            ])
            ->add('lat', HiddenType::class)
            ->add('lng', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ParcSearch::class,
            'method' => 'get',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
