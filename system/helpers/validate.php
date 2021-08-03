<?php
function validate($rules,$input) {
    
    foreach($input as $key => $value) {
        if (isset($rules[$key])) {
            if (!call_user_func($rules[$key],$value)) {
                return [
                    'status' => false,
                    'field' => $key,
                    'rule' => $rules[$key]
                ];
            }
        }
    }
    return [
        'status' => true
    ];
}

function requried($value = null) {
    if (isset($value) && strlen($value) > 0) {
        return true;
    }
    return false;
}
