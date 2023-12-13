<?php
include("./includes/connect.php");
session_start();
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form login and register</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <div class="login">
        <h1>Log in platform</h1>
        <h4>Welcome to our E-Commerce Website</h4>
        <form method="POST" action="">
            <label>User Name</label>
            <input type="text" placeholder="Enter your phone number" autocomplete="off" name="mail" required>
            <label>Password</label>
            <input type="password" placeholder="Enter your password" autocomplete="off" name="pass" required>
            <input type="submit" name="user_login" value="Submit">
        </form>
        <p>Not have an account? <a href="signup.php">Sign up Here</a></p>
    </div>
</body>

</html>

<?php


if (isset($_POST['user_login'])) {
    $username = $_POST['mail'];
    $password = $_POST['pass'];
    $select_query = "Select * from `account` where username='$username'";
    $result = mysqli_query($conn, $select_query);
    $row_count = mysqli_num_rows($result);
    $row_data = mysqli_fetch_assoc($result);


    if (!empty($username) && !empty($password) && !is_numeric($username)) {
        if ($row_count === 0) {
            echo "<script>alert('username does not exist')</script>";
        } else if (password_verify($password, $row_data['Password'])) {

            $select = "Select * 
                           from `customer` c, `account` a 
                           where c.account_id = a.account_id and a.username = '$username'";
            $res = mysqli_query($conn, $select);
            $row_cuss = mysqli_num_rows($res);

            if ($row_cuss > 0) {

                $row = mysqli_fetch_assoc($res);
                $_SESSION['Cart_ID'] = $row['Customer_ID'];
                $_SESSION['username'] = $username;
                echo "<script>window.open('home.php','_self')</script>";
                // echo $_SESSION['username'];

                // echo"<script>alert('Login successful!')</scipt>"
                // if($row_count==1 and $row_count_cart==0){
                //     echo"<script>alert('Login successful!')</scipt>";
                //     echo"<script>window.open('profile.php','_self')</script>";
                // }else{
                //     echo"<script>alert('Login successful!')</scipt>";
                //     echo"<script>window.open('payment.php','_self')</script>";
                // }
            } else {
                echo "<script>alert('go to shop')</script>";
                $_SESSION['username'] = $username;
                echo "<script>window.open('../Seller/shop.php','_self')</script>";
            }
        } else {
            echo "<script type='text/javascript'> alert('Password do not match! Please try again!')</script>";
        }
    } else {
        echo "<script type='text/javascript'> alert('Please enter some Valid Information')</script>";
    }
}
?>