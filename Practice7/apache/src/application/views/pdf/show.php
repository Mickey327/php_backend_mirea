<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous">
<form enctype="multipart/form-data" action="/pdf/upload" method="POST">
    <div>
        <input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
        <br>
        <label class="custom-file-label" for="file_field">Отправить файл:</label>
        <br>
        <input class="custom-file-input" id="file_field" name="userfile" type="file"/>
    </div>
    <br>
    <input class="btn btn-primary" type="submit" value="Отправить файл"/>
</form>
</body>
</html>
<?php
$scanned_directory = array_diff(scandir('application/views/pdf/files'), array('..','.'));
if (count($scanned_directory) > 0) {
    foreach($scanned_directory as $file) {
        echo "<div class='card'><a class='card-body' href='application/views/pdf/files/".$file."'>".$file."</a></div>";
    }
}
?>