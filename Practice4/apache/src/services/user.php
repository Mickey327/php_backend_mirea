<?php
include_once "../repositories/user.php";
include_once "../entities/user.php";
class UserService{
    public static function create($data){
        if (
            !empty($data->name) &&
            !empty($data->password)
        ) {
            $user = new User();
            $user->name = $data->name;
            $user->password = $data->password;

            // создание пользователя
            if (UserRepository::create($user)) {
                // установим код ответа - 201 создано
                http_response_code(201);

                // сообщим пользователю
                echo json_encode(array("message" => "Пользователь был создан."), JSON_UNESCAPED_UNICODE);
            }
            // если не удается создать пользователя, сообщим об этом
            else {
                // установим код ответа - 503 сервис недоступен
                http_response_code(503);

                // сообщим пользователю
                echo json_encode(array("message" => "Невозможно создать пользователя."), JSON_UNESCAPED_UNICODE);
            }
        }
        // сообщим пользователю что данные неполные
        else {
            // установим код ответа - 400 неверный запрос
            http_response_code(400);

            // сообщим пользователю
            echo json_encode(array("message" => "Невозможно создать пользователя. Данные неполные."), JSON_UNESCAPED_UNICODE);
        }
    }
    public static function read(){
        $result = UserRepository::read();
        $row_cnt = $result->num_rows;

        // проверка, найдено ли больше 0 записей
        if ($row_cnt > 0) {
            $users_arr = array();
            $users_arr["records"] = array();

            while ($row = $result->fetch_row()) {
                // извлекаем строку
                extract($row);
                $user_item = array(
                    "id" => $row[0],
                    "name" => $row[1],
                    "password" => $row[2],
                );
                array_push($users_arr["records"], $user_item);
            }

            // устанавливаем код ответа - 200 OK
            http_response_code(200);

            echo json_encode($users_arr);
        }
        else {
            // установим код ответа - 404 Не найдено
            http_response_code(404);

            echo json_encode(array("message" => "Записи о пользователях не найдены."), JSON_UNESCAPED_UNICODE);
        }
    }

    public static function update($data){
        $user = new User();
        $user->id = $data->id;
        $user->name = $data->name;
        $user->password = $data->password;
        if (UserRepository::update($user)) {
            // установим код ответа - 200 ok
            http_response_code(200);

            // сообщим пользователю
            echo json_encode(array("message" => "Пользователь был обновлён"), JSON_UNESCAPED_UNICODE);
        }
        else {
            // код ответа - 503 Сервис не доступен
            http_response_code(503);

            // сообщение пользователю
            echo json_encode(array("message" => "Невозможно обновить пользователя"), JSON_UNESCAPED_UNICODE);
        }
    }

    public static function delete($id){
        if (UserRepository::delete($id)) {
            // код ответа - 200 ok
            http_response_code(200);

            // сообщение пользователю
            echo json_encode(array("message" => "Пользователь был удален"), JSON_UNESCAPED_UNICODE);
        } // если не удается удалить товар
        else {
            // код ответа - 503 Сервис не доступен
            http_response_code(503);

            // сообщим об этом пользователю
            echo json_encode(array("message" => "Не удалось удалить пользователя"));
        }
    }
}
