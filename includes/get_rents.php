<?php
	include_once 'db_connect.php';

	if ($stmt = $mysqli->query("SELECT ID FROM user WHERE Username='".$_SESSION['user']."'")) {
		$ID = mysqli_fetch_array($stmt)['ID'];
	}

	if ($stmt = $mysqli->query("SELECT Date, book_ID, ID FROM rented WHERE Users_ID='".$ID."'")) {
		 if(mysqli_num_rows($stmt)==0) {
			echo '<h3>No rented books!</h3>';
		}
		while ($row = mysqli_fetch_assoc($stmt)) {
			if ($stmt2 = $mysqli->query("SELECT Title, Author FROM book WHERE ID='".$row['book_ID']."'")) {
				$row2 = mysqli_fetch_array($stmt2);

				echo '<div class="panel panel-default">';
					echo '<div class="panel-heading">';
						echo '<h2 class="panel-title"><b>'.$row2['Title'].' - By '.$row2['Author'].'</b></h2>';
					echo '</div>';
					echo '<div class="panel-body">';
						echo 'Date for rent: '.$row['Date'].'<br><br>';
						echo '<a class="btn btn-primary" href="includes/deliver_book.php?book_ID='.$row['book_ID'].'&rentID='.$row['ID'].'" role="button">Deliver book</a>';
					echo '</div>';
				echo '</div>';
			}
		}
	}
	else {
		echo '<h3>No rented books!</h3>';
	}
?>