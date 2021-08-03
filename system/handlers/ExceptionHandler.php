<?php
set_exception_handler(function($ex) {
    $file = $ex->getFile();
    $line = $ex->getLine();
    $msg = $ex->getMessage();
    $bt = $ex->getTraceAsString();

    error_log($msg, 0);
    error_log($file . " - " . $line, 0);
    error_log($bt, 0);
    if (env('debug.error.reporting')) {
        if (env('debug.error.display')) {
            echo $msg." in file: ".$file . " - Line: " . $line;
            print_r($bt);
        }
        if (env('debug.error.console.log')) {
            echo "<script>".json_encode("File: ".$file. " Line:" . $line."\r\n".$msg)."</script>";
        }
        if (env('debug.error.header.log')) {
            $exp = explode('/',$file);
            $file = array_pop($exp);
            if (!headers_sent()) {
                header('log_'.$file.'_'.$line.': '.json_encode($msg));
            }
        }
    }
});