<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

   
    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id', 'ID')->onlyOnIndex(),
            EmailField::new('email', 'Email'),
            TextField::new('password', 'Mot de passe'),
            ChoiceField::new('roles', 'Role de l\'utilisateur')
            ->setChoices([
                'ROLES_USER'=>'ROLE_USER',
                'ROLES_ADMIN'=>'ROLE_ADMIN',
                'ROLE_SUPER_ADMIN'=>'ROLE_SUPER_ADMIN',
            ])
            ->allowMultipleChoices(true)
        ];
    }
  
}
