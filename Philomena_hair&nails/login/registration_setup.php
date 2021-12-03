<?php
include_once("../database.php");
     
        if(isset($_POST["submit"])){

            $firstname = $_POST["fname"];
            $lastname = $_POST["lname"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $password = md5(($_POST["password"]));
            $street = $_POST["street"];
            $postalCode = $_POST["pcode"];
            $place = $_POST["place"];
            $role = $_POST["role"];
            

            $sql = "INSERT INTO `customer` ( `role_id`, `fname`, `lname`, `email`, `phone`, `password`, `street`, `postal_code`, `place`) 
                        VALUES (:ri, :fn, :ln, :em, :pe, :pw, :st, :pc, :pl)";
            $stmt = $database->prepare($sql);
            $userArray = array( "ri"=>$role,
                                "fn"=>$firstname, 
                                "ln"=>$lastname,
                                "em"=>$email,
                                "pe"=>$phone,
                                "pw"=>$password,
                                "st"=>$street,
                                "pc"=>$postalCode, 
                                "pl"=>$place,);                            
            $stmt->execute($userArray);

            header('location: ../dashboard_c.php');

    }

?>