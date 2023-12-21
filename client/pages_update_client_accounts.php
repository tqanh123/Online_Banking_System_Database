<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$Customer_id = $_SESSION['Customer_id'];
//register new account
if (isset($_POST['update_account'])) {
    //Client open account
    $Acc_Name = $_POST['Acc_Name'];
    $Account_Number = $_POST['Account_Number'];
    $Acctype_ID = $_POST['Acctype_ID'];
    //$acc_rates = $_POST['acc_rates'];
    $Acc_Status = $_POST['Acc_Status'];
    $Acc_Status = $_POST['Acc_Status'];
    $Customer_ID  = $_GET['Customer_ID'];
    $client_national_id = $_POST['client_national_id'];
    $client_name = $_POST['client_name'];
    $client_phone = $_POST['client_phone'];
    $client_number = $_POST['client_number'];
    $client_email  = $_POST['client_email'];
    $client_adr  = $_POST['client_adr'];

    //Insert Captured information to a database table
    $query = "UPDATE  BankAccounts  SET Acc_Name=?, Account_Number=?, Acctype_ID=?, acc_rates=?, Acc_Status=?, Acc_Status=?, client_name=?, client_national_id=?, client_phone=?, client_number=?, client_email=?, client_adr=? WHERE Customer_ID =?";
    $stmt = $mysqli->prepare($query);
    //bind paramaters
    $rc = $stmt->bind_param('sssssssssssi', $Acc_Name, $Account_Number, $Acctype_ID, $Acc_Status, $Acc_Status,  $client_name, $client_national_id, $client_phone, $client_number, $client_email, $client_adr, $Customer_ID);
    $stmt->execute();

    //declare a varible which will be passed to alert function
    if ($stmt) {
        $success = "Account Updated";
    } else {
        $err = "Please Try Again Or Try Later";
    }
}

?>
<!-- Log on to codeastro.com for more projects! -->
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
        $Customer_ID = $_GET['Customer_ID'];
        $ret = "SELECT * FROM  BankAccounts WHERE Customer_ID = ? ";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('i', $Customer_ID);
        $stmt->execute(); //ok
        $res = $stmt->get_result();
        $cnt = 1;
        while ($row = $res->fetch_object()) {

        ?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Update <?php echo $row->client_name; ?> iBanking Account</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="pages_open_acc.php">iBanking Accounts</a></li>
                                    <li class="breadcrumb-item"><a href="pages_open_acc.php">Manage </a></li>
                                    <li class="breadcrumb-item active"><?php echo $row->client_name; ?></li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-12">
                                <!-- general form elements -->
                                <div class="card card-purple">
                                    <div class="card-header">
                                        <h3 class="card-title">Fill All Fields</h3>
                                    </div>
                                    <!-- form start -->
                                    <form method="post" enctype="multipart/form-data" role="form">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputEmail1">Client Name</label>
                                                    <input type="text" readonly name="client_name" value="<?php echo $row->client_name; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputPassword1">Client Number</label>
                                                    <input type="text" readonly name="client_number" value="<?php echo $row->client_number; ?>" class="form-control" id="exampleInputPassword1">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputEmail1">Client Phone Number</label>
                                                    <input type="text" readonly name="client_phone" value="<?php echo $row->client_phone; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputPassword1">Client National ID No.</label>
                                                    <input type="text" readonly value="<?php echo $row->client_national_id; ?>" name="client_national_id" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputEmail1">Client Email</label>
                                                    <input type="email" readonly name="client_email" value="<?php echo $row->client_email; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputEmail1">Client Address</label>
                                                    <input type="text" name="client_adr" readonly value="<?php echo $row->client_adr; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                            </div>
                                            <!-- ./End Personal Details -->

                                            <!--Bank Account Details-->

                                            <div class="row">
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputEmail1">Account Name</label>
                                                    <input type="text" name="Acc_Name" value="<?php echo $row->Acc_Name; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>

                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputEmail1">Account Number</label>
                                                    <input type="text" name="Account_Number" value="<?php echo $row->Account_Number; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputEmail1">Account Type</label>
                                                    <select class="form-control" onChange="getiBankAccs(this.value);" name="Acctype_ID">
                                                        <option>Select Any Account types</option>
                                                        <?php
                                                        //fetch all iB_Acctype_IDs
                                                        $ret = "SELECT * FROM  iB_Acctype_IDs ORDER BY RAND() ";
                                                        $stmt = $mysqli->prepare($ret);
                                                        $stmt->execute(); //ok
                                                        $res = $stmt->get_result();
                                                        $cnt = 1;
                                                        while ($row = $res->fetch_object()) {

                                                        ?>
                                                            <option value="<?php echo $row->name; ?> "> <?php echo $row->name; ?> </option>
                                                        <?php } ?>
                                                    </select>

                                                </div>
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputEmail1">Account Type Rates (%)</label>
                                                    <input type="text" name="acc_rates" readonly required class="form-control" id="AccountRates">
                                                </div>

                                                <div class=" col-md-6 form-group" style="display:none">
                                                    <label for="exampleInputEmail1">Account Status</label>
                                                    <input type="text" name="Acc_Status" value="Active" readonly required class="form-control">
                                                </div>

                                                <div class=" col-md-6 form-group" style="display:none">
                                                    <label for="exampleInputEmail1">Account Amount</label>
                                                    <input type="text" name="Acc_Status" value="0" readonly required class="form-control">
                                                </div>

                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <button type="submit" name="update_account" class="btn btn-success">Update iBanking Account</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div><!-- /.container-fluid -->
                </section><!-- Log on to codeastro.com for more projects! -->
                <!-- /.content -->
            </div>
        <?php } ?>
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