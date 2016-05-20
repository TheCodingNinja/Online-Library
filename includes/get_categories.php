<?php
	include_once 'db_connect.php';
	
	if($stmt = $mysqli->query("SELECT Name FROM category ORDER BY Name")) {
		while($row = mysqli_fetch_assoc($stmt))
		{
			echo '<option>'. $row['Name'] . '</option>';
		}
	}
?>