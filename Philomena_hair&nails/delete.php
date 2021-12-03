<?php
// Connect to MySQL database
include 'database.php';
// session_start();
// beveiliging zodat onbevoegden niet via de url op dit pagina kan komen
if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_role_id'] != "1" && $_GET['hetid'] > 0 && $_SESSION['sess_user_id'] != "") {
    
} else { 
  header('location: appointments.php');
}

if (isset($_GET['hetid'])) {
        // Eerste select stmt
    $stmt = $database->prepare('SELECT ap.id, ap.cid, ap.date, ad.amount, ad.appointment_id, ad.duration, ad.sid FROM appointment ap
    INNER JOIN appointment_details ad
    WHERE ap.id = ad.appointment_id
    AND ap.id = ?');
    $stmt->execute([$_GET['hetid']]);
    $app = $stmt->fetch(PDO::FETCH_ASSOC);
        // Tweede select stmt
    $stmt2 = $database->prepare('SELECT ap.id, ap.cid, ap.date, c.fname, c.lname FROM appointment ap
    INNER JOIN customer c
    WHERE ap.cid = c.id
    AND ap.id = ?');
    $stmt2->execute([$_GET['hetid']]);
    $cus = $stmt2->fetch(PDO::FETCH_ASSOC);

    if (!$app) {
        exit('Dit persoon en/of afspraak bestaat niet!');
    }
    // Activeert wanneer op 'ja' gedrukt wordt op regel 70
    if (isset($_GET['confirm'])) {
        //wanneer klant op 'ja' klikt start de sql DELETE stmt    
        if ($_GET['confirm'] == 'Ja') {
            // User clicked the "Yes" button, delete record
            // SQL to run the delete into the database
            $sql = "DELETE appointment, appointment_details
        FROM appointment
        INNER JOIN appointment_details 
        ON appointment.id = appointment_details.appointment_id 
        WHERE appointment.id = ?";
            
            $stmt = $database->prepare($sql);
            $stmt->execute([$_GET['hetid']]);
            $msg = "Afspraak is verwijderd! <br> <a href='appointments.php'>Terug naar afspraken</a>";
        } else {
            // User clicked the "No" button and it will redirect them back to the appointment page
            header('Location: appointments.php');
            echo "did not work";
            exit;
        }
    }
} else {
    header('Location: appointments.php');
    exit();
}



?>
<?=template_header_loggedin_emp('Delete')?>

<div class="content delete">
	<h2>Verwijder afspraak van <?=$cus['fname'] ."&nbsp;". $cus['lname']?></h2>
    <?php if (isset($msg)): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Weet u zeker dat u afspraak '#<?=$app['id']?>' wilt verwijderen?</p>
    <div class="yesno">
        <a href="delete.php?hetid=<?=$app['id']?>&confirm=Ja">Ja</a>
        <a href="delete.php?hetid=<?=$app['id']?>&confirm=Nee">Nee</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>