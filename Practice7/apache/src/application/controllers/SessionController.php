<?php
namespace application\controllers;
use application\core\Controller;

class SessionController extends Controller {
    public function startAction() {
        $this->view->render('Тест сессий');
    }

    public function pageAction(){
        $result = $this->model->defineTheme();
        $vars = ["result" => $result];
        $this->view->render("Страница после загрузки", $vars);
    }

}


