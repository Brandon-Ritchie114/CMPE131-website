<?php
session_start();
$username = $_SESSION["var"];
$conn = new mysqli("localhost", "root", "", "bank");
//check connection

if ($conn->connect_error) {
  die("connection failed:" . $conn->connect_error);
}


$user_sql = "SELECT * FROM users WHERE `Username` = '$username'"; //grab all data
$result = $conn->query($user_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Robin the Bank - Employee Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
      <h2>User Dashboard</h2>
      <div class="nav-item" onclick="showContent('overview')">Overview</div>
      <div class="nav-item" onclick="showContent('userData')">User Information</div>
      <div class="nav-item" onclick="showContent('Transfer')">Transfer</div>
      <div class="nav-item" onclick="showContent('atmTransactions')">Transactions</div>
      <div class="nav-item" onclick="showContent('settings')">Settings</div>
    </div>

    <!-- Logout Option (styled as nav item) -->
    <form action="../index.php">
      <input type="submit" value="Logout" />
    </form>
  </div>

  <!-- Content Area -->
  <div class="content">
    <div id="overview" class="placeholder-content">
      <?php while ($rows = $result->fetch_assoc()) { ?>
        <h3>Welcome Back <?php echo $rows['FirstName']; ?></h3>

        <table>
          <tr>
            <th>Name</th>
            <th>Account Type</th>
            <th>Balance</th>
          </tr>
          <tr>
            <th><?php echo $rows['FirstName']; ?></th>
            <th> <?php if ($rows['accttype'] == 1) { ?> Checking <?php } else { ?>Savings</th><?php } ?>
            <th>$<?php echo $rows['Amount']; ?></th$>
          </tr>

        </table>
        <p class="placeholder"></p>
      </div>
      <div id="userData" class="placeholder-content" style="display: none;">
        <h3>User Information</h3>
        <table>
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>PhoneNumber</th>
            <th>Address</th>
            <th>City</th>
            <th>State</th>
            <th>Zip</th>
            <th>Username</th>
            <th>Email</th>
          </tr>
          <?php

          ?>
          <tr>
            <td><?php echo $rows['FirstName']; ?></td>
            <td><?php echo $rows['LastName']; ?></td>
            <td><?php echo $rows['phone1'] .
              $rows['phone2'] .
              $rows['phone3'];
            ?></td>
            <td><?php echo $rows['address1']; ?></td>
            <td><?php echo $rows['City']; ?></td>
            <td><?php echo $rows['State']; ?></td>
            <td><?php echo $rows['Zip']; ?></td>
            <td><?php echo $rows['Username']; ?></td>
            <td><?php echo $rows['Email']; ?></td>
          </tr>
        </table>
      </div>
      <?php
      }
      ?>
    <div id="Transfer" class="placeholder-content" style="display: none;">
      <div class="container">
        <h1>Fund Transfer</h1>
        <form action='../functions/fundtransferFunc.php' method="post">
          <label>Recipient Account Number:</label>
          <input type="text" name="recipientaccount" required><br>

          <label>Amount to Transfer:</label>
          <input type="number" name="transferamount" min="0.01" step="0.01" required><br>

          <input type="submit" Value="Transfer">
        </form>
        <button class="button" onclick="alert('Connecting to support...')">Chat with Support</button>
        <footer>
          &copy; 2024 Robin the Bank. All rights reserved.
        </footer>
      </div>
      <script>
        function usersubmit(event) {
          event.preventDefault();
          const recipientAccount = document.getElementById("recipientaccount").value;
          const transferAmount = parseFloat(document.getElementById("transferAmount").value);
          if (isNaN(transferAmount) || transferAmount <= 0) {
            alert("Please enter a valid positive amount to transfer.");
            return;
          }

          const receiptUrl = `receipt.html?recipientaccount=${encodeURIComponent(recipientAccount)}&transferAmount=${encodeURIComponent(transferAmount)}`;
          window.open(receiptUrl, '_blank');

          alert('Your fund transfer request has been successfully submitted.');
          window.location.reload();
        }
      </script>
    </div>
    <div id="atmTransactions" class="placeholder-content" style="display: none;">
      <h3>ATM Transactions</h3>
      <table>
        <thead>
          <tr>
            <th>User</th>
            <th>Amount</th>
            <th>Location</th>
            <th>Date</th>
            <th>Time</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>john_doe</td>
            <td class="positive-amount">$100.00</td>
            <td>Location A</td>
            <td>2024-11-13</td>
            <td>15:00</td>
          </tr>
          <tr>
            <td>jane_smith</td>
            <td class="negative-amount">-$50.00</td>
            <td>Location B</td>
            <td>2024-11-12</td>
            <td>10:30</td>
          </tr>
          <tr>
            <td>mark_twain</td>
            <td class="positive-amount">$200.00</td>
            <td>Location C</td>
            <td>2024-11-11</td>
            <td>13:20</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div id="settings" class="placeholder-content" style="display: none;">

      <h3>Settings</h3>
      <form action="../functions/deleteacct.php" method="post">
        <label>Delete Account</label><br>
        <input type="password" id="password" name="pw" placeholder="Password" onkeyup='check();' required><br>
        <input type="password" id="confirm_password" placeholder="Confirm Password" onkeyup='check();' required><br>
        <br>
        <span id="message"></span><br>
        <input type="submit" Value="Delete Account">
      </form>

    </div>

    <script>
      // Function to handle displaying the content for each tab
      function showContent(tabId) {
        // Hide all placeholder content sections
        document.querySelectorAll('.placeholder-content').forEach(content => {
          content.style.display = 'none';
        });

        // Remove 'active' class from all navigation items
        document.querySelectorAll('.nav-item').forEach(item => {
          item.classList.remove('active');
        });

        // Show the selected content and set active class on the nav item
        document.getElementById(tabId).style.display = 'block';
        document.querySelector(`.nav-item[onclick="showContent('${tabId}')"]`).classList.add('active');
      }
    </script>

    <script src="../functions/passwordcheck.js"></script>
    <?php $conn->close();
    ?>
</body>

</html>