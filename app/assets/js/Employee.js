import {proxyNodeList,selector,debounce} from "./BulkActions.js"; 
import {debug,c} from './Console.js';
import { MSelect } from './MSelect.js';
import { ready } from './Dom.js'
import { Validate } from './Validate.js'


(($,c,debug)=>{
    function init() {
        debug(true);
        const fields = {
            first_name      : $('#first_name'),
            surname         : $('#surname'),
            email           : $('#email'),
            contact_number  : $('#contact_number'),
            start_date      : $('#start_date'),
            active          : $('#active'),
            employee_code   : $('#employee_code'),
            group_id        : $('#group_id'),
            id              : $('#id')
        }
        const form = $('#employee_form');
        form.addEventListener('submit', validateForm);

        function validateForm(event) {
            event.preventDefault();
            let valid = true;
            const vali  = new Validate();
            if (!vali.checkEmail(fields.email)) {
                valid = false;
            }
            
            if (valid) {
                if (confirm('Are You Sure you want to submit in inactive employee?')){
                    return true;
                }else{
                    return false;
                }
            }
        }

        var mySelect = new MSelect(
            document.querySelector('#employee_groups'), {
                appendTo: '#SelectContainer',
                width:250,
                height:130
            }
        );
    }
    ready(init);
})(selector,c,debug);