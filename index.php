<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Robin the Bank Login Page</title>
  <link rel="stylesheet" href="/css/index.css">
</head>

<body>
  <div class="container">
    <img src="/misc/banklogo.png" alt="Robin the Bank Logo" class="logo">
    <h1> Login Page</h1>
    <h2>Secure Login</h2>

    <form action="/functions/indexfunc.php" method="post">
      <input type="text" id="username" name=Username placeholder="Username" required>
      <input type="password" id="password" name=Password placeholder="Password" required>

      <div class="remember-me">
        <input type="checkbox" id="remember-me">
        <label for="remember-me">Remember me</label>
      </div>

      <input type="submit" value=Submit>
    </form>

    <button class="button" onclick="supportMessage()">Chat with Support</button>

    <a class="link" href="html/forgotpw.html">Forgot your password?</a>
    <a class="link" href="html/registration.html">Don't have an account? Register here</a>

    <footer>
      &copy; 2024 Robin the Bank. All rights reserved.
    </footer>
  </div>

  <script>
    function supportMessage() {
      alert('Support not available...');
    }
  </script>
</body>

</html>