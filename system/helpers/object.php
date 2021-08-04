<?php
function loadSQL($file) {
    return include env('app.sql.path').$file.'.php';
}

function transpose($data,$pk,$objName,$objPk,$objColmns) {
    $newData = [];
    foreach($data as $key => $obj) {
        if (!isset($newData[$obj->$pk])) {
            $newData[$obj->$pk] = $obj;
        }
        $tempObj = (object)[];
        foreach($objColmns as $column) {
            $tempObj->$column = $obj->$column;
        }
        $newData[$obj->$pk]->$objName[$obj->$objPk] = $tempObj;
    }
    return $newData;
}