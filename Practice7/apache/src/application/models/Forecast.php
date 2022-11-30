<?php
namespace application\models;

use application\core\Model;

class Forecast extends Model {

    public function getForecasts(){
        return $this->db->row('SELECT * FROM forecasts');
    }

    public function insertForecastFromAPI() {
        $params = Forecast::responseFromAPI();
        $this->db->query("INSERT INTO forecasts(weather, temp, min_temp, max_temp, pressure, wind_speed) VALUES (:weather,:temp,:min_temp,:max_temp,:pressure,:wind_speed)", $params);

        return $params;
    }

    private static function responseFromAPI(): array
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://api.openweathermap.org/data/2.5/weather?q=Moscow&units=metric&appid=YOUR_API_KEY");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($output, true);
        $params = [
            'weather' => $response['weather'][0]['main'],
            'temp' => $response['main']['temp'],
            'min_temp' => $response['main']['temp_min'],
            'max_temp' => $response['main']['temp_max'],
            'pressure' => $response['main']['pressure'],
            'wind_speed' => $response['wind']['speed']
        ];
        return $params;
    }

    public function create(){
        $params = Forecast::responseFromAPI();
        if (
            !empty($params['weather']) &&
            !empty($params['temp']) &&
            !empty($params['min_temp']) &&
            !empty($params['max_temp']) &&
            !empty($params['pressure']) &&
            !empty($params['wind_speed'])
        ) {
            $this->db->query("INSERT INTO forecasts(weather, temp, min_temp, max_temp, pressure, wind_speed) VALUES (:weather,:temp,:min_temp,:max_temp,:pressure,:wind_speed)", $params);
            return array("result" => json_encode("Запись о погоде была создана.", JSON_UNESCAPED_UNICODE), "code" => 201);
            }
            else {
                return array("result" => json_encode("Невозможно создать запись о погоде", JSON_UNESCAPED_UNICODE), "code" => 503);
            }
    }

    public function read(){
        // запрашиваем прогнозы погоды
        $result = $this->db->row("SELECT id, weather, temp, min_temp, max_temp, pressure, wind_speed, date FROM forecasts");

        if (!empty($result)) {
            return array("result"=> json_encode($result, JSON_UNESCAPED_UNICODE), "code" => 200);
        }
        else {
            return array("result"=> json_encode("Записи о погоде не найдены.", JSON_UNESCAPED_UNICODE), "code" => 404);
        }
    }
    public function delete($id){
        $id = htmlspecialchars(strip_tags($id));
        $params = [
            "id" => $id
        ];
        $this->db->query("DELETE FROM forecasts WHERE id = :id", $params);
        return array("result"=> json_encode("Запись о погоде была удалена", JSON_UNESCAPED_UNICODE), "code" => 200);
    }

}
