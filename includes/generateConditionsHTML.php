<?php

function formatData($weather) {
	$weatherInfo = $weather[CURRENT];

	if ($weatherInfo['cod'] >= 400) {
		return "<p class='error'><br>Error: Please Make Sure that the Entered Data is Correct</p>";
	}
	if (!$weatherInfo['sys']) {
		return "";
	}
	$location = '';
	if (array_key_exists('country', $weatherInfo['sys'])) {
		$location = '<h2>' . $weatherInfo['name'] . ', ' . $weatherInfo['sys']['country'] . '</h2>';
	}else {
		$location = '<h2>' . 'Longitude: ' . $weatherInfo['coord']['lon'] . '&nbsp;&nbsp;&nbsp;&nbsp;' . 'Latitude: ' . $weatherInfo['coord']['lat'] . '</h2<br>';
	}

	$currentWeather = generateCurrentWeather($weather[CURRENT]);
	$forecast = generateForecast($weather[FORECAST]);

	return $location . $currentWeather . $forecast;
}

function generateCurrentWeather($weatherInfo){
	$title = '<h3>Current Weather</h3>';
	$description = ucfirst($weatherInfo['weather'][0]['description']) . '<br>';
	$temp = 'Temperature: ' . round(($weatherInfo['main']['temp'] - 273),1) . ' &#8451; <br>';
	$pressure = 'Pressure: ' . round($weatherInfo['main']['pressure'] / 10, 1) . ' kPa <br>';
	$wind = 'Wind: ' . (int)($weatherInfo['wind']['speed'] * 3.6) . ' km / h <br>';

	$currentWeather = $title . $description . $temp . $pressure . $wind;

	return $currentWeather;
}

function generateForecast($weatherInfo){
	$title = '<h3>5-Day Forecast</h3>';

	$data = '';
	date_default_timezone_set('UTC');
	$prevDay = '';
	for ($i=0; $i < count($weatherInfo['list']); $i++) {
		$date = date("g a e", $weatherInfo['list'][$i]['dt']); //Unix to Readable
		$temp = 'Temperature: <br>' . round(($weatherInfo['list'][$i]['main']['temp_max'] - 273), 1) . ' &#8451;';
		$weather = 'Weather: <br>' . $weatherInfo['list'][$i]['weather'][0]['description'];
		$iconPath = 'http://openweathermap.org/img/w/' . $weatherInfo['list'][$i]['weather'][0]['icon'] . '.png';
		$icon = '<img src="' . $iconPath . '" alt="Weather Icon">';

		$dateDate = '<div class="forecast">';

		if ($prevDay !== date("l", $weatherInfo['list'][$i]['dt'])) {
			$day = '<h4>' . date("l", $weatherInfo['list'][$i]['dt']) . '</h4>' . '<br>';
			if ($i === 0) {
				$dateDate = '<div class="day">' . $day . $dateDate;
			}else {
				$dateDate = '</div>' . '<div class="day">' . $day .  $dateDate;
			}
		}

		$dateDate = $dateDate .
			$date . '<br>' .
			$temp . '<br>' .
			$weather . '<br>' .
			$icon . '<br>' .
			'</div>' . '<br>';

		$data = $data . $dateDate;
		$prevDay = date("l", $weatherInfo['list'][$i]['dt']);
	}
	$forecast = '<div class="container">' . $title . $data . '</div>' . '</div>';

	return $forecast;
}
