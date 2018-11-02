<?php
require 'includes/inputParse.php';

function cUrl($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	$data = curl_exec($ch);
	curl_close($ch);

	return $data;
}

function retrieveLocation($input){
	$coordinate = textToCoordinate($input);
	$longitude = $coordinate['long'];
	$latitude =  $coordinate['lat'];

	return [
    "long" => $longitude,
    "lat" => $latitude
	];
}
