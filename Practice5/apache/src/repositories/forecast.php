<?php
include_once "../mysqlConnect.php";
include_once "../entities/forecast.php";
class ForecastRepository {
    public static function read()
    {
        $db = connectDB();
        // выбираем все записи
        $query = "SELECT
        id, weather, temp, min_temp, max_temp, pressure, wind_speed, date
    FROM forecasts";

        return $db->query($query);
    }
    public static function create($forecast)
    {
        $db = connectDB();
        // запрос для вставки (создания) записей
        $query = "INSERT INTO forecasts(weather, temp, min_temp, max_temp, pressure, wind_speed) VALUES(?,?,?,?,?,?)";

        // подготовка запроса
        $stmt = $db->prepare($query);

        // очистка
        $forecast->weather = htmlspecialchars(strip_tags($forecast->weather));
        $forecast->temp = htmlspecialchars(strip_tags($forecast->temp));
        $forecast->min_temp = htmlspecialchars(strip_tags($forecast->min_temp));
        $forecast->max_temp = htmlspecialchars(strip_tags($forecast->max_temp));
        $forecast->pressure = htmlspecialchars(strip_tags($forecast->pressure));
        $forecast->wind_speed = htmlspecialchars(strip_tags($forecast->wind_speed));

        // привязка значений
        $stmt->bind_param("sddddd", $forecast->weather, $forecast->temp, $forecast->min_temp, $forecast->max_temp, $forecast->pressure, $forecast->wind_speed);

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
        // запрос для удаления записи
        $query = "DELETE FROM forecasts WHERE id = ?";

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
