<?php
ini_set('memory_limit', '512M');
ini_set('display_errors', 1);
error_reporting(E_ALL);

function debug($str){
    echo '<pre>';
    var_dump($str);
    echo '</pre>';
    exit;
}
