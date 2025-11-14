<?php
require_once './fn-php/fn-users.php';

$msg_error = "";

if (filter_has_var(INPUT_POST, "loginsubmit")) {

  $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
  $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
  $remember = filter_input(INPUT_POST, 'remember');

  // search user
  $userinfo = searchUser($username);
  
  if ($username === '' || $password === '') {
    $msg_error = "Username and password are required.";
  } else if (count($userinfo) != 0) {  // user found
    // Check password
    if ($userinfo[1] === $password) {
      // start session
      session_start();
      // save data in session
      $_SESSION['role'] = $userinfo[2];
      $_SESSION['name'] = $userinfo[3];
      $_SESSION['surname'] = $userinfo[4];

      
      if ($remember) {
          // 'Remember me' checked -> Save user info in cookies
          setcookie('username', $username, time() + 3*24*60*60, "/"); // 3 days
          setcookie('password', $password, time() + 3*24*60*60, "/");
      } else {
          // 'Remember me' NOT checked -> delete cookie if it exists
          setcookie('username', '', time() - 3600, "/");
          setcookie('password', '', time() - 3600, "/");
      }

      header("Location: index.php");
    } else {  // incorrect password
      $msg_error = "Incorrect password";
    }
  } else {  // user not found
    $msg_error = "User not found";
  }
} else {
  // If cookies exists, fill form with last logged in user's info
    $username = $_COOKIE['username'] ?? '';
    $password = $_COOKIE['password'] ?? '';
}

?>

<?php include_once "topmenu.php"; ?>

<main class="flex-grow-1 d-flex justify-content-center align-items-center">
  <div class="container" style="max-width: 400px;">

    <h2 class="text-center display-4 mb-4 fw-normal">Login Form</h2>

    <div class="card shadow">
      <div class="card-body">
        <?php if ($msg_error): ?>
          <div class="alert alert-danger pt-1 pb-1"><?php echo $msg_error; ?></div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

          <div class="mb-3">
            <label for="username" class="form-label fw-bold">Email:</label>
            <input type="text" class="form-control" id="username" placeholder="Enter username" name="username"
              value="<?php echo $username ?? ""; ?>">
          </div>

          <div class="mb-3">
            <label for="password" class="form-label fw-bold">Password:</label>
            <input type="password" class="form-control" id="password" placeholder="Enter password" name="password"
              value="<?php echo $password ?? ""; ?>">
          </div>

          <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">Remember me</label>
          </div>

          <button type="submit" name="loginsubmit" class="btn btn-dark w-100">Submit</button>

          <p class="text-center mt-3 mb-0">Don't have an account? <a href="register.php">Register</a> </p>

        </form>

      </div>
    </div>
    
  </div>
</main>

<?php include_once "footer.php"; ?>
</body>

</html>