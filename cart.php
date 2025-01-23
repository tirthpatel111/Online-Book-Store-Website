<?php
include 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user ID

// Handle cart update functionality
if (isset($_POST['update_cart'])) {
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    mysqli_query($conn, "UPDATE `cart` SET quantity='$cart_quantity' WHERE id='$cart_id'") or die('query failed');
    $message[] = 'Cart Quantity Updated';
}

// Handle individual cart item deletion
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id='$delete_id'") or die('query failed');
    header('location:cart.php');
    exit();
}

// Handle deleting all items from the cart
if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Custom CSS to increase image box size -->
    <style>
        .card-img-top {
            height: 350px;  /* Increased height of the image */
            object-fit: cover;  /* Ensures the image maintains aspect ratio */
        }

        /* Optional: Adjusting the layout for the cards */
        .col-md-3 {
            flex: 0 0 30%; /* Optional: Adjust the column size if you want bigger images */
        }
    </style>
</head>
<body>

<?php include 'user_header.php'; ?>

<section class="shopping_cart py-5">
    <div class="container">
        <h1 class="text-center mb-4">Products in Your Cart</h1>

        <div class="row">
            <?php
            $grand_total = 0;
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');

            if (mysqli_num_rows($select_cart) > 0) {
                while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                    $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']);
                    $grand_total += $sub_total;
            ?>
                <div class="col-md-3 mb-4"> <!-- Adjusted column width for bigger images -->
                    <div class="card shadow-sm">
                        <img src="./uploaded_img/<?php echo $fetch_cart['image']; ?>" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $fetch_cart['name']; ?></h5>
                            <p class="card-text">Rs. <?php echo number_format($fetch_cart['price'], 2); ?>/-</p>

                            <form action="" method="post" class="d-flex justify-content-between align-items-center">
                                <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                                <input type="number" name="cart_quantity" class="form-control w-50 cart-quantity" min="1" max="10" value="<?php echo $fetch_cart['quantity']; ?>" data-price="<?php echo $fetch_cart['price']; ?>" data-id="<?php echo $fetch_cart['id']; ?>" onchange="updateCart(this)">
                                <button type="submit" name="update_cart" class="btn btn-primary ms-2">Update</button>
                            </form>
                            <p class="mt-3">Total: <span class="fw-bold cart-item-total" id="total-<?php echo $fetch_cart['id']; ?>">Rs. <?php echo number_format($sub_total, 2); ?>/-</span></p>

                            <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this product from cart?');">
                                <i class="fas fa-trash"></i> Remove
                            </a>
                        </div>
                    </div>
                </div>
            <?php
                }
            } else {
                echo '<p class="text-center w-100">Your cart is empty!</p>';
            }
            ?>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <h2 class="fw-bold">Total Cart Price: <span class="text-success" id="grand-total">Rs. <?php echo number_format($grand_total, 2); ?>/-</span></h2>

            <div>
                <a href="cart.php?delete_all" class="btn btn-danger me-2 <?php echo ($grand_total > 0) ? '' : 'disabled'; ?>" onclick="return confirm('Are you sure you want to delete all cart items?');">
                    <i class="fas fa-trash-alt"></i> Delete All
                </a>
                <a href="shop.php" class="btn btn-secondary">Continue Shopping</a>
                <a href="checkout.php" class="btn btn-success <?php echo ($grand_total > 0) ? '' : 'disabled'; ?>">Proceed to Checkout</a>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
