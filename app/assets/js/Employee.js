import {proxyNodeList,selector,debounce} from "./BulkActions.js"; 
import {debug,c} from './Console.js';
import { MSelect } from './MSelect.js';
import { ready } from './Dom.js'


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