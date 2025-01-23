<?php
include 'config.php';
session_start();

// Initialize variables for user_id and role
$user_id = null;
$role = null;

// Check if the user is logged in, otherwise redirect to login page
if (isset($_SESSION['admin_name'])) {
    // If the user is an admin, log them out
    $user_id = $_SESSION['admin_id']; // Store admin ID to log out time
    $role = 'admin';
    unset($_SESSION['admin_name']);
    unset($_SESSION['admin_email']);
    unset($_SESSION['admin_id']);
} elseif (isset($_SESSION['user_name'])) {
    // If the user is a normal user, log them out
    $user_id = $_SESSION['user_id']; // Store user ID to log out time
    $role = 'user';
    unset($_SESSION['user_name']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_id']);
}

// Check if there is a valid user_id, then log out
if ($user_id) {
    // Query to fetch the current audit record for the user
    $audit_query = "SELECT audit_id FROM audit_table WHERE user_id = '{$user_id}' AND logout_time IS NULL LIMIT 1";
    $result = mysqli_query($conn, $audit_query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the row and update the logout time
        $row = mysqli_fetch_assoc($result);
        $audit_id = $row['audit_id'];

        // Now update the logout_time in the audit table
        $update_query = "UPDATE audit_table SET logout_time = CURRENT_TIMESTAMP WHERE audit_id = '{$audit_id}'";
       
        mysqli_query($conn, $update_query);
        echo $update_query;
    }
}

// Destroy the session after logging out
session_destroy();

// Redirect to home page (or login page, depending on your flow)
header('Location: home.php'); // Change this to 'login.php' if needed
exit();
?>
