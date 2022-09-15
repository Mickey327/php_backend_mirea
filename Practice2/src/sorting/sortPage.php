<?php
    include_once 'mergeSort.php';
    if (isset($_GET['numbers'])){
        $array = array_filter(explode(',', $_GET['numbers']), 'is_numeric');
        $sorted_array = merge_sort($array);
        foreach ($sorted_array as $item){
            printf("%d ",$item);
        }
    }
?>
