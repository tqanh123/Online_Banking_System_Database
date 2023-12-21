<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$customer_id = $_SESSION['customer_id'];

    if (isset($_POST['open_account'])) {
        $acc_name = $_POST['acc_name'];
        $national = $_POST['national'];
        $phone_number = $_POST['phone'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $date_of_birth = $_POST['date_of_birth'];
        $email = $_POST['email'];
        $acc_type_id = $_POST['acc_type'];

        $getSelectedAccType = "SELECT * FROM acc_types WHERE Acctype_ID = ?";
        $stmt = $mysqli->prepare($getSelectedAccType);
        $stmt->bind_param('i', $acc_type_id);
        $stmt->execute();
        $resultSelectedAccType = $stmt->get_result();

        if ($resultSelectedAccType->num_rows == 1) {
            $rowSelectedAccType = $resultSelectedAccType->fetch_assoc();
    
            $sqlInsertAccount = "INSERT INTO bankaccounts (Acc_Name, Customer_ID, Acc_status, Acc_amount, Create_AT, Acctype_ID)
                                            VALUES (?, ?, 'active', '0.00', NOW(), ?)";
            $stmt = $mysqli->prepare($sqlInsertAccount);
            $stmt->bind_param('sssi', $acc_name, $customer_id, $acc_status, $acc_type_id);
            $stmt->execute();
        }
    }

    $getCustomerDetails = "SELECT * FROM customers WHERE Customer_ID = ?";
    $stmt = $mysqli->prepare($getCustomerDetails);
    $stmt->bind_param('i', $customer_id);
    $stmt->execute();
    $resultCustomer = $stmt->get_result();

    if ($resultCustomer->num_rows === 1) {
        $rowCustomer = $resultCustomer->fetch_assoc();
        $acc_name = $rowCustomer['Cus_Name'];
        $national = $rowCustomer['National'];
        $phone_number = $rowCustomer['Phone'];
        $gender = $rowCustomer['Gender'];
        $address = $rowCustomer['Address'];
        $date_of_birth = $rowCustomer['Date_of_Birth'];
        $email = $rowCustomer['Email'];
    }
    
?>

<form method='post' action='open_account.php'>
    <label for='acc_name'>Account Name:</label>
    <input type='text' name='acc_name' value='<?php echo $acc_name ?? ''; ?>'><br><br>

    <label for='national'>National:</label>
    <input type='text' name='national' value='<?php echo $national ?? ''; ?>'><br><br>

    <label for='phone'>Phone Number:</label>
    <input type='text' name='phone' value='<?php echo $phone_number ?? ''; ?>'><br><br>

    <label for='gender'>Gender:</label>
    <input type='text' name='gender' value='<?php echo $gender ?? ''; ?>'><br><br>

    <label for='address'>Address:</label>
    <input type='text' name='address' value='<?php echo $address ?? ''; ?>'><br><br>

    <label for='date_of_birth'>Date of Birth:</label>
    <input type='date' name='date_of_birth' value='<?php echo $date_of_birth ?? ''; ?>'><br><br>

    <label for='email'>Email:</label>
    <input type='text' name='email' value='<?php echo $email ?? ''; ?>'><br><br>

    <label for='acc_type'>Select Account Type:</label>
    <select name='acc_type' id='acc_type'>
        <?php
        $getAccTypes = "SELECT * FROM acc_types";
        $resultAccTypes = $mysqli->query($getAccTypes);

        if ($resultAccTypes->num_rows > 0) {
            while ($rowAccType = $resultAccTypes->fetch_assoc()) {
                echo "<option value='" . $rowAccType['Acctype_ID'] . "'>";
                echo $rowAccType['Name'] . " - " . $rowAccType['Description'] . " (Rate: " . $rowAccType['Rate'] . ")";
                echo "</option>";
            }
        } else {
            echo "<option value=''>No account types available</option>";
        }
        ?>
    </select><br><br>
    <input type='submit' name='open_account' value='Open Account'>
</form>

