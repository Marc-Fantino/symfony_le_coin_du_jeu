<?php

namespace App\Form;

use App\Entity\BluelineSymfony;
use App\Entity\Categories;
use App\Entity\Distributeur;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('description', TextareaType::class)
            ->add('photo', FileType::class, [
                'label' => 'Image de l\'arcade',
                'required' => false,
                'data_class' => null,
                'empty_data' => 'Aucune image pour ce produit !'
            ])
            ->add('disponible', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('prix', NumberType::class)
            ->add('photoCarte', FileType::class, [
                'label' => 'Image de l\'arcade',
                'required' => false,
                'data_class' => null,
                'empty_data' => 'Aucune image pour ce produit !'
            ])
            ->add('numero', ReferenceType::class)
            ->add('Distributeur', EntityType::class, [
                'class' => Distributeur::class,
                'choice_label' => 'NomDistributeur',
                'label' => 'Selectionnez un ou plusieurs distributeurs',
                'multiple' => true
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'NomCategorie',
                'label' => 'Catégorie du jeu',
                'required' => true
            ])
            ->add('User', EntityType::class, [
                'class' => User::class,
                'choice_label' => "email",
                'label' => "nom du vendeur"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BluelineSymfony::class,
        ]);
    }
}
