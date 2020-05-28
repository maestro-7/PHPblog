<?php

	if(isset($_POST['loginButton'])) {

		$email = $_POST['loginEmail'];
		$password = $_POST['loginPassword'];

		$result = $user->login($email, $password);

		if($result != null) {
			$_SESSION['userLoggedIn'] = $result;
			header("Location: index.php");
		}
	}