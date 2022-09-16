
<html lang="en">
<head>
    <title>Admin page</title>
</head>
<body>
<?php
include_once 'commands.php';
    $commands = array("ls", "ps", "whoami", "id", "pwd", "date");
    foreach ($commands as $command) {
        run_command($command);
    }
?>

</body>

</html>

