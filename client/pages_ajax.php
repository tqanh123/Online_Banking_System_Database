<?php
include('conf/pdoconfig.php');
if (!empty($_POST["iBankAccountType"])) {
    //get bank account rate
    $id = $_POST['iBankAccountType'];
    $stmt = $DB_con->prepare("SELECT * FROM Acc_types WHERE Acctype_ID = :id");
    $stmt->execute(array(':id' => $id));
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
         echo htmlentities($row['Rate']); 
    }
}

if (!empty($_POST["iBankAccNumber"])) {
    //get  back account transferables name
    $id = $_POST['iBankAccNumber'];
    $stmt = $DB_con->prepare("SELECT * FROM BankAccounts WHERE Account_Number= :id");
    $stmt->execute(array(':id' => $id));

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
         echo htmlentities($row['Acc_Name']); 
    }
}

if (!empty($_POST["iBankAccHolder"])) {
    //get  back account transferables name
    $id = $_POST['iBankAccHolder'];
    $stmt = $DB_con->prepare("SELECT * FROM BankAccounts NATURAL JOIN Customers WHERE  Account_Number= :id");
    $stmt->execute(array(':id' => $id));

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo htmlentities($row['Cus_Name']);        
    }
}

if (!empty($_POST["iBankAccHolder"])) {
    //get  back account transferables name
    $id = $_POST['iBankAccHolder'];
    $stmt = $DB_con->prepare("SELECT * FROM BankAccounts NATURAL JOIN Customers WHERE  Account_Number= :id");
    $stmt->execute(array(':id' => $id));

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo htmlentities($row['Customer_ID']);        
    }
}

if (isset($_GET['accloan_id'])){
    $acc_id = $_GET['accloan_id'];
    $stmt = $DB_con->prepare("SELECT * FROM LoanTypes WHERE LoanType_ID = :id");
    $stmt->execute(array(':id' => $acc_id));

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
         $text1 = $row['Rate'];
         $text2 = $row['Installment_Period'];
         echo json_encode(["text_1" => $text1, "text_2" => $text2]);
    }
}

?>


