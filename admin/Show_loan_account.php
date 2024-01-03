<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];


// $sql = "SELECT ba.Account_Number, ba.Acc_Status, at.Name, ba.Acc_Amount AS Acc_Type_Name, at.Description AS Acc_Type_Description 
//                                 FROM BankAccounts ba 
//                                 INNER JOIN Acc_types at ON ba.Acctype_ID = at.Acctype_ID
//                                 WHERE ba.Acc_Status = 'inactive' AND at.Name = 'loan' AND CONVERT(ba.Acc_Amount, DECIMAL(10,2)) > 0;";
// $result = $mysqli->query($sql);

// if ($result->num_rows > 0) {
//     echo "<h2>Manage Loan Accounts</h2>";
//     echo "<table border='1'>";
//     echo "<tr><th>Account Number</th><th>Account Status</th><th>Account Type</th><th>Description</th><th>Action</th></tr>";

//     while ($row = $result->fetch_assoc()) {
//         echo "<tr>";
//         echo "<td>" . $row["Account_Number"] . "</td>";
//         echo "<td>" . $row["Acc_Status"] . "</td>";
//         echo "<td>" . $row["Acc_Type_Name"] . "</td>";
//         echo "<td>" . $row["Acc_Type_Description"] . "</td>";
//         echo "<td><a href='loan_management.php?account_number=" . $row["Account_Number"] . "'>Manage</a></td>"; 
//         echo "</tr>";
//     }

//     echo "</table>";
// } else {
//     echo "No inactive loan accounts found.";
// }

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
              <form method="get" action="Show_loan_account.php">
                  <label for="status">Select Loan Status:</label>
                  <select name="status" id="status">
                      <option value="all">All</option>
                      <option value="inactive">Inactive</option>
                      <option value="active">Active</option>
                  </select>
                  <input type="submit" value="Filter">
              </form>
                <h3 class="card-title">Select on any account to view for loan</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Customer Name</th>
                      <th>Status</th>
                      <th>Loan Amount</th>
                      <th>Loan Type</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $status = $_GET['status'] ?? 'all';
                    $whereClause = '';
                    
                    if ($status !== 'all') {
                        $whereClause = " WHERE l.Status = '$status'";
                    }
                    
                    $sql = "SELECT c.Cus_Name AS Customer_Name, l.Status, l.Loan_Amount, lt.Name AS Loan_Type, l.Customer_ID, l.Loan_ID
                            FROM Loans l
                            INNER JOIN LoanTypes lt ON l.LoanType_ID = lt.LoanType_ID
                            INNER JOIN Customers c ON l.Customer_ID = c.Customer_ID
                            $whereClause;
                    ";

                    $result = $mysqli->query($sql);
                    $cnt = 1;
                    while ($row = $result->fetch_object()) {

                    ?>

                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $row->Customer_Name; ?></td>
                        <td><?php echo $row->Status; ?></td>
                        <td><?php echo $row->Loan_Amount; ?></td>
                        <td><?php echo $row->Loan_Type; ?></td>
                        <!-- <td><?php echo $row->client_name; ?></td> -->
                        <td>
                          <?php if ($row->Status !== 'Active') { ?>
                            <a class="btn btn-success btn-sm" href='loan_management.php?customer_id=<?php echo $row->Customer_ID; ?>&loan_id=<?php echo $row->Loan_ID; ?>'>Manage</a>
                          <?php } ?>
                        </td>

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