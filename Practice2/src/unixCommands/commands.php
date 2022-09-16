<?php
    function run_command($command){
        $result = array();
        exec($command, $result);
        echo "<pre>" .$command. ": </pre>";
        echo "<pre>" .implode("\n", $result) . "</pre>";
    }
?>
