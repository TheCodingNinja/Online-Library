<?php
	$book = $_REQUEST['book'];

	if ($stmt = $mysqli->query("SELECT ID FROM book WHERE Title='".$book."'")) {
		$row = mysqli_fetch_assoc($stmt);

		$mysqli->query("DELETE FROM rented WHERE book_ID='".$row['ID']."'");
		$mysqli->query("DELETE FROM count WHERE book_ID='".$row['ID']."'");
		$mysqli->query("DELETE FROM booksubject WHERE book_ID='".$row['ID']."'");
		$mysqli->query("DELETE FROM book WHERE ID='".$row['ID']."'");
	}
?>