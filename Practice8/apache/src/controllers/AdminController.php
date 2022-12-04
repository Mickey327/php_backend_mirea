<?php
namespace app\controllers;

use app\models\Admin;
use Yii;
use yii\web\Controller;

class AdminController extends Controller{
    public function actionUsers() {
        $users = Admin::find()->all();
        $this->view->title = "Admin page";
        return $this->render('users', compact('users'));
    }

    public function actionApi(){
        $method = $_SERVER['REQUEST_METHOD'];

        switch($method){
            case 'GET':
                $vars = Admin::find()->all();
                $vars += ['code' => 200];
                break;
            case 'POST':
                $data = json_decode(file_get_contents("php://input"));
                $user = new Admin();
                $user->name = $data->name;
                $user->password = Admin::crypt_apr1_md5($data->password);
                $user->save();
                $vars = array("result" => json_encode("Пользователь был создан.", JSON_UNESCAPED_UNICODE), "code" => 201);
                break;
            case 'PUT':
                $data = json_decode(file_get_contents("php://input"));
                $user = Admin::findOne(['id' => $data->id]);
                if ($user){
                    $user->name = $data->name;
                    $user->password = Admin::crypt_apr1_md5($data->password);
                    $vars = array("result"=> json_encode("Пользователь был обновлён", JSON_UNESCAPED_UNICODE), "code" => 200);
                } else {
                    $vars = array("result"=> json_encode("Невозможно обновить пользователя", JSON_UNESCAPED_UNICODE), "code" => 503);
                }
                break;
            case 'DELETE':
                $data = json_decode(file_get_contents("php://input"));
                Admin::findOne(['id' => $data->id])->delete();
                $vars = array("result"=> json_encode("Пользователь был удален", JSON_UNESCAPED_UNICODE), "code" => 200);
                break;
            default:
                $vars = [
                    "result"=> json_encode(array("message" => "Неверный http метод")),
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
