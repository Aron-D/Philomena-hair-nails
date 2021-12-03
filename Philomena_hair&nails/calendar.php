<?php
include 'database.php';
// session_start();
// beveiliging zodat onbevoegden niet via de url op dit pagina kan komen
if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != "") {
    
} else { 
  header('location:login/login.php');
}

function buildCalender($month, $year) {
    //database connectie voor in de functie
    global $database;

    $stmt = $database->prepare("SELECT * FROM appointment WHERE MONTH(date) = :mo AND YEAR(date) = :ye");
    $stmt->bindValue(':mo', $month);
    $stmt->bindValue(':ye', $year);
    $bookings = array();
    if($stmt->execute()) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); 
        if(!empty($result)) { 

            foreach ($result as $r) {
                
               $bookings[] = $r["date"];
            }



        }
    }
    //array van de namen van de dagen in de week
    $daysOfWeek = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
    //eerste dag van de maand pakken met de mktime function
    $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

    // nu het aantal dagen pakken 
    $numberDays = date('t',$firstDayOfMonth);
    
    // Informatie ophalen over de eerste dag van de maand
    $dateComponents = getdate($firstDayOfMonth);

    // de benaming van de maanden die wordt gevraagd
    $monthName = $dateComponents['month'];

    // variable voor het dag van de week
    $dayOfWeek = $dateComponents['wday'];

    // Create the table tag opener and day headers 
$datetoday = date('Y-m-d'); 

$prev_month = date('m',mktime(0,0,0,$month-1,1,$year));
$prev_year = date('Y',mktime(0,0,0,$month-1,1,$year));
$next_month = date('m',mktime(0,0,0,$month+1,1,$year));
$next_year = date('Y',mktime(0,0,0,$month+1,1,$year));
$currentMonth = date('m');
$currentYear = date('Y');
$calendar = "<center><h2>$monthName $year</h2>"; 
$calendar .= "<a class='btn btn-primary btn-xs' href='?month=".$prev_month."&year=".$prev_year."'>Vorige maand</a>";
$calendar .= "<a class='btn btn-primary btn-xs' href='?month=".$currentMonth."&year=".$currentYear."'>Huidige maand</a>"; // Dit werkt niet bij mij op firefox, test het graag uit op een chrome webbrowser
$calendar .= "<a class='btn btn-primary btn-xs' href='?month=".$next_month."&year=".$next_year."'>Volgende maand</a></center>";
$calendar .= "<br><table class='table table-bordered'>"; 
$calendar .= "<tr>"; 

// Create the calendar headers 
foreach($daysOfWeek as $day) { 
    $calendar .= "<th class='header'>$day</th>"; 
} 

// Create the rest of the calendar
// Initiate the day counter, starting with the 1st. 
$calendar .= "</tr><tr>";
$currentDay = 1;

// The variable $dayOfWeek is used to 
// ensure that the calendar 
// display consists of exactly 7 columns.
if($dayOfWeek > 0) { 
    for($k=0;$k<$dayOfWeek;$k++){ 
        $calendar .= "<td class='empty'></td>"; 
    } 
}
$month = str_pad($month, 2, "0", STR_PAD_LEFT);
while ($currentDay <= $numberDays) { 
    //Seventh column (Saturday) reached. Start a new row. 
    if ($dayOfWeek == 7) { 
        $dayOfWeek = 0; 
        $calendar .= "</tr><tr>"; 
    } 
    $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT); 
    $date = "$year-$month-$currentDayRel"; 
    $dayname = strtolower(date('l', strtotime($date))); 
    $eventNum = 0;
    $today = $date==date('Y-m-d')? 'today' : '';

    if($date<date('Y-m-d')) {
        $calendar.="<td class='$today'><h4>$currentDay</h4><a class='btn btn-danger btn-xs'>N.V.T.</a></td>"; 
    } else {
        $calendar.="<td class='$today'><h4>$currentDay</h4><a class='btn btn-succes btn-xs' href='booking.php?date=".$date."'>Reserveren</a></td>"; 
    }

   
    //Increment counters 
    $currentDay++; 
    $dayOfWeek++; 
} 
//Complete the row of the last week in month, if necessary 
if ($dayOfWeek < 7) { 
    $remainingDays = 7 - $dayOfWeek; 
    for($l=0;$l<$remainingDays;$l++){ 
        $calendar .= "<td class='empty'></td>"; 
    } 
} 

$calendar .= "</tr></table>";

return $calendar;
}
?>
<?=template_header_loggedin_cus_calendar('kalender')?>

<div class="container"> 
  <div class="row"> 
   <div class="col-md-12"> 
    <div id="calendar"> 
     <?php 
      $dateComponents = getdate();
      if(isset($_GET['month']) && isset($_GET['year'])) {

        $month = $_GET['month'];
        $year = $_GET['year'];

      } else {

      $month = $dateComponents['mon']; 
      $year = $dateComponents['year']; 
      
    }


    echo buildCalender($month,$year);
    
     ?> 
    </div> 
   </div> 
  </div> 
</div> 
<?=template_footer()?>