<?php
include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:login.php');
}

if (isset($_POST['update_order'])) {
  $order_update_id = $_POST['order_id'];
  $update_payment = $_POST['update_payment'];

  mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');

  $message[] = 'Order Payment status has been updated';
}

if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM `orders` WHERE id='$delete_id'");
  $message[] = '1 order has been deleted';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>

  <?php
  include 'admin_header.php';
  ?>

  <section class="admin_orders container my-5">
    <h1 class="title text-center mb-4">Placed Orders</h1>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
      <?php
      $select_orders = mysqli_query($conn, "
          SELECT o.*, r.name, r.email, r.number 
          FROM `orders` o
          LEFT JOIN `register` r ON o.user_id = r.id
      ") or die('query failed');

      if (mysqli_num_rows($select_orders) > 0) {
        while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
      ?>
          <div class="col">
            <div class="card shadow-sm p-3">
              <div class="card-body">
                <p><strong>User Id :</strong> <span><?php echo $fetch_orders['user_id'] ?></span></p>
                <p><strong>Name :</strong> <span><?php echo $fetch_orders['name']; ?></span></p>
                <p><strong>Number :</strong> <span><?php echo $fetch_orders['number']; ?></span></p>
                <p><strong>Email :</strong> <span><?php echo $fetch_orders['email']; ?></span></p>
                <p><strong>Address :</strong> <span><?php echo $fetch_orders['address'] ?></span></p>
                <p><strong>Total Products :</strong> <span><?php echo $fetch_orders['total_products'] ?></span></p>
                <p><strong>Total Price :</strong> <span><?php echo $fetch_orders['total_price'] ?></span></p>
                <p><strong>Payment Method :</strong> <span><?php echo $fetch_orders['method'] ?></span></p>

                <form action="" method="post" class="mt-3">
                  <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                  <div class="d-flex gap-2">
                    <select name="update_payment" class="form-select" required>
                      <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
                      <option value="pending">Pending</option>
                      <option value="completed">Completed</option>
                    </select>
                    <button type="submit" name="update_order" class="btn btn-primary">Update</button>
                    <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('Are you sure you want to delete this order?');" class="btn btn-danger">Delete</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
      <?php
        }
      } else {
        echo '<p class="text-center col-12">No orders placed yet!</p>';
      }
      ?>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="admin_js.js"></script>

</body>

</html>

<?php
include "footer.php";
?>
