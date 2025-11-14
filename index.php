<?php
session_start();
$current_page = 'index.php';
?>

<?php include_once "topmenu.php"; ?>

<main class="flex-grow-1 container-fluid py-5 text-dark d-flex align-items-center justify-content-center">
  <div class="row align-items-center justify-content-center px-5 w-100">

    <div class="col-lg-6 col-md-10 mb-4 mb-lg-0">
      <img src="images/restaurant.jpg" alt="ProvenSoft Restaurant" class="img-fluid rounded-4 shadow-lg w-100">
    </div>

    <div class="col-lg-5 col-md-10">
      <h1 class="fw-bold mb-4">Welcome to ProvenSoft Restaurant</h1>
      <p class="lead mb-3">
        At <strong>ProvenSoft Restaurant</strong> we combine tradition and innovation to offer you a unique gastronomic experience.
        Our kitchen team prepares dishes using local and seasonal ingredients, taking care of every last detail.
      </p>
      <p class="mb-4">
        Come and enjoy a cozy atmosphere, personalized attention, and Mediterranean cuisine that will not leave you indifferent.
        <em>We look forward to seeing you!</em>
      </p>
      <a href="<?= $isLogged ? 'daymenu.php' : 'login.php' ?>" class="btn btn-dark text-white btn-md mt-2">
        Check today's menu
      </a>
      <a href="<?= $isLogged ? 'viewmenus.php' : 'login.php' ?>" class="btn btn-dark text-white btn-md mt-2">
        View the full menu
      </a>
    </div>

  </div>
</main>

<?php include_once "footer.php"; ?>

</body>
</html>