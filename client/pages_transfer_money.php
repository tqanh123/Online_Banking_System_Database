<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$Customer_id = $_SESSION['Customer_id'];


    if (isset($_POST['deposit'])) {
        $account_id = $_GET['account_id'];
        $acc_name = $_POST['acc_name'];
        //$acc_amount  = $_POST['acc_amount'];
        $tr_type  = $_POST['tr_type'];
        $User_id  = $_SESSION['Customer_id'];
        $User_name  = $_POST['User_name'];
        $transaction_amt = -$_POST['transaction_amt'];
    
        //Few fields to hold funds transfers
        $receiving_id = $_POST['receiving_acc_no'];
        $receiving_acc_name = $_POST['receiving_acc_name'];
        $receiving_acc_holder = $_POST['receiving_acc_holder'];
        $receiving_cus_id = $_POST['receiving_holder_id'];
    
        //Notication
        $notification_details = "$User_name Has Transfered $ $transaction_amt From Bank Account $account_id To Bank Account $receiving_id";
        $notification_details1 = "$receiving_acc_holder Has Received $ $transaction_amt From Bank Account $acc_name To Bank Account $receiving_id";
    
        /*
                *You cant transfer money from an bank account that has no money in it so
                *Lets Handle that here.
                */
        $result = "SELECT SUM(Amount) FROM  Transactions  WHERE Account_Id=?";
        $stmt = $mysqli->prepare($result);
        $stmt->bind_param('i', $account_id);
        $stmt->execute();
        $stmt->bind_result($amt);
        $stmt->fetch();
        $stmt->close();
    
    
        if ($transaction_amt > $amt) {
            $transaction_error  =  "You Do Not Have Sufficient Funds In $acc_name Account For Transfer. Your Current Account Balance Is $ $amt";
        } else {
    
    
            //Insert Captured information to a database table
            $query = "INSERT INTO Transactions (Account_ID, Transaction_Type, Customer_ID, Amount, Receiving_ID, Created_At)
                      VALUES ('$account_id', '$tr_type', '$User_id', '$transaction_amt', '$receiving_id', 'NOW()')";
            $notification = "INSERT INTO  notifications (notification_details, Created_At) VALUES ('$notification_details', 'NOW()')";
    
            $stmt = $mysqli->query($query);
            $notification_stmt = $mysqli->query($notification);
    
            // connect Customers and NOtifications
            $cn_query = "SELECT MAX(Notification_ID) AS no_id FROM notifications";
            $res_cn = $mysqli->query($cn_query);
            $no_id = $res_cn->fetch_object();
    
            $cus_no_query = "INSERT INTO CustomersNotifications(Customer_ID, Notification_ID) 
                             VALUES('$User_id', '". $no_id -> no_id."')";
            $recive_no_query = "INSERT INTO CustomersNotifications(Customer_ID, Notification_ID) 
                             VALUES('$receiving_cus_id', '". $no_id -> no_id."')";
            
            $res_cusno = $mysqli -> query($cus_no_query);
            $res_receiveno = $mysqli -> query($recive_no_query);
    
            //declare a varible which will be passed to alert function
            if ($stmt && $notification_stmt) {
                $success = "Money Transfered";
            } else {
                $err = "Please Try Again Or Try Later";
            }
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
        $account_id = $_GET['account_id'];
        $ret = "SELECT * FROM  bankAccounts 
                NATURAL JOIN Customers
                NATURAL JOIN Acc_types
                WHERE Account_Number = ? ";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('i', $account_id);
        $stmt->execute(); //ok
        $res = $stmt->get_result();
        $cnt = 1;
        while ($row = $res->fetch_object()) {

            $result = "SELECT SUM(Amount) FROM  Transactions
                       WHERE Account_Id=?";
            $stmt = $mysqli->prepare($result);
            $stmt->bind_param('i', $account_id);
            $stmt->execute();
            $stmt->bind_result($amt);
            $stmt->fetch();
            $stmt->close();
            $result = "SELECT -SUM(Amount) FROM  Transactions
                       WHERE Receiving_ID=? ";
            $stmt2 = $mysqli->prepare($result);
            $stmt2->bind_param('i', $account_id);
            $stmt2->execute();
            $stmt2->bind_result($amt_r);
            $stmt2->fetch();
            $stmt2->close();
        ?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Transfer Money</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="pages_transfer_money.php">Finances</a></li>
                                    <li class="breadcrumb-item"><a href="pages_transfer_money.php">Transfer</a></li>
                                    <li class="breadcrumb-item active"><?php echo $row->Acc_Name; ?></li>
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
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputEmail1">User Name</label>
                                                    <input type="text" readonly name="User_name" value="<?php echo $row->Cus_Name; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputPassword1">User National </label>
                                                    <input type="text" readonly value="<?php echo $row->National; ?>" name="User_national_id" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputEmail1">User Phone Number</label>
                                                    <input type="text" readonly value="<?php echo $row->Phone; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputEmail1">Account Name</label>
                                                    <input type="text" readonly name="acc_name" value="<?php echo $row->Acc_Name; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputPassword1">Account Number</label>
                                                    <input type="text" readonly value="<?php echo $row->Account_Number; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-4 form-group" >
                                                    <label for="exampleInputEmail1">Account Type | Category</label>
                                                    <input type="text" readonly value="<?php echo $row->Name; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputPassword1">Current Account Balance</label>
                                                    <input type="text" readonly value="<?php echo $amt; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputPassword1">Amount Transfered($)</label>
                                                    <input type="text" name="transaction_amt" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputPassword1">Receiving Account Number</label>
                                                    <select name="receiving_acc_no" onChange="getiBankAccs(this.value);" required class="form-control">
                                                        <option>Select Receiving Account</option>
                                                        <?php
                                                        //fetch all iB_Accs
                                                        $ret = "SELECT * FROM bankAccounts WHERE Account_Number !='".$row->Account_Number."'";
                                                        $stmt = $mysqli->prepare($ret);
                                                        $stmt->execute(); //ok
                                                        $res = $stmt->get_result();
                                                        $cnt = 1;
                                                        while ($row = $res->fetch_object()) {

                                                        ?>
                                                            <option><?php echo $row->Account_Number; ?></option>

                                                        <?php } ?>

                                                    </select>
                                                </div>
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputPassword1">Receiving Account Name</label>
                                                    <input type="text" name="receiving_acc_name" required class="form-control" id="ReceivingAcc">
                                                </div>
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputPassword1">Receiving Account Holder</label>
                                                    <input type="text" name="receiving_acc_holder" required class="form-control" id="AccountHolder">
                                                </div>
                                                <div class=" col-md-4 form-group" style="display:none">
                                                    <label for="exampleInputPassword1">Receiving Holder id</label>
                                                    <input type="text" name="receiving_holder_id" required class="form-control" id="Holder_id">
                                                </div>

                                                <div class=" col-md-4 form-group" style="display:none">
                                                    <label for="exampleInputPassword1">Transaction Type</label>
                                                    <input type="text" name="tr_type" value="Transfer" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-4 form-group" style="display:none">
                                                    <label for="exampleInputPassword1">Transaction Status</label>
                                                    <input type="text" name="tr_status" value="Success " required class="form-control" id="exampleInputEmail2">
                                                </div>

                                            </div>

                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <button type="submit" name="deposit" class="btn btn-success">Transfer Funds</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div><!-- /.container-fluid -->
                </section>
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