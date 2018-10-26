<?php

function containsNumber($char) {
	$numbersPresent = $char == '0' || $char == '1' || $char == '2' || $char == '3' || $char == '4' || $char == '5' || $char == '6' || $char == '7' || $char == '8' || $char == '9' || $char == '-' || $char == '.';
	return $numbersPresent;
}

function findNumber($chars, $start) {
	$number = [];
	$end = 0;
	$numberReached = false;

	//Collect user input for longitude
	for ($i=$start; $i < count($chars); $i++) {
		if (containsNumber($chars[$i])) {
			$numberReached = true;
		}
		if ($numberReached) {
			if (containsNumber($chars[$i])) {
				array_push($number, $chars[$i]);
			}else {
				$end = $i;
				$numberReached = false;
				break;
			}
		}
	}

	return [$number, $end];
}

function charsToNumber($chars){
	$nums = [];

	for ($i=0; $i < count($chars); $i++) {
		array_push($nums, (float)$chars[$i]);
	}

	return $nums;

}

function covertToValue($nums){
  $length = count($nums);
  $value = 0;

  for ($i=0; $i < $length; $i++) {
    $value += $nums[$i] * pow(10, $length - $i - 1);  //10^(length-i-1)
  }

  return $value;

}


function inputToCoordinate($chars){
  $latNum = findNumber($chars, 0);
	$latitude = covertToValue(charsToNumber($latNum[0]));
	$longitude =  covertToValue(charsToNumber(findNumber($chars, $latNum[1])[0]));

  return [
    "long" => $longitude,
    "lat" => $latitude
	];;
}
