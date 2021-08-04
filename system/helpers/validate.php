<?php
class validate {
    function __invoke() {

    }

    public static function input() {

    }
}
function validate($rules,$input) {
    foreach($input as $key => $value) {
        if (isset($rules[$key])) {
            foreach($rules[$key] as $rule) {
                if (!call_user_func($rule,$value)) {
                    return [
                        'status' => false,
                        'field' => $key,
                        'rule' => $rules[$key]
                    ];
                }
            }
        }
    }
    return [
        'status' => true
    ];
}
function email($value = null) {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
}

function required($value = null) {
    if (isset($value) && strlen($value) > 0) {
        return true;
    }
    return false;
}


