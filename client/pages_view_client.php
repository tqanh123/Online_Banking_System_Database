<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$Customer_id = $_SESSION['Customer_id'];

if (isset($_POST['update_client_account'])) {
    //update client
    $Cus_Name = $_POST['Cus_Name'];
    $National = $_POST['National'];
    $Phone = $_POST['Phone'];
    $Email = $_POST['Email'];
    //$Password = sha1(md5($_POST['Password']));
    $Address  = $_POST['Address'];

    $profile_pic  = $_FILES["profile_pic"]["Cus_Name"];
    move_uploaded_file($_FILES["profile_pic"]["tmp_Cus_Name"], "dist/img/" . $_FILES["profile_pic"]["Cus_Name"]);

    //Insert Captured information to a database table
    $query = "UPDATE  Customers SET Cus_Name=?, National=?, Phone=?, Email=?, Address=?, profile_pic=?";
    $stmt = $mysqli->prepare($query);
    //bind paramaters
    $rc = $stmt->bind_param('sssssss', $Cus_Name, $National, $Phone, $Email,  $Address, $profile_pic);
    $stmt->execute();

    //declare a varible which will be passed to alert function
    if ($stmt) {
        $success = "Client Account Updated";
    } else {
        $err = "Please Try Again Or Try Later";
    }
}
//change Password
if (isset($_POST['change_client_Password'])) {
    $Password = sha1(md5($_POST['Password']));
    //insert unto certain table in database
    $query = "UPDATE Customers  SET Password=?";
    $stmt = $mysqli->prepare($query);
    //bind paramaters
    $rc = $stmt->bind_param('ss', $Password);
    $stmt->execute();
    //declare a varible which will be passed to alert function
    if ($stmt) {
        $success = "Client Password Updated";
    } else {
        $err = "Please Try Again Or Try Later";
    }
}


?>
<!-- Log on to codeastro.com for more projects! -->
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
            <!-- Content Header with logged in user details (Page header) -->
            <?php
            // $client_number = $_GET['client_number'];
            // $ret = "SELECT * FROM  Customers  WHERE client_number = ? ";
            // $stmt = $mysqli->prepare($ret);
            // $stmt->bind_param('s', $client_number);
            // $stmt->execute(); //ok
            // $res = $stmt->get_result();
            // while ($row = $res->fetch_object()) {
                //set automatically logged in user default image if they have not updated their pics
                if ($row->profile_pic == '') {
                    $profile_picture = "

                        <img class='img-fluid'
                        src='dist/img/user_icon.png'
                        alt='User profile picture'>

                        ";
                } else {
                    $profile_picture = "

                        <img class=' img-fluid'
                        src='dist/img/$row->profile_pic'
                        alt='User profile picture'>

                        ";
                }


            ?>
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1><?php echo $row->Cus_Name; ?> Profile</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="pages_manage_clients.php">iBanking Clients</a></li>
                                    <li class="breadcrumb-item"><a href="pages_manage_clients.php">Manage</a></li>
                                    <li class="breadcrumb-item active"><?php echo $row->Cus_Name; ?></li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3">

                                <!-- Profile Image -->
                                <div class="card card-purple card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <?php echo $profile_picture; ?>
                                        </div>

                                        <h3 class="profile-userCus_Name text-center"><?php echo $row->Cus_Name; ?></h3>

                                        <p class="text-muted text-center">Client @iBanking </p>

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>ID No.: </b> <a class="float-right"><?php echo $row->National; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Email: </b> <a class="float-right"><?php echo $row->Email; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Phone: </b> <a class="float-right"><?php echo $row->Phone; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>ClientNo: </b> <a class="float-right"><?php echo $row->client_number; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Address: </b> <a class="float-right"><?php echo $row->Address; ?></a>
                                            </li>

                                        </ul>

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->

                                <!-- About Me Box 
                    <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">About Me</h3>
                    </div>
                    <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> Education</strong>

                        <p class="text-muted">
                        B.S. in Computer Science from the University of Tennessee at Knoxville
                        </p>

                        <hr>

                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                        <p class="text-muted">Malibu, California</p>

                        <hr>

                        <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                        <p class="text-muted">
                        <span class="tag tag-danger">UI Design</span>
                        <span class="tag tag-success">Coding</span>
                        <span class="tag tag-info">Javascript</span>
                        <span class="tag tag-warning">PHP</span>
                        <span class="tag tag-primary">Node.js</span>
                        </p>

                        <hr>

                        <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                    </div>
                    </div>
                    <!-- /.card -->
                            </div>

                            <!-- /.col -->
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#update_Profile" data-toggle="tab">Update Profile</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#Change_Password" data-toggle="tab">Change Password</a></li>
                                        </ul>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <!-- / Update Profile -->
                                            <div class="tab-pane active" id="update_Profile">
                                                <form method="post" enctype="multipart/form-data" class="form-horizontal">
                                                    <div class="form-group row">
                                                        <label for="inputCus_Name" class="col-sm-2 col-form-label">Cus_Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" Cus_Name="Cus_Name" required class="form-control" value="<?php echo $row->Cus_Name; ?>" id="inputCus_Name">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                                        <div class="col-sm-10">
                                                            <input type="Email" Cus_Name="Email" required value="<?php echo $row->Email; ?>" class="form-control" id="inputEmail">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputCus_Name2" class="col-sm-2 col-form-label">Contact</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" required Cus_Name="Phone" value="<?php echo $row->Phone; ?>" id="inputCus_Name2">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputCus_Name2" class="col-sm-2 col-form-label">National ID Number</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" required readonly Cus_Name="National" value="<?php echo $row->National; ?>" id="inputCus_Name2">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputCus_Name2" class="col-sm-2 col-form-label">Address</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" required Cus_Name="Address" value="<?php echo $row->Address; ?>" id="inputCus_Name2">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputCus_Name2" class="col-sm-2 col-form-label">Profile Picture</label>
                                                        <div class="input-group col-sm-10">
                                                            <div class="custom-file">
                                                                <input type="file" Cus_Name="profile_pic" class=" form-control custom-file-input" id="exampleInputFile">
                                                                <label class="custom-file-label  col-form-label" for="exampleInputFile">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="offset-sm-2 col-sm-10">
                                                            <button Cus_Name="update_client_account" type="submit" class="btn btn-outline-success">Update Account</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- /Change Password -->
                                            <div class="tab-pane" id="Change_Password">
                                                <form method="post" class="form-horizontal">
                                                    <div class="form-group row">
                                                        <label for="inputCus_Name" class="col-sm-2 col-form-label">Old Password</label>
                                                        <div class="col-sm-10">
                                                            <input type="Password" class="form-control" required id="inputCus_Name">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail" class="col-sm-2 col-form-label">New Password</label>
                                                        <div class="col-sm-10">
                                                            <input type="Password" Cus_Name="Password" class="form-control" required id="inputEmail">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputCus_Name2" class="col-sm-2 col-form-label">Confirm New Password</label>
                                                        <div class="col-sm-10">
                                                            <input type="Password" class="form-control" required id="inputCus_Name2">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="offset-sm-2 col-sm-10">
                                                            <button type="submit" Cus_Name="change_client_Password" class="btn btn-outline-success">Change Password</button>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                            <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                    </div><!-- /.card-body -->
                                </div>
                                <!-- /.nav-tabs-custom -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->

            <?php //} ?>
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
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
</body>

</html>