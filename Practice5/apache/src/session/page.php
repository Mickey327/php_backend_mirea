<?php include_once 'theme.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administrate</title>
    <style>span { margin: 10px; }</style>
    <?php
    defineTheme();
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<?php
echo '<input type="submit" class="button" name="white" value="white" />
<input type="submit" class="button" name="black" value="black" />';
echo "<h1>Страница для тестирования сессий</h1>";
echo "<p>Сессия была начата GMT+0: ".$_SESSION['start_time']."</p>";
echo "<p>Значение темы:" .($_SESSION['theme'] ? "black" : "white") . "</p>";
if (!isset($_SESSION['count']))
{
    $_SESSION['count'] = 1;
}
else
{
    ++$_SESSION['count'];
}
echo "<p>Счётчик перезапуска страницы с данной сессией: " . $_SESSION['count'] . "</p>";
?>
</body>
<script type="text/javascript">
    $(document).ready(function(){
        $('.button').click(function(){
            var clickBtnValue = $(this).val();
            var ajaxurl = 'theme.php'
            console.log(clickBtnValue)
            var data =  {'theme': clickBtnValue};
            $.post(ajaxurl, data, function () {
                window.location.reload()
            });
        });
    });
</script>
</html>
