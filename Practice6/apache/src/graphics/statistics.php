<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Statistics page</title>
    <style>span { margin: 10px; }</style>
</head>
<body>
<h1>Графики:</h1>
<?php
require '../../vendor/autoload.php';
require 'shape.php';


$loader = new Nelmio\Alice\Loader\NativeLoader();

$objectSet = $loader->loadData([
    MyShape::class => [
        'myshape{1..50}' => [
            'red' => '<numberBetween(0, 255)>',
            'green' => '<numberBetween(0, 255)>',
            'blue' => '<numberBetween(0, 255)>',
            'width' => '<numberBetween(100, 500)>',
            'height' => '<numberBetween(100, 500)>'
        ],
    ]
]);
$array = $objectSet->getObjects();
?>
<div style=" display: flex;flex-direction: column;">
    <?php
    $i = 0;
    $j = 0;
    foreach ($array as $shape) {
        if ($i === 3)
            $i = 0;
        echo <<<A
            <style="
                display: flex;
                flex-direction: row;
                justify-content: space-between;
            ">
                <img src="/graphics/generator.php?type=$i&data=$shape&number=$j" alt="Here should be a picture"><span></span>
            </div> 
A;
        $i++;
        $j++;
    }
    ?>
</div>
</body>
</html>
