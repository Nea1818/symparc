<?php

namespace App\Form;

use App\Entity\Parc;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ParcType extends AbstractType
{
    /**
     * Permet d'avoir la configuration de base attendue dans un champ
     *
     * @param string $label
     * @param string $placeholder
     * @return array
     */
    private function getConfiguration($placeholder)
    {
        return [
            'attr' => [
                'placeholder' => $placeholder
            ]
            ];
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, $this->getConfiguration("Nom de l'espace vert"))
            ->add('slug', TextType::class, $this->getConfiguration("Adresse web créee automatiquement", [
                'required' => false
            ]))
            ->add('pictureFiles', FileType::class, [
                'required' => false,
                'multiple' => true
            ])
            ->add('address', TextType::class)
            ->add('postal_code', TextType::class)
            ->add('city', TextType::class)
            ->add('lat', HiddenType::class)
            ->add('lng', HiddenType::class)
            ->add('introduction', TextareaType::class, $this->getConfiguration("Introduction"))
            ->add('description', TextareaType::class, $this->getConfiguration("Description détaillée"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Parc::class
        ]);
    }
}
