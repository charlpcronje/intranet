// By using the JS proxy it is easy and fast to do DOM operations

export const proxyNodeList = function(selector) { 
    const nodeList = document.querySelectorAll(selector);
    return new Proxy(nodeList, {
        set: function(target, property, value) {
            for (let i = 0; i < target.length; i++) {
                target[i][property] = value;
            }
         },
        get: function(target, property) {
            return target[0] && target[0][property];
        }
    });
}

export function selector(selector) {
    let all = document.querySelectorAll(selector);
    if(all.length == 1) return all[0];
    return all;
}


export const debounce = (fn, delay = 500) => {
    let timeoutId;
    return (...args) => {
        // cancel the previous timer
        if (timeoutId) {
            clearTimeout(timeoutId);
        }
        // setup a new timer
        timeoutId = setTimeout(() => {
            fn.apply(null, args)
        }, delay);
    };
};