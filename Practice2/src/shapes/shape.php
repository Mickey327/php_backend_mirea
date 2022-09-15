

<?php

    //3rd digit shape (1 - circle, 0 - rect), 2nd digit color (1 - red, 0 - blue), 1st digit size (1 - 100px, 2 - 500px)
    require_once 'ShapeObject.php';
    if (isset($_GET['encoded'])){
        $shapeCode = $_GET['encoded'];
        $shapeValue = $shapeCode & 0b100;
        $colorValue = $shapeCode & 0b010;
        $sizeValue = $shapeCode & 0b001;

        if (!is_numeric($shapeCode) || $shapeCode > (1 << 3) - 1 || $shapeCode < 0)
            echo 'Parameter should be from 0 to 7';
        else {
            $color = ($colorValue == 2) ? "red" : "blue";
            $size = ($sizeValue == 1) ? 100 : 500;
            echo "<svg height='1200' width='1200'>";
            if ($shapeValue == 4) {
                (new Circle($size, $color))->getShapeTag();
            }
            else {
                (new Rectangle($size * 2, $size, $color))->getShapeTag();
            }
            echo "</svg>";
        }
    } else {
        echo 'Wrong parameter type';
    }
?>
