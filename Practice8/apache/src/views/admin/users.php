<?php
$this->title = 'Admin page';
?>
<style>span { margin: 10px; }</style>
<div style="display: flex;flex-direction: column;">
    <?php
    foreach ($users as $user) { echo <<<A
            <div style="
                display: flex;
                flex-direction: row;
            ">
                <span>{$user['id']}</span><span>{$user['name']}</span><span>{$user['password']}</span>
            </div>
        A;
    }
    ?>
</div>
