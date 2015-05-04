<?php

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["username"] == "" && $_POST["password"] == ""){
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$file = 'login.php';
	header("Location: http://$host$uri/$file");
	exit;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<title>Regisztráció</title>

</head>

<body>

<?php

$username = $password = $password_re = $year = $sex = $hobby_programming = $hobby_cooking = $hobby_running = $hobby_reading = $internet_hours = $introduction = "";
$usernameError = $passwordError = $password_reError = $sexError = $internet_hoursError = $introductionError = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(strlen($_POST["username"]) < 1 || strlen($_POST["username"]) > 32){
		$usernameError = "Felhasználó név min. 3, max. 32 karakter";
	}
	else{
		$username = $_POST["username"];
	}
	
	if(strlen($_POST["password"]) < 1 || strlen($_POST["password"]) > 32){
		$passwordError = "Jelszó név min. 5, max. 32 karakter";
	}
	else{
		$password = $_POST["password"];
	}
	
	if($_POST["password"] != $_POST["password-re"]){
		$password_reError = "Nem azonos jelszók";
	}
}

?>

<?php if($_SERVER["REQUEST_METHOD"] == "GET" || $usernameError || $passwordError || $password_reError){ ?>

<form method="post" action="register.php">
	<span class="error"><?php echo $usernameError; ?></span><br />
	<label for="username">Felhasználói név:</label><input id="username" name="username" type="text" /><br />
	<span class="error"><?php echo $passwordError; ?></span><br />
	<label for="password">Jelszó:</label><input id="password" name="password" type="password" /><br />
	<span class="error"><?php echo $password_reError; ?></span><br />
	<label for="password-re">Jelszó újra:</label><input id="password-re" name="password-re" type="password" /><br />
	<label for="year">Születési év</label>
	<select id="year">
	  <?php
		for($i = 1900; $i <= 2003; $i++){
			echo "<option value=" . $i . ">" . $i . "</option>";
		}
	  ?>
	</select><br />
	<span>Nem:</span><br />
	<input id="sex-male" type="radio" name="sex" value="male" /><label for="sex-male">férfi</label><br />
	<input id="sex-female" type="radio" name="sex" value="female" /><label for="sex-female">nő</label><br />
	<span>Hobbi:</span><br />
	<input id="hobby-programming" type="checkbox" name="hobby-programming" /><label for="hobby-programming">programozás</label><br />
	<input id="hobby-cooking" type="checkbox" name="hobby-cooking" /><label for="hobby-cooking">főzés</label><br />
	<input id="hobby-running" type="checkbox" name="hobby-running" /><label for="hobby-running">futás</label><br />
	<input id="hobby-reading" type="checkbox" name="hobby-reading" /><label for="hobby-reading">olvasás</label><br />
	<label for="internet-hours">Napi ennyi órát internetezek:</label><input type="text" id="internet-hours" /><br />
	<label for="introduction">Bemutatkozás:</label><textarea id="introduction"></textarea><br />
	<input type="submit" name="submit" value="Submit"> 
</form>

<?php } else { 
	$conn = mysqli_connect("localhost", "root", "");
	mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS bactact");
	mysqli_select_db($conn, "bactact");
	$val = mysqli_query($conn, "show tables like 'users'");

	if($val !== FALSE)
	{
		mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `users` (
		  `username` varchar(32) NOT NULL,
		  `password` varchar(32) NOT NULL,
		  `year` int(11) NOT NULL,
		  `sex` tinyint(1) NOT NULL,
		  `hobby_programming` tinyint(1) NOT NULL,
		  `hobby_cooking` tinyint(1) NOT NULL,
		  `hobby_reading` tinyint(1) NOT NULL,
		  `hobby_running` tinyint(1) NOT NULL,
		  `internet_hours` int(11) NOT NULL,
		  `introduction` varchar(256) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	}
	
	$existing_user = mysqli_query($conn, "select * from users where username = '" . $username . "'");
	
	if(mysqli_num_rows($existing_user) > 0){
		die("Már létezik felhasználó ilyen névvel!");
	}
	else{
		mysqli_query($conn, "INSERT INTO `bactact`.`users`
			(`username`, `password`, `year`, `sex`, `hobby_programming`, `hobby_cooking`, `hobby_reading`, `hobby_running`, `internet_hours`, `introduction`)
			VALUES ('" . $username . "', '" . $password . "', '" . $year . "', '1', '1', '0', '0', '0', '10', 'majom');");
		}
	
		echo "Sikeres regisztráció!";
	}
?>

</body>
</html>