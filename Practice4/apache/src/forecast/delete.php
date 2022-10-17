<?php

// HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../objects/forecast.php";
include_once "../mysqlConnect.php";
$db = connectDB();
$forecast = new Forecast($db);

// получаем id
$data = json_decode(file_get_contents("php://input"));

// установим id
$forecast->id = $data->id;

// удаление
if ($forecast->delete()) {
    // код ответа - 200 ok
    http_response_code(200);

    // сообщение пользователю
    echo json_encode(array("message" => "Запись о погоде была удалена"), JSON_UNESCAPED_UNICODE);
} // если не удается удалить товар
else {
    // код ответа - 503 Сервис не доступен
    http_response_code(503);

    // сообщим об этом пользователю
    echo json_encode(array("message" => "Не удалось удалить запись о погоде"));
}
