<?php

function containsNumber($char) {
	$numbersPresent = $char == '0' || $char == '1' || $char == '2' || $char == '3' || $char == '4' || $char == '5' || $char == '6' || $char == '7' || $char == '8' || $char == '9' || $char == '-' || $char == '.';
	return $numbersPresent;
}

function textToCoordinate($input){
	//Declare coordinate pair
	$longitude = [];
	$latitude = [];

	//Cast input from string -> char[]
	$input = str_split($input);

	//Add numerical chars for longitude
	$end = 1;
	foreach ($input as $char) {
		if ($char == ','){
			break;
		}
		if (!containsNumber($char)) {
			continue;
		}

		array_push($longitude, $char);
		$end++;
	}

	//Add numerical chars for latitude
	while ($end< count($input)) {
		$end++;
		if ($input[$end] == '}'){
			break;
		}
		if (!containsNumber($input[$end])) {
			continue;
		}

		array_push($latitude, $input[$end]);
	}

	//Cast char[] -> string
	$longitude = implode($longitude);
	$latitude = implode($latitude);
	//Cast string -> float
	$longitude = floatval($longitude);
	$latitude = floatval($latitude);

    //Return dictionary of coordinates
	return [
    "long" => $latitude,
    "lat" => $longitude
	];

}
