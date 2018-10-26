<?php

//Define constants
define('LOCATION', 'location');
define("CURRENT", "current");
define("FORECAST", "forecast");

//Import files
require 'includes/JSONFunction.php';
require 'includes/retrieval.php';
require 'includes/formatWeather.php';

function generateWeatherHTML(){
	$weatherHTML = "";
	if($_GET) {
		//TODO: Fix detection of negative values and decimals
		$weatherJSON = retrieveJSON($_GET[LOCATION]);
		$weatherInfo = parseJSON($weatherJSON);
		//TODO: Output information in attractive, readable manner
		$weatherHTML = formatData($weatherInfo);
		//print_r($weatherInfo[FORECAST]);
	}

	return $weatherHTML;
}

function formatData($weather) {
	$weatherInfo = $weather[CURRENT];

	if ($weatherInfo['cod'] >= 400) {
		return "Error: Please Make Sure that the Entered Data is Correct";
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
	$temp = 'Temperature: ' . ($weatherInfo['main']['temp'] - 273) . ' &#8451; <br>';
	$pressure = 'Pressure: ' . $weatherInfo['main']['pressure'] / 10 . ' kPa <br>';
	$wind = 'Wind: ' . (int)($weatherInfo['wind']['speed'] / 3.6) . ' km / h <br>';

	$currentWeather = $title . $description . $temp . $pressure . $wind;

	return $currentWeather;
}

//// TODO: Add <div> container to each day
function generateForecast($weatherInfo){
	$title = '<h3>5-Day Forecast</h3>';

	$data = '';
	date_default_timezone_set('UTC');
	$prevDay = '';
	for ($i=0; $i < count($weatherInfo['list']); $i++) {
		$date = date("g a e", $weatherInfo['list'][$i]['dt']); //Unix to Readable
		$low = 'Min Temp: ' . ($weatherInfo['list'][$i]['main']['temp_min'] - 273) . ' &#8451;';
		$high = 'Max Temp: ' . ($weatherInfo['list'][$i]['main']['temp_max'] - 273) . ' &#8451;';
		$weather = 'Weather: ' . $weatherInfo['list'][$i]['weather'][0]['description'];

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
			$low . '<br>' .
			$high . '<br>' .
			$weather . '<br>' .
			'</div>' . '<br>';

		$data = $data . $dateDate;
		$prevDay = date("l", $weatherInfo['list'][$i]['dt']);
	}
	$forecast = '<div class="container">' . $title . $data . '</div>' . '</div>';

	return $forecast;
}
