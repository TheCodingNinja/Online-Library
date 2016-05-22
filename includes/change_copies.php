<?php
	if ($_REQUEST['copies'] != "") {
		if ($stmt = $mysqli->query("SELECT * FROM book WHERE Title='".$_REQUEST['book']."'")) {
			$book = mysqli_fetch_array($stmt);

			if ($stmt2 = $mysqli->query("SELECT * FROM rented WHERE book_ID='".$book['ID']."'")) {
				$renteds = mysqli_num_rows($stmt2);

				if ($renteds <= $_REQUEST['copies']) {
					if ($mysqli->query("UPDATE count SET Copies='".$_REQUEST['copies']."' WHERE book_ID='".$book['ID']."'")) {
						$message = '<div class="alert alert-success" role="alert">Amount of copies changed!</div>';
					}
				}
				else {
					$message = '<div class="alert alert-warning" role="alert">Cannot change value to less, than what rented at the moment!</div>';
				}
			}
		}
	}
	else {
		$message = '<div class="alert alert-warning" role="alert">Please enter an amount to chenge to!</div>';
	}
?>