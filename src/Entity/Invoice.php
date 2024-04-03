<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
#[Vich\Uploadable]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'invoices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne]
    private ?Partner $invoiceTo = null;

    #[ORM\ManyToOne]
    private ?Partner $invoiceFrom = null;

    #[ORM\Column(length: 16)]
    private ?string $invoiceNumber = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $invoiceDate = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $paymentTerms = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instructions = null;

    #[ORM\Column(nullable: true)]
    private ?array $items = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'invoice_logo', fileNameProperty: 'logo')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(length: 8, nullable: true)]
    private ?string $vat = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isPaid = null;

    #[ORM\Column(length: 8, nullable: true)]
    private ?string $currency = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getInvoiceTo(): ?Partner
    {
        return $this->invoiceTo;
    }

    public function setInvoiceTo(?Partner $invoiceTo): static
    {
        $this->invoiceTo = $invoiceTo;

        return $this;
    }

    public function getInvoiceFrom(): ?Partner
    {
        return $this->invoiceFrom;
    }

    public function setInvoiceFrom(?Partner $invoiceFrom): static
    {
        $this->invoiceFrom = $invoiceFrom;

        return $this;
    }

    public function getInvoiceNumber(): ?string
    {
        return $this->invoiceNumber;
    }

    public function setInvoiceNumber(string $invoiceNumber): static
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }


    public function getPaymentTerms(): ?string
    {
        return $this->paymentTerms;
    }

    public function setPaymentTerms(?string $paymentTerms): static
    {
        $this->paymentTerms = $paymentTerms;

        return $this;
    }


    public function getInstructions(): ?string
    {
        return $this->instructions;
    }

    public function setInstructions(?string $instructions): static
    {
        $this->instructions = $instructions;

        return $this;
    }

    public function getItems(): ?array
    {
        return $this->items;
    }

    public function setItems(?array $items): static
    {
        $this->items = $items;

        return $this;
    }

    public function __toString()
    {
        return 'Items';
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getInvoiceDate(): ?\DateTime
    {
        return $this->invoiceDate;
    }

    public function setInvoiceDate(?\DateTime $invoiceDate): static
    {
        $this->invoiceDate = $invoiceDate;

        return $this;
    }


    public function getVat(): ?string
    {
        return $this->vat;
    }

    public function setVat(?string $vat): static
    {
        $this->vat = $vat;

        return $this;
    }

    public function isIsPaid(): ?bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(?bool $isPaid): static
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }
}
