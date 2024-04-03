<?php
/**
 * This file is part of the Prodeimat project
 * @Author: Ricel Quispe
 */

declare(strict_types=1);

namespace App\Controller\EasyAdmin\Trait;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

trait ReadOnlyTrait
{

    public function configureActions(Actions $actions): Actions
    {
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            return $actions
                ->disable(Action::NEW, Action::EDIT, Action::DELETE)
                ->add(Crud::PAGE_INDEX, Action::DETAIL);
        }

        return $actions;
    }

}
