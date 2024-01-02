<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'] ?? '';
    $action = $_POST['loan_action'] ?? '';

    if (!empty($customer_id) && !empty($action)) {
        if ($action === 'accept') {

            $sqlUpdateStatus = "UPDATE loans SET Status = 'Active' WHERE Customer_ID = $customer_id";
            if ($mysqli->query($sqlUpdateStatus) === TRUE) {

                $notificationDetails = "Your loan has been accepted. Your loan account is now active.";
                $sqlCreateNotification = "INSERT INTO Notifications (Notification_Details, Created_At) VALUES ('$notificationDetails', NOW())";
                if ($mysqli->query($sqlCreateNotification) === TRUE) {
                    $success = "Loan Accept";
                    $notification_id = $mysqli->insert_id;
                    $sqlCreateCustomerNotification = "INSERT INTO customersnotifications (Customer_ID, Notification_ID) VALUES ($customer_id, $notification_id)";
                    if ($mysqli->query($sqlCreateCustomerNotification) === TRUE) {
                        
                    }
                } else {
                    echo "Error creating notification: " . $mysqli->error;
                }
            } else {
                echo "Error updating account amount: " . $mysqli->error;
            }
        } elseif ($action === 'reject') {

            $notificationDetails = "Your loan has been rejected.";
            $sqlCreateNotification = "INSERT INTO Notifications (Notification_Details, Created_At) VALUES ('$notificationDetails', NOW())";
          
            if ($mysqli->query($sqlCreateNotification) === TRUE) {
                echo "Loan rejected successfully. Notification created.";
                $sqlDeleteLoan = "DELETE FROM Loans WHERE Customer_ID = $customer_id";
                $sqlDeleteCustomerLoan = "DELETE FROM CustomerLoans WHERE Customer_ID = $customer_id";

                $notification_id = $mysqli->insert_id;
                $sqlCreateCustomerNotification = "INSERT INTO customersnotifications (Customer_ID, Notification_ID) VALUES ($customer_id, $notification_id)";
                if ($mysqli->query($sqlDeleteLoan) === TRUE && $mysqli->query($sqlDeleteCustomerLoan) === TRUE && $mysqli->query($sqlCreateCustomerNotification) === TRUE) {
                    
                }
            } else {
                echo "Error creating notification: " . $mysqli->error;
            }
        } else {
            echo "Invalid action.";
        }
        $mysqli->close();
    } else {
        echo "Account number or action not provided.";
    }
}

?>