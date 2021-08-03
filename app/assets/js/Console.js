// define a new console
export const c = (function(o){
    return {
        l: function(txt){
            o.log(txt);
        },
        i: function (txt) {
            o.info(txt)
        },
        w: function (txt) {
            o.warn(txt)
        },
        e: function (txt) {
            o.error(txt)
        }
    };
}(globalThis.console));

const consoleHolder = globalThis.console;
export const debug =  function(bool){
    if(!bool){
        console = {};
        Object.keys(consoleHolder).forEach(function(key){
            console[key] = function(){};
        })
    }else{
        globalThis.console = consoleHolder;
    }
}
debug(false);