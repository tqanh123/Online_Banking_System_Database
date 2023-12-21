<?php
session_start();
include('conf/config.php');
if (isset($_POST['login'])) {
  $Email = $_POST['Email'];
  $Password = sha1(md5($_POST['Password']));
  $stmt = $mysqli->prepare("SELECT Email, Password, Customer_ID  FROM  Customers   WHERE Email=? AND Password=?");
  $stmt->bind_param('ss', $Email, $Password); 
  $stmt->execute(); 
  $stmt->bind_result($Email, $Password, $Customer_ID);
  $rs = $stmt->fetch();
  $_SESSION['Customer_id'] = $Customer_ID; 
  //$uip=$_SERVER['REMOTE_ADDR'];
  //$ldate=date('d/m/Y h:i:s', time());
  if ($rs) { 
    // $success = $_SESSION['Customer_id'];
    header("location:pages_dashboard.php");
  } else {
    #echo "<script>alert('Access Denied Please Check Your Credentials');</script>";
    $err = "Access Denied Please Check Your Credentials";
  }
}
?>
  <!DOCTYPE html>
  <html>
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <?php include("dist/_partials/head.php"); ?>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
       <p>Online Banking System</p>
      </div><!-- Log on to codeastro.com for more projects! -->
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Log In To Start User Session</p>

          <form method="post">
            <div class="input-group mb-3">
              <input type="Email" name="Email" class="form-control" placeholder="Email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="Password" name="Password" class="form-control" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="remember">
                  <label for="remember">
                    Remember Me
                  </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" name="login" class="btn btn-success btn-block">Log In</button>
              </div>
              <!-- /.col -->
            </div>
          </form>


          <!-- /.social-auth-links -->

          <!-- <p class="mb-1">
            <a href="pages_reset_pwd.php">I forgot my password</a>
          </p> -->


          <p class="mb-0">
            <a href="pages_client_signup.php" class="text-center">Register a new account</a>
          </p><!-- Log on to codeastro.com for more projects! -->

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