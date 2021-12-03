<?php 
include 'database.php';
// session_start();
// beveiliging zodat onbevoegden niet via de url op dit pagina kan komen
if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != "") {
    
} else { 
  header('location:login/login.php');
}

?>



<?=template_header_loggedin_cus('afspraak_aanmaak');?>
<!-- Begin selectie "Haar" of "Nagels" -->
<div id='titleselect'>Selecteer uw type service
<form action='add_hair.php' method='post'>
<select class='selectdiv' name='headcat'>
<option value='hair'>Haarservice</option>
<option value='nail'>Nagelservice</option>
</select>
<input id='sub1' type='submit' name='submit' value='Volgende'>
</form>
</div>

<?=template_footer();?>
<!-- Eind selectie "Haar" of "Nagels" -->
