<?php
session_start();
if (isset($_POST['theme'])){
    $_SESSION['theme'] = $_POST['theme'];
}

function defineTheme(): void
{
    if (isset($_SESSION['theme'])){
        if ($_SESSION['theme'] == "black"){
            echo <<<A
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
            echo <<<A
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
}
