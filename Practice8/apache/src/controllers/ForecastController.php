<?php

namespace app\controllers;

use app\models\Forecast;
use Yii;
use yii\web\Controller;

class ForecastController extends Controller
{

    public function actionNow(){
        $params = Forecast::responseFromAPI();
        $forecast = new Forecast;
        $forecast->weather = $params['weather'];
        $forecast->temp = $params['temp'];
        $forecast->min_temp = $params['min_temp'];
        $forecast->max_temp = $params['max_temp'];
        $forecast->pressure = $params['pressure'];
        $forecast->wind_speed = $params['wind_speed'];
        $forecast->save();
        return $this->render('now', $forecast);
    }

    public function actionHistory(){
        $forecasts = Forecast::find()->all();
        return $this->render('history', ['forecasts' => $forecasts]);
    }

    public function actionApi()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                $vars = Forecast::find()->all();
                $vars += ['code' => 200];
                break;
            case 'POST':
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
                    $vars = array("result" => json_encode("Запись о погоде была создана.", JSON_UNESCAPED_UNICODE), "code" => 201);
                }
                else {
                    $vars = array("result" => json_encode("Невозможно создать запись о погоде", JSON_UNESCAPED_UNICODE), "code" => 503);
                }
                break;
            case 'DELETE':
                $data = json_decode(file_get_contents("php://input"));
                Forecast::findOne(['id' => $data->id])->delete();
                $vars = array("result" => json_encode("Запись о погоде была удалена", JSON_UNESCAPED_UNICODE), "code" => 200);
                break;
            default:
                $vars = [
                    "result" => json_encode(array("message" => "Неверный http метод")),
                    "code" => 405
                ];
                break;
        }
        Yii::$app->response->statusCode = $vars['code'];
        return $this->asJson($vars);
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
