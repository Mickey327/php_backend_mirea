<?php
namespace application\controllers;
use application\core\Controller;

class StatisticsController extends Controller {
    public function showAction() {
        $vars = ["images" => $this->model->drawImages()];
        $this->view->render('Страница графиков', $vars);
    }

}