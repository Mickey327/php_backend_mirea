<?php
include_once "../services/forecast.php";
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
$method = $_SERVER['REQUEST_METHOD'];

switch($method){
    case 'GET':
        ForecastService::read();
        break;
    case 'POST':
        ForecastService::create();
        break;
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        ForecastService::delete($data->id);
        break;
    default:
        // код ответа - Метод не поддерживается
        http_response_code(405);

        // сообщим об этом пользователю
        echo json_encode(array("message" => "Неверный http метод"));
        break;
}
