<?php
include_once "../encrypt/md5.php";
class User
{
    // подключение к базе данных и таблице "forecasts"
    private $conn;
    private $table_name = "users";

    // свойства объекта
    public $id;
    public $name;
    public $password;

    // конструктор для соединения с базой данных
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function read()
    {
        // выбираем все записи
        $query = "SELECT
        id, name, password
    FROM users";

        // подготовка запроса
        //$stmt = $this->conn->prepare($query);

        // выполняем запрос
        //$stmt->execute();
        return $this->conn->query($query);
    }
    function create()
    {
        // запрос для вставки (создания) записей
        $query = "INSERT INTO users(name, password) VALUES (?, ?)";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->password = crypt_apr1_md5($this->password);


        // привязка значений
        $stmt->bind_param("ss", $this->name, $this->password);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    function update()
    {
        // запрос для обновления записи (товара)
        $query = "UPDATE users SET name=?, password=? WHERE id=?";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->password = crypt_apr1_md5($this->password);
        $this->id = htmlspecialchars(strip_tags($this->id));

        // привязываем значения
        $stmt->bind_param("ssi", $this->name, $this->password, $this->id);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // метод для удаления
    function delete()
    {
        // запрос для удаления записи
        $query = "DELETE FROM users WHERE id = ?";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->id = htmlspecialchars(strip_tags($this->id));

        // привязываем id записи для удаления
        $stmt->bind_param('i', $this->id);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}