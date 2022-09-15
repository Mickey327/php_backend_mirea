<?php
    function ls_command(): bool|string
    {
        return exec('ls');
    }
    function ps_command(): bool|string
    {
        return exec('ps -e');
    }
    function whoami_command(): bool|string
    {
        return exec('whoami');
    }
    function id_command(): bool|string
    {
        return exec('id');
    }
    function pwd_command(): bool|string
    {
        return exec('pwd');
    }
    function date_command(): bool|string
    {
        return exec('date');
    }
?>
