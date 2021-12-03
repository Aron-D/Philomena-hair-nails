<?php
include 'database.php';
// session_start();

if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_role_id'] != "1" && $_GET['hetid'] > 0 && $_SESSION['sess_user_id'] != "") {
    
} else { 
  header('location:login/login.php');
}

$zid = $_GET['hetid'];

template_header_loggedin_emp('dashboard_customer');

$stmtord = $database->prepare("SELECT * FROM appointment WHERE id = ?");
$stmtord->execute([$zid]);
$row = $stmtord->fetch(PDO::FETCH_OBJ);

$ordid = $row->id;
$custid = $row->cid;

$stmtcust = $database->prepare("SELECT * 
        FROM customer
        WHERE id = $custid");
$stmtcust->execute();
$klantachternaam = $stmtcust->fetch();
$klantachternaam = $stmtcust->fetch()['lname'];

$stmtdet = $database->prepare("SELECT categories, amount, duration, products, price 
        FROM appointment_details ad 
        INNER JOIN services se ON se.id = ad.sid 
        WHERE appointment_id = $ordid");

$stmtdet->execute();
$amountprice = 0;
$totalprice = 0;
$s = "<table border='5'>";
$s .= "<tr style='font-weight:bold;'><td>Categorie</td><td>Producten</td><td>Aantal</td><td>Prijs enkel</td><td>Prijs</td></tr>";
while ($row = $stmtdet->fetch(PDO::FETCH_OBJ)) {
    $amountprice = $row->amount * $row->price;
    $totalprice += $row->price;
    
    $s .= "<tr><td>". $row->categories."</td>"
    . "<td>". $row->products."</td>"
    . "<td>". $row->amount."</td>"
    . "<td>&euro; ". $row->price."</td>"
    . "<td>&euro; ". number_format($amountprice, 2, ',', '.')."</td>";

}

$s .= "</table>";
echo "<div id='orderbox'>";
echo "<a href='appointments.php'>Terug</a>";
echo $s;
echo "<h1>Totale bedrag: &euro; ".number_format($totalprice, 2, ',', '.')."</h1>";
template_footer();
$database = null;