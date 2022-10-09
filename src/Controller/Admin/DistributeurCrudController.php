<?php

namespace App\Controller\Admin;

use App\Entity\Distributeur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DistributeurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Distributeur::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
