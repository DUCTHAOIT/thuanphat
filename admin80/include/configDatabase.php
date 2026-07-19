<?php
	// Tu nhan dien local (XAMPP) hay hosting that, giong cach lam o configSystem.php
	$serverName = strtolower($_SERVER['SERVER_NAME']);

	if ($serverName == 'localhost' || $serverName == 'thuanphatitc.local') {
		$DATABASE_HOST = "localhost";
		$DATABASE_NAME = "thuanphat";
		$DATABASE_USER = "root";
		$DATABASE_PASSWORD = "";
	} else {
		// Hosting moi (DirectAdmin)
		$DATABASE_HOST = "localhost";
		$DATABASE_NAME = "thuanpha6a5b_thuanphat";
		$DATABASE_USER = "thuanpha6a5b_thuanphat";
		$DATABASE_PASSWORD = "ZTAgAswE4vE9tDdc2upd";
	}
    $mysqli = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASSWORD, $DATABASE_NAME);
    if ($mysqli->connect_errno) {
        echo "Failed to connect MySQL: " . $mysqli->connect_error;
        exit();
    }
?>