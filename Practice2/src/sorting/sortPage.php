<?php
    include_once 'mergeSort.php';
    if (isset($_GET['numbers'])){
        $array = array_filter(explode(',', $_GET['numbers']), 'is_numeric');
        $sorted_array = merge_sort($array);
        echo "<pre> [";
        echo implode(", ", $sorted_array);
        echo "] </pre>";
    }
?>
