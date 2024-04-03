<?php

namespace App\Controller\EasyAdmin;

use App\Entity\Partner;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PartnerCrudController extends AbstractCrudController
{
    use \App\Controller\EasyAdmin\Trait\ReadOnlyTrait;

    public static function getEntityFqcn(): string
    {
        return Partner::class;
    }

    /*
     *
    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $name = TextField::new('name');
        $address = TextField::new('address');
        $postal = TextField::new('postal');
        $city = DateField::new('city');
        $country = DateField::new('country');

        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
