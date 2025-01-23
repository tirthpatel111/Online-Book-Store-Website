<?php
include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
};

if (isset($_POST['add_products_btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = number_format($_POST['price'], 2, '.', ''); // Format the price to 2 decimal places
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = "uploaded_img/" . $image;

    $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name='$name'") or die('query failed');

    if (mysqli_num_rows($select_product_name) > 0) {
        $message[] = 'The given product is already added';
    } else {
        $add_product_query = mysqli_query($conn, "INSERT INTO `products`(name,price,image) VALUES ('$name','$price','$image')");
        if ($add_product_query) {
            if ($image_size > 2000000) {
                $message[] = 'Image size is too large';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = "Product added successfully!";
            }
        } else {
            $message[] = "Product failed to be added!";
        }
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    $delete_img_query = mysqli_query($conn, "SELECT image from `products` WHERE id='$delete_id'") or die('query failed');
    $fetch_del_img = mysqli_fetch_assoc($delete_img_query);
    unlink('./uploaded_img/' . $fetch_del_img['image']);

    mysqli_query($conn, "DELETE FROM `products` WHERE id='$delete_id'") or die('query failed');
    header('location:admin_products.php');
}

if (isset($_POST['update_product'])) {
    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_price = number_format($_POST['update_price'], 2, '.', ''); // Format the price to 2 decimal places

    mysqli_query($conn, "UPDATE `products` SET name='$update_name', price='$update_price' WHERE id='$update_p_id'") or die('query failed');

    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = './uploaded_img/' . $update_image;
    $old_image = $_POST['update_old_img'];
    
    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $message[] = 'Image size is too large';
        } else {
            mysqli_query($conn, "UPDATE `products` SET image='$update_image' WHERE id='$update_p_id'") or die('query failed');
            move_uploaded_file($update_image_tmp_name, $update_folder);
            unlink('./uploaded_img/' . $old_image);
            $message[] = "Product updated successfully!";
        }
    }
    header('location:admin_products.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
include 'admin_header.php';
?>

<section class="container my-5">
  <h3 class="text-center mb-4">Add Product</h3>
  <form action="" method="post" enctype="multipart/form-data" class="row g-3">
    <div class="col-md-6">
      <input type="text" name="name" class="form-control" placeholder="Enter Product Name" required>
    </div>
    <div class="col-md-6">
      <input type="number" min="0" name="price" class="form-control" placeholder="Enter Product Price" required>
    </div>
    <div class="col-md-6">
      <input type="file" name="image" class="form-control" accept="image/jpg, image/jpeg, image/png" required>
    </div>
    <div class="col-md-12">
      <input type="submit" name="add_products_btn" class="btn btn-primary w-100" value="Add Product">
    </div>
  </form>
</section>

<section class="container my-5">
  <h3 class="text-center mb-4">All Products</h3>
  <div class="row">
    <?php
      $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');

      if (mysqli_num_rows($select_products) > 0) {
        while ($fetch_products = mysqli_fetch_assoc($select_products)) {
    ?>
    <div class="col-md-4 mb-4">
      <div class="card">
        <img src="./uploaded_img/<?php echo $fetch_products['image'];?>" class="card-img-top" alt="">
        <div class="card-body">
          <h5 class="card-title"><?php echo $fetch_products['name'];?></h5>
          <p class="card-text">Rs. <?php echo number_format($fetch_products['price'], 2); ?> /-</p>
          <a href="admin_products.php?update=<?php echo $fetch_products['id']?>" class="btn btn-warning">Update</a>
          <a href="admin_products.php?delete=<?php echo $fetch_products['id']?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
        </div>
      </div>
    </div>
    <?php
        }
      } else {
        echo '<p class="col-12 text-center">No products added yet!</p>';
      }
    ?>
  </div>
</section>

<section class="container">
  <?php
    if (isset($_GET['update'])) {
      $update_id = $_GET['update'];
      $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id='$update_id'") or die('query failed');
      if (mysqli_num_rows($update_query) > 0) {
        while ($fetch_update = mysqli_fetch_assoc($update_query)) {
  ?>

  <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id'];?>">
    <input type="hidden" name="update_old_img" value="<?php echo $fetch_update['image'];?>">

    <div class="mb-3 text-center">
      <img src="./uploaded_img/<?php echo $fetch_update['image'];?>" class="img-fluid mb-3" style="max-width: 200px;" alt="">
    </div>

    <input type="text" name="update_name" value="<?php echo $fetch_update['name'];?>" class="form-control mb-3" required placeholder="Enter Product Name">
    <input type="number" name="update_price" min="0" value="<?php echo $fetch_update['price'];?>" class="form-control mb-3" required placeholder="Enter Product Price">
    <input type="file" name="update_image" class="form-control mb-3" accept="image/jpg, image/jpeg, image/png">
    
    <button type="submit" name="update_product" class="btn btn-primary">Update</button>
    <button type="reset" class="btn btn-secondary" id="close_update">Cancel</button>
  </form>

  <?php
        }
      }
    } else {
      echo "<script>document.querySelector('.edit_product_form').style.display='none';</script>";
    }
  ?>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="admin_js.js"></script>

</body>
</html>

<?php
include "footer.php";
?>
