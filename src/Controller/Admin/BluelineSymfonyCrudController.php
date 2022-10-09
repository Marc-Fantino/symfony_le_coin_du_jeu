<?php

namespace App\Controller\Admin;

use App\Entity\BluelineSymfony;
use App\Entity\User;
use App\Form\ReferenceType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;

class BluelineSymfonyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BluelineSymfony::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id', 'ID')->onlyOnIndex(),
            TextField::new('nom', "Nom du jeu"),
            TextEditorField::new('description', "Description du jeu"),
           
            NumberField::new('prix', "Prix du jeu"),
            ImageField::new('photo')
                ->setBasePath('/image')
                ->setUploadDir('public/image')
                ->setFormType(FileUploadType::class)
                ->setRequired(true),
            ImageField::new('photoCarte')
                ->setBasePath('/image')
                ->setUploadDir('public/image')
                ->setFormType(FileUploadType::class)
                ->setRequired(true),
            DateTimeField::new('disponible', "Date de depot"),
            AssociationField::new('distributeur', "Liste des distributeurs"),
            AssociationField::new('categorie', "Catégorie du jeu"),
            IntegerField::new('numero', "Référence de l'\annonce")
                ->setFormType(ReferenceType::class),
            AssociationField::new('User', "Email qui pose l\'annonce"),
        ];
    }
}
