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

		$mysqli->query("DELETE FROM rented WHERE Users_ID='".$row['ID']."' AND book_ID='".$_REQUEST['book_ID']."' AND ID='".$_REQUEST['rentID']."'");

		header("Location: ../my_account.php");
	}
?>