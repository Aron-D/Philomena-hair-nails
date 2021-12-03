<?php 
include 'database.php';
// session_start();
// beveiliging zodat onbevoegden niet via de url op dit pagina kan komen
if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_role_id'] != "1" && $_SESSION['sess_user_id'] != "") {
  template_header_loggedin_emp('dashboard_employee');
  echo '<h3 style="font-size: 25px;position: absolute;top: 14%;left: 1%;">Welkom!, '.$_SESSION['sess_name'].'</h3>';

} else { 
  header('location:login/login.php');
}
?>

<div id="content">
Dashboard
</div>
<div id="area1"><a href="appointments.php">Afspraak overzicht</a></div>

<?=template_footer();?>