<html>
<header>
    <title>
        Error Page
    </title>
</header>

<head>
    <meta http-equiv='refresh' content='2; ../html/userdashboard.php'>
    <a href=" ../html/userdashboard.php">Click here if page doesn't automatically update</a> Error:
</head>

</html>
<?php
session_start();
$useraccount = $_SESSION["var"];
$recipientaccount = $_POST["recipientaccount"];
$transferamount = $_POST["transferamount"];
// Connect to the database
$conn = new mysqli("localhost", "root", "", "bank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//error messages
$sql_user = "SELECT `Username` FROM `users` WHERE Username = '$recipientaccount'";
$result = $conn->query($sql_user);
if ($result->num_rows === 0) {
    echo "Invalid Account";
    exit;
}

$sql = "SELECT `Amount` FROM `users` WHERE Username = '$useraccount'";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    if (($row['Amount'] < $transferamount)) {
        echo "invalid Amount";
        exit;
    } else {
        $total = $row['Amount'] - $transferamount; //get the difference
    }
}
//update user account 
$sql = "UPDATE users SET Amount = '$total' WHERE Username = '$useraccount'";
$result = $conn->query($sql);



//get recipient account value and add transferamt
$sql = "SELECT Amount FROM `users` WHERE Username = '$recipientaccount'";
$result = $conn->query($sql);
if ($row = $result->fetch_assoc()) {
    $total = $row['Amount'] + $transferamount; //get the difference
} else {
    echo mysqli_error($conn);

}
//update recipient account
$sql = "UPDATE users SET Amount = '$total' WHERE Username = '$recipientaccount'";
$result = $conn->query($sql);

$conn->close();
if ($result) {
    header('location: ../html/userdashboard.php');
    exit;
}
?>