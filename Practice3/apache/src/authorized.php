<?php
    if (!isset($_GET['role'])) {
        echo 'Wrong credentials';
        exit(0);
    }
    else {
        $role = $_GET['role'];
        if ($role == 'admin'){
            echo "<a href='admin.php'>Get List of Users</.a>";
        }
        echo "<br>";
        echo "<a href='forecast.php'>Get Forecast In Moscow Now</.a>";
    }
?>
