<?php include_once 'mysqlConnect.php';
    const cookie = 'auth';
    header('Access-Control-Allow-Origin: *');
    $name = $_GET['name'];
    $password = $_GET['password'];
    if (!isset($name) || !isset($password)) {
        echo 'false';
        exit(0);
    }

    $mysqli = connectDB();
    if (mysqli_connect_errno()) {
        printf("Не удалось подключиться: %s\n", mysqli_connect_error());
        exit();
    }
    $statement = $mysqli->prepare(sprintf(
    'select %s, %s from %s where name = ? and password = ?',
    'id', 'role', 'users'
    ));
    $statement->bind_param('ss', $name, $password);
    $statement->execute();
    $statement->store_result();
    $result = $statement->num_rows;
    if ($result === 1) {
        $statement->bind_result($i, $role);
        $statement->fetch();
        setcookie(cookie, $i);
        $url = '/authorized.php?role='.$role;
        header('Location: ' . $url);
        exit(0);
    } else {
        echo 'Wrong credentials';
    }
    $mysqli->close();
?>
