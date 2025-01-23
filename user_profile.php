<?php
include 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id']; 


$query = mysqli_query($conn, "SELECT * FROM register WHERE id='$user_id'") or die('query failed');
$user = mysqli_fetch_assoc($query);


if (!$user_id) {
    header('location:login.php');
    exit;
}


if (isset($_POST['update'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);



    if (!empty($password)) {

        // $password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE register SET name='$name', email='$email', password='$password' WHERE id='$user_id'";
    } else {

        $update_query = "UPDATE register SET name='$name', email='$email' WHERE id='$user_id'";
    }


    $result = mysqli_query($conn, $update_query) or die('query failed');

    if ($result) {
        $message[] = 'Profile updated successfully!';
    } else {
        $message[] = 'Failed to update profile!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <?php include "user_header.php"; ?>
</head>
<body>


    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
            <div class="alert alert-info alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3 w-50" role="alert">
                <span>' . $message . '</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ';
        }
    }
    ?>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4" style="max-width: 500px; width: 100%;">

            <h2 class="text-center mb-4">Edit Profile</h2>

            <form action="" method="post">

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo $user['name']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo $user['email']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">New Password (Leave blank to keep current password)</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>

                <button type="submit" name="update" class="btn btn-primary w-100">Update Profile</button>

            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
