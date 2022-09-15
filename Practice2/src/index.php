<html lang="en">
<head>
    <title>Practice 2 page</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<h3>Выберите фигуру для рисовки (Задание 1)</h3>
<form  id = "a">
    <p>Форма фигуры</p>
    <input class="shapeCheckbox" type="radio" name="shape" value="circle" required />Круг <br>
    <input class="shapeCheckbox" type="radio" name="shape" value="rectangle" />Прямоугольник <br>
    <p>Цвет фигуры</p>
    <input class="colorCheckbox"  type="radio" name="color" value="red" required />Красный <br>
    <input class="colorCheckbox" type="radio" name="color" value="blue" />Синий <br>
    <p>Размер фигуры</p>
    <input class="sizeCheckbox" type="radio" name="size" value="small" required />Маленькая <br>
    <input class="sizeCheckbox" type="radio" name="size" value="big" />Большая<br>
    <input type='reset' id='reset-form' disabled value='Нарисовать'>
</form>

<h3>Введите числа через запятую, которые будут отсортированы методом слияния (Задание 2)</h3>
<form id = "b">
    <input class="numbersArea" type="text" name="numbers" id="sort-text" placeholder="Введите тут числа"/><br>
    <input type='reset' id='sort-form' disabled value='Отсортировать'>
</form>
<h3>Перейти в панель администратора(Задание 3)</h3>
<form id = "c">
    <input type='reset' id='admin-form' value='Перейти'>
</form>
<script type="text/javascript">
    function goToShape(){
        let shape = $('.shapeCheckbox:checked').val() === "circle" ? 1 : 0
        let color = $('.colorCheckbox:checked').val() === "red" ? 1 : 0
        let size = $('.sizeCheckbox:checked').val() === "small" ? 1 : 0
        document.location.href = 'shapes/shape.php?encoded=' + ((shape << 2) + (color << 1) + size).toString()
    }
    $(document).ready(function (){
        $('form input').click(function() {
            if ($('input[name=shape]:checked').length > 0 &&
                $('input[name=color]:checked').length > 0 &&
                $('input[name=size]:checked').length > 0) {
                let button = document.getElementById("reset-form")
                button.removeAttribute("disabled")
                button.addEventListener('click', goToShape)
            }
            $('input[name=numbers]').keyup(function (){
                let button = document.getElementById("sort-form")
                button.removeAttribute("disabled")
                button.addEventListener('click', function (){
                    document.location.href = 'sorting/sortPage.php?numbers=' + $('#sort-text').val()
                })

            })
            $('#admin-form').click(function (){
                document.location.href = 'unixCommands/commandPage.php'
            })
        })

    });

</script>
</body>
</html>

