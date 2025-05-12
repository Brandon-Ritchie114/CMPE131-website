<html>

<head>
    <title>
        Loading page
    </title>
</head>

<body>
    repeated ID number / username. Employee Not Added.
    <meta http-equiv='refresh' content='1; ../html/employeeRegistration.html'>
    <a href=" ../html/employeeRegistration.html">Click here if page doesn't automatically update</a>
</body>

</html>

<?php
$firstname = $_POST["firstname"];
$middlename = $_POST["middlename"];
$lastname = $_POST["lastname"];
$IDnum = $_POST["IDnum"];
$username = $_POST["username"];
$password = $_POST["pw"];

$conn = new mysqli("localhost", "root", "", "bank");
if (!$conn) {
    die("connection failed:" . mysqli_connect_error());
}

$sql_verify = "SELECT IDNumber, Username FROM `employees` WHERE 1";
$result_verify = $conn->query($sql_verify);
while ($rows = $result_verify->fetch_assoc()) {
    if ($rows['IDNumber'] == $IDnum || $rows['Username'] == $username) {
        exit;
    }
}

$sql = "INSERT INTO employees (FirstName, MiddleName, LastName,IDNumber,Username, Password
) VALUES ('$firstname', '$middlename', '$lastname', $IDnum,'$username', '$password')";
$result = $conn->query($sql);
if ($result) {
    header('location: ../index.php');
    exit;
} else {
    mysqli_error($conn); //error output
}
mysqli_close($conn); //close connection

?>