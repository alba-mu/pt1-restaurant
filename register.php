<?php
require_once './fn-php/fn-users.php';

$msg_error = "";
$msg_success = "";
$inserted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && filter_has_var(INPUT_POST, "registersubmit")) {

  $username = trim(filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS));
  $password = trim(filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS));
  $name = trim(filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS));
  $surname = trim(filter_input(INPUT_POST, "surname", FILTER_SANITIZE_SPECIAL_CHARS));

  // Basic validations
  if ($username === '' || $password === '' || $name === '' || $surname === '') {
    $msg_error = "All fields are required.";

    // Password validation (minimum 4 characters and 1 number)
  } elseif (strlen($password) < 4) {
    $msg_error = "The password must have at least 4 characters.";
  } elseif (!preg_match("#[0-9]+#", $password)) {
    $msg_error = "The password must contain at least 1 number.";

  } else {
    // Try to insert the user
    $inserted = insertUser($username, $password, "registered", $name, $surname);
    if ($inserted) {
      $msg_success = "User successfully registered! You can now log in. <a href='login.php' class='btn btn-dark text-white'>Login</a>"; 
      $username = $password = $name = $surname = ''; // Clear variables so they are not shown in the form
    } else {
      $msg_error = "A user with this username already exists."; // Registration error
    }
  }
}

?>

<?php include_once "topmenu.php"; ?>

<main class="flex-grow-1 container py-4">
  <div class="container-fluid">
    <div class="container">
      <h2 class="mb-3">Registration Form</h2>

      <?php if ($msg_error): ?>
        <div class="alert alert-danger"><?php echo $msg_error; ?></div>
      <?php elseif ($msg_success): ?>
        <div class="alert alert-success"><?php echo $msg_success; ?></div>
      <?php endif; ?>

      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-group mb-3">
          <label for="username">Username:</label>
          <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" value="<?php if (!$inserted)
            echo $username ?? ''; ?>">
        </div>

        <div class="form-group mb-3">
          <label for="password">Password:</label>
          <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" value="<?php if (!$inserted)
            echo $password ?? ''; ?>">
        </div>

        <div class="form-group mb-3">
          <label for="name">Name:</label>
          <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?php if (!$inserted)
            echo $name ?? ''; ?>">
        </div>

        <div class="form-group mb-3">
          <label for="surname">Surname:</label>
          <input type="text" class="form-control" id="surname" placeholder="Enter surname" name="surname" value="<?php if (!$inserted)
            echo $surname ?? ''; ?>">
        </div>

        <button type="submit" name="registersubmit" class="btn btn-dark text-white">Submit</button>
      </form>
    </div>
  </div>
</main>

<?php include_once "footer.php"; ?>

</body>

</html>