<?php

if (session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }
    
$servername = "localhost";
$username = "root";
$password = "";

try {
  $database = new PDO("mysql:host=$servername;dbname=philomena_h_&_n", $username, $password);
  $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
// HTML Template functions voor de rest van de paginabestanden van de klant en medewerker
function template_header_logout($title) {
  echo <<<EOT
  <!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <title>$title</title>
      <link href="css/style.css" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    </head>
    <body>
      <nav class="navtop">
        <div>
          <h1>Philomena Hair&Nails</h1>
          <a href="index.php"><i class="fas fa-home"></i>Home</a>
          <a href="login/login.php"><i class="fas fa-sign-in-alt"></i>Inloggen</a>
        </div>
      </nav>
  EOT;
  }
  function template_header_loggedin_cus($title) {
    echo <<<EOT
    <!DOCTYPE html>
    <html>
      <head>
        <meta name="viewport" content="width=device-width initial-scale=1.0" charset="utf-8">
        <title>$title</title>
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
      </head>
      <body>
        <nav class="navtop">
          <div>
            <h1>Philomena Hair&Nails</h1>
            <a href="dashboard_c.php"><i class="fas fa-home"></i>Home</a>
            <a href="login/logout.php"><i class="fas fa-sign-in-alt"></i>uitloggen</a>
          </div>
        </nav>
    EOT;
  }
  function template_header_loggedin_emp($title) {
    echo <<<EOT
    <!DOCTYPE html>
    <html>
      <head>
        <meta charset="utf-8">
        <title>$title</title>
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
      </head>
      <body>
        <nav class="navtop">
          <div>
            <h1>Philomena Hair&Nails</h1>
            <a href="dashboard_e.php"><i class="fas fa-home"></i>Home</a>
            <a href="login/logout.php"><i class="fas fa-sign-in-alt"></i>uitloggen</a>
          </div>
        </nav>
    EOT;
  }
  function template_header_loggedin_cus_calendar($title) {
    echo <<<EOT
    <!DOCTYPE html>
    <html>
      <head>
        <meta name="viewport" content="width=device-width initial-scale=1.0" charset="utf-8">
        <title>$title</title>
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <link href="css/stylecal.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      </head>
      <body>
      <nav class="navtop">
      <div>
        <h1>Philomena Hair&Nails</h1>
        <a href="dashboard_c.php"><i class="fas fa-home"></i>Home</a>
        <a href="login/logout.php"><i class="fas fa-sign-in-alt"></i>uitloggen</a>
      </div>
    </nav>
    EOT;
  }
  function template_footer() {
  echo <<<EOT
      </body>
  </html>
  EOT;
  }
  ?>
