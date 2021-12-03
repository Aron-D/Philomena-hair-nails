<?php
include 'database.php';
// session_start();

// beveiliging zodat onbevoegden niet via de url op dit pagina kan komen
if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != "") {
    
} else { 
  header('location:login/login.php');
}

if(isset($_GET['date'])) {
    $date = $_GET['date'];
    $appid = $_SESSION["appointment_id"];
}

if(isset($_POST['submit'])) {
// echo "<pre>".print_r($_POST, true)."</pre>"; exit();
    $timeslot = $_POST['timeslot'];
    // Stmt voor controle of de dag al een keer gekozen is
    $stmt = $database->prepare("SELECT * FROM appointment 
        WHERE date = :dt
        AND timeslot = :ts");

    $stmt->execute(['dt'=> $date,
                    'ts'=> $timeslot]);
    // print_r($stmt->fetchAll(PDO::FETCH_OBJ));        
    if($stmt->rowCount()){
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        if(!empty($result)){
            $msg = "<div class='alert alert-danger'>Dit tijdstip is helaas bezet!</div>";
        } else { // zo niet gekozen dan activeert de tweede stmt UPDATE
    $stmt2 = $database->prepare("UPDATE appointment 
    SET
     date = :dt,
     timeslot = :ts
     WHERE id = :appid");
    //  exit("<h1>$timeslot</h1>");
    $stmt2->execute(['dt'=> $date,
                     'ts'=> $timeslot,
                     'appid'=> $appid]);
    $msg = "<div class='alert alert-success'>Reserveren gelukt <a href='./mollie/payments.php'>Volgende stap</a></div>";
}}}

$duration = 30;
$cleanup = 0;
$start = "10:00";
$end = "18:00";

function timeslots($duration, $cleanup, $start, $end){
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT".$duration."M");
    $cleanupInterval = new DateInterval("PT".$cleanup."M");
    $slots = array();
    
    for($intStart = $start; $intStart<$end; $intStart->add($interval)->add($cleanupInterval)){
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if($endPeriod>$end){
            break;
        }
        
        $slots[] = $intStart->format("H:iA")." - ". $endPeriod->format("H:iA");
        
    }
    // print_r($slots); exit; 
    return $slots;
}
?>
<?=template_header_loggedin_cus_calendar('kalender')?>
<div class="row">
<a href='calendar.php'>Terug</a> <br>
<h2>Reserveren voor de datum: <? echo date('d/m/Y', strtotime($date));?></h2> <br>
<h2>Kies uw tijdstip</h2>
   <div class="col-md-12">
       <?php echo(isset($msg))?$msg:""; ?>
   </div>
    <?php $timeslots = timeslots($duration, $cleanup, $start, $end); 
        foreach($timeslots as $ts){
    ?>
    <div class="col-md-2">
        <div class="form-group">

        <button class="btn btn-success book" data-timeslot="<?php echo $ts; ?>"><?php echo $ts; ?></button>

        </div>
    </div>
    <?php } ?>
</div>
 <!-- begin bootstrap code van w3schools -->
<div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Reserveren voor: <span id="slot"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" method="post">
                               <div class="form-group">
                                    <label for="">Time Slot</label>
                                    <input readonly type="text" class="form-control" id="timeslot" name="timeslot">
                                </div>
                                <div class="form-group pull-right">
                                    <button name="submit" type="submit" class="btn btn-primary">Reserveren</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>

        </div>
    </div>
     <!-- einde bootstrap code van w3schools -->
     <!-- Enkele scripts voor de timeslot bevestigings venster -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-"
     crossorigin="anonymous">
     </script>
     <script>
    $(".book").click(function(){
    var timeslot = $(this).attr('data-timeslot');
    $("#slot").html(timeslot);
    $("#timeslot").val(timeslot);
    $("#myModal").modal("show");
    });
     </script>
<?=template_footer()?>