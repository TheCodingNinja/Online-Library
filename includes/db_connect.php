<?php
	include_once 'psl-config.php';
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

	if(mysqli_connect_errno()){
		echo "Failed to connect: " . mysqli_connect_error();
	}
?>