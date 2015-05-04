<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<title>Bejelentkezés</title>

</head>

<body>

<?php

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["username"] && $_POST["password"]){
	echo "1";
}
else{
	echo "2";
}

?>

<form action="register.php" method="post">
Felhasználónév: <input type="text" name="username"><br>
Jelszó: <input type="text" name="password"><br>
<input type="submit" value="Bejelentkezés/regisztráció" >
</form>
</body>
</html>