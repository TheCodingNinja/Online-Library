<?php
	function hashPassword($pass) {
		$hashed = password_hash($pass, PASSWORD_DEFAULT, array("cost" => 10));
		return $hashed;
	}

	function verifyLogin ($username, $token, $role, $mysqli) {
		if ($stmt = $mysqli->query("SELECT ID, Password, roles_ID FROM user WHERE Username='".$username."'")) {
			$row = mysqli_fetch_array($stmt);
			if ($stmt2 = $mysqli->query("SELECT Token FROM token WHERE user_ID='".$row['ID']."'")) {
				$checkToken = mysqli_fetch_array($stmt2)['Token'];
			}
			else {
				return false;
			}
			if ($token == $checkToken && $role == $row['roles_ID']) {
				return true;
			}
		}
		else {
			return false;
		}
	}
?>