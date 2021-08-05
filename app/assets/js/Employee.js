import {proxyNodeList,selector,debounce} from "./BulkActions.js"; 
import {debug,c} from './Console.js';
import { MSelect } from './MSelect.js';
import { ready } from './Dom.js'
import { Validate } from './Validate.js'


!(function($,c,debug) {
    class Employee {
        form = $('#employee_form');
        fields = {
            firstName        : $('#first_name'),
            surname          : $('#surname'),
            email            : $('#email'),
            contactNumber    : $('#contact_number'),
            startDate        : $('#start_date'),
            active           : $('#active'),
            employeeCode     : $('#employee_code'),
            id               : $('#id'),
            empGroups        : $('#employee_groups')
        }
        formValid = true;
        constructor() {
            debug(true);
            this.validateForm();
        } 
         
        validateForm() {
            const self = this;
            this.form.addEventListener('submit',(e) => {
                e.preventDefault();
                if (!Validate.checkEmail(self.fields.email)) {
                    self.formValid = false;
                }
                
                if (!self.fields.active.checked) {
                    if (confirm('Are You Sure you want to submit in inactive employee?')){
                        if (self.formValid) this.form.submit();
                    }else{
                        return false;
                    }
                }
                if (self.formValid) this.form.submit();
                
            });
        }
    }
    function init() {
        new Employee();
    }
    ready(init);
}(selector,c,debug));