<?php
session_destroy();
// $_SESSION['sess_user_id'] = "";
// $_SESSION['sess_role_id'] = "";
// $_SESSION['sess_username'] = "";
// $_SESSION['sess_name'] = "";
if(empty($_SESSION['sess_user_id'])) header("location: ../index.php");
?>