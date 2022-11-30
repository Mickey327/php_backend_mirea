<link rel="stylesheet" href="http://localhost:8081/style.css" type="text/css"/>
<h1>History of forecasts in Moscow which was get by users</h1>
<table>
    <tr><th>Date</th><th>Weather Type</th><th>Temp</th><th>Min. Temp</th><th>Max. Temp</th><th>Pressure</th><th>Wind Speed(m/s)</th></tr>
<?php
foreach ($forecasts as $forecast){
    echo "<tr><td>{$forecast['date']}</td><td>{$forecast['weather']}</td><td>{$forecast['temp']}</td><td>{$forecast['min_temp']}</td><td>{$forecast['max_temp']}</td><td>{$forecast['pressure']}</td><td>{$forecast['wind_speed']}</td></tr>";
}?>
</table>
