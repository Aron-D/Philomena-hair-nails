<?php
include 'database.php';
// session_start(); 
// beveiliging zodat onbevoegden niet via de url op dit pagina kan komen
if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != "") {
    
} else { 
  header('location:login/login.php');
}

$appointmentId = $_SESSION['appointment_id'];

try {
    // Insert alleen de betaalmethode met ideal betaling als value
    $sql = "UPDATE appointment 
            SET payment = 'Ideal betaald'
            WHERE id = $appointmentId
            LIMIT 1";

    $stmt = $database->prepare($sql);
    $stmt->execute();

    echo "Connected succesfully";
    }
    catch(PDOException $e)
    {
    echo 'Connection failed: ' . $e->getMessage();
    }
    $conn = null;
    
    // Hier kan nog een checkout komen met de info van de afspraak
    header('Location: dashboard_c.php');
    exit();
?>