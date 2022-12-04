<?php
namespace app\controllers;


use app\models\Session;
use yii\web\Controller;

class SessionController extends Controller {

    public function actionPage(){
        $result = Session::defineTheme();
        $vars = ["result" => $result];
        return $this->render('page', $vars);
    }

    public function actionStart(){
        return $this->render('start');
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}