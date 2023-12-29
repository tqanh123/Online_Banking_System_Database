<?php
    $host="localhost";
    $dbuser="root";
    $dbpass="";
    $db="online_banking";
    $mysqli=new mysqli($host,$dbuser, $dbpass, $db);


    if (isset($_GET['acc_id'])){
        // echo "<script> alert('ok'); </script> ";
        $acc_id = $_GET['acc_id'];
        $bank = "SELECT * FROM BankAccounts b, Customers c WHERE b.Account_Number = '$acc_id' AND b.Customer_ID = c.Customer_ID";
        $res = mysqli_query($mysqli, $bank);
        $row = $res -> fetch_object();
        
        $text1 = $row->Acc_Name;
        $text2 = $row->Cus_Name;
        $text3 = $row->Customer_ID;
        // echo $text2;
        echo json_encode(["text_1" => $text1, "text_2" => $text2, "text_3" => $text3]);
        
    }

?>