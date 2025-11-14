<?php
/**
 * File: adminusers.php
 *
 * Description:
 * This page is intended for admin users to manage application users. 
 * Access is restricted based on user roles. 
 * Currently, the functionality is not implemented. 
 */
session_start();
$current_page = 'adminusers.php';
require_once './fn-php/fn-roles.php';
?>

<?php include_once "includes/topmenu.php"; ?>

<main class="flex-grow-1 container py-4">
    <div class="container-fluid">

        <div class="container">
            <h2>Admin users</h2>
            <?php if (isGranted($_SESSION['role'] ?? '', 'adminusers')): ?>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit anim id est laborum
                </p>
            <?php else: ?>
                <p>You are not allowed to acces this page!</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include_once "includes/footer.php"; ?>

</body>

</html>