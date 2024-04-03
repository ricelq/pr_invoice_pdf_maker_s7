<?php

namespace App\Controller\EasyAdmin;

use App\Controller\EasyAdmin\Trait;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{

    use \App\Controller\EasyAdmin\Trait\ReadOnlyTrait;

    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $username = TextField::new('username');
        $email = TextField::new('email');

        // Define roles field
        $roles = ChoiceField::new('roles', 'Roles')
            ->allowMultipleChoices()
            ->setChoices([
                'User' => 'ROLE_USER',
                'Admin' => 'ROLE_ADMIN',
                // Add more roles as needed
            ])
            ->renderAsBadges(); // Optional, renders roles as badges in the index view


        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $username, $email, $roles];
        } else {
            return [$username, $email, $roles];
        }
    }
}
