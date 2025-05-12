<html>

<head>
    <title>
        Loading page
    </title>
    <meta http-equiv='refresh' content='1; ../index.php'>
</head>

<body>
    repeated Username. User Not Added.
    <meta http-equiv='refresh' content='2; ../html/registration.html'>
    <a href=" ../html/registration.html">Click here if page doesn't automatically update</a>
</body>

</html>

<?php
$firstname = $_POST["firstname"];
$middlename = $_POST["middlename"];
$lastname = $_POST["lastname"];
$dob = $_POST["dob"];
$gender = $_POST["gender"];
$email = $_POST["email"];
$phone1 = $_POST["phone1"];
$phone2 = $_POST["phone2"];
$phone3 = $_POST["phone3"];
$address1 = $_POST["address1"];
$address2 = $_POST["address2"];
$city = $_POST["city"];
$state = $_POST["stat"];
$zip = $_POST["zip"];
$ssn1 = $_POST["ssn1"];
$ssn2 = $_POST["ssn2"];
$ssn3 = $_POST["ssn3"];
$username = $_POST["username"];
$password = $_POST["pw"];
$ans = $_POST["ans"];
$aboutUs = $_POST["aboutUs"];
$accttype = $_POST["accttype"];

$conn = new mysqli("localhost", "root", "", "bank");
if (!$conn) {
    die("connection failed:" . mysqli_connect_error());
}

$sql_verify = "SELECT Username FROM `users` WHERE 1";
$result_verify = $conn->query($sql_verify);
while ($rows = $result_verify->fetch_assoc()) {
    if ($rows['Username'] == $username) {
        exit;
    }
}

$sql = "INSERT INTO users (FirstName, MiddleName, LastName, DOB, Gender, Email, phone1, phone2, phone3, address1, address2, City, State, Zip, ssn1, ssn2, ssn3, Username, Password, securityQuestion, 
aboutUs, accttype) VALUES ('$firstname', '$middlename', '$lastname', '$dob', '$gender', '$email', '$phone1', '$phone2', '$phone3', '$address1', '$address2', '$city', '$state', '$zip', '$ssn1', 
'$ssn2', '$ssn3' ,'$username', '$password', '$ans', '$aboutUs', '$accttype')";
$result = $conn->query($sql);
if ($result) {
    header('location: ../index.php');
} else {
    mysqli_error($conn); //error output
}
mysqli_close($conn); //close connection

?>