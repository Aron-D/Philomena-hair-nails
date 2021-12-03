<?php
// Connect to MySQL database
include 'database.php';
// session_start();
// beveiliging zodat onbevoegden niet via de url op dit pagina kan komen
if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_role_id'] != "1" && $_SESSION['sess_user_id'] != "") {
    
} else { 
  header('location:login/login.php');
}

    $sql = "SELECT a.id, a.date, a.payment, a.cid, c.fname, c.lname, c.email, c.phone FROM appointment as a, customer as c
    WHERE a.cid = c.id";

$GetAppointments = $database->prepare($sql);
$GetAppointments->execute();
// Fetch the records so we can display them in our template.
$appointements = $GetAppointments->fetchAll(PDO::FETCH_ASSOC);



?>

<?=template_header_loggedin_emp('Afspraak overzicht')?>
        <!--  Begin HTML Content  -->
    <div class="content read">
	<h2>Afspraken van vandaag, <?=date("d F Y")?></h2>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Klantinformatie</td>
                <td>Datum/Tijdstip</td>
                <td>Betalingsmethode</td>
                <td style="position:relative; left:5%;">Acties</td>
            </tr>
        </thead>
        <tbody>
        <!--  Foreach zodat er meerdere malen een regel wordt gemaakt   -->
            <?php foreach ($appointements as $app): ?>
            <tr>
                <td><?=$app['id']?></td>
                <td><?=$app['fname']?>&nbsp;<?=$app['lname']?>,<br>
                <?=$app['email']?>,<br>
                <?=$app['phone']?></td>
                <td><?=$app['date']?></td>
                <td><?=$app['payment']?></td>
                <td class="actions">
                    <a href="appointment_view.php?hetid=<?=$app['id']?>" class="view"><i class="fas fa-eye"></i></a> &nbsp;
                    <a href="delete.php?hetid=<?=$app['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
        <!--  Eind HTML Content  -->
<?=template_footer()?>