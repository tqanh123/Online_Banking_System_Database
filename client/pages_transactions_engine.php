<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$Customer_id = $_SESSION['Customer_id'];
//roll back transaction
if (isset($_GET['RollBack_Transaction'])) {
  $id = intval($_GET['RollBack_Transaction']);
  $adn = "DELETE FROM  Transactions  WHERE tr_id = ?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->close();

  if ($stmt) {
    $info = "Transaction Rolled Back";
  } else {
    $err = "Try Again Later";
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
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Transaction History</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="pages_transactions_engine.php">Transaction History</a></li>
                <li class="breadcrumb-item active">Transactions</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Select on any action options to manage Transactions</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Transaction Code</th>
                      <th>Account No.</th>
                      <th>Type</th>
                      <th>Amount</th>
                      <th>Timestamp</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    //Get latest transactions 
                    $Customer_id = $_SESSION['Customer_id'];
                    $ret = "SELECT * FROM `Transactions` WHERE Customer_id =? ORDER BY Created_At DESC ";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('i', $Customer_id);
                    $stmt->execute(); //ok    
                    $res = $stmt->get_result();
                    $cnt = 1;
                    while ($row = $res->fetch_object()) {
                      /* Trim Transaction Timestamp to 
                            *  User Uderstandable Formart  DD-MM-YYYY :
                            */
                      $transTstamp = $row->Created_At;
                      //Perfom some lil magic here
                      if ($row->Transaction_Type == 'Deposit') {
                        $alertClass = "<span class='badge badge-success'>$row->Transaction_Type</span>";
                      } elseif ($row->Transaction_Type == 'Withdrawal') {
                        $alertClass = "<span class='badge badge-danger'>$row->Transaction_Type</span>";
                      } else {
                        $alertClass = "<span class='badge badge-warning'>$row->Transaction_Type</span>";
                      }
                    ?>

                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $row->Transaction_ID; ?></a></td>
                        <td><?php echo $row->Account_Id; ?></td>
                        <td><?php echo $alertClass; ?></td>
                        <td>$ <?php echo $row->Amount; ?></td>
                        <td><?php echo date("d-M-Y h:m:s ", strtotime($transTstamp)); ?></td>

                      </tr>
                    <?php $cnt = $cnt + 1;
                    } ?>
                    </tfoot>
                </table>
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
  </script>
</body>

</html>