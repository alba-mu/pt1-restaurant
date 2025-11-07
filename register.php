<?php 
require_once './fn-php/fn-users.php';

$msg_error = "";
$msg_success = "";

// TODO
// Implementar el codi de Registre, afegint l’usuari al fitxer users.txt
if ($_SERVER['REQUEST_METHOD'] === 'POST' && filter_has_var(INPUT_POST, "registersubmit")) {
  //TODO: improve validations
  $username = filter_input(INPUT_POST, "username");
  $password = filter_input(INPUT_POST, "password");
  $name = filter_input(INPUT_POST, "name");
  $surname = filter_input(INPUT_POST, "surname");

  // Validacions bàsiques
  if ($username === '' || $password === '' || $name === '' || $surname === '') {
      $msg_error = "Tots els camps són obligatoris.";
  } elseif (strlen($password) < 4) {
      $msg_error = "La contrasenya ha de tenir almenys 4 caràcters.";
  } else {
      // Intentar inserir l'usuari
      $inserted = insertUser($username, $password, "registered", $name, $surname);
      if ($inserted) {
          $msg_success = "Usuari registrat correctament! Pots iniciar sessió.";
      } else {
          $msg_error = "Ja existeix un usuari amb aquest nom d'usuari.";
      }
  }
}


include_once "topmenu.php";
?>
<div class="container-fluid">

  <h2>Registration form</h2>

  <!-- Missatges -->
  <?php if ($msg_error): ?>
    <div class="alert alert-danger"><?php echo $msg_error; ?></div>
  <?php elseif ($msg_success): ?>
    <div class="alert alert-success"><?php echo $msg_success; ?></div>
  <?php endif; ?>

  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
    </div>
    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
    </div>
    <div class="form-group">
      <label for="surname">Surname:</label>
      <input type="text" class="form-control" id="surname" placeholder="Enter surname" name="surname">
    </div>
    <button type="submit" name="registersubmit" class="btn btn-dark text-white">Submit</button>
  </form>
  <?php include_once "footer.php";?>
</div>
</body>
</html>