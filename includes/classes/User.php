<?php

class User extends DB_Connection {
	
	private $conn;
	private $loginErrorArray;
	private $registerErrorArray;
	public function __construct() {
		$this->conn = $this->connect();
		$this->loginErrorArray = array();
		$this->registerErrorArray = array();
	}

	public function login($email, $password) {

		$password = md5($password);
		$sql = "SELECT id,name, surname, email FROM users where email = ? and password = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute([$email, $password]);
		$user = $stmt->fetch();

		if($user == null) {
			array_push($this->loginErrorArray, "Email or Password is invalid");
		}

		return $user;
	}
	public function insertUserDetails($name,$surname,$email,$password)
	{
		$password = md5($password);
		$sql = "insert into users(name,surname,email,password) values (?,?,?,?)";
		$stmt =  $this->conn->prepare($sql);

		try{

			$stmt->execute([$name,$surname,$email,$password]);

			$last_id = $this->conn->lastInsertId();

			$user = new stdClass();
			$user->id = $last_id;
			$user->name = $name;
			$user->surname = $surname;
			$user->email = $email;
			return $user;
		}
		catch(Exception $e)
		{
			return null;
		}
	}
	public function validateFirstName($name)
	{
		if(strlen($name)<4 || strlen($name)>25)
		{
			array_push($this->registerErrorArray," Your first name length must be in between 4 to 25");
			return;
		}
	}
	public function validateLastName($surname)
	{
		if(strlen($surname)<4 || strlen($surname)>25)
		{
			array_push($this->registerErrorArray," Your Last name length must be in between 4 to 25");
			return;
		}
	}

	public function validateEmail($email)
	{
		if(filter_var($email, FILTER_VALIDATE_EMAIL)==false)
		{
			array_push($this->registerErrorArray," This email is not valid");
			return;
		}

		$sql  = "SELECT email FROM users WHERE email = ?";
		$stmt  =$this->conn->prepare($sql);
		$stmt->execute([$email]);
		$result = $stmt->fetch();

		if($result!= null)
		{
			array_push($this->registerErrorArray," This email is already taken");
		}
	}
	public function validatePassword($password)
	{
		if(strlen($password)<5 || strlen($password)>30)
		{
			array_push($this->registerErrorArray," Your Password length must be in between 5 to 30");
			return;
		}
	}

	public function register($name,$surname,$email,$password)
	{
		$this->validateFirstName($name);

		$this->validateLastName($surname);

		$this->validateEmail($email);

		$this->validatePassword($password);

		if(empty($this->registerErrorArray) == true)
		{
			return $this->insertUserDetails($name,$surname,$email,$password);
		}
		else{
			return null;
		}
	}
	public function getLoginErrors() {

		//Check if the loginErrorArray has any item in it
		if(!empty($this->loginErrorArray)) {
			$error = $this->loginErrorArray[0];
			return "<div class='alert alert-danger' role='alert'>$error</div>";
		}
	}

	public function getRegisterErrors()
	{
		return $this->registerErrorArray;
	}

	public function getName($user_id)
	{
		$sql ="SELECT name from users where id =?";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute([$user_id]);
		$user = $stmt->fetch();

		if($user ==null){
			return null;
		}

		return $user->name;
	}
}
?>