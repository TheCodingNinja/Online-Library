<?php
	include_once 'db_connect.php';

	if($stmt = $mysqli->query("SELECT * FROM book")) {
		while($row = mysqli_fetch_assoc($stmt))
		{
			echo '<div class="panel panel-default">';
			echo '<div class="panel-heading">';
				echo '<h2 class="panel-title"><b>'.$row['Title'].' - By '.$row['Author'].'</b></h2>';
			echo '</div>';
			echo '<div class="panel-body">';
				echo $row['Description'].'<br><br>';
				if($stmt2 = $mysqli->query("SELECT * FROM rented WHERE book_ID='".$row['ID']."'")) {
					$rows = mysqli_num_rows($stmt2);

					if($stmt3 = $mysqli->query("SELECT Copies FROM count WHERE book_ID='".$row['ID']."'")) {
						while($row3 = mysqli_fetch_assoc($stmt3))
						{
							echo 'Pages: '.$row['Pages'].'<br>';
							echo 'Copies: '.$row3['Copies'].'<br><br>';

							if ($stmt4 = $mysqli->query("SELECT Name FROM subject JOIN booksubject ON subject.ID = booksubject.subject_ID JOIN book ON book.ID = booksubject.book_ID WHERE book.ID = ".$row['ID'])) {
								while($row4 = mysqli_fetch_assoc($stmt4)) {
									echo $row4['Name'].' | ';
								}
							}
							echo '<br>';

							if ($rows >= $row3['Copies']) {
								echo '<div class="alert alert-warning" role="alert">All copies are rented!</div>';
							}
							else {
								echo '<a class="btn btn-primary pull-right" href="" role="button">Rent</a>';
							}
						}
					}
				}
			echo '</div>';
			echo '</div>';
		}
	}
?>