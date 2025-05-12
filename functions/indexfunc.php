<?php
session_start();
$loggedin = false;
$error = "";
if (isset($_POST["Username"]) && isset($_POST["Password"])) {
    if ($_POST["Username"] && $_POST["Password"]) {
        $username = $_POST["Username"];
        $_SESSION["var"] = $username;
        $password = $_POST["Password"];
        //check connection
        $conn = mysqli_connect("localhost", "root", "", "bank");
        //check connection
        if (!$conn) {
            die("connection failed:" . mysqli_connect_error());
        }
        $sql = "SELECT 'users' AS tablename,`Username`, `Password` FROM users WHERE `Username` = '$username' 
        UNION 
        SELECT 'employees' AS tablename, `Username`, `Password` FROM employees WHERE `Username` = '$username'";
        $result = $conn->query(query: $sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row["Password"] == $password) {
                    if ($row["tablename"] == "users") {
                        $loggedin = true;
                        header('location: ../html/userdashboard.php?variable=' . $username);
                        exit();
                    } else if ($row["tablename"] == "employees") {
                        header('location: ../html/employeedashboard.php');
                        exit();
                    }
                } else {
                    echo mysqli_error($conn);
                }
            }

        }
        //echo "Table: " . $row["tablename"] . ", Password: " . $row["Password"] . "<br>";
    }
    mysqli_close($conn); //close connection
} else {
    echo "Username or PW is empty";
}

?>

<html>

<head>
    <title>
        Loading Page
    </title>
</head>

<body>
    Bad Login info: <?php if ($loggedin == false) { ?>
        <meta http-equiv='refresh' content='2; ../index.php'><?php } ?>
    <a href="../index.php">Click here if page doesn't automatically redirect</a>
</body>

</html>