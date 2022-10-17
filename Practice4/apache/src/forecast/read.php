<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты
include_once "../objects/forecast.php";
include_once "../mysqlConnect.php";
$db = connectDB();
$forecast = new Forecast($db);

// запрашиваем прогнозы погоды
$result = $forecast->read();
$row_cnt = $result->num_rows;

// проверка, найдено ли больше 0 записей
if ($row_cnt > 0) {
    $forecasts_arr = array();
    $forecasts_arr["records"] = array();

    while ($row = $result->fetch_row()) {
        // извлекаем строку
        extract($row);
        $forecast_item = array(
            "id" => $row[0],
            "weather" => $row[1],
            "temp" => $row[2],
            "min_temp" => $row[3],
            "max_temp" => $row[4],
            "pressure" => $row[5],
            "wind_speed" => $row[6],
            "date" => $row[7]
        );
        array_push($forecasts_arr["records"], $forecast_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);

    // выводим данные о погоде в формате JSON
    echo json_encode($forecasts_arr);
}
else {
    // установим код ответа - 404 Не найдено
    http_response_code(404);

    // сообщаем пользователю, что записи о погоде не найдены
    echo json_encode(array("message" => "Записи о погоде не найдены."), JSON_UNESCAPED_UNICODE);
}

