import {Controller} from '@hotwired/stimulus';
import '../scss/login.scss';

console.log('xxxx');

export default class extends Controller {
    connect() {
        console.log('iiiiiii');
        let pageLogin = this.element;
        let loginSubmitButton = pageLogin.querySelector('#login-submit-button');
        console.log(loginSubmitButton);
    }
}
