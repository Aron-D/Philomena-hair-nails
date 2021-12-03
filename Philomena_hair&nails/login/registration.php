<?php
    include '../database.php';
    // session_start();
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="../css/style-login.css" rel="stylesheet" type="text/css">
	</head>
    <!-- register  -->
		<div class="register">
			<h1>Registreren</h1>
			<form action="registration_setup.php" method="post">
				<input type="text" name="fname" placeholder="Voornaam" required>
				<input type="text" name="lname" placeholder="Achternaam" required>
                <input type="email" name="email" placeholder="Email" required>
				<input type="text" name="phone" placeholder="Telefoonnummer" required>
                <input type="password" name="password" placeholder="Wachtwoord" required>
                <input type="text" name="street" placeholder="Straatnaam" required>
                <input type="text" name="pcode" placeholder="Postcode" required>
                <input type="text" name="place" placeholder="Plaats" required>
                <input type="hidden" name="role" value="1" >
                
		<div id="login"><input type="submit" name="submit" value="Aanmaken"></div>
		<a href="login.php"><div id="terug2"> Terug </div></a>
			</form>
      <!-- end login -->
		</div>
	</body>
</html>
