<?php
function merge_sort(&$arrayToSort)
{
    if (sizeof($arrayToSort) <= 1)
        return $arrayToSort;

    // split our input array into two halves
    // left...
    $leftFrag = array_slice($arrayToSort, 0, (int)(count($arrayToSort)/2));
    // right...
    $rightFrag = array_slice($arrayToSort, (int)(count($arrayToSort)/2));

    // RECURSION
    // split the two halves into their respective halves...
    $leftFrag = merge_sort($leftFrag);
    $rightFrag = merge_sort($rightFrag);

    $returnArray = merge($leftFrag, $rightFrag);

    return $returnArray;
}

function merge(&$lF, &$rF)
{
    $result = array();

    // while both arrays have something in them
    while (count($lF)>0 && count($rF)>0) {
        if ($lF[0] <= $rF[0]) {
            array_push($result, array_shift($lF));
        }
        else {
            array_push($result, array_shift($rF));
        }
    }

    // did not see this in the pseudo code,
    // but it became necessary as one of the arrays
    // can become empty before the other
    array_splice($result, count($result), 0, $lF);
    array_splice($result, count($result), 0, $rF);

    return $result;
}
?>