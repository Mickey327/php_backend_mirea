<?php
namespace application\controllers;
use application\core\Controller;

class AdminController extends Controller {
    public function usersAction() {
        $users = $this->model->getUsers();
        $vars = [
            'users' => $users
        ];
        $this->view->render('Панель администратора', $vars);
    }

    public function apiAction(){
        $method = $_SERVER['REQUEST_METHOD'];

        switch($method){
            case 'GET':
                $vars = $this->model->read();
                $this->view->json($vars['result'], $vars['code']);
                break;
            case 'POST':
                $data = json_decode(file_get_contents("php://input"));
                $vars = $this->model->create($data);
                $this->view->json($vars['result'], $vars['code']);
                break;
            case 'PUT':
                $data = json_decode(file_get_contents("php://input"));
                $vars = $this->model->update($data);
                $this->view->json($vars['result'], $vars['code']);
                break;
            case 'DELETE':
                $data = json_decode(file_get_contents("php://input"));
                $vars = $this->model->delete($data);
                $this->view->json($vars['result'], $vars['code']);
                break;
            default:
                http_response_code(405);
                $vars = [
                    "result"=> json_encode(array("message" => "Неверный http метод")),
                    "code" => 405
                ];
                echo json_encode(array("message" => "Неверный http метод"));
                $this->view->json($vars['result'], $vars['code']);
                break;
        }
    }
}
