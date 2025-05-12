<?php
function connectDatabase()
{
    $host = "localhost";
    $dbname = "bank";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Connection Error " . $e->getMessage());
    }
}

function formatSSN($ssn1, $ssn2, $ssn3)
{
    return '***-**-' . $ssn3;
}
function getUsersData($filterUsername = null)
{
    $conn = connectDatabase();

    try {
        if ($filterUsername) {
            $query = "SELECT 
                        Username, 
                        CONCAT(phone1, '-', phone2, '-', phone3) AS Phone, 
                        Email, 
                        CONCAT(FirstName, ' ', MiddleName, ' ', LastName) AS FullName,
                        ssn1, ssn2, ssn3, Amount, address1, address2, City, State, Zip, Email, FirstName, LastName,MiddleName,Gender,DOB
                      FROM users    
                      WHERE Username LIKE :username";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':username', $filterUsername, PDO::PARAM_STR);
        } else {

            return [];
        }

        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as &$user) {
            $user['FormattedSSN'] = formatSSN($user['ssn1'], $user['ssn2'], $user['ssn3']);
        }

        return $users;

    } catch (PDOException $e) {
        die("Error: Could not get any data. " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit'])) {
    // $username = $_GET["Username"];
    $firstname = $_POST["first"];
    $middlename = $_POST["middle"];
    $lastname = $_POST["last"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $email = $_POST["email"];
    $phone1 = $_POST["phone1"];
    $phone2 = $_POST["phone2"];
    $phone3 = $_POST["phone3"];
    $address1 = $_POST["address1"];
    $address2 = $_POST["address2"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zip = $_POST["zip"];
    $amount = $_POST["amount"];
    $username = $_POST["username"];
    $conn = new mysqli("localhost", "root", "", "bank");
    if (!$conn) {
        die("Connection failed:" . mysqli_connect_error());
    }
    /*$sql = "UPDATE `users` SET FirstName = '$firstname', MiddleName = '$middlename',LastName = '$lastname',DOB = '$dob',Gender = '$gender',Email = '$email',
    phone1 = '$phone1', phone2 = '$phone2', phone3 = '$phone3', address1 = '$address1', address2 = '$address2', City = '$city', State = '$state',
    Zip = '$zip', Amount = '$amount' WHERE 1";*/
    if ($_POST["first"] != "") {
        $sql = "UPDATE `users` SET FirstName = '$firstname' WHERE Username = '$username'";
        $result = $conn->query($sql);
    }
    if ($_POST["middle"] != "") {
        $sql = "UPDATE `users` SET MiddleName = '$middlename' WHERE Username = '$username'";
        $result = $conn->query($sql);
    }
    if ($_POST["last"] != "") {
        $sql = "UPDATE `users` SET LastName = '$lastname' WHERE Username = '$username'";
        $result = $conn->query($sql);
    }
    if ($_POST["dob"] != "") {
        $sql = "UPDATE `users` SET DOB = '$dob' WHERE Username = '$username'";
        $result = $conn->query($sql);
    }
    if ($_POST["gender"] != "") {
        $sql = "UPDATE `users` SET Gender = '$gender' WHERE Username = '$username'";
        $result = $conn->query($sql);
    }
    if ($_POST["phone1"] != "") {
        $sql = "UPDATE `users` SET phone1 = '$phone1' WHERE Username = '$username'";
        $result = $conn->query($sql);
    }
    if ($_POST["phone2"] != "") {
        $sql = "UPDATE `users` SET phone2 = '$phone2' WHERE Username = '$username'";
        $result = $conn->query($sql);
    }
    if ($_POST["phone3"] != "") {
        $sql = "UPDATE `users` SET phone3 = '$phone3' WHERE Username = '$username'";
        $result = $conn->query($sql);
    }
    if ($_POST["address1"] != "") {
        $sql = "UPDATE `users` SET address1 = '$address1' WHERE Username = '$username'";
        $result = $conn->query($sql);
    }
    if ($_POST["address2"] != "") {
        $sql = "UPDATE `users` SET address1 = '$address1' WHERE Username = '$username'";
        $result = $conn->query($sql);
    }
    if ($_POST["city"] != "") {
        $sql = "UPDATE `users` SET City = '$city' WHERE Username = '$username'";
        $result = $conn->query($sql);
    }
    if ($_POST["state"] != "") {
        $sql = "UPDATE `users` SET State = '$state' WHERE Username = '$username'";
        $result = $conn->query($sql);
    }
    if ($_POST["zip"] != "") {
        $sql = "UPDATE `users` SET Zip = '$zip' WHERE Username = '$username'";
        $result = $conn->query($sql);
    }
    if ($_POST["amount"] != "") {
        $sql = "UPDATE `users` SET Amount = '$amount' WHERE Username = '$username'";
        $result = $conn->query($sql);
    }
    if ($_POST["email"] != "") {
        $sql = "UPDATE `users` SET Email = '$email' WHERE Username = '$username'";
        $result = $conn->query($sql);
    }
    $conn->close();
    if ($result) {
        header('location: ../html/employeedashboard.php');
        exit;
    }
}
?>