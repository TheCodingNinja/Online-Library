<?php
	include_once 'db_connect.php';

	if ($stmt = $mysqli->query("SELECT Title FROM book")) {
		while ($row = mysqli_fetch_array($stmt)) {
			echo '<option value="'.$row['Title'].'">'.$row['Title'].'</option>';
		}
	}
?>