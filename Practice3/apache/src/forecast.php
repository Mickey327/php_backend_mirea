<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forecast Page</title>
</head>
<body>
<?php
    include_once 'mysqlConnect.php';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://api.openweathermap.org/data/2.5/weather?q=Moscow&units=metric&appid=YOUR_API_KEY");
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    if (!$output){
        die("Connection Failure");
    }
    curl_close($curl);
    $response = json_decode($output, true);
    $weather_type = $response['weather'][0]['main'];
    $temp =  $response['main']['temp'];
    $min_temp = $response['main']['temp_min'];
    $max_temp = $response['main']['temp_max'];
    $pressure = $response['main']['pressure'];
    $wind_speed = $response['wind']['speed'];
    $mysqli = connectDB();
    if ($mysqli->connect_error){
        die("Can't connect to db");
    }
    $stmt = $mysqli->prepare("INSERT INTO forecasts(weather, temp, min_temp, max_temp, pressure, wind_speed) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt -> bind_param("sddddd", $weather_type, $temp, $min_temp, $max_temp, $pressure, $wind_speed);
    $stmt -> execute();
    $stmt -> close();
    $mysqli -> close();
    echo "<h1>Forecast in Moscow Now:</h1>
    <p>Weather: <span>$weather_type</span></p>
    <p>Temp: <span>$temp °C</span></p>
    <p>Max Temp: <span>$max_temp °C</span></p>
    <p>Min Temp: <span>$min_temp °C</span></p>
    <p>Pressure: <span>$pressure hPa</span></p>
    <p>Wind speed: <span>$wind_speed m/s</span></p>"
?>
</body>
</html>
