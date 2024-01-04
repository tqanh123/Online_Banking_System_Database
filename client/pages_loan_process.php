<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$Customer_id = $_SESSION['Customer_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'] ?? '';
    $loan_account_id = $_POST['loan_account'] ?? '';
    $bank_account_id = $_POST['bank_account'] ?? '';
    $loan_action = $_POST['loan_action'] ?? '';

    if (!empty($customer_id) && !empty($loan_account_id) && !empty($bank_account_id) && !empty($loan_action)) {
        $mysqli->begin_transaction();

        $getLoanDetails = "SELECT * FROM Loans WHERE Loan_ID = $loan_account_id AND Customer_ID = $customer_id FOR UPDATE";
        $loanResult = $mysqli->query($getLoanDetails);
        $loanRow = $loanResult->fetch_assoc();

        if ($loanRow['Status'] === 'Active') {
            if ($loan_action === 'accept') {
                $loan_amount = $loanRow['Loan_Amount'];

                $getAccountDetails = "SELECT * FROM BankAccounts WHERE Account_Number = $bank_account_id FOR UPDATE";
                $accountResult = $mysqli->query($getAccountDetails);
                $accountRow = $accountResult->fetch_assoc();

                if ($accountRow['Acc_Amount'] >= $loan_amount) {
                    $updatedAmount = $accountRow['Acc_Amount'] - $loan_amount;
                    $updateAccountQuery = "UPDATE BankAccounts SET Acc_Amount = $updatedAmount WHERE Account_Number = $bank_account_id";
                    $mysqli->query($updateAccountQuery);

                    $transaction_description = "Loan payment - Loan ID: " . $loanRow['Loan_ID'];
                    $insertTransactionQuery = "INSERT INTO Transactions (Customer_ID, Account_Id, Amount, Transaction_Type, Created_At) VALUES ($customer_id, $bank_account_id, $loan_amount, '$transaction_description', NOW())";
                    $mysqli->query($insertTransactionQuery);

                    $deleteLoanQuery = "DELETE FROM Loans WHERE Loan_ID = $loan_account_id AND Customer_ID = $customer_id";
                    if ($mysqli->query($deleteLoanQuery)) {
                        $mysqli->commit();
                        echo "Loan processed successfully. Loan amount deducted from the bank account. Transaction recorded.";
                    } else {
                        $mysqli->rollback();
                        echo "Error deleting loan: " . $mysqli->error;
                    }
                } else {
                    $mysqli->rollback();
                    echo "Insufficient funds in the bank account to cover the loan.";
                }
            } elseif ($loan_action === 'reject') {
                $deleteLoanQuery = "DELETE FROM Loans WHERE Loan_ID = $loan_account_id AND Customer_ID = $customer_id";
                if ($mysqli->query($deleteLoanQuery)) {
                    $mysqli->commit();
                    echo "Loan rejected and deleted successfully.";
                } else {
                    $mysqli->rollback();
                    echo "Error deleting loan: " . $mysqli->error;
                }
            } else {
                $mysqli->rollback();
                echo "Invalid loan action.";
            }
        } else {
            $mysqli->rollback();
            echo "Loan has already been processed.";
        }
    } else {
        echo "Customer ID, loan action, loan account, or bank account not provided.";
    }
}
?>