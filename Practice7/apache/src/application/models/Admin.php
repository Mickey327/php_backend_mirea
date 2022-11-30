<?php
namespace application\models;

use application\core\Model;
use application\lib\MD5;


class Admin extends Model {

    public function getUsers(){
        return $this->db->row('select * from users');
    }

    public function create($user){
        if (
            !empty($user->name) &&
            !empty($user->password)
        ) {
            $user->name = htmlspecialchars(strip_tags($user->name));
            $user->password = htmlspecialchars(strip_tags($user->password));
            $user->password = MD5::crypt_apr1_md5($user->password);
            $params = [
                "name" => $user->name,
                "password" => $user->password
            ];
            $this->db->query("INSERT INTO users(name, password) VALUES (:name, :password)", $params);
            return array("result" => json_encode("Пользователь был создан.", JSON_UNESCAPED_UNICODE), "code" => 201);
        }
        else {
            return array("result" => json_encode("Невозможно создать пользователя", JSON_UNESCAPED_UNICODE), "code" => 503);
        }
    }

    public function read(){
        $result = $this->db->row("SELECT id, name, password FROM users");

        if (!empty($result)) {
            return array("result"=> json_encode($result, JSON_UNESCAPED_UNICODE), "code" => 200);
        }
        else {
            return array("result"=> json_encode("Пользователь не найден.", JSON_UNESCAPED_UNICODE), "code" => 404);
        }
    }

    public function update($data){
        $data->name = htmlspecialchars(strip_tags($data->name));
        $data->password = htmlspecialchars(strip_tags($data->password));
        $data->password = MD5::crypt_apr1_md5($data->password);
        $data->id = htmlspecialchars(strip_tags($data->id));
        $params = [
            "id" => $data->id,
            "name" => $data->name,
            "password" => $data->password
        ];
        $this->db->query("UPDATE users SET name=:name, password=:password WHERE id=:id", $params);
        if (!empty($data->name) && !empty($data->password) && !empty($data->id)) {
            return array("result"=> json_encode("Пользователь был обновлён", JSON_UNESCAPED_UNICODE), "code" => 200);
        }
        else {
            return array("result"=> json_encode("Невозможно обновить пользователя", JSON_UNESCAPED_UNICODE), "code" => 503);
        }
    }

    public function delete($data){
        $data->id = htmlspecialchars(strip_tags($data->id));
        $params = [
            "id" => $data->id
        ];
        $this->db->query("DELETE FROM users WHERE id = :id", $params);
        return array("result"=> json_encode("Пользователь был удален", JSON_UNESCAPED_UNICODE), "code" => 200);
    }

}