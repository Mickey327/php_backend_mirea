<?php

namespace app\models;

use yii\db\ActiveRecord;

class Forecast extends ActiveRecord
{
    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'forecasts';
    }
    public static function responseFromAPI(): array
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
            $forecast = new Forecast;
            $forecast->weather = $params['weather'];
            $forecast->temp = $params['temp'];
            $forecast->min_temp = $params['min_temp'];
            $forecast->max_temp = $params['max_temp'];
            $forecast->pressure = $params['pressure'];
            $forecast->wind_speed = $params['wind_speed'];
            $forecast->save();
            return array("result" => json_encode("Запись о погоде была создана.", JSON_UNESCAPED_UNICODE), "code" => 201);
        }
        else {
            return array("result" => json_encode("Невозможно создать запись о погоде", JSON_UNESCAPED_UNICODE), "code" => 503);
        }
    }
}