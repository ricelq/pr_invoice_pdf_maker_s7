import {Controller} from '@hotwired/stimulus';
import '../scss/invoice-items-field.scss';

export default class InvoiceCollectionItemsController extends Controller {
    connect() {
        let itemsField = this.element;

        if (itemsField) {
            // initialize when page loaded
            this.initializeCollectionItemsInteractions(itemsField);

            // new event in order to take into account new items to be added to the collection
            itemsField.addEventListener('click', () => {
                this.initializeCollectionItemsInteractions(itemsField);
            })
        }
    }

    initializeCollectionItemsInteractions(itemsField) {

        let collectionContainer = itemsField.querySelector('.ea-form-collection-items');

        if (collectionContainer) {
            let collectionItems = collectionContainer.querySelectorAll('.field-collection-item');
            if (collectionItems.length > 0) {
                Array.from(collectionItems).forEach((item) => {
                    this.updateAccordionHeaderLabel(item);
                    this.calculateAndSetTotal(item)
                })
            }
        }
    }

    updateAccordionHeaderLabel(item) {
        let accordionHeader = item.querySelector('.accordion-header .accordion-button');
        let itemNameInput = item.querySelector('.accordion-body [data-item-name]');
        accordionHeader.textContent = itemNameInput.value ? itemNameInput.value : "";

        // listen the input focus and set the accordion header label
        itemNameInput.addEventListener('blur', (e) => {
            e.stopImmediatePropagation();
            this.updateAccordionHeaderLabel(item);
        });
    }

    calculateAndSetTotal(item) {
        // the total calculation from quantity and price fields
        let multipliersInputs = item.querySelectorAll('[data-multiplier]');
        let totalInput = item.querySelector('[data-total]');
        totalInput.value = parseFloat(multipliersInputs[0].value) * parseFloat(multipliersInputs[1].value);

        Array.from(multipliersInputs).forEach((input) => {
            input.addEventListener('blur', (e) => {
                e.stopImmediatePropagation();
                this.calculateAndSetTotal(item);
            });
        })
    }
}
