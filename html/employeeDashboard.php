<?php
include '../functions/employeeDashFunc.php';

$filterUsername = isset($_GET['username']) ? trim($_GET['username']) : null;
$usersData = getUsersData($filterUsername);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Robin the Bank - Employee Dashboard</title>
    <link rel="stylesheet" href="../css/employeedash.css">
</head>

<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <!-- Logo Area -->
        <div class="logo">
            <img src="../misc/banklogo.png" alt="Robin the Bank Logo">
        </div>
        <div>
            <h2>Admin Dashboard</h2>
            <div class="nav-item" onclick="showContent('userData')">User Data</div>
            <div class="nav-item" onclick="showContent('editUsers')">Edit Users</div>
        </div>

        <!-- Logout Option (styled as nav item) -->
        <form action="../index.php">
            <input type="submit" value="Logout" />
        </form>
    </div>

    <!-- Content Area -->
    <div class="content">
        <div id="userData" class="placeholder-content">
            <h3>Costumer</h3>
            <form method=" GET" action="">
                <label for="search">Search:</label>
                <input type="text" id="search" name="username" placeholder="Enter Username" required>
                <button type="submit">Search</button>
            </form>
            <?php if (!empty($usersData)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Full Name</th>
                            <th>SNN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usersData as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['Username']); ?></td>
                                <td><?php echo htmlspecialchars($user['Phone']); ?></td>
                                <td><?php echo htmlspecialchars($user['Email']); ?></td>
                                <td><?php echo htmlspecialchars($user['FullName']); ?></td>
                                <td><?php echo htmlspecialchars($user['FormattedSSN']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No user selected. Please search for a user to continue.
                </p>
            <?php endif; ?>
        </div>
        <div id="editUsers" class="placeholder-content" style="display: none;">
            <?php if (!empty($usersData)): ?>
                <h3>Edit Users</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Amount</th>
                            <th>Phone Number</th>
                            <th>Addres 1</th>
                            <th>Address 2</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Zip</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usersData as $user): ?>
                            <tr>

                                <td <?php if ($user['Amount'] >= 0) { ?> class="positive-amount" <?php } else { ?>
                                        class="negative-amount" <?php } ?>>
                                    <?php echo $user['Amount']; ?>
                                </td>
                                <td> <?php echo $user['Phone']; ?></td>
                                <td> <?php echo $user['address1']; ?></td>
                                <td> <?php echo $user['address2']; ?></td>
                                <td> <?php echo $user['City']; ?></td>
                                <td> <?php echo $user['State']; ?></td>
                                <td> <?php echo $user['Zip']; ?></td>
                            </tr>
                            <form action="../functions/employeeDashFunc.php" method="post">
                                <tr>
                                    <td><input type="text" name="amount"></td:>
                                    <td><input type="text" name="phone1" maxlength="3"><input type="text" name="phone2"
                                            maxlength="3"><input type="text" name="phone3" maxlength="4"></td:>
                                    <td><input type="text" name="address1"></td:>
                                    <td><input type="text" name="address2"></td:>
                                    <td><input type="text" name="city"></td:>
                                    <td><input type="text" name="state"></td:>
                                    <td><input type="text" name="zip"></td:>
                                </tr>
                        </tbody>
                    </table>
                    <table>
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Date of Birth</th>
                                <th>Gender</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> <?php echo $user['FirstName']; ?></td>
                                <td> <?php echo $user['MiddleName']; ?></td>
                                <td> <?php echo $user['LastName']; ?></td>
                                <td> <?php echo $user['DOB']; ?></td>
                                <td> <?php echo $user['Gender']; ?></td>
                                <td><?php echo $user['Email']; ?></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="first"></td:>
                                <td><input type="text" name="middle"></td:>
                                <td><input type="text" name="last"></td:>
                                <td><input type="date" name="dob"></td:>
                                <td><input type="text" name="gender"></td:>
                                <td><input type="text" name="email"></td:>

                            </tr>
                        </tbody>
                    </table>
                    <table>
                        <thead>
                            <tr>
                                <th>Confirm Username: <?php echo $user['Username']; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" name="username"></td>
                            </tr>
                        </tbody>
                    </table>

                    <input type="submit" value="Submit" name="submit">
                    </form>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Please select a Costumer to view.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function showContent(tabId) {
            document.querySelectorAll(".placeholder-content").forEach((content) => {
                content.style.display = "none";
            });

            document.querySelectorAll(".nav-item").forEach((item) => {
                item.classList.remove("active");
            });

            document.getElementById(tabId).style.display = "block";
            document
                .querySelector(`.nav-item[onclick="showContent('${tabId}')"]`)
                .classList.add("active");
        }
    </script>
    <!-- AC-->
</body>

</html>