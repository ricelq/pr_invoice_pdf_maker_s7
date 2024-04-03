<?php

namespace App\Controller\EasyAdmin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class PostCrudController extends AbstractCrudController
{
    use \App\Controller\EasyAdmin\Trait\ReadOnlyTrait;

    public static function getEntityFqcn(): string
    {
        return Post::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $title = TextField::new('title');
        $summary = TextField::new('summary');
        $body = TextField::new('body');
        $publishedAt = DateField::new('publishedAt');

        $tag = AssociationField::new('tags')
            ->setFormTypeOptions([
                'by_reference' => false,
            ])
            ->autocomplete();

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $title, $summary, $body, $tag, $publishedAt];
        } else {
            return [$title, $summary, $body, $tag, $publishedAt];
        }
    }

}
