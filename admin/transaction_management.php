<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];

$sql = "SELECT * FROM `Transaction` WHERE Status = 'Pending'";

$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    echo "<h2>Pending Transactions</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Transaction ID</th><th>Customer ID</th><th>Amount</th><th>Status</th><th>Action</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Transaction_ID"] . "</td>";
        echo "<td>" . $row["Customer_ID"] . "</td>";
        echo "<td>" . $row["Amount"] . "</td>";
        echo "<td>" . $row["Status"] . "</td>";
        echo "<td><a href='confirm_transaction.php?id=" . $row["Transaction_ID"] . "'>Confirm</a></td>";
        echo "<td><a href='reject_transaction.php?id=" . $row["Transaction_ID"] . "'>Reject</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No pending transactions.";
}

$conn->close();
?>