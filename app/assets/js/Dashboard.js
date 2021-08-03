import {proxyNodeList,selector,debounce} from "./BulkActions.js"; 
import { ready } from "./Dom.js";
import {c, debug} from './Console.js';

!(function($) {
    function init() {
        debug(true);
        c.l('Dashboard Loaded');
        let code = $("#Lifecycle").innerHTML;
    
        //code.replace(/&amp;/g, "&").replace(/&gt;/g, ">").replace(/&lt;/g, "<").replace(/&quot;/g, "\"");
        document.getElementById('Lifecycle').innerHTML = marked(code);
        return 
    }

    ready(init);
}(selector))


