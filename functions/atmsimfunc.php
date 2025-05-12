<html>
<header>
    <title>
        Error Page
    </title>
</header>

<head>
    <meta http-equiv='refresh' content='-1; ../html/atmsimulation.html'>
    <a href=" ../html/atmsimulation.html">Back to ATM</a> Balance:
</head>

</html>
<?php
$username = $_POST["username"];
$amount = $_POST["amount"];
// Connect to the database

$conn = new mysqli("localhost", "root", "", "bank");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deposit'])) {
        $sql_user = "SELECT `Username` FROM `users` WHERE Username = '$username'";
        $result = $conn->query($sql_user);
        if ($result->num_rows === 0) {
            echo "Invalid Account";
            exit;
        } else {
            $sql = "SELECT Amount FROM `users` WHERE Username = '$username'";
            $result = $conn->query($sql);
            if ($row = $result->fetch_assoc()) {
                $total = $row['Amount'] + $amount; //get the difference
            }
            $sql = "UPDATE users SET Amount = '$total' WHERE Username = '$username'";
            $result = $conn->query($sql);
        }

    } else if (isset($_POST['withdraw'])) {
        $sql = "SELECT `Amount` FROM `users` WHERE Username = '$username'";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            if (($row['Amount'] < $amount)) {
                echo "invalid Amount";
                exit;
            } else {
                $total = $row['Amount'] - $amount; //get the difference
            }
        }
        $sql = "UPDATE users SET Amount = '$total' WHERE Username = '$username'";
        $result = $conn->query($sql);
    } else if (isset($_POST['checkbal'])) {
        $sql = "SELECT `Amount` FROM `users` WHERE Username = '$username'";
        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            echo $row["Amount"];
            exit;
        }
    }
}
//error messages

$conn->close();
if ($result) {
    header('location: ../html/atmsimulation.html');

    exit;
}
?>