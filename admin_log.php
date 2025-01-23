<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
</head>
<body>
    
  <?php
  include "admin_header.php";
  ?>

<?php
$conn = mysqli_connect('localhost', 'root', '', 'book') or die('Connection failed');

session_start();

if ($_SESSION != null) {
    $query = "SELECT * FROM audit_table";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        echo "<div class='container mt-5'>";
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead class='thead-dark'>";
        echo "<tr><th>Audit Id</th><th>User Id</th><th>Login Date and Time</th><th>Logout Date and Time</th><th>Role</th></tr>";
        echo "</thead><tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . ($row['audit_id']) . "</td>";
            echo "<td>" . ($row['user_id']) . "</td>";
            echo "<td>" . ($row['login_time']) . "</td>";
            echo "<td>" . ($row['logout_time']) . "</td>";
            echo "<td>" . ($row['role']) . "</td>";
            
            echo "</tr>";
        }

        echo "</tbody></table>";
        echo "</div>";
    } else {
        echo "<div class='container mt-5'><p class='text-center text-muted'>No records found.</p></div>";
    }

} else {
    header("Location: login.php");
}
?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


<?php
include "footer.php";
?>
