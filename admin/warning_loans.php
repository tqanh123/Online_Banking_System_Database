<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];

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
                    
                    $sql = "SELECT c.Cus_Name AS Customer_Name, l.Status, l.Loan_Amount, lt.Name AS Loan_Type, l.Customer_ID, l.Loan_ID
                            FROM Loans l
                            INNER JOIN LoanTypes lt ON l.LoanType_ID = lt.LoanType_ID
                            INNER JOIN Customers c ON l.Customer_ID = c.Customer_ID
                            WHERE Loan_ID IN (select Loan_ID 
                                              from Loans ll
                                              WHERE DATE_ADD(ll.Start_Date, INTERVAL ll.Loan_Term MONTH) < NOW())
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