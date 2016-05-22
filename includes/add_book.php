<?php
	include_once 'db_connect.php';

	if ($_REQUEST['title'] != "") {
		if ($_REQUEST['description'] != "") {
			if ($_REQUEST['author'] != "") {
				if ($_REQUEST['pages'] != "") {
					if ($_REQUEST['subjects'] != "") {
						if ($_REQUEST['copies'] != "") {
							if ($mysqli->query("INSERT INTO book (Title, Description, Author, Pages) VALUES ('".$_REQUEST['title']."', '".$_REQUEST['description']."', '".$_REQUEST['author']."', '".$_REQUEST['pages']."')")) {
								$bookID = mysqli_insert_id($mysqli);

								if ($mysqli->query("INSERT INTO count (Copies, book_ID) VALUES ('".$_REQUEST['copies']."', '".$bookID."')")) {
									$subjects = explode(",", $_REQUEST['subjects']);
									for ($i = 0; $i < count($subjects); $i++) {
										if ($stmt = $mysqli->query("SELECT Name FROM subject")) {
											$used = false;
											while($row = mysqli_fetch_array($stmt)) {
												if (strtolower($row['Name']) == strtolower($subjects[$i])) {
													$used = true;
												}
											}

											if (!$used) {
												$mysqli->query("INSERT INTO subject (Name) VALUES ('".ucfirst(strtolower($subjects[$i]))."')");
												$ID = mysqli_insert_id($mysqli);
											}
											else {
												$stmt2 = $mysqli->query("SELECT ID FROM subject WHERE Name='".ucfirst(strtolower($subjects[$i]))."'");
												$ID = mysqli_fetch_assoc($stmt2)['ID'];
											}

											$mysqli->query("INSERT INTO booksubject (subject_ID, book_ID) VALUES ('".$ID."', '".$bookID."')");


										}
									}
									$message = '<div class="alert alert-success" role="alert">Book added to library!</div>';

								}
							}
						}
						else {
							$message = '<div class="alert alert-warning" role="alert">Please enter an amount of copies!</div>';
						}
					}
					else {
						$message = '<div class="alert alert-warning" role="alert">Please enter at least one subject!</div>';
					}
				}
				else {
					$message = '<div class="alert alert-warning" role="alert">Please enter an amount of pages!</div>';
				}
			}
			else {
				$message = '<div class="alert alert-warning" role="alert">Please enter an author!</div>';
			}
		}
		else {
			$message = '<div class="alert alert-warning" role="alert">Please enter a description!</div>';
		}
	}
	else {
		$message = '<div class="alert alert-warning" role="alert">Please enter a title!</div>';
	}
?>