<?php
namespace app\controllers;

use app\models\Statistics;
use yii\web\Controller;

class StatisticsController extends Controller {

    public function actionShow(){
        $vars = ["images" => Statistics::drawImages()];
        return $this->render('show', $vars);
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}