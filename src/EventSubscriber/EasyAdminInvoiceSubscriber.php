<?php

namespace App\EventSubscriber;

use App\Controller\EasyAdmin\InvoiceCrudController;
use App\Entity\Invoice;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminInvoiceSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityUpdatedEvent::class => 'onBeforeEntityInvoiceUpdatedEvent',
            BeforeCrudActionEvent::class => 'onBeforeCrudActionEvent',
        ];
    }

    public function onBeforeCrudActionEvent(BeforeCrudActionEvent $event): void
    {
        $crud = $event->getAdminContext()->getCrud();

        if ($crud->getControllerFqcn() !== InvoiceCrudController::class) {
            return;
        }

        $context = $event->getAdminContext();
        $entityInstance = $context->getEntity()->getInstance();

        if (!$entityInstance instanceof Invoice) {
            return;
        }

        if ($entityInstance->getItems()) {
            $itemsJson = $entityInstance->getItems()[0];

            if ($itemsJson) {
                $itemsArray = json_decode($itemsJson, true);
                $entityInstance->setItems($itemsArray);
            }
        }
    }

    public function onBeforeEntityInvoiceUpdatedEvent(BeforeEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof Invoice) {
            return;
        }

        $items = $event->getEntityInstance()->getItems();
        $itemsJson = json_encode($items);

        $entity->setItems([$itemsJson]);
    }
}
