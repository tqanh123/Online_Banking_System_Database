<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$Customer_id = $_SESSION['Customer_id'];

/*
    get all dashboard analytics 
    and numeric values from distinct 
    tables
    */

//return total number of ibank clients
$result = "SELECT count(*) FROM Customers";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($Customer_id);
$stmt->fetch();
$stmt->close();


//return total number of iBank Account Types
$result = "SELECT count(*) FROM Acc_types";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($Acc_Types);
$stmt->fetch();
$stmt->close();

//return total number of iBank Accounts
$result = "SELECT count(*) FROM BankAccounts";
$stmt = $mysqli->prepare($result);  
$stmt->execute();
$stmt->bind_result($BankAccounts);
$stmt->fetch();
$stmt->close();

//return total number of iBank Deposits
$Customer_id = $_SESSION['Customer_id'];
$result = "SELECT SUM(Amount) FROM Transactions WHERE  Customer_id = ? AND Transaction_Type = 'Deposit' ";
$stmt = $mysqli->prepare($result);
$stmt->bind_param('i', $Customer_id);
$stmt->execute();
$stmt->bind_result($deposits);
$stmt->fetch();
$stmt->close();

//return total number of iBank Withdrawals
$Customer_id = $_SESSION['Customer_id'];
$result = "SELECT -SUM(Amount) FROM Transactions WHERE  Customer_id = ? AND Transaction_Type = 'Withdrawal' ";
$stmt = $mysqli->prepare($result);
$stmt->bind_param('i', $Customer_id);
$stmt->execute();
$stmt->bind_result($withdrawal);
$stmt->fetch();
$stmt->close();



//return total number of iBank Transfers
$Customer_id = $_SESSION['Customer_id'];
$result = "SELECT -SUM(Amount) FROM Transactions WHERE  Customer_id = ? AND Transaction_Type = 'Transfer' ";
$stmt = $mysqli->prepare($result);
$stmt->bind_param('i', $Customer_id);
$stmt->execute();
$stmt->bind_result($Transfers);
$stmt->fetch();
$stmt->close();

//return total number of  iBank initial cash->balances
$Customer_id = $_SESSION['Customer_id'];
$result = "SELECT SUM(Amount) FROM Transactions  WHERE Customer_id =?";
$stmt = $mysqli->prepare($result);
$stmt->bind_param('i', $Customer_id);
$stmt->execute();
$stmt->bind_result($acc_amt);
$stmt->fetch();
$stmt->close();
//Get the remaining money in the accounts
$TotalBalInAccount = ($deposits)  - (($withdrawal) + ($Transfers));


//ibank money in the wallet
$Customer_id = $_SESSION['Customer_id'];
$result = "SELECT SUM(Amount) FROM Transactions  WHERE Customer_id = ?";
$stmt = $mysqli->prepare($result);
$stmt->bind_param('i', $Customer_id);
$stmt->execute();
$stmt->bind_result($new_amt);
$stmt->fetch();
$stmt->close();
//Withdrawal Computations

?>

<!DOCTYPE html>
<html lang="en">
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
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Client Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!--iBank Deposits -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-upload"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Deposits</span>
                  <span class="info-box-number">
                    $ <?php echo $deposits; ?>
                  </span>
                </div>
              </div>
            </div>
            <!----./ iBank Deposits-->

            <!--iBank Withdrwals-->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-download"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Withdrawals</span>
                  <span class="info-box-number">$ <?php echo $withdrawal; ?> </span>
                </div>
              </div>
            </div>
            <!-- Withdrawals-->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <!--Transfers-->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-random"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Transfers</span>
                  <span class="info-box-number">$ <?php echo $Transfers; ?></span>
                </div>
              </div>
            </div>
            <!-- /.Transfers-->

            <!--Balances-->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-purple elevation-1"><i class="fas fa-money-bill-alt"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Wallet Balance</span>
                  <span class="info-box-number">$ <?php echo $TotalBalInAccount; ?></span>
                </div>
              </div>
            </div>
            <!-- ./Balances-->
          </div>

          
          <!-- /.row -->

          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <div class="col-md-12">
              <!-- TABLE: Transactions -->
              <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">Latest Transactions</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover m-0">
                      <thead>
                        <tr>
                          <th>Transaction Code</th>
                          <th>Account No.</th>
                          <th>Type</th>
                          <th>Amount</th>
                          <!-- <th>Acc. Owner</th> -->
                          <th>Timestamp</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        //Get latest transactions ;
                        $Customer_id = $_SESSION['Customer_id'];
                        $ret = "SELECT * FROM `Transactions` WHERE  Customer_id = ?  ORDER BY Transactions. created_at DESC ";
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
                            <td><?php echo $row->Transaction_ID; ?></a></td>
                            <td><?php echo $row->Customer_ID; ?></td>
                            <td><?php echo $alertClass; ?></td>
                            <td> <?php echo $row->Amount; ?></td>
                            <!-- <td><?php echo $row->Receiving_I; ?></td> -->
                            <td><?php echo date("d-M-Y h:m:s ", strtotime($transTstamp)); ?></td>
                          </tr>

                        <?php } ?>

                      </tbody>
                    </table>
                  </div>
                  <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                  <a href="pages_transactions_engine.php" class="btn btn-sm btn-info float-left">View All</a>
                </div>
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!--/. container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php include("dist/_partials/footer.php"); ?>

  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>

  <!-- OPTIONAL SCRIPTS -->
  <script src="dist/js/demo.js"></script>

  <!-- PAGE PLUGINS -->
  <!-- jQuery Mapael -->
  <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="plugins/raphael/raphael.min.js"></script>
  <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>

  <!-- PAGE SCRIPTS -->
  <script src="dist/js/pages/dashboard2.js"></script>

  <!--Load Canvas JS -->
  <script src="plugins/canvasjs.min.js"></script>
  <!--Load Few Charts-->
  <script>
    window.onload = function() {

      var Piechart = new CanvasJS.Chart("PieChart", {
        exportEnabled: false,
        animationEnabled: true,
        title: {
          text: "Accounts Per Acc Types "
        },
        legend: {
          cursor: "pointer",
          itemclick: explodePie
        },
        data: [{
          type: "pie",
          showInLegend: true,
          toolTipContent: "{name}: <strong>{y}%</strong>",
          indexLabel: "{name} - {y}%",
          dataPoints: [{
              y: <?php
                  //return total number of accounts opened under savings acc type
                  $Customer_id = $_SESSION['Customer_id'];
                  $result = "SELECT count(*) FROM BankAccounts WHERE  acc_type ='Savings' AND Customer_id =? ";
                  $stmt = $mysqli->prepare($result);
                  $stmt->bind_param('i', $Customer_id);
                  $stmt->execute();
                  $stmt->bind_result($savings);
                  $stmt->fetch();
                  $stmt->close();
                  echo $savings;
                  ?>,
              name: "Savings Acc",
              exploded: true
            },

            {
              y: <?php
                  //return total number of accounts opened under  Retirement  acc type
                  $Customer_id  = $_SESSION['Customer_id'];
                  $result = "SELECT count(*) FROM BankAccounts WHERE  acc_type =' Retirement' AND Customer_id =? ";
                  $stmt = $mysqli->prepare($result);
                  $stmt->bind_param('i', $Customer_id);
                  $stmt->execute();
                  $stmt->bind_result($Retirement);
                  $stmt->fetch();
                  $stmt->close();
                  echo $Retirement;
                  ?>,
              name: " Retirement Acc",
              exploded: true
            },

            {
              y: <?php
                  //return total number of accounts opened under  Recurring deposit  acc type
                  $Customer_id  = $_SESSION['Customer_id'];
                  $result = "SELECT count(*) FROM BankAccounts WHERE  acc_type ='Recurring deposit' AND Customer_id =? ";
                  $stmt = $mysqli->prepare($result);
                  $stmt->bind_param('i', $Customer_id);
                  $stmt->execute();
                  $stmt->bind_result($Recurring);
                  $stmt->fetch();
                  $stmt->close();
                  echo $Recurring;
                  ?>,
              name: "Recurring deposit Acc ",
              exploded: true
            },

            {
              y: <?php
                  //return total number of accounts opened under  Fixed Deposit Account deposit  acc type
                  $Customer_id  = $_SESSION['Customer_id'];
                  $result = "SELECT count(*) FROM BankAccounts WHERE  acc_type ='Fixed Deposit Account' AND Customer_id = ? ";
                  $stmt = $mysqli->prepare($result);
                  $stmt->bind_param('i', $Customer_id);
                  $stmt->execute();
                  $stmt->bind_result($Fixed);
                  $stmt->fetch();
                  $stmt->close();
                  echo $Fixed;
                  ?>,
              name: "Fixed Deposit Acc",
              exploded: true
            },

            {
              y: <?php

                  //return total number of accounts opened under  Current account deposit  acc type
                  $Customer_id  = $_SESSION['Customer_id'];
                  $result = "SELECT count(*) FROM BankAccounts WHERE  acc_type ='Current account' AND Customer_id =? ";
                  $stmt = $mysqli->prepare($result);
                  $stmt->bind_param('i', $Customer_id);
                  $stmt->execute();
                  $stmt->bind_result($Current);
                  $stmt->fetch();
                  $stmt->close();
                  echo $Current;
                  ?>,
              name: "Current Acc",
              exploded: true
            }
          ]
        }]
      });

      var AccChart = new CanvasJS.Chart("AccountsPerAccountCategories", {
        exportEnabled: false,
        animationEnabled: true,
        title: {
          text: "Transactions"
        },
        legend: {
          cursor: "pointer",
          itemclick: explodePie
        },
        data: [{
          type: "pie",
          showInLegend: true,
          toolTipContent: "{name}: <strong>{y}%</strong>",
          indexLabel: "{name} - {y}%",
          dataPoints: [{
              y: <?php
                  //return total number of transactions under  Withdrawals
                  $Customer_id  = $_SESSION['Customer_id'];
                  $result = "SELECT count(*) FROM Transactions WHERE  Transaction_Type ='Withdrawal' AND Customer_id =? ";
                  $stmt = $mysqli->prepare($result);
                  $stmt->bind_param('i', $Customer_id);
                  $stmt->execute();
                  $stmt->bind_result($Withdrawals);
                  $stmt->fetch();
                  $stmt->close();
                  echo $Withdrawals;
                  ?>,
              name: "Withdrawals",
              exploded: true
            },

            {
              y: <?php
                  //return total number of transactions under  Deposits
                  $Customer_id  = $_SESSION['Customer_id'];
                  $result = "SELECT count(*) FROM Transactions WHERE  Transaction_Type ='Deposit' AND Customer_id =? ";
                  $stmt = $mysqli->prepare($result);
                  $stmt->bind_param('i', $Customer_id);
                  $stmt->execute();
                  $stmt->bind_result($Deposits);
                  $stmt->fetch();
                  $stmt->close();
                  echo $Deposits;
                  ?>,
              name: "Deposits",
              exploded: true
            },

            {
              y: <?php
                  //return total number of transactions under  Deposits
                  $Customer_id  = $_SESSION['Customer_id'];
                  $result = "SELECT count(*) FROM Transactions WHERE  Transaction_Type ='Transfer' AND Customer_id =? ";
                  $stmt = $mysqli->prepare($result);
                  $stmt->bind_param('i', $Customer_id);
                  $stmt->execute();
                  $stmt->bind_result($Transfers);
                  $stmt->fetch();
                  $stmt->close();
                  echo $Transfers;
                  ?>,
              name: "Transfers",
              exploded: true
            }

          ]
        }]
      });
      Piechart.render();
      AccChart.render();
    }

    function explodePie(e) {
      if (typeof(e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
        e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
      } else {
        e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
      }
      e.chart.render();

    }
  </script>

</body>

</html>