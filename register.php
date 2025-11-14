<?php
/**
 * File: register.php
 * Author: Alba Muñoz
 * Date: 07/11/2025
 *
 * Description:
 * This file handles the user registration process.
 * It validates the input fields, checks password requirements,
 * inserts the user into the database if valid, and displays
 * appropriate success or error messages.
 */
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
      $msg_success = "<p class='mb-2'>User successfully registered! You can log in now.</p> <a href='login.php' class='btn btn-dark text-white'>Login</a><span>"; 
      $username = $password = $name = $surname = ''; // Clear variables so they are not shown in the form
    } else {
      $msg_error = "A user with this username already exists."; // Registration error
    }
  }
}

?>

<?php include_once "includes/topmenu.php"; ?>

<main class="flex-grow-1 d-flex justify-content-center align-items-center">
  <div class="container" style="max-width: 500px;">

    <h2 class="text-center display-4 mb-4 fw-normal">Registration Form</h2>

    <div class="card shadow">
      <div class="card-body">
        <?php if ($msg_error): ?>
          <div class="alert alert-danger pt-1 pb-1"><?php echo $msg_error; ?></div>
        <?php elseif ($msg_success): ?>
          <div class="alert alert-success pt-1 pb-1 text-center"><?php echo $msg_success; ?></div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

          <div class="mb-3">
            <label for="username" class="form-label fw-bold">Username:</label>
            <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" 
              value="<?php if (!$inserted) echo $username ?? ''; ?>">
          </div>

          <div class="mb-3">
            <label for="password" class="form-label fw-bold">Password:</label>
            <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" 
              value="<?php if (!$inserted) echo $password ?? ''; ?>">
          </div>

          <div class="mb-3">
            <label for="name" class="form-label fw-bold">Name:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" 
              value="<?php if (!$inserted) echo $name ?? ''; ?>">
          </div>

          <div class="mb-3">
            <label for="surname" class="form-label fw-bold">Surname:</label>
            <input type="text" class="form-control" id="surname" placeholder="Enter surname" name="surname" 
              value="<?php if (!$inserted) echo $surname ?? ''; ?>">
          </div>

          <button type="submit" name="registersubmit" class="btn btn-dark w-100">Submit</button>

          <p class="text-center mt-3 mb-0">Already have an account? <a href="login.php">Login</a> </p>

        </form>

      </div>
    </div>
    
  </div>
</main>

<?php include_once "includes/footer.php"; ?>

</body>

</html>