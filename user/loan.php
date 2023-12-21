<?php
include("./includes/connect.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['cus_name'];
        $national = $_POST['national'];
        $phone_number = $_POST['phone'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $date_of_birth = $_POST['date_of_birth'];
        $email = $_POST['email'];

        
        
    }


?>