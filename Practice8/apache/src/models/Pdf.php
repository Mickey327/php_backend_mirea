<?php

namespace app\models;

class Pdf
{
    public static function uploadFile()
    {
        $target_dir = "./files/";
        $target_file = $target_dir . basename($_FILES["userfile"]["name"]);
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (file_exists($target_file)) {
            return "Такой файл уже существует\n";
        }
        if ($_FILES["userfile"]["size"] > 2000000) {
            return "Файл слишком большой.";
        }

        if ($fileType != "pdf") {
            return "Только pdf файлы доступны к загрузке\n";
        }
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $target_file)) {
            return "Файл " . htmlspecialchars(basename($_FILES["userfile"]["name"])) . " был успешно загружен.";
        } else {
            return "Ошибка при загрузке файла.\n";
        }

    }
}