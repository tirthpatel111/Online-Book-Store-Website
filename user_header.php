<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<?php
include 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;

$cart_row_number = 0;
if ($user_id) {
    $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('Query failed');
    $cart_row_number = mysqli_num_rows($select_cart_number);
}
?>

<header class="user_header bg-dark shadow-sm">
    <div class="container-fluid">
        <div class="row align-items-center py-3">
            <!-- Logo Section -->
            <div class="col-md-4 d-flex align-items-center">
                <div class="logo_cont d-flex align-items-center">
                    <img src="book_logo.png" alt="Logo" class="img-fluid me-2" style="height: 40px;">
                    <span class="book_logo text-primary h4 mb-0">booksmart</span> 
                </div>
            </div>

            <!-- Navbar -->
            <div class="col-md-5">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item"><a href="home.php" class="nav-link text-white">Home</a></li>
                            <li class="nav-item"><a href="about.php" class="nav-link text-white">About</a></li>
                            <li class="nav-item"><a href="shop.php" class="nav-link text-white">Products</a></li>
                            <li class="nav-item"><a href="contact.php" class="nav-link text-white">Contact</a></li>
                            <li class="nav-item"><a href="orders.php" class="nav-link text-white">Orders</a></li>
                            <li class="nav-item"><a href="user_log.php" class="nav-link text-white">Log</a></li>
                            
                                </li>
                            <?php if ($user_id): ?>
                                <li class="nav-item"><a href="logout.php" class="nav-link text-danger">Logout</a></li>
                                <!-- Remove icon and just show text -->
                            <?php else: ?>
                                <li class="nav-item"><a href="login.php" class="nav-link text-success">Login</a></li>
                            <?php endif; ?>

                            <!-- <li class="nav-item"><a href="user_profile.php" class="nav-link text-white">Profile</a> -->
                        </ul>
                    </div>
                </nav>
            </div>

            <!-- Icons Section -->
            <div class="col-md-3 d-flex justify-content-end">
                <a href="search_page.php" class="btn btn-outline-secondary me-3"><i class="fa-solid fa-magnifying-glass"></i></a>
                <a href="cart.php" class="btn btn-outline-primary">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="badge bg-danger"><?php echo $cart_row_number; ?></span>
                </a>
            </div>
        </div>
    </div>
</header>

<!-- Include Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="admin_js.js"></script>


<style>
    /* Custom styles to increase space and button text size */
.user_header .nav-item {
    font-size: 1.25rem; /* Increases the font size of the text in the buttons */
}

.user_header .nav-item {
    margin-right: 15px; /* Adds space between the search and cart button */
}

</style>