<?php
/**
 * Checks permission to access a page based on user role
 * @param string $role the role of the user ('admin', 'registered', etc.)
 * @param string $page the page being accessed (e.g., 'adminmenus', 'adminusers', 'daymenu', etc.)
 * @return bool true if access is granted, false otherwise
 */
function isGranted(string $role, string $page): bool {
    // Define permissions per page
    $permissions = [
        'adminmenus' => ['admin'],       // Only admin can access
        'adminusers' => ['admin'],       // Only admin
        'daymenu'    => ['admin', 'registered', 'staff'],  // Logged in users can access
        'viewmenus'  => ['admin', 'registered', 'staff'],  // Logged in users can access
        'index'      => ['admin', 'registered', 'guest', 'staff'], // Everyone
        'login'      => ['guest'],
        'register'   => ['guest'],
    ];

    // Determine effective role for not logged-in users
    if ($role === '') {
        $role = 'guest';
    }

    // Grant access if page exists in permissions and role is allowed
    if (isset($permissions[$page]) && in_array($role, $permissions[$page])) {
        return true;
    }

    return false;
}
?>
