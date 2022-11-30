<?php
echo 'Добро пожаловать на стартовую страницу с сессией';
$_SESSION['theme'] = "white";
$_SESSION['start_time'] = date("Y-m-d H:i:s");
$_SESSION['count'] = 0;

echo '<br><a href="/session/page">Страница теста сессий</a>';
