<?php

$target_dir = realpath(dirname(getcwd()))."/pdf/files/";
$target_file = $target_dir . basename($_FILES["userfile"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
if (file_exists($target_file)){
    $uploadOk = 0;
    echo "Такой файл уже существует\n";
}
if ($_FILES["userfile"]["size"] > 2000000) {
    $uploadOk = 0;
    echo "Файл слишком большой.";
}

if ($fileType != "pdf"){
    $uploadOk = 0;
    echo "Только pdf файлы доступны к загрузке\n";
}
if ($uploadOk == 1){
    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $target_file)) {
        echo "Файл ". htmlspecialchars( basename( $_FILES["userfile"]["name"])). " был успешно загружен.";
    } else {
        echo "Ошибка при загрузке файла.\n";
    }
}
?>



