<?php
$this->title = 'Show statistics page';
?>
<h1>Графики:</h1>
<div style=" display: flex;flex-direction: column;">
    <?php
    foreach ($images as $image) {
        echo <<<A
            <div>
                <style="
                display: flex;
                flex-direction: row;
                justify-content: space-between;
            ">
                <img src=$image alt="Here should be a picture"><span></span>
            </div> 
A;
    }
    ?>
</div>