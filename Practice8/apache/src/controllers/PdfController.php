<?php
namespace app\controllers;

use app\models\Pdf;
use yii\web\Controller;

class PdfController extends Controller {
    public function actionShow() {
        return $this->render('show');
    }

    public function actionUpload(){
        $result = Pdf::uploadFile();
        return $this->render('upload', ["result" => $result]);
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}