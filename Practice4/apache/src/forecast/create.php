<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../objects/forecast.php";
include_once "../mysqlConnect.php";


// получаем данные от API
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://api.openweathermap.org/data/2.5/weather?q=Moscow&units=metric&appid=YOUR_API_KEY");
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($curl);
if (!$output){
    die("Connection Failure");
}
curl_close($curl);
$response = json_decode($output, true);
$weather_type = $response['weather'][0]['main'];
$temp =  $response['main']['temp'];
$min_temp = $response['main']['temp_min'];
$max_temp = $response['main']['temp_max'];
$pressure = $response['main']['pressure'];
$wind_speed = $response['wind']['speed'];
$db = connectDB();
$forecast = new Forecast($db);
// убеждаемся, что данные не пусты
if (
    !empty($weather_type) &&
    !empty($temp) &&
    !empty($min_temp) &&
    !empty($max_temp) &&
    !empty($pressure) &&
    !empty($wind_speed)
) {
    $forecast->weather = $weather_type;
    $forecast->temp = $temp;
    $forecast->min_temp = $min_temp;
    $forecast->max_temp = $max_temp;
    $forecast->pressure = $pressure;
    $forecast->wind_speed = $wind_speed;

    if ($forecast->create()) {
        // установим код ответа - 201 создано
        http_response_code(201);

        echo json_encode(array("message" => "Запись о погоде была создана."), JSON_UNESCAPED_UNICODE);
    }
    else {
        http_response_code(503);

        echo json_encode(array("message" => "Невозможно создать запись о погоде."), JSON_UNESCAPED_UNICODE);
    }
}
else {
    http_response_code(400);

    echo json_encode(array("message" => "Невозможно создать запись о погоде. Данные неполные."), JSON_UNESCAPED_UNICODE);
}