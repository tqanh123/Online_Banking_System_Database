<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();

$admin_id = $_SESSION['admin_id'];
$customerID = $_GET['customer_id'] ?? '';

// if (!empty($customerID)) {

//     // balance
//     $sqlAccount = "SELECT Acc_Amount FROM BankAccounts WHERE Customer_ID = $customerID";
//     $resultAccount = $mysqli->query($sqlAccount);

//     if ($resultAccount->num_rows > 0) {
//         $rowAccount = $resultAccount->fetch_assoc();
//         $accAmount = $rowAccount["Acc_Amount"];

//         echo "<h2>Account Details for Customer ID: $customerID</h2>";
//         echo "<p>Account Amount: $accAmount</p>";
//     } else {
//         echo "No account details found for this customer.";
//     }

//     // account types
//     $sqlAccTypes = "SELECT * FROM Acc_types WHERE Acctype_ID IN (SELECT Acctype_ID FROM BankAccounts WHERE Customer_ID = $customerID)";
//     $resultAccTypes = $mysqli->query($sqlAccTypes);

//     if ($resultAccTypes->num_rows > 0) {
//         echo "<h3>Account Types:</h3>";
//         echo "<ul>";
//         while ($rowAccType = $resultAccTypes->fetch_assoc()) {
//             echo "<li>AccType ID: " . $rowAccType["Acctype_ID"] . " - Name: " . $rowAccType["Name"] . " - Description: " . $rowAccType["Description"] . " - Rate: " . $rowAccType["Rate"] . "</li>";
//         }
//         echo "</ul>";
//     } else {
//         echo "No account types found for this customer.";
//     }

//     // transactions
//     $sqlTransactions = "SELECT * FROM `Transactions` WHERE Customer_ID = $customerID";
//     $resultTransactions = $mysqli->query($sqlTransactions);

//     if ($resultTransactions->num_rows > 0) {
//         echo "<h3>Transactions:</h3>";
//         echo "<table border='1'>";
//         echo "<tr><th>Transaction ID</th><th>Amount</th><th>Transaction Type</th></tr>";

//         while ($rowTransaction = $resultTransactions->fetch_assoc()) {
//             echo "<tr>";
//             echo "<td>" . $rowTransaction["Transaction_ID"] . "</td>";
//             echo "<td>" . $rowTransaction["Amount"] . "</td>";
//             echo "<td>" . $rowTransaction["Transaction_Type"] . "</td>";
//             echo "</tr>";
//         }

//         echo "</table>";
//     } else {
//         echo "No transactions found for this customer.";
//     }

//     $mysqli->close();
// } else {
//     echo "Customer ID not provided.";
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
                <h3 class="card-title">All Bank Accounts</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Account Number</th>
                      <th>Account Name</th>
                      <th>Account Status</th>
                      <th>Account Amount</th>
                      <th>Account Type ID</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sqlBankAccounts = "SELECT ba.*, c.Customer_ID, c.Cus_Name AS Customer_Name
                                                        FROM BankAccounts ba
                                                        INNER JOIN Customers c ON ba.Customer_ID = c.Customer_ID
                                                        WHERE c.Customer_ID = $customerID;";

                    $result = $mysqli->query($sqlBankAccounts);
                    $cnt = 1;
                    while ($row = $result->fetch_object()) {

                    ?>

                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $row->Account_Number; ?></td>
                        <td><?php echo $row->Acc_Name; ?></td>
                        <td><?php echo $row->Acc_Status; ?></td>
                        <td><?php echo $row->Acc_Amount; ?></td>
                        <td><?php echo $row->Acctype_ID; ?></td>
                      </tr>
                    <?php $cnt = $cnt + 1;
                    } ?>
                    </tfoot>
                </table>
              </div>
              
              <!-- /.card-body -->
            </div>
            <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Transactions</h3>
                    </div>
                    <div class="card-body">
                        <table id="transactionsTable" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Transaction ID</th>
                                    <th>Amount</th>
                                    <th>Transaction Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                $sqlTransactions = "SELECT * FROM Transactions WHERE Customer_ID = $customerID";
                                $resultTransactions = $mysqli->query($sqlTransactions);
                                $transactionCount = 1;

                                while ($transactionRow = $resultTransactions->fetch_object()) {
                                ?>
                                    <tr>
                                        <td><?php echo $transactionCount; ?></td>
                                        <td><?php echo $transactionRow->Transaction_ID; ?></td>
                                        <td><?php echo $transactionRow->Amount; ?></td>
                                        <td><?php echo $transactionRow->Transaction_Type; ?></td>
                                    </tr>
                                <?php
                                $transactionCount++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
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
