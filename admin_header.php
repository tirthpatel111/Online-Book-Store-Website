
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <span>' . $message . '</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
    }
}
?>

<header class="admin_header bg-dark text-white">
    <div class="container-fluid py-3">
        <div class="row align-items-center">
          
            <div class="col-md-4">
                <div class="header_logo h4 mb-0">Admin Dashboard</div>
            </div>

           
            <div class="col-md-4">
                <nav class="header_navbar d-flex justify-content-center">
                    <a href="admin_page.php" class="nav-link text-white">Home</a>
                    <a href="admin_products.php" class="nav-link text-white">Products</a>
                    <a href="admin_orders.php" class="nav-link text-white">Orders</a>
                    <a href="admin_users.php" class="nav-link text-white">User</a>
                    <a href="admin_log.php" class="nav-link text-white">Log</a>
                </nav>
            </div>

            <div class="col-md-4 d-flex justify-content-end">
                
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</header>


<style>

    .header_navbar .nav-link {
        font-size: 1.25rem;  
    }
</style>


</style>
<!-- Include Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="admin_js.js"></script>
