<?php
session_start();
$username = $_SESSION["var"];
$password = $_POST["pw"];
$conn = new mysqli("localhost", "root", "", "bank");
//check connection
if ($conn->connect_error) {
    die("connection failed:" . $conn->connect_error);
}
$sql = "SELECT `Password` FROM `users` WHERE Username = '$username'";
$result = $conn->query($sql);
if ($rows = $result->fetch_assoc()) {
    if ($rows['Password'] == $password) {
        $sql_del = "DELETE FROM `users` WHERE Username = '$username'";
        $conn->query($sql_del);
        header('location: ../index.php');
        exit;
    }
}


if (!$result) {
    mysqli_error($conn);
}
mysqli_close($conn);

?>

<html>

<head>
    <title>Loading Page </title>

</head>

<body>
    Bad Login info: <?php if ($loggedin == false) { ?>
        <meta http-equiv='refresh' content='2; ../html/userdashboard.php'><?php } ?>
    <a href="../html/userdashboard.php">Click here if page doesn't automatically redirect</a>
</body>

</html>