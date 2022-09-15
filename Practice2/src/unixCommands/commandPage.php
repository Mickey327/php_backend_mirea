
<html lang="en">
<head>
    <title>Admin page</title>
</head>
<body>
<?php
include_once 'commands.php';
?>
<input type='button' name='ls' value='ls' onclick='ls()'>
<input type='button' name='ps' value='ps' onclick='ps()'>
<input type='button' name='whoami' value='whoami' onclick='whoami()'>
<input type='button' name='id' value='id' onclick='id_command()'>
<input type='button' name='pwd' value='pwd' onclick='pwd()'>
<input type='button' name='date' value='date' onclick='date()'>
<p id="ls"></p>
<p id="ps"></p>
<p id="whoami"></p>
<p id="id-command"></p>
<p id="pwd"></p>
<p id="date"></p>
</body>
<script>
    function ls(){
        document.getElementById("ls").innerText =  "ls: " + "<?php echo ls_command() ?>"
    }
    function pwd(){
        document.getElementById("pwd").innerText =  "pwd: " + "<?php echo pwd_command() ?>"
    }
    function date(){
        document.getElementById("date").innerText =  "date: " + "<?php echo date_command() ?>"
    }
    function whoami(){
        document.getElementById("whoami").innerText =  "whoami: " + "<?php echo whoami_command() ?>"
    }
    function ps(){
        document.getElementById("ps").innerText =  "ps: " + "<?php echo ps_command() ?>"
    }
    function id_command(){
        document.getElementById("id-command").innerText =  "id: " + "<?php echo id_command() ?>"
    }
</script>
</html>

