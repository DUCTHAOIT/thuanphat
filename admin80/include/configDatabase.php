<?php
	$DATABASE_HOST = "localhost";
	$DATABASE_NAME = "thuanphat";
	$DATABASE_USER = "root";
	$DATABASE_PASSWORD = "";
    $mysqli = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASSWORD, $DATABASE_NAME);
    if ($mysqli->connect_errno) {
        echo "Failed to connect MySQL: " . $mysqli->connect_error;
        exit();
    }
?>