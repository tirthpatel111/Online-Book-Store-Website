<?php
include 'config.php';

// Handle User Deletion
if(isset($_GET['delete'])){
  $delete_id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM `register` WHERE id='$delete_id'");
  $message[] = '1 user has been deleted';
  header("location:admin_users.php");
}

// Handle Add User Submission
if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $user_type = $_POST['user_type'];

    // Check if user already exists
    $select_user = mysqli_query($conn, "SELECT * FROM `register` WHERE email='$email'") or die('query failed');

    if(mysqli_num_rows($select_user) > 0){
        $message[] = 'User with this email already exists!';
    } else {
        // Insert new user into the database
        mysqli_query($conn, "INSERT INTO `register` (name, email, password, user_type) VALUES ('$name', '$email', '$password', '$user_type')") or die('query failed');
        $message[] = 'User added successfully!';
        header('location:admin_users.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users</title>

  <!-- Bootstrap CSS Link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ4QJkzS5+6FEXd04tP0JgXkAX9aFz8Hbx99nC8J1heZlOlr5L3t3F3Z2yKh" crossorigin="anonymous">
</head>

<body>

  <!-- Include Admin Header -->
  <?php include 'admin_header.php'; ?>

  <section class="container mt-5">

    <!-- Add User Section -->
    <h2 class="text-center mb-4">Add New User</h2>
    <!-- Display messages if any -->
    <?php
    if(isset($message)){
        foreach($message as $msg){
            echo '
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <span>'.$msg.'</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
    ?>

    <form action="" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="user_type" class="form-label">User Type</label>
            <select name="user_type" id="user_type" class="form-select" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Add User</button>
    </form>

    <!-- Display Existing Users -->
    <h2 class="text-center mt-5 mb-4">Existing Users</h2>
    <div class="row">
      <?php
      $select_users = mysqli_query($conn, "SELECT * FROM `register`");

      while ($fetch_users = mysqli_fetch_assoc($select_users)) {
      ?>
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Username: <span><?php echo $fetch_users['name'] ?></span></h5>
              <p class="card-text">Email: <span><?php echo $fetch_users['email'] ?></span></p>
              <p class="card-text">Usertype: <span style="color:<?php if ($fetch_users['user_type'] == 'admin') {
                                                                      echo 'blue';
                                                                    } else {
                                                                      echo 'green';
                                                                    } ?>"><?php echo $fetch_users['user_type'] ?></span></p>
              <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');" class="btn btn-danger btn-sm">Delete</a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>

  </section>

  <!-- Bootstrap JS and Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybQ7h8FfAw7+jiJ2q9Gioi4v6gKe9RY6p42l7n4g6GFbFadkJ4" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0GO3o7SkH7tIv9H2hfjiN5HYqYkm6pPL3/s7rf9xeO4VZ8dR" crossorigin="anonymous"></script>

</body>

</html>

<?php
include "footer.php";
?>
