<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$Customer_id = $_SESSION['Customer_id'];

$loan_id = $_GET['loan_id'] ?? '';

if (isset($_POST['checkout_loan'])) {
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
                        $success = "Loan processed successfully. Loan amount deducted from the bank account. Transaction recorded.";
                    } else {
                        $mysqli->rollback();
                        $err = "Error deleting loan: " . $mysqli->error;
                    }
                } else {
                    $mysqli->rollback();
                    $err = "Insufficient funds in the bank account to cover the loan.";
                }
            } elseif ($loan_action === 'reject') {
                $deleteLoanQuery = "DELETE FROM Loans WHERE Loan_ID = $loan_account_id AND Customer_ID = $customer_id";
                if ($mysqli->query($deleteLoanQuery)) {
                    $mysqli->commit();
                    $success = "Loan rejected and deleted successfully.";
                } else {
                    $mysqli->rollback();
                    $err = "Error deleting loan: " . $mysqli->error;
                }
            } else {
                $mysqli->rollback();
                $err = "Invalid loan action.";
            }
        } else {
            $mysqli->rollback();
            $err = "Loan has already been processed.";
        }
    } else {
        $err = "Customer ID, loan action, loan account, or bank account not provided.";
    }
}
?>

<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php include("dist/_partials/head.php"); ?>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include("dist/_partials/nav.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include("dist/_partials/sidebar.php"); ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                            <section class="content-header">
                                <div class="container-fluid">
                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            <h1>Loan checkout</h1>
                                        </div>
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                                                <li class="breadcrumb-item"><a href="pages_deposits.php">Deposit</a></li>
                                                <li class="breadcrumb-item active">Loan Checkout</a></li>
                                                
                                            </ol>
                                        </div>
                                    </div>
                                </div><!-- /.container-fluid -->
                            </section>
                            </div>
                            <div class="card-body">
                            <form method='post' action='' id='checkoutForm'>
                                <input type='hidden' name='customer_id' value='<?php echo $Customer_id; ?>'>  
                                <label for='loan_account'>Choose Loan Account:</label>
                                <select name='loan_account' id='loan_account'>
                                    <?php
                                    $sql = "SELECT * FROM loans WHERE Customer_ID = $Customer_id";
                                    $result = $mysqli->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_object()) {
                                            echo "<option value='" . $row->Loan_ID . "'>";
                                            echo  " - " . $row->Status . " (" . $row->Loan_Amount . ")";
                                            echo "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No loan accounts available</option>";
                                    }
                                    ?>
                                </select><br><br>
                                <label for='bank_account'>Choose Bank Account:</label>
                                <select name='bank_account' id='bank_account'>
                                    <?php
                                    $sqlBank = "SELECT * FROM BankAccounts WHERE Customer_ID = $Customer_id";
                                    $resultBank = $mysqli->query($sqlBank);

                                    if ($resultBank->num_rows > 0) {
                                        while ($rowBank = $resultBank->fetch_object()) {
                                            echo "<option value='" . $rowBank->Account_Number . "'>";
                                            echo  $rowBank->Account_Number . " - " . $rowBank->Acc_Status . " (" . $rowBank->Acc_Amount . ")";
                                            echo "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No bank accounts available</option>";
                                    }
                                    ?>
                                </select><br><br>
                                <?php if(isset($loan_id)) { ?>
                                    <input type='hidden' name='loan_id' value='<?php echo $loan_id; ?>'>
                                <?php } ?>
                                <input type='hidden' name='loan_action' value='accept'>
                                <button type='submit' name="checkout_loan" class='btn btn-primary'>Checkout</button>
                            </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include("dist/_partials/footer.php"); ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->
    <script>
        $(function() {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });

        function submitForm() {
            document.getElementById('checkoutForm').submit();
        }
    </script>
</body>

</html>