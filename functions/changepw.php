<html>


<head>
    <title>
        Loading Page
    </title>
    <meta http-equiv='refresh' content='1; ../index.php'>

</head>

</html>
<?php
$username = $_POST["username"];
$password = $_POST["pw"];
$securityQuestion = $_POST["securityQuestion"];
$string1 = "";
$id;
$conn = new mysqli("localhost", "root", "", "bank");
if (!$conn) {
    die("connection Failed: " . mysqli_connect_error());
}

$sql = "SELECT `securityQuestion` FROM `users` WHERE Username = '$username'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // Fetch the row and extract the string
    while ($row = $result->fetch_assoc()) {
        // Assuming 'column_name' is the column where the string is stored
        $string1 = $row['securityQuestion'];
    }
}

if ($securityQuestion === $string1) {
    $sql_update = "UPDATE `users` SET `Password` = '$password' WHERE Username = '$username'";
    $conn->query($sql_update);
    echo "Password reset!";
} else {
    echo "Security question wrong or incorrect username";
}


if (!$result) {
    mysqli_error($conn); //error output
}
mysqli_close($conn); //close connection
?>