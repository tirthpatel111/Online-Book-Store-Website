<?php
include 'config.php';
session_start();

// Initialize an array to store messages
$message = [];

// Check if user is logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Handle the "Add to Cart" action only if the user is logged in
if (isset($_POST['add_to_cart'])) {
    $pro_name = $_POST['product_name'];
    $pro_price = $_POST['product_price'];
    $pro_image = $_POST['product_image'];

    // Check if the product is already in the cart for the user
    $check = mysqli_query($conn, "SELECT * FROM `cart` WHERE name='$pro_name' AND user_id='$user_id'") or die('Query failed');

    if (mysqli_num_rows($check) > 0) {
        // If product is already in the cart, show the message
        $message[] = 'Product already added to the cart!';
    } else {
        // Insert the product into the cart with quantity 1
        $insert_query = mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, quantity) VALUES ('$user_id','$pro_name','$pro_price','$pro_image', 1)") or die('Query failed');
        $message[] = 'Product added to cart!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Custom CSS to fix image size for products -->
  <style>
    .card-img-top {
      width: 100%;          /* Ensure the image takes up the full width of the card */
      height: 500px;        /* Fixed height for all images */
      object-fit: cover;    /* Ensures the image maintains aspect ratio while covering the box */
    }
  </style>
</head>

<body>
  <?php include 'user_header.php'; ?>

  <!-- Hero Section -->
  <section class="home_cont text-center bg-light py-5">
    <div class="container">
      <h1 class="display-4 text-dark">The Booksmart</h1>
      <p class="lead text-light text-dark">Explore, Discover, and Buy Your Favorite Books</p>
    </div>
  </section>

  <!-- Display success or error messages -->
  <?php if (!empty($message)): ?>
    <div class="container mt-4">
      <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?php foreach ($message as $msg): ?>
          <p><?php echo $msg; ?></p>
        <?php endforeach; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
  <?php endif; ?>

  <!-- Products Section -->
  <section class="products_cont py-5">
    <div class="container">
      <div class="row">
        <?php
        // Fetch all products from the database
        $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('Query failed');
        if (mysqli_num_rows($select_products) > 0) {
          while ($fetch_products = mysqli_fetch_assoc($select_products)) {
        ?>
            <div class="col-md-4 mb-4">
              <form action="" method="post" class="card h-100 shadow-sm">
                <img src="./uploaded_img/<?php echo $fetch_products['image']; ?>" class="card-img-top" alt="Product Image">
                <div class="card-body text-center">
                  <h5 class="card-title"><?php echo $fetch_products['name']; ?></h5>
                  <!-- Price formatted to 2 decimal places -->
                  <p class="card-text">Rs. <?php echo number_format($fetch_products['price'], 2); ?> /-</p>
                  <input type="hidden" name="product_name" value="<?php echo $fetch_products['name'] ?>">
                  <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                  <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">

                  <!-- Check if user is logged in before allowing to add to cart -->
                  <?php if ($user_id): ?>
                    <input type="submit" value="Add to Cart" name="add_to_cart" class="btn btn-primary btn-block">
                  <?php else: ?>
                    <a href="login.php" class="btn btn-secondary btn-block">Add to cart</a>
                  <?php endif; ?>
                </div>
              </form>
            </div>
        <?php
          }
        } else {
          echo '<p class="text-center text-muted">No Products Added Yet!</p>';
        }
        ?>
      </div>
    </div>
  </section>

  <?php include 'footer.php'; ?>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
