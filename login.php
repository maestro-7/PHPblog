<?php
	
	session_start(); //hold session, get anything from session

	include("includes/connection.php");
	include("includes/classes/User.php");

	if(isset($_SESSION['userLoggedIn']))
	{
		header("Location: index.php");
	}

	$user = new User();

	include("includes/login-handler.php");
	$result = null;
	if(isset($_POST['registerButton']))
	{
		$name = $_POST["inputFirstName"];
		$surname = $_POST["inputLastName"];
		$email = $_POST["registerEmail"];
		$password = $_POST["registerPassword"];

		$result = $user->register($name,$surname,$email,$password);
		if($result != null)
		{
			$_SESSION['userLoggedIn'] = $result;
			header("Location: index.php");
		}
	}
	

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<title>Login</title>

	<!-- Bootstrap core CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">


	<style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
		}

		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}

		input {
			border: 2px solid #000	;
		}
	</style>
	<!-- Custom styles for this template -->
	<link href="assets/css/signin.css" rel="stylesheet">
	<script src="assets/js/jquery-3.3.1.min.js"></script>
</head>
<?php
	if(isset($_POST['registerButton']))
	{
		echo "<script>
			$(document).ready(function(){
				$('#registerForm').show();
				$('#loginForm').hide();
			});
			</script>";
	}
	else if(isset($_POST['loginButton']))
	{
		echo "<script>
		$( document ).ready(function() {
			$('#registerForm').hide();
			$('#loginForm').ahow();		});
			</script>";
	}
?>

<body class="text-center" style="background-color: white">

	<form id="loginForm" class="form-signin" action="login.php" method="POST">
		
		<?php
			echo $user->getLoginErrors();
		?>

		
		<label for="inputEmail" class="sr-only">Email address</label>
		<input name="loginEmail" type="email" class="form-control" placeholder="Email address" required>
		<label for="inputPassword" class="sr-only">Password</label>
		<input name="loginPassword" type="password" class="form-control" placeholder="Password" required>
		<button class="btn btn-lg btn-primary btn-block" type="submit" name="loginButton">Log In</button>
		<div class="hasAccountText">
			<span id="hideLogin" onclick="hide('login')">Don't have an account yet? Signup here.</span>
		</div>
	</form>

	<form id="registerForm" style="display: none" class="form-signin" action="login.php" method="POST">

	<?php
		foreach($user->getRegisterErrors() as $error)
		{
			echo "<div class='alert alert-danger' role='alert'>$error </div>";
		}
	?>
		<label for="inputFirstName" class="sr-only">First Name</label>
		<input name="inputFirstName" type="text" class="form-control" placeholder="First Name" required>
		<label for="inputLastName" class="sr-only">Last Name</label>
		<input name="inputLastName" type="text" class="form-control" placeholder="Last Name" required>
		<label for="inputEmail" class="sr-only">Email address</label>
		<input name="registerEmail" type="email" class="form-control" placeholder="Email address" required>
		<label for="inputPassword" class="sr-only">Password</label>
		<input name="registerPassword" type="password" class="form-control" placeholder="Password" required>
		<button class="btn btn-lg btn-primary btn-block" type="submit" name="registerButton">Register</button>
		<div class="hasAccountText">
			<span id="hideRegister" onclick="hide('register')">Already have an account? Log in here.</span>
		</div>
	</form>
</body>
<script type="text/javascript">
	
	function hide(hide) {
		console.log(hide);

		if(hide === 'login') {
			$("#registerForm").show();
			$("#loginForm").hide();
		} else {
			$("#loginForm").show();
			$("#registerForm").hide();			
		}
	}
</script>
</html>
