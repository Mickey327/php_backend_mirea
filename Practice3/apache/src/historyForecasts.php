<html lang="en">
<head>
    <title>History forecast page</title>
    <link rel="stylesheet" href="http://localhost:8081/style.css" type="text/css"/>
</head>
<body>
<h1>History of forecasts in Moscow which was get by users</h1>
<table>
    <tr><th>Date</th><th>Weather Type</th><th>Temp</th><th>Min. Temp</th><th>Max. Temp</th><th>Pressure</th><th>Wind Speed(m/s)</th></tr>
    <?php
    include_once 'mysqlConnect.php';
    $mysqli = connectDB();
    if ($mysqli->connect_error){
        die("Cant connect to db");
    }
    $result = $mysqli->query("SELECT * FROM forecasts");
    foreach ($result as $row){
        echo "<tr><td>{$row['date']}</td><td>{$row['weather']}</td><td>{$row['temp']}</td><td>{$row['min_temp']}</td><td>{$row['max_temp']}</td><td>{$row['pressure']}</td><td>{$row['wind_speed']}</td></tr>";
    }
    ?>
</table>
</body>
</html>
