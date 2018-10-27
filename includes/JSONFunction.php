<?php

define('API_KEY', 'Get your API key by signing up at https://openweathermap.org/api');

function inputType($input) {
	$type = 0;
	$chars = str_split($input);

	if ($_GET[LOCATION] === "") {
		return 'none';
	//Start with '{'
	}else if ($chars[0] == '{') {
		$type = 'geographic';
	//Value is a city name
	}else {
		$type = 'name';
	}

	return $type;
}

function retrieveJSON($input){
	$type = inputType($input);
	$current = "";
	$forecast = "";

	if ($type === 'geographic') {
		$coordinate = retrieveLocation($_GET[LOCATION]);
		$current = cUrl("http://api.openweathermap.org/data/2.5/weather?lat=" . $coordinate['long'] . "&lon=" . $coordinate['lat'] . "&appid=" . API_KEY);
		$forecast = cUrl("http://api.openweathermap.org/data/2.5/forecast?lat=" . $coordinate['long'] . "&lon=" . $coordinate['lat'] . "&appid=" . API_KEY);
	}else if ($type === 'name') {
		//Retrieve Query OpenWeatherMap for a city name
		$current = cUrl("http://api.openweathermap.org/data/2.5/weather?q=" . $_GET[LOCATION] . "&appid=" . API_KEY);
		$forecast = cUrl("http://api.openweathermap.org/data/2.5/forecast?q=" . $_GET[LOCATION] . "&appid=" . API_KEY);
	}

	return [
    CURRENT => $current,
    FORECAST => $forecast
	];

}

//Return hashtable with JSON values
function parseJSON($JSON) {

	$currentJSON = json_decode($JSON[CURRENT], true);
	$forecastJSON = json_decode($JSON[FORECAST], true);

	return [
    CURRENT => $currentJSON,
    FORECAST => $forecastJSON
	];


}
