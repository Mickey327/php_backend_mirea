<?php
namespace application\models;

use application\core\Model;

class Session extends Model {

    public function defineTheme()
    {
        if (isset($_POST['white'])){
            $_SESSION['theme'] = "white";
        }
        if (isset($_POST['black'])){
            $_SESSION['theme'] = "black";
        }
        if (isset($_SESSION['theme'])){
            if ($_SESSION['theme'] == "black"){
                return <<<A
        <style>
            body { background-color: black; }
            span { color: white; }
            h1 { color: white; }
            p { color: white; }
            button { background-color: black; color: white; }
            input { background-color: black; color: white; }
            form { color: white; }
        </style>
    A;
            } else if ($_SESSION['theme'] == "white") {
                return <<<A
        <style>
            body { background-color: white; }
            span { color: black; }
            h1 { color: black; }
            p { color: black; }
            button { background-color: white; color: black; }
            input { background-color: white; color: black; }
            form { color: black; }
        </style>
        A;
            }
        }
        return "";

    }
}
