<?php
	include 'login_setup.php';
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="../css/style-login.css" rel="stylesheet" type="text/css">
	</head>
    <!-- registration -->
    <div id="reg">Nog geen Account?: <a id="reg1" href="registration.php"><u>Klik hier!</u></a></div>
    <!-- end registration -->
	<span class="loginMsg"><?php echo @$msg;?></span>
    <!-- login -->
		<div class="login">
			<h1>Login</h1>
			<form action="" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="E-mail/Gebruikersnaam" autocomplete="off">
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Wachtwoord" autocomplete="off">
				<label for="type-login"><i class="fas fa-bars"></i></label>
  				<select id="typelog" name="type-login">
    			<option value="cus">Als klant</option>
    			<option value="emp">Als medewerker</option>
                
		<div id="login"><input type="submit" name="submitBtnLogin" value="Login"></div>
		<a id="ter" href="../index.php"><div id="terug"> Terug </div></a>
			</form>
      <!-- end login -->
		</div>
	</body>
</html>
