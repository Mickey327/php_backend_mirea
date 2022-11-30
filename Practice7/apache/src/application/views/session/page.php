<?php
echo $result;

echo '<form action="/session/page" method="POST"><input type="submit"  class="button" name="white" value="white" />
<input type="submit" class="button" name="black" value="black" /></form>';
echo "<h1>Страница для тестирования сессий</h1>";
echo "<p>Сессия была начата GMT+0: " . $_SESSION['start_time'] . "</p>";
echo "<p>Значение темы:" . $_SESSION['theme'] . "</p>";
if (!isset($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}
echo "<p>Счётчик перезапуска страницы с данной сессией: " . $_SESSION['count'] . "</p>";
?>
