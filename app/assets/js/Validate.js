
export class Validate {
    static isEmailValid = (email) => {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    };
    
    static isRequired = value => value === '' ? false : true

    constructor() 
    }

    checkEmail(emailEl) {
        let valid = false;
        const email = emailEl.value.trim();
        if (!Validate.isRequired(email)) {
            showError(emailEl, 'Email cannot be blank.');
        } else if (!isEmailValid(email)) {
            showError(emailEl, 'Email is not valid.')
        } else {
            showSuccess(emailEl);
            valid = true;
        }
        return valid;
    };

    showError(input, message) {
        // get the form-field element
        const formField = input.parentElement;
        // add the error class
        formField.classList.remove('success');
        formField.classList.add('error');
    
        // show the error message
        const error = formField.querySelector('small');
        error.textContent = message;
    };

    showSuccess(input) {
        // get the form-field element
        const formField = input.parentElement;
    
        // remove the error class
        formField.classList.remove('error');
        formField.classList.add('success');
    
        // hide the error message
        const error = formField.querySelector('small');
        error.textContent = '';
    }
}
