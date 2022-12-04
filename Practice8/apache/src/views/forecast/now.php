<?php
$this->title = 'Forecast now';
?>
<?php
echo "<h1>Forecast in Moscow Now:</h1>
    <p>Weather: <span>$forecast->weather</span></p>
    <p>Temp: <span>$forecast->emp °C</span></p>
    <p>Max Temp: <span>$forecast->max_temp °C</span></p>
    <p>Min Temp: <span>$forecast->min_temp °C</span></p>
    <p>Pressure: <span>$forecast->pressure hPa</span></p>
    <p>Wind speed: <span>$forecast->wind_speed m/s</span></p>"
?>
