<?php
include 'config.php';
session_start();

// Initialize an array to store messages
$message = [];

// Check if user is logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Handle the "Add to Cart" action only if the user is logged in
if (isset($_POST['add_to_cart'])) {
    if (!$user_id) {
        // Redirect to login page, passing the current page URL as a query parameter
        header('location: login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
        exit;
    }

    $pro_name = $_POST['product_name'];
    $pro_price = $_POST['product_price'];
    $pro_quantity = $_POST['product_quantity'];
    $pro_image = $_POST['product_image'];

    // Check if the selected quantity is more than 10
    if ($pro_quantity > 10) {
        $message[] = 'Quantity out of stock. Maximum available quantity is 10.';
    } else {
        // Check if the product is already in the cart
        $check = mysqli_query($conn, "SELECT * FROM `cart` WHERE name='$pro_name' AND user_id='$user_id'") or die('query failed');

        if (mysqli_num_rows($check) > 0) {
            // If product is already in the cart
            $message[] = 'Product already added to cart!';
        } else {
            // Insert the product into the cart
            mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) 
                                 VALUES ('$user_id', '$pro_name', '$pro_price', '$pro_quantity', '$pro_image')") or die('query failed');
            $message[] = 'Product added to cart!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ3QqNGr1jPzF6xYwbw68fSffM4+XQxhYOpxLZjj+YuPeUtM0g3tGz4k1tQ8" crossorigin="anonymous">

    <!-- Font Awesome (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<?php include 'user_header.php'; ?>

<!-- Display messages -->
<?php if (!empty($message)): ?>
    <div class="container mt-4">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?php 
            // Loop through and display each message
            foreach ($message as $msg) {
                echo $msg . "<br>";
            }
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

<!-- Products Section -->
<section class="products_cont py-5">
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
            <?php
            // Fetch all products from the database
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');

            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
                   <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="./uploaded_img/<?php echo $fetch_products['image']; ?>" class="card-img-top" alt="Product Image" style="object-fit: cover; height: 500px;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $fetch_products['name']; ?></h5>
                            <p class="card-text">Rs. <?php echo number_format($fetch_products['price'], 2); ?> /-</p> <!-- Price formatted with two decimals -->
                            <form action="" method="post" class="mt-auto">
                                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                                <div class="input-group mb-3">
                                    <input type="number" name="product_quantity" min="1" max="10" value="1" class="form-control" aria-label="Product Quantity">
                                </div>
                                <!-- Display a warning label if the quantity is greater than 10 -->
                                <span id="quantity_warning" style="color: red; display: none;">Quantity out of stock. Maximum available quantity is 10.</span>
                                <?php if ($user_id): ?>
                                    <button type="submit" name="add_to_cart" class="btn btn-primary w-100">Add to Cart</button>
                                <?php else: ?>
                                    <a href="login.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" class="btn btn-warning w-100">Add to Cart</a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>

            <?php
                }
            } else {
                echo '<div class="col-12"><p class="empty text-center">No Products Added Yet!</p></div>';
            }
            ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<!-- Bootstrap JS & Dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb4mCkYemLJytabC7QTfnFJrgHmqNG4W8pyH1lNUa4rI0epyt" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0ed5H6rM6SzmQmK9l5r0cXnBdAmCj6p0P6O28j53y0WwQzYh" crossorigin="anonymous"></script>

<script src="script.js"></script>

</body>
</html>
