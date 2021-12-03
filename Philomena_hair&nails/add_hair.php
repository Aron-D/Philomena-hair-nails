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
// Wanneer 'nail' op de vorige pagina gekozen wordt, wordt je doorgewezen naar de add_nail.php pagina
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
        if(isset($_POST) && !empty($_POST)) {
            // echo "<pre>".print_r($_POST, true)."</pre>"; exit();
                // Posts in een variable voegen en in de insert met name de variables uitgevoerd
                $dames = $_POST["servicesdamesD"];
                $heren = $_POST["servicesherenD"];
                $kinderen = $_POST["serviceskinderD"];
                $kinderen2 = $_POST["serviceskinderD2"];

            // een if statement van de submit input zetten zodat de insert into van appointment niet dubbel in de database komt
            if(isset($_POST['submit2'])) {
            $sql = "INSERT INTO appointment(cid, payment) VALUES($customerId, 'Achteraf betaling')";
            $stmtapp = $database->prepare($sql);
            $stmtapp->execute();
            // last insert id oppakken in variable zodat de appointment id in een session gelegd kan worden.
            $lini = $database->lastInsertId();
            $_SESSION["appointment_id"] = $lini;
            // Vier keer if statements uitvoeren met insert wegens bug op multidimensionele arrays
            if($dames !== "none") {

            $sql = "INSERT INTO appointment_details(appointment_id, sid, amount, duration) 
            VALUES ($lini, $dames, 1, 1)";
            $stmt = $database->prepare($sql);
            $stmt->execute();
            header('location:calendar.php');
            }
            if($heren !== "none") {

                $sql = "INSERT INTO appointment_details(appointment_id, sid, amount, duration) 
                VALUES ($lini, $heren, 1, 1)";
                $stmt = $database->prepare($sql);
                $stmt->execute();
                header('location:calendar.php');
                }
                if($kinderen !== "none") {

                    $sql = "INSERT INTO appointment_details(appointment_id, sid, amount, duration) 
                    VALUES ($lini, $kinderen, 1, 1)";
                    $stmt = $database->prepare($sql);
                    $stmt->execute();
                    header('location:calendar.php');
                    }
                    if($kinderen2 !== "none") {

                        $sql = "INSERT INTO appointment_details(appointment_id, sid, amount, duration) 
                        VALUES ($lini, $kinderen2, 1, 1)";
                        $stmt = $database->prepare($sql);
                        $stmt->execute();
                        header('location:calendar.php');
                        }
                }
        } else {
            echo "Voer tenminste 1 dienst in om verder te gaan!";
        }
    }

function createSelect($db,$sid,$cat,$title) { // Selecteren van alle services uit de database met een select functie
    
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



// Begin van Haardiensten
template_header_loggedin_cus('afspraak_aanmaak_haar');
echo "<div id='selectboxes'>";
echo "<h1 id='titleapp'>Haardiensten</h1>";
echo "<a href='make_appointment.php'>Terug</a>";
echo "<form action='' method='post'>";
echo createSelect($database, 'damesD', 'dames', 'Diensten voor Dames');

echo createSelect($database, 'herenD', 'heren', 'Diensten voor Heren');

echo createSelect($database, 'kinderD', 'kinderen t/m 11 jaar', 'Diensten voor kinderen t/m 11 jaar');

echo createSelect($database, 'kinderD2', 'kinderen 12 t/m 15 jaar', 'Diensten voor kinderen 12 t/m 15 jaar');

echo "<p>Klik hier om verder te gaan: <input type='submit' value='Volgende' name='submit2'></p>";

echo "</form>";

echo "</div>";
// Eind van Haardiensten

catcher();

template_footer();
}

