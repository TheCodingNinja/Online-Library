<?php
	session_start();
	include_once 'db_connect.php';
	if ($stmt = $mysqli->query("SELECT ID FROM user WHERE Username='".$_SESSION['user']."'")) {
		while($row = mysqli_fetch_array($stmt)) {
			$mysqli->query("DELETE FROM token WHERE user_ID='".$row['ID']."'");
		}
	}

	session_unset('token');
	session_unset('user');
	session_unset('role');
	session_destroy();
	header("Location: ../index.php");
?>