<?php

//Define constants
define('LOCATION', 'location');
define("CURRENT", "current");
define("FORECAST", "forecast");

//Import files
require 'includes/JSONFunction.php';
require 'includes/retrieval.php';
require 'includes/generateConditionsHTML.php';

function generateWeatherHTML(){
	$weatherHTML = "";
	if($_GET) {
		$weatherJSON = retrieveJSON($_GET[LOCATION]);
		$weatherInfo = parseJSON($weatherJSON);
		$weatherHTML = formatData($weatherInfo);
	}

	return $weatherHTML;
}
