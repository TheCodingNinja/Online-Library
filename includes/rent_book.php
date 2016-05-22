<?php
	session_start();

	include_once 'db_connect.php';
	include_once 'functions.php';

	if (isset($_SESSION['token'])) {
		if (!verifyLogin($_SESSION['user'], $_SESSION['token'], $_SESSION['role'], $mysqli))
			header("Location: includes/logout.php");
	}

	if ($stmt = $mysqli->query("SELECT ID FROM user WHERE Username='".$_SESSION['user']."'")) {
		$row = mysqli_fetch_array($stmt);

		$mysqli->query("INSERT INTO rented (Date, Users_ID, book_ID) VALUES (now(), '".$row['ID']."', '".$_REQUEST['book_ID']."')");

		header("Location: ../index.php");
	}
?>