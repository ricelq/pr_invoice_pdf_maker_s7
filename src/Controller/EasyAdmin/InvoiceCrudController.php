<?php

namespace App\Controller\EasyAdmin;

use App\Entity\Invoice;
use App\Form\InvoiceItemType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class InvoiceCrudController extends AbstractCrudController
{
    use \App\Controller\EasyAdmin\Trait\ReadOnlyTrait;

    public static function getEntityFqcn(): string
    {
        return Invoice::class;
    }

    public function configureAssets(Assets $assets): Assets
    {
        return parent::configureAssets($assets)->addAssetMapperEntry('admin');
    }

    public function configureActions(Actions $actions): Actions
    {
        $printInvoice = Action::new('printInvoice', 'Print invoice', 'fa-solid fa-print')
            ->linkToRoute('app_admin_print_invoice', function (Invoice $invoice): array {
                return [
                    'invoice' => $invoice->getId()
                ];
            })
            ->setHtmlAttributes(['target' => '_blank']);

        return $actions
            ->add(Crud::PAGE_EDIT, $printInvoice);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ...
            //->overrideTemplates([
            //    'crud/edit' => 'bundles/EasyAdminBundle/crud/edit.html.twig',
            //])
            // this defines the pagination size for all CRUD controllers
            // (each CRUD controller can override this value if needed)
            ->setPaginatorPageSize(8)
            // don't forget to add EasyAdmin's form theme at the end of the list
            // (otherwise you'll lose all the styles for the rest of form fields)
            ->setFormThemes(['bundles/EasyAdminBundle/invoice-collection-items.html.twig', '@EasyAdmin/crud/form_theme.html.twig']);

    }

    public function configureFields(string $pageName): iterable
    {

        /* Header */
        $headerPanel = FormField::addPanel('Header');
        $id = IdField::new('id');
        $invoiceNumber = TextField::new('invoiceNumber');
        $invoiceDate = DateField::new('invoiceDate');
        $instructions = TextField::new('instructions');
        $currency = ChoiceField::new('currency', 'Currency')
            ->setChoices([
                'CHF' => 'CHF',
                '$' => '$',
                '€' => '€',
            ])
            ->renderAsBadges();
        $isPaid = BooleanField::new('isPaid');
        $paymentTerms = ChoiceField::new('paymentTerms', 'Payment Terms')
            ->setChoices([
                '15 Days' => '15 Days',
                '30 Days' => '30 Days',
            ])
            ->renderAsBadges();
        $vat = ChoiceField::new('vat', 'VAT')
            ->setChoices([
                'None' => 'None',
                '8.1 %' => '8.1',
                '2.6 %' => '2.6',
                '19 %' => '19',
                '20 %' => '20',
                '21 %' => '21',
                '22 %' => '22',
                '23 %' => '23',
                '24 %' => '24',
            ])
            ->renderExpanded(false)
            ->renderAsBadges();


        /* Address */
        $addressPanel = FormField::addPanel('Address');
        $invoiceFrom = AssociationField::new('invoiceFrom', 'Invoice From');
        $invoiceTo = AssociationField::new('invoiceTo', 'Invoice To');
        $logoUpload = TextField::new('imageFile')
            ->setFormType(VichImageType::class)
            ->setLabel('Invoice From Logo');
        $logoImage = ImageField::new('logo')
            ->setBasePath('/uploads/invoice/logo');


        /* Items */
        $itemsPanel = FormField::addPanel('Items');
        $items = CollectionField::new('items', '')
            ->onlyOnForms()
            ->setEntryType(InvoiceItemType::class)
            ->setFormTypeOptions([
                'block_name' => 'custom_collection_items',
                'row_attr' => [
                    'data-controller' => 'invoice-collection-items',
                ]
            ]);


        if (Crud::PAGE_INDEX === $pageName) {
            return [
                $id, $invoiceNumber, $invoiceDate, $paymentTerms, $isPaid, $logoImage, $invoiceFrom, $invoiceTo, $items];

        } else {
            return [
                $headerPanel, $invoiceNumber, $invoiceDate, $paymentTerms, $currency, $vat, $isPaid, $instructions, $addressPanel,
                $invoiceFrom, $invoiceTo, $logoUpload, $itemsPanel, $items];
        }

    }

}
