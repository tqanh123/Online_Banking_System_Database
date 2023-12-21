<?php
session_start();
include('conf/config.php');

//register new account
if (isset($_POST['create_account'])) {
  //Register  Client
  $Cus_Name = $_POST['Cus_Name'];
  $National = $_POST['National'];
  $Phone = $_POST['Phone'];
  $Email = $_POST['Email'];
  $Password = sha1(md5($_POST['Password']));
  $Address  = $_POST['Address'];

  //$profile_pic  = $_FILES["profile_pic"]["name"];
  //move_uploaded_file($_FILES["profile_pic"]["tmp_name"],"dist/img/".$_FILES["profile_pic"]["name"]);

  //Insert Captured information to a database table
  $query = "INSERT INTO customers (Cus_Name, National, Phone, Email, Password, Address) VALUES (?,?,?,?,?,?)";
  $stmt = $mysqli->prepare($query);
  //bind paramaters
  $rc = $stmt->bind_param('ssssss', $Cus_Name, $National, $Phone, $Email, $Password, $Address);
  $stmt->execute();

  //declare a varible which will be passed to alert function
  if ($stmt) {
    $success = "Account Created";
  } else {
    $err = "Please Try Again Or Try Later";
  }
}
?>
  <!DOCTYPE html>
  <html><!-- Log on to codeastro.com for more projects! -->
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <?php include("dist/_partials/head.php"); ?>

  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <p>Sign Up</p>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign Up To Use Our Online Banking System</p>

          <form method="post">
            <div class="input-group mb-3">
              <input type="text" name="Cus_Name" required class="form-control" placeholder="Client Full Name">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="text" required name="National" class="form-control" placeholder="National ID Number">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-tag"></span>
                </div>
              </div>
            </div>
            
            <div class="input-group mb-3">
              <input type="text" name="Phone" required class="form-control" placeholder="Client Phone Number">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-phone"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="text" name="Address" required class="form-control" placeholder="Client Address">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-map-marker"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="email" name="Email" required class="form-control" placeholder="Client Address">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div><!-- Log on to codeastro.com for more projects! -->
            <div class="input-group mb-3">
              <input type="password" name="Password" required class="form-control" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" name="create_account" class="btn btn-success btn-block">Sign Up</button>
              </div>
              <!-- /.col -->
            </div>
          </form>

          <p class="mb-0">
            <a href="pages_client_index.php" class="text-center">Login</a>
          </p>

        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>

  </body>

  </html>
<?php
 ?>