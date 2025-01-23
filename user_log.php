<?php
// Start the session
session_start();

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'book') or die('Connection failed');

// Initialize a flag to check login status
$is_logged_in = false;
$login_message = "";

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $is_logged_in = true; // User is logged in
    $user_id = $_SESSION['user_id']; // Get the user_id from the session

    // Prepare SQL query to fetch audit logs from the audit_table for the logged-in user
    $query = "SELECT * FROM audit_table WHERE user_id = ?";  // Corrected column name 'user_id' instead of 'id'
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $login_message = "Login is necessary to view this page.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Log</title>
  <?php include "user_header.php"; ?> <!-- Include header -->
  
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="home.css">
</head>

<body>

<div class="container mt-5">

  <?php if ($is_logged_in): ?>
      <?php
      if (mysqli_num_rows($result) > 0) {
          // Display the records in a table
          echo "<table class='table table-bordered table-striped'>";
          echo "<thead class='thead-dark'>"; // Apply dark theme to the header
          echo "<tr><th>Audit Id</th><th>User Id</th><th>Login Date and Time</th><th>Logout Date and Time</th></tr>";
          echo "</thead><tbody>";

          // Loop through each row and display the values
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['audit_id']) . "</td>";  // Make sure 'audit_id' is the correct column name
              echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";  // Changed to 'user_id' as per the audit table schema
              echo "<td>" . htmlspecialchars($row['login_time']) . "</td>";  // Assuming login_time exists in the table
              echo "<td>" . htmlspecialchars($row['logout_time']) . "</td>"; // Assuming logout_time exists in the table
              echo "</tr>";
          }

          echo "</tbody></table>";
      } else {
          // If no records are found
          echo "<p class='text-center text-muted'>No records found.</p>";
      }
      ?>
  <?php else: ?>
      <!-- Display a login prompt if the user is not logged in -->
      <div class="alert alert-warning text-center" role="alert">
          <?php echo $login_message; ?>
      </div>
  <?php endif; ?>

</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<style>
  /* General Reset */
  * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
  }

  /* Table Styling */
  table {
      margin-top: 20px;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
      table, table th, table td {
          font-size: 0.9rem;
      }
  }
</style>

<?php
include "footer.php";
?>
