<?php
include 'database.php';

// session_start();

error_reporting(E_ALL & ~E_NOTICE);

function f($value) {

    return number_format($value, 2, ',', '.');
    
}
// beveiliging zodat onbevoegden niet via de url op dit pagina kan komen
if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != "") {
    
} else { 
  header('location:login/login.php');
}

if(isset($_POST['submit']) && ($_POST['headcat'] == 'nail')) {
    header('location:add_nail.php');
  } else {

    $customerId = $_SESSION['sess_user_id'];
    function catcher() {
        $servername = "localhost";
        $username = "root";
        $password = "";

        try {
        $database = new PDO("mysql:host=$servername;dbname=philomena_h_&_n", $username, $password);
                $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        }
        $customerId = $_SESSION['sess_user_id'];
        if(isset($_POST)) {
        
            
                $nieuweSet = $_POST["servicesnieuwesetD"];
                $nabehandeling = $_POST["servicesnabehandelingD"];
                $handen = $_POST["serviceshandenD"];
                $voeten =$_POST["servicesvoetenD"];

            // een if statement van de submit input zetten zodat de insert into van appointment niet dubbel in de database komt
            if(isset($_POST['submit2'])) {
            $sql = "INSERT INTO appointment(cid, payment) VALUES($customerId, 'Achteraf betaling')";
            $stmtapp = $database->prepare($sql);
            $stmtapp->execute();
            // last insert id oppakken in variable zodat de appointment id in een session gelegd kan worden.
            $lini = $database->lastInsertId();
            $_SESSION['appointment_id'] = $lini;
            // Vier keer if statements uitvoeren met insert wegens bug op multidimensionele arrays
            if($nieuweSet !== "none") {

            $sql = "INSERT INTO appointment_details(appointment_id, sid, amount, duration) 
            VALUES ($lini, {$nieuweSet}, 1, 1)";
            $stmt = $database->prepare($sql);
            $stmt->execute();
            header('location:calendar.php');
            }
            if($nabehandeling !== "none") {

                $sql = "INSERT INTO appointment_details(appointment_id, sid, amount, duration) 
                VALUES ($lini, {$nabehandeling}, 1, 1)";
                $stmt = $database->prepare($sql);
                $stmt->execute();
                header('location:calendar.php');
                }
                if($handen !== "none") {

                    $sql = "INSERT INTO appointment_details(appointment_id, sid, amount, duration) 
                    VALUES ($lini, {$handen}, 1, 1)";
                    $stmt = $database->prepare($sql);
                    $stmt->execute();
                    header('location:calendar.php');
                    }
                    if($voeten !== "none") {

                        $sql = "INSERT INTO appointment_details(appointment_id, sid, amount, duration) 
                        VALUES ($lini, {$voeten}, 1, 1)";
                        $stmt = $database->prepare($sql);
                        $stmt->execute();
                        header('location:calendar.php');
                        }
            }
        }
    }
    
    function createSelect($db,$sid,$cat,$title,$css) { // Selecteren van alle services uit de database met een select functie
    
        // maak een div met daarin de checkboxen voor deze services
        $s = "<h1 class='titlediv'>$title</h1>";
        $s .= "<select name='services$sid'>\n";
        $s .= "\t<option value='none' selected>(Selecteer hier uw dienst)</option>\n";
    
        $sql = $db->prepare("SELECT * FROM services WHERE categories = '$cat' ORDER BY categories, price DESC");
        $sql->execute();
    
        while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
            $s .= "\t<option value='$row->id'>$row->id | $row->products ($row->categories) &euro; ".f($row->price)."</option>\n";
        }
        $s .= "</select>\n";
    
        return $s;
    }
    // Begin afspraak aanmaak nagel diensten inhoud

template_header_loggedin_cus('afspraak_aanmaak_nagels');
echo "<div id='selectboxes'>";
echo "<h1 id='titleapp'>Nageldiensten</h1>";
echo "<a href='make_appointment.php'>Terug</a>";
echo "<form action='' method='post'>";
echo createSelect($database, 'nieuwesetD', 'nieuwe set','nieuwe sets','1');

echo createSelect($database, 'nabehandelingD', 'nabehandeling', 'nabehandelingen','2');
    
echo createSelect($database, 'handenD', 'handen', 'Handen service','3');
    
echo createSelect($database, 'voetenD', 'voeten', 'Voeten service','4');
echo "<p>Klik hier om verder te gaan: <input type='submit' value='Volgende' name='submit2'></p>";
echo "</form>";
echo "</div>";
catcher();
template_footer();
}
// Eind afspraak aanmaak haar diensten inhoud