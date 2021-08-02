<?php

use system\base\DotData;

function data() {
    $dotData = new DotData();
    return $dotData->DataSet->data;
}