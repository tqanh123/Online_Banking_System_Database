<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];

$customer_id = $_GET['customer_id'] ?? '';

// if (!empty($customer_id)) {
//     $sql = "SELECT c.Customer_ID, c.Cus_Name AS Customer_Name, c.National, c.Phone, c.Date_of_Birth, c.Gender, c.Address,
//                 l.Loan_ID, l.LoanType_ID, lt.Name AS Loan_Type, lt.Description AS Loan_Type_Description,
//                 l.Loan_Amount AS Loan_Amount, l.Loan_Term, l.Start_Date, l.Status, l.Installment
//                 FROM Customers c
//                 LEFT JOIN Loans l ON c.Customer_ID = l.Customer_ID
//                 LEFT JOIN LoanTypes lt ON l.LoanType_ID = lt.LoanType_ID
//                 WHERE c.Customer_ID = $customer_id;";

//     $result = $mysqli->query($sql);

//     if ($result->num_rows > 0) {
//         $row = $result->fetch_assoc();
//         echo "<h2>Loan Details for Customer Name: " . $row["Customer_Name"] . "</h2>";
//         echo "<p>Loan Amount: " . $row["Loan_Amount"] . "</p>";
//         echo "<p>Loan Type: " . $row["Loan_Type"] . "</p>";
//         echo "<p>Loan Description: " . $row["Loan_Type_Description"] . "</p>";
//         echo "<p>Installment: " . $row["Installment"] . "</p>";
//         echo "<p>Loan Term: ". $row["Loan_Term"] . "</p>";

//         echo "<form method='post' action='process_loan.php'>";
//         echo "<input type='hidden' name='customer_id' value='" . $row["Customer_ID"] . "'>";
//         echo "<input type='submit' name='loan_action' value='Accept Loan'>";
//         echo "<input type='submit' name='loan_action' value='Reject Loan'>";
//         echo "</form>";

//         echo "<h3>Customer Information:</h3>";
//         echo "<table border='1'>";
//         echo "<tr><th>Account Number</th><th>Account Name</th><th>Customer ID</th><th>Account Status</th><th>Account Amount</th><th>Created At</th></tr>";

           
//             echo "<tr>";
//             echo "<td>" . $row["Customer_ID"] . "</td>";
//             echo "<td>" . $row["Customer_Name"] . "</td>";
//             echo "<td>" . $row["National"] . "</td>";
//             echo "<td>" . $row["Date_of_Birth"] . "</td>";
//             echo "<td>" . $row["Gender"] . "</td>";
//             echo "<td>" . $row["Address"] . "</td>";
//             echo "</tr>";

//             echo "</table>";
//         } else {
//             echo "No loan details found for this account number.";
//         }
//     $mysqli->close();
// }
// if ($stmt) {
//   $success = "Loan Accept";
// } else {
//   $err = "Please Try Again Or Try Later";
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
                <?php
                    $sql = "SELECT c.Customer_ID, c.Cus_Name AS Customer_Name, c.National, c.Phone, c.Date_of_Birth, c.Gender, c.Address,
                                l.Loan_ID, l.LoanType_ID, lt.Name AS Loan_Type, lt.Description AS Loan_Type_Description,
                                l.Loan_Amount AS Loan_Amount, l.Loan_Term, l.Start_Date, l.Status, l.Installment
                                FROM Customers c
                                LEFT JOIN Loans l ON c.Customer_ID = l.Customer_ID
                                LEFT JOIN LoanTypes lt ON l.LoanType_ID = lt.LoanType_ID
                                WHERE c.Customer_ID = $customer_id;";

                    $result = $mysqli->query($sql);
                    while ($row = $result->fetch_object()) {
                    ?>
                            <?php echo "<h2>Loan Details for Customer Name: " . $row->Customer_Name . "</h2>";?>
                            <?php echo "<p>Loan Amount: " . $row->Loan_Amount . "</p>";?>
                            <?php echo "<p>Loan Type: " . $row->Loan_Type . "</p>";?>
                            <?php echo "<p>Loan Description: " . $row->Loan_Type_Description . "</p>";?>
                            <?php echo "<p>Installment: " . $row->Installment . "</p>";?>
                            <?php echo "<p>Loan Term: ". $row->Loan_Term . "</p>";?>

                            <form method='post' action='process_loan.php'>
                                <input type='hidden' name='customer_id' value='<?php echo $row->Customer_ID; ?>'>  
                                <button type='submit' name='loan_action' value='accept' class='btn btn-primary'>Accept Loan</button>
                                <button type='submit' name='loan_action' value='reject' class='btn btn-danger'>Reject Loan</button>
                            </form>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover table-striped">
                  <thead>
                    <tr>
                      <th>Customer ID</th>
                      <th>Name</th>
                      <th>National</th>
                      <th>Date of Birth</th>
                      <th>Gender</th>
                      <th>Address</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    

                      <tr>
                        <td><?php echo $row->Customer_ID; ?></td>
                        <td><?php echo $row->Customer_Name; ?></td>
                        <td><?php echo $row->National; ?></td>
                        <td><?php echo $row->Date_of_Birth; ?></td>
                        <td><?php echo $row->Gender; ?></td>
                        <td><?php echo $row->Address; ?></td>
                        <td>
                        <a class="btn btn-success btn-sm" href='show_account_detail.php?customer_id=<?php echo $row->Customer_ID; ?>'>View Statistics</a>
                          </a>
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