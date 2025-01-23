<?php
include 'config.php';
session_start();

if(isset($_POST['submit'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, ($_POST['password'])); // Make sure the password is hashed the same way as in the DB

    $query = "SELECT * FROM `register` WHERE email='$email' AND password='$password'";
    $select_users = mysqli_query($conn, $query) or die('Query failed: ' . mysqli_error($conn));

    if(mysqli_num_rows($select_users) > 0){
        $row = mysqli_fetch_assoc($select_users);

        if($row['user_type'] == 'admin'){
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];

            // Record login in the audit table
            $audit_qry = "INSERT INTO audit_table(user_id, login_time, role) VALUES('{$row['id']}', CURRENT_TIMESTAMP, 'admin')";
            // "INSERT INTO audit_table  VALUES ('','$id', CURRENT_TIMESTAMP,NULL,'$role')";
            mysqli_query($conn, $audit_qry);

            header('location:admin_page.php');
        } elseif($row['user_type'] == 'user'){
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];

            // Record login in the audit table
            $audit_qry = "INSERT INTO audit_table(user_id, login_time, role) VALUES('{$row['id']}', CURRENT_TIMESTAMP, 'user')";
            mysqli_query($conn, $audit_qry);

            header('location:home.php');
        }
    } else {
        $message[] = 'Incorrect email or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome CDN (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <!-- Custom CSS for Styling -->
    <link rel="stylesheet" href="login.css">
</head>

<body>

    <!-- Show messages if any -->
    <?php
    if(isset($message)){
        foreach($message as $message){
            echo '
            <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3 w-50" role="alert">
                <span>'.$message.'</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ';    
        }
    }
    ?>

    <!-- Login Form -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">

            <h2 class="text-center mb-4">Login</h2>

            <form action="" method="post">

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

               

                <button type="submit" name="submit" class="btn btn-primary w-100">Login</button>
                <div class="d-flex justify-content-between mb-4">
               
                    <a href="register.php">Register Now</a>
                </div>

            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>
</body>

</html>
