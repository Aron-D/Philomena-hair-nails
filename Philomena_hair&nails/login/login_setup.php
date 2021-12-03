<?php 
// session_start();
include("../database.php");
?>
<?php
$msg = ""; 
if(isset($_POST['submitBtnLogin'])) {
  $username = trim($_POST['username']);
  $password = md5(trim($_POST['password']));
  $typeUser = $_POST['type-login'];

  if ($typeUser == 'cus') {
    $tablename = 'customer';
    $where = "`email`=:username and `password`=:password";
    $loc = 'location: ../dashboard_c.php';
  } else {
    $tablename = 'employee';
    $where = "`username`=:username and `password`=:password";
    $loc = 'location: ../dashboard_e.php';
  }

  if($username != "" && $password != "") {
    try {
      $query = "select * from $tablename where $where";
      $stmt = $database->prepare($query);
      $stmt->bindParam('username', $username, PDO::PARAM_STR);
      $stmt->bindValue('password', $password, PDO::PARAM_STR);
      $stmt->execute();
      $count = $stmt->rowCount();
      $row   = $stmt->fetch(PDO::FETCH_ASSOC);
      if($count == 1 && !empty($row)) {
        $_SESSION['sess_user_id']   = $row['id'];
        $_SESSION['sess_role_id']   = $row['role_id'];
        $_SESSION['sess_user_name'] = $row['email'];
        $_SESSION['sess_name'] = $row['fname'];
        header($loc);
       
      } else {
        $msg = "Gebruikersnaam of Wachtwoord klopt niet!";
      }
    } catch (PDOException $e) {
        // $customer = true;
      echo "Error : ".$e->getMessage() ." ". $e->getLine();
    }
  } 
}
?>