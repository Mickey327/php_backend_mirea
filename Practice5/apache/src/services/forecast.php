<?php
include_once "../repositories/forecast.php";
include_once "../entities/forecast.php";
class ForecastService{
    public static function create(){
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
        $forecast = new Forecast();
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

            if (ForecastRepository::create($forecast)) {
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
    }
    public static function read(){
        // запрашиваем прогнозы погоды
        $result = ForecastRepository::read();
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
    }
    public static function delete($id){
        if (ForecastRepository::delete($id)) {
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
    }
}
