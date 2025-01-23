<?php
include 'config.php';
session_start();

// $user_id = $_SESSION['user_id'];

// if (!isset($user_id)) {
//   header('location:login.php');
// }

if (isset($_POST['add_to_cart'])) {

  $product_name = $_POST['product_name'];
  $product_price = $_POST['product_price'];
  $product_image = $_POST['product_image'];
  $product_quantity = $_POST['product_quantity'];

  $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

  if (mysqli_num_rows($check_cart_numbers) > 0) {
    $message[] = 'Already added to cart!';
  } else {
    mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
    $message[] = 'Product added to cart!';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Page</title>

  <!-- Include Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome CDN (for icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" />

  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="home.css">
</head>

<body>

  <?php
  include 'user_header.php';
  ?>

  <!-- Search Section -->
  <section class="search_cont py-4">
    <div class="container">
      <form action="" method="post" class="d-flex justify-content-center">
        <input type="text" name="search" class="form-control me-2" placeholder="Search Products..." aria-label="Search">
        <button type="submit" name="submit" class="btn btn-primary">Search</button>
      </form>
    </div>
  </section>

  <!-- Products Section -->
  <section class="products_cont py-5">
    <div class="container">
      <div class="row">
        <?php
        if (isset($_POST['submit'])) {
          $search_item = $_POST['search'];
          $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE name LIKE '%{$search_item}%'") or die('query failed');
          if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
        ?>
              <div class="col-md-4 mb-4">
                <form action="" method="post" class="card shadow-sm">
                  <img src="./uploaded_img/<?php echo $fetch_products['image']; ?>" class="card-img-top" alt="Product Image">
                  <div class="card-body">
                    <h5 class="card-title"><?php echo $fetch_products['name']; ?></h5>
                    <p class="card-text">Rs. <?php echo $fetch_products['price']; ?>/-</p>

                    <input type="hidden" name="product_name" value="<?php echo $fetch_products['name'] ?>">
                    <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">

                    <div class="input-group mb-3">
                      <input type="number" name="product_quantity" class="form-control" min="1" value="1" aria-label="Quantity">
                    </div>

                    <button type="submit" name="add_to_cart" class="btn btn-primary w-100">Add to Cart</button>
                  </div>
                </form>
              </div>
        <?php
            }
          } else {
            echo '<p class="empty text-center">No result found!</p>';
          }
        } else {
          echo '<p class="empty text-center">Search something!</p>';
        }
        ?>
      </div>
    </div>
  </section>

  <?php
  include 'footer.php';
  ?>

  <!-- Include Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>

</body>

</html>
