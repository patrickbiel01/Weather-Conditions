<?php
	require 'includes/weatherFunctions.php';
 ?>

<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Weather</title>
		<link rel="shortcut icon" type="image/x-icon" href="images/sun.png">
		<link rel="stylesheet" href="css/styles.css">
	</head>

  <body>
		<h1>Weather Forecast</h1>
    <form class="search-form" action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
      <p>
				<label for="location"></label>
        <input type="text" name="location" placeholder="Enter City Name or georpahic coordinates" <?php if ($_GET) { echo 'value="' . $_GET['location'] . '"'; } ?>>
      </p>
    </form>
    <i>Note: Enter City Names: City, Country and coordinates: {longitude, latitude}</i>

    <?= generateWeatherHTML(); ?>

		<div id="credit">
		    Copyright 2018 by Patrick Biel <br>
		    Icons made by <a href="https://www.flaticon.com/authors/good-ware" title="Good Ware">Good Ware</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a>
		<br>
		Background photo by
		<a href="https://www.pexels.com/photo/photo-of-blue-sky-912110/">Elia Clerici</a>
		</div>

  </body>
