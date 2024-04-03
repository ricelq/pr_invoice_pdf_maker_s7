<?php

namespace App\DataFixtures;

use App\DataFixtures\Service\UploaderService;
use App\Entity\Invoice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\Company;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\File;


class InvoiceFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    private ParameterBagInterface $params;
    private UploaderService $uploaderService;
    private string $defaultLogo;

    public function __construct(ParameterBagInterface $params, UploaderService $uploaderService)
    {
        $this->uploaderService = $uploaderService;
        $this->params = $params;
        $this->defaultLogo = 'prodeimat-logo-pdf-660c3638296e4512924401.png';
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadInvoices($manager);
    }

    private function uploadLogo(): string
    {
        $projectRoot = $this->params->get('app.project.dir');
        $destinationPath = $projectRoot . '/public' . $this->params->get('app.uploads.invoice_logo') . '/';
        return $this->uploaderService
            ->uploadImage(new File(__DIR__ . '/Images/' . $this->defaultLogo), $destinationPath);
    }

    public function loadInvoices($manager): void
    {
        $faker = Factory::create();
        $faker->addProvider(new Company($faker));
        $paymentTerms = ['15 Days', '30 Days'];
        $currency = ['CHF' => 'CHF', '$' => '$', '€' => '€'];
        $vat = ['None', '8.1', '2.6', '19', '20', '21', '22', '23', '24'];
        $logo = $this->uploadLogo();
        $items = [
            '1' => [
                'item' => 'Network administration',
                'description' => 'Network administration design configuring',
                'quantity' => rand(1, 10),
                'price' => rand(1, 20),
            ],
            '2' => [
                'item' => 'Automated testing',
                'description' => 'Development testing',
                'quantity' => rand(1, 10),
                'price' => rand(1, 20),
            ],
            '3' => [
                'item' => 'IT support',
                'description' => 'Moving files, archiving',
                'quantity' => rand(1, 10),
                'price' => rand(1, 20),
            ],
            '4' => [
                'item' => 'Computer security',
                'description' => 'Implement and maintain security',
                'quantity' => rand(1, 10),
                'price' => rand(1, 20),
            ]
        ];

        for ($i = 1; $i < 10; $i++) {

            $invoice = new Invoice();

            // dates
            $today1 = new \DateTime();
            $invoiceDate = $today1->modify('-' . rand(61, 90) . ' day');
            $today2 = new \DateTime();
            $updatedAt = $today2->modify('-' . rand(1, 60) . ' day');

            // text
            $instructions = ['', $faker->text(255)];

            $invoice
                ->setInvoiceFrom($this->getReference('partnerFixture' . $i))
                ->setInvoiceTo($this->getReference('partnerFixture' . 10 - $i))
                ->setInvoiceDate($invoiceDate)
                ->setUpdatedAt($updatedAt)
                ->setVat($vat[array_rand($vat)])
                ->setIsPaid($faker->boolean())
                ->setCurrency(array_rand($currency))
                ->setLogo($logo)
                ->setItems([json_encode($items)])
                ->setInvoiceNumber($faker->unique()->randomNumber(9))
                ->setPaymentTerms($faker->randomElement($paymentTerms))
                ->setInstructions($faker->randomElement($instructions))
                ->setUser($this->getReference('userFixture' . rand(1, 9)));
            $manager->persist($invoice);
        }
        $manager->flush();
    }


    public function getDependencies()
    {
        return [PartnerFixtures::class];
    }

    public static function getGroups(): array
    {
        return ['invoice'];
    }
}
