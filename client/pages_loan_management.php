<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$Customer_id = $_SESSION['Customer_id'];

$loan_id = $_GET['loan_id'] ?? '';
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
                            </div>
                            <div class="card-body">
                            <form method='post' action='pages_loan_process.php' id='checkoutForm'>
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
                                <button type='submit' class='btn btn-primary'>Checkout</button>
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