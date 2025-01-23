<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];  // Assuming user ID is stored in session

if (!isset($user_id)) {
    header('location:login.php');
    exit;
}

// Fetch user details (name, email, and number) from the 'register' table
$user_query = mysqli_query($conn, "SELECT * FROM `register` WHERE id = '$user_id'") or die('query failed');
if (mysqli_num_rows($user_query) > 0) {
    $user_details = mysqli_fetch_assoc($user_query);
    $user_name = $user_details['name'];  // User's name
    $user_email = $user_details['email'];  // User's email
    $user_number = $user_details['number'];  // User's phone number
} else {
    $user_name = '';
    $user_email = '';
    $user_number = '';
}

if (isset($_POST['update_quantity'])) {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];

    // Update quantity in the cart
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$quantity' WHERE id = '$cart_id' AND user_id = '$user_id'") or die('query failed');
    
    // Redirect to the same page to refresh the cart details
    header('Location: checkout.php');
    exit;
}

if (isset($_POST['order_btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = $_POST['number'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products[] = '';
    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    
    if (mysqli_num_rows($cart_query) > 0) {
        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }

    $total_products = implode(' ', $cart_products);

    // Check if order already exists (use the email fetched from register table)
    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

    if ($cart_total == 0) {
        $message[] = 'Your cart is empty';
    } else {
        if (mysqli_num_rows($order_query) > 0) {
            $message[] = 'Order already placed!'; 
        } else {
            // Insert order into the database
            mysqli_query($conn, "INSERT INTO `orders`(user_id, method, address, total_products, total_price, payment_status) 
            VALUES('$user_id', '$method', '$address', '$total_products', '$cart_total', 'pending')") or die('query failed');

            // Get the last inserted order_id
            $order_id = mysqli_insert_id($conn); 

            $insert_user_order_query = "INSERT INTO `order` (user_id, order_id) VALUES ('$user_id', '$order_id')";
            if (!mysqli_query($conn, $insert_user_order_query)) {
                echo "Error inserting user_id and order_id: " . mysqli_error($conn);
            }

            $message[] = 'Order placed successfully!';

            // Remove items from cart after order
            mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');

            // Redirect to orders page
            header('Location: orders.php');
            exit();
        }
    }
}

// Function to format price in a currency format
function formatPrice($amount) {
    return 'Rs. ' . number_format($amount, 2);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ3QqNGr1jPzF6xYwbw68fSffM4+XQxhYOpxLZjj+YuPeUtM0g3tGz4k1tQ8" crossorigin="anonymous">
    
    <!-- Font Awesome (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<?php include 'user_header.php'; ?>

<!-- Display Messages -->
<?php if (!empty($message)): ?>
    <div class="container mt-4">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?php 
            foreach ($message as $msg) {
                echo $msg . "<br>";
            }
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

<!-- Ordered Products Section -->
<section class="display_order py-5">
    <div class="container">
        <h2 class="mb-4">Ordered Products</h2>
        <?php
            $grand_total = 0;
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');
            
            if (mysqli_num_rows($select_cart) > 0) {
        ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
        <?php
                while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                    $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
                    $grand_total += $total_price;
        ?>
                <form action="" method="post">
                    <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>"> <!-- hidden input to identify cart item -->
                    <tr>
                        <td><img src="./uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="Product Image" class="img-fluid" style="width: 100px; height: 100px;"></td>
                        <td><?php echo $fetch_cart['name']; ?></td>
                        <td><?php echo formatPrice($fetch_cart['price']); ?></td>
                        <td>
                        <input type="number" name="quantity" value="<?php echo $fetch_cart['quantity']; ?>" min="1" max="10" class="form-control w-35">

                        </td>
                        <td><?php echo formatPrice($total_price); ?></td>
                        <td>
                            <button type="submit" name="update_quantity" class="btn btn-sm btn-warning">Update</button>
                        </td>
                    </tr>
                </form>
        <?php
                }
        ?>
            </tbody>
        </table>
        <div class="text-right font-weight-bold">
            <h3>Grand Total: <?php echo formatPrice($grand_total); ?>/-</h3>
        </div>
        <?php
            } else {
                echo '<p class="empty">Your cart is empty</p>';
            }
        ?>
    </div>
</section>

<!-- Contact Form (for user details) -->
<section class="contact_us py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Add Your Details</h2>
        <form action="" method="post">
            <div class="mb-3">
                <input type="text" name="name" required class="form-control" value="<?php echo $user_name; ?>" placeholder="Enter your name">
            </div>
            <div class="mb-3">
                <input type="tel" name="number" required class="form-control" placeholder="Enter your number" maxlength="10" pattern="\d{10}" >
            </div>

            <div class="mb-3">
                <input type="email" name="email" required class="form-control" value="<?php echo $user_email; ?>" placeholder="Enter your email">
            </div>
            <div class="mb-3">
                <select name="method" class="form-select" required>
                    <option value="cash on delivery">Cash on Delivery</option>
                    <!-- <option value="gpay">GPay</option> -->
                </select>
            </div>
            <div class="mb-3">
                <textarea name="address" class="form-control" rows="4" placeholder="Enter your address" required></textarea>
            </div>
            <div class="text-center">
                <input type="submit" value="Place Your Order" name="order_btn" class="btn btn-primary btn-lg">
            </div>
        </form>
    </div>
</section>

<!-- Bootstrap JS (required for Bootstrap components like modal, etc.) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0trjlA7yYPtbxJsc9+8gN4Xy7rOGXkE8yHw/a13fzE4rhf1P" crossorigin="anonymous"></script>

</body>
</html>
