<?php
class Forecast
{
    // подключение к базе данных и таблице "forecasts"
    private $conn;
    private $table_name = "forecasts";

    // свойства объекта
    public $id;
    public $weather;
    public $temp;
    public $min_temp;
    public $max_temp;
    public $pressure;
    public $wind_speed;
    public $date;

    // конструктор для соединения с базой данных
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function read()
    {
        // выбираем все записи
        $query = "SELECT
        id, weather, temp, min_temp, max_temp, pressure, wind_speed, date
    FROM forecasts";

        return $this->conn->query($query);
    }
    function create()
    {
        // запрос для вставки (создания) записей
        $query = "INSERT INTO forecasts(weather, temp, min_temp, max_temp, pressure, wind_speed) VALUES(?,?,?,?,?,?)";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->weather = htmlspecialchars(strip_tags($this->weather));
        $this->temp = htmlspecialchars(strip_tags($this->temp));
        $this->min_temp = htmlspecialchars(strip_tags($this->min_temp));
        $this->max_temp = htmlspecialchars(strip_tags($this->max_temp));
        $this->pressure = htmlspecialchars(strip_tags($this->pressure));
        $this->wind_speed = htmlspecialchars(strip_tags($this->wind_speed));

        // привязка значений
        $stmt->bind_param("sddddd", $this->weather, $this->temp, $this->min_temp, $this->max_temp, $this->pressure, $this->wind_speed);

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
        $query = "DELETE FROM forecasts WHERE id = ?";

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