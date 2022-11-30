<?php
namespace application\controllers;
use application\core\Controller;
use application\models\Forecast;

class ForecastController extends Controller {
    public function nowAction() {
        $vars = $this->model->insertForecastFromAPI();
        $this->view->render('Прогноз погоды в Москве сейчас', $vars);
    }

    public function historyAction() {
        $forecasts = $this->model->getForecasts();
        $vars = [
            'forecasts' => $forecasts
        ];
        $this->view->render('История прогнозов погоды в Москве', $vars);
    }

    public function apiAction(){
        $method = $_SERVER['REQUEST_METHOD'];

        switch($method){
            case 'GET':
                $vars = $this->model->read();
                $this->view->json($vars['result'], $vars['code']);
                break;
            case 'POST':
                $vars = $this->model->create();
                $this->view->json($vars['result'], $vars['code']);
                break;
            case 'DELETE':
                $data = json_decode(file_get_contents("php://input"));
                $vars = $this->model->delete($data->id);
                $this->view->json($vars['result'], $vars['code']);
                break;
            default:
                $vars = [
                    "result"=> json_encode(array("message" => "Неверный http метод")),
                    "code" => 405
                ];
                $this->view->json($vars['result'], $vars['code']);
                break;
        }
    }
}
