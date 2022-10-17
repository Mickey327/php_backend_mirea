<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты
include_once "../objects/user.php";
include_once "../mysqlConnect.php";

$db = connectDB();
$user = new User($db);


$result = $user->read();
$row_cnt = $result->num_rows;

// проверка, найдено ли больше 0 записей
if ($row_cnt > 0) {
    $users_arr = array();
    $users_arr["records"] = array();

    while ($row = $result->fetch_row()) {
        // извлекаем строку
        extract($row);
        $user_item = array(
            "id" => $row[0],
            "name" => $row[1],
            "password" => $row[2],
        );
        array_push($users_arr["records"], $user_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);

    echo json_encode($users_arr);
}
else {
    // установим код ответа - 404 Не найдено
    http_response_code(404);

    echo json_encode(array("message" => "Записи о пользователях не найдены."), JSON_UNESCAPED_UNICODE);
}

