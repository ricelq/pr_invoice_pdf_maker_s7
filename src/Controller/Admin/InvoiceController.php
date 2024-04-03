<?php

namespace App\Controller\Admin;

use App\Entity\Invoice;
use Konekt\PdfInvoice\InvoicePrinter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class InvoiceController extends AbstractController
{

    #[Route('/admin/print-invoice', name: 'app_admin_print_invoice')]
    public function printInvoice(Invoice $invoice): void
    {
        // init
        $logoDir = $this->getParameter('app.uploads.invoice_logo') . '/';
        $logoImage = $logoDir . $invoice->getLogo();
        $logoImage = substr($logoImage, 1);
        $invoiceDate = date('d M, Y', $invoice->getInvoiceDate()->getTimestamp());
        $invoiceTime = date('h:i:s A', $invoice->getInvoiceDate()->getTimestamp());
        $dueDate = str_contains($invoice->getPaymentTerms(), '15') ? $invoice->getInvoiceDate()->modify('+15 day') : $invoice->getInvoiceDate()->modify('+30 day');
        $dueDate = date('M dS ,Y', $dueDate->getTimestamp());
        $currency = $invoice->getCurrency();

        $printer = new InvoicePrinter('A4', $currency, 'en');
        $printer->setNumberFormat('.', ',', 'left', true, false);
        $printer->setColor("#027a92");

        /* Header */
        $printer->setLogo($logoImage);
        $printer->setType('Invoice');
        $printer->setReference($invoice->getInvoiceNumber());
        $printer->setDate(' ' . $invoiceDate);
        $printer->setTime(' ' . $invoiceTime);
        $printer->setDue(' ' . $dueDate);

        /* Address */
        $printer->setFrom([
            $invoice->getInvoiceFrom()->getName(),
            $invoice->getInvoiceFrom()->getAddress(),
            $invoice->getInvoiceFrom()->getPostal() . ', ' . $invoice->getInvoiceFrom()->getCity(),
            $invoice->getInvoiceFrom()->getCountry(),
        ]);
        $printer->setTo([
            $invoice->getInvoiceTo()->getName(),
            $invoice->getInvoiceTo()->getAddress(),
            $invoice->getInvoiceTo()->getPostal() . ', ' . $invoice->getInvoiceTo()->getCity(),
            $invoice->getInvoiceTo()->getCountry(),
        ]);


        /* Items */
        $grandTotal = 0;
        if (isset($invoice->getItems()[0])) {
            $items = json_decode($invoice->getItems()[0], true);
            foreach ($items as $item) {

                $total = $item['quantity'] * $item['price'];
                $printer->addItem(
                    $item['item'],
                    $item['description'],
                    $item['quantity'],
                    false,
                    $item['price'],
                    false,
                    $total
                );
                $grandTotal = $grandTotal + $total;
            }
        }

        /* Total */
        $printer->addTotal('Total', $grandTotal);

        /* Total VAT */
        $vat = 0;
        if ($invoice->getVat() and ($invoice->getVat() !== 'None')) {
            $vat = ($invoice->getVat() / 100) * $grandTotal;
            $printer->addTotal('VAT ' . $invoice->getVat() . ' %', $vat);
        }

        /* Grand Total */
        $printer->addTotal('Total due', $grandTotal + $vat, true);

        /* Paid Tampon */
        if ($invoice->isIsPaid()) {
            $printer->addBadge("Payment Paid");
        }

        /* Instructions */
        if ($invoice->getInstructions()) {
            $printer->addTitle('Instructions');
            $printer->addParagraph($invoice->getInstructions());
        }

        /* Footer */
        $printer->setFooternote($this->getParameter('app.company'));

        /* Template */
        $printer->render('example3.pdf', 'I');
        /* I => Display on browser, D => Force Download, F => local path save, S => return document as string */
    }
}
