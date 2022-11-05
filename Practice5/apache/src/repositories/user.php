<?php
include_once "../mysqlConnect.php";
include_once "../entities/user.php";
include_once "../encrypt/md5.php";
class UserRepository {
    public static function read()
    {
        $db = connectDB();
        // выбираем все записи
        $query = "SELECT
        id, name, password
    FROM users";
        return $db->query($query);
    }
    public static function create($user)
    {
        $db = connectDB();
        $query = "INSERT INTO users(name, password) VALUES (?, ?)";

        // подготовка запроса
        $stmt = $db->prepare($query);

        // очистка
        $user->name = htmlspecialchars(strip_tags($user->name));
        $user->password = htmlspecialchars(strip_tags($user->password));
        $user->password = crypt_apr1_md5($user->password);


        // привязка значений
        $stmt->bind_param("ss", $user->name, $user->password);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    //метод для обновления
    public static function update($user)
    {
        $db = connectDB();
        // запрос для обновления записи (товара)
        $query = "UPDATE users SET name=?, password=? WHERE id=?";

        // подготовка запроса
        $stmt = $db->prepare($query);

        // очистка
        $user->name = htmlspecialchars(strip_tags($user->name));
        $user->password = htmlspecialchars(strip_tags($user->password));
        $user->password = crypt_apr1_md5($user->password);
        $user->id = htmlspecialchars(strip_tags($user->id));

        // привязываем значения
        $stmt->bind_param("ssi", $user->name, $user->password, $user->id);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // метод для удаления
    public static function delete($id)
    {
        $db = connectDB();
        $query = "DELETE FROM users WHERE id = ?";

        // подготовка запроса
        $stmt = $db->prepare($query);

        // очистка
        $id = htmlspecialchars(strip_tags($id));

        // привязываем id записи для удаления
        $stmt->bind_param('i', $id);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
