<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$customer_id = $_SESSION['customer_id'];

if (isset($_POST['open_loan'])) {
    $loan_type_id = $_POST['loan_type'];
    $loan_amount = $_POST['loan_amount'];

    $getSelectedLoanType = "SELECT * FROM loan_types WHERE LoanType_ID = ?";
    $stmt = $mysqli->prepare($getSelectedLoanType);
    $stmt->bind_param('i', $loan_type_id);
    $stmt->execute();
    $resultSelectedLoanType = $stmt->get_result();

    if ($resultSelectedLoanType->num_rows == 1) {
        $rowSelectedLoanType = $resultSelectedLoanType->fetch_assoc();

        $sqlInsertLoan = "INSERT INTO loans (Customer_ID, LoanType_ID, Loan_Amount, Status, Start_Date)
                                        VALUES (?, ?, ?, 'inactive', NOW())";
        $stmt = $mysqli->prepare($sqlInsertLoan);
        $stmt->bind_param('iid', $customer_id, $loan_type_id, $loan_amount);
        $stmt->execute();
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

        <!-- Content Wrapper. Contains page content -->
        <?php
        // $client_id = $_SESSION['client_id'];
        // $ret = "SELECT * FROM  iB_clients WHERE client_id = ? ";
        // $stmt = $mysqli->prepare($ret);
        // $stmt->bind_param('i', $client_id);
        // $stmt->execute(); //ok
        // $res = $stmt->get_result();
        // $cnt = 1;
        // while ($row = $res->fetch_object()) {

        ?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Open <?php echo $row->name; ?> iBanking Account</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="pages_open_acc.php">iBanking Accounts</a></li>
                                    <li class="breadcrumb-item"><a href="pages_open_acc.php">Open </a></li>
                                    <li class="breadcrumb-item active"><?php echo $row->name; ?></li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-12">
                            <div class="card card-purple">
                                <div class="card-header">
                                    <h3 class="card-title">Fill All Fields</h3>
                                </div>
                                <form method="post" enctype="multipart/form-data" role="form">
                                    <div class="card-body">
                                        <label for='loan_amount'>Loan Amount:</label>
                                        <input type='text' name='loan_amount'><br><br>

                                        <label for='loan_type'>Select Loan Type:</label>
                                        <select name='loan_type' id='loan_type'>
                                        <?php
                                        $getLoanTypes = "SELECT * FROM loan_types";
                                        $resultLoanTypes = $mysqli->query($getLoanTypes);

                                        if ($resultLoanTypes->num_rows > 0) {
                                            while ($rowLoanType = $resultLoanTypes->fetch_assoc()) {
                                                echo "<option value='" . $rowLoanType['LoanType_ID'] . "'>";
                                                echo $rowLoanType['Name'] . " - " . $rowLoanType['Description'] . " (Interest Rate: " . $rowLoanType['Rate'] . ")";
                                                echo "</option>";
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" name="open_loan" class="btn btn-success">Apply for Loan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.col-md-12 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
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
    <!-- bs-custom-file-input -->
    <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            bsCustomFileInput.init();
        });
    </script>
</body>

</html>