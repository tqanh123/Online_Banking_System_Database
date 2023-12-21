<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];

// $searchCustomerID = $_GET['customer_id'] ?? '';

// $sql = "SELECT * FROM Customers";
// if (!empty($searchCustomerID)) {
//     $sql .= " WHERE Customer_ID = $searchCustomerID";
// }

// if ($mysqli->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// $result = $mysqli->query($sql);

// if ($result->num_rows > 0) {
//     echo "<h2>List of Customers</h2>";
//     echo "<table border='1'>";
//     echo "<tr><th>Customer ID</th><th>Name</th><th>Nationality</th><th>Phone</th><th>Date of Birth</th><th>Gender</th><th>Address</th><th>Email</th><th>Profile Pic</th></tr>";

//     while ($row = $result->fetch_assoc()) {
//         echo "<tr>";
//         echo "<td><a href='show_account_detail.php?customer_id=" . $row["Customer_ID"] . "'>" . $row["Customer_ID"] . "</a></td>";
//         echo "<td><a href='show_account_detail.php?customer_id=" . $row["Customer_ID"] . "'>" . $row["Cus_Name"] . "</a></td>";
//         echo "<td>" . $row["National"] . "</td>";
//         echo "<td>" . $row["Phone"] . "</td>";
//         echo "<td>" . $row["Date_of_Birth"] . "</td>";
//         echo "<td>" . $row["Gender"] . "</td>";
//         echo "<td>" . $row["Address"] . "</td>";
//         echo "<td>" . $row["Email"] . "</td>";
//         echo "<td>" . $row["Profile_pic"] . "</td>";
//         echo "</tr>";
//     }

//     echo "</table>";
// } else {
//     echo "No customers found.";
// }

?>

<!-- <h2>Search Customer by ID</h2>
<form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    Customer ID: <input type="text" name="customer_id">
    <input type="submit" value="Search">
</form> -->

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
                <h3 class="card-title">Select on any account to view statistics</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Customer Name</th>
                      <th>National</th>
                      <th>Date_of_Birth</th>
                      <th>Gender</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT * FROM Customers";

                    $result = $mysqli->query($sql);
                    $cnt = 1;
                    while ($row = $result->fetch_object()) {

                    ?>

                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $row->Cus_Name; ?></td>
                        <td><?php echo $row->National; ?></td>
                        <td><?php echo $row->Date_of_Birth; ?></td>
                        <td><?php echo $row->Gender; ?></td>
                        <td><?php echo $row->Email; ?></td>
                        <td><?php echo $row->Address; ?></td>
                        <!-- <td><?php echo $row->client_name; ?></td> -->
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
