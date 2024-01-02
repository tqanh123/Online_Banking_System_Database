<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$customer_id = $_SESSION['Customer_id'];

if (isset($_POST['open_loan'])) {
    $loan_type_id = $_POST['loan_type'];
    $loan_amount = $_POST['loan_amount'];
    $acc_rate = $_POST['acc_rate'];
    $term = $_POST['loan_term'];

    // calculate Loan rate and installment follow loan term 
    $rate = ($term / 6) * 0.5;
    $installment = $loan_amount * (1 + $rate);

    $sqlInsertLoan = "INSERT INTO loans (Customer_ID, LoanType_ID, Loan_Amount, Loan_Term, Installment, Status, Start_Date)
                      VALUES (?, ?, ?, ?, ?, 'inactive', NOW())";
    $stmt = $mysqli->prepare($sqlInsertLoan);
    $stmt->bind_param('iidid', $customer_id, $loan_type_id, $loan_amount, $term, $installment);
    $stmt->execute();

    if ($stmt) {
        $success = "Loan Account Opened";
    } else {
        $err = "Please Try Again Or Try Later";
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
        $Customer_id = $_SESSION['Customer_id'];
        $ret = "SELECT * FROM Customers WHERE Customer_ID = ? ";
        $stmt = $mysqli->prepare($ret)  ;
        $stmt->bind_param('i', $Customer_id);
        $stmt->execute(); //ok
        $res = $stmt->get_result();
        $row = $res->fetch_object();

        ?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Open <?php echo $row->Cus_Name; ?> iBanking Account</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="pages_open_acc.php">iBanking Accounts</a></li>
                                    <li class="breadcrumb-item"><a href="pages_open_acc.php">Open </a></li>
                                    <li class="breadcrumb-item active"><?php echo $row->Cus_Name; ?></li>
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
                                        <div class="row">
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputEmail1">user Name</label>
                                                <input type="text" readonly  value="<?php echo $row->Cus_Name; ?>" required class="form-control" id="exampleInputEmail1">
                                            </div>
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputPassword1">user Number</label>
                                                <input type="text" readonly name="customer_id" value="<?php echo $row->Customer_ID; ?>" class="form-control" id="exampleInputPassword1">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputEmail1">user Phone Number</label>
                                                <input type="text" readonly  value="<?php echo $row->Phone; ?>" required class="form-control" id="exampleInputEmail1">
                                            </div>
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputPassword1">user National</label>
                                                <input type="text" readonly value="<?php echo $row->National; ?>" required class="form-control" id="exampleInputEmail1">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputEmail1">user Email</label>
                                                <input type="email" readonly value="<?php echo $row->Email; ?>" required class="form-control" id="exampleInputEmail1">
                                            </div>
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputEmail1">user Address</label>
                                                <input type="text" readonly value="<?php echo $row->Address; ?>" required class="form-control" id="exampleInputEmail1">
                                            </div>
                                        </div>

                                        <div class="row">
                                        <div class=" col-md-6 form-group">
                                                <label for="exampleInputEmail1">Loan term</label>
                                                <input type="text" name="loan_term" required class="form-control"><br><br>
                                            </div>    

                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputEmail1">Loan Amount</label>
                                                <input type="text" name="loan_amount" required class="form-control"><br><br>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputEmail1">Account Type</label>
                                                <select id="open_loan_acc" name="loan_type" class="form-control" onChange="getiBankAccs(this.value);">
                                                    <option>Select Any Account types</option>
                                                    <?php
                                                    //fetch all Acc_types
                                                    $ret = "SELECT * FROM  Loantypes ORDER BY RAND() ";
                                                    $stmt = $mysqli->prepare($ret);
                                                    $stmt->execute(); //ok
                                                    $res = $stmt->get_result();
                                                    while ($row = $res->fetch_object()) {
                                                    ?>
                                                        <option value="<?php echo $row->LoanType_ID; ?> "> <?php echo $row->Name; ?> </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputEmail1">Loan Type Rates (%)</label>
                                                <input type="text" readonly required class="form-control" id="loanRates">
                                            </div>
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputEmail1">Loan Installment Period</label>
                                                <input type="text" name="installment" readonly required class="form-control" id="loanInstallment">
                                            </div>
                                            <div class=" col-md-6 form-group" style="display:none">
                                                <label for="exampleInputEmail1">Account Status</label>
                                                <input type="text" name="acc_status" value="Active" readonly required class="form-control">
                                            </div>
                                            <div class=" col-md-6 form-group" style="display:none">
                                                <label for="exampleInputEmail1">Account rate</label>
                                                <input type="text" name="acc_rate" value="<?php $row->Rate ?>" readonly required class="form-control">
                                            </div>
                                        </div>                                                                      
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

<script>
    const account = document.getElementById("open_loan_acc");
    account.addEventListener("change", (event) => {
    var accloan_id = event.target.value;
    
    var xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        // alert(this.responseText);
        var data = JSON.parse(this.responseText);
        document.getElementById('loanRates').value = data.text_1;
        document.getElementById('loanInstallment').value = data.text_2;
      }
    }

    xml.open("GET", "pages_ajax.php?accloan_id="+accloan_id, true);
    xml.send();
    })
</script>