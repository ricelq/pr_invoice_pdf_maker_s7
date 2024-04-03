<?php

namespace App\Form;

use App\Entity\Invoice;
use App\Entity\Ncds\Approvers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('item', null, [
                'label' => 'Item name',
                'attr' => ['data-item-name' => '']
            ])
            ->add('description', null, [
                'label' => 'Description',
            ])
            ->add('quantity', NumberType::class, [
                'label' => 'Quantity',
                'rounding_mode' => 0,
                'scale' => 2,
                'attr' => ['data-multiplier' => '']
            ])
            ->add('price', NumberType::class, [
                'label' => 'Price',
                'rounding_mode' => 0,
                'scale' => 2,
                'attr' => ['data-multiplier' => '']
            ])
            ->add('total', null, [
                'label' => 'Total',
                'disabled' => true,
                'empty_data' => 0,
                'attr' => ['data-total' => '']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'compound' => true,
        ]);
    }
}
