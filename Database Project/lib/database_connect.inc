<?php
    $hostName = "localhost";
    $userName = "web_user";
    $password = "summer_camp123";
    $dbName = "summer_camp";

    require("exceptions.inc");

	$db = new mysqli($hostName, $userName, $password, $dbName);
	if (mysqli_connect_errno()) {
		throw new FileException();
	}
?>