<?php
include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Page</title>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />

</head>

<body>

  <?php
  include 'admin_header.php';
  ?>

  <section class="admin_dashboard container my-5">

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">


      <div class="col">
        <div class="card text-center p-4 shadow">
          <div class="card-body">
            <?php
            $total_pendings = 0;
            $select_pending = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
            if (mysqli_num_rows($select_pending) > 0) {
              while ($fetch_pendings = mysqli_fetch_assoc($select_pending)) {
                $total_price = $fetch_pendings['total_price'];
                $total_pendings += $total_price;
              };
            };
            ?>
            <h3>Rs. <?php echo $total_pendings; ?></h3>
            <p>Total Payments Pending</p>
          </div>
        </div>
      </div>


      <div class="col">
        <div class="card text-center p-4 shadow">
          <div class="card-body">
            <?php
            $total_completed = 0;
            $select_completed = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
            if (mysqli_num_rows($select_completed) > 0) {
              while ($fetch_completed = mysqli_fetch_assoc($select_completed)) {
                $total_price = $fetch_completed['total_price'];
                $total_completed += $total_price;
              };
            };
            ?>
            <h3>Rs. <?php echo $total_completed; ?></h3>
            <p>Completed Payments</p>
          </div>
        </div>
      </div>


      <div class="col">
        <div class="card text-center p-4 shadow">
          <div class="card-body">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            $number_of_products = mysqli_num_rows($select_products);
            ?>
            <h3><?php echo $number_of_products; ?></h3>
            <p>Products Added</p>
          </div>
        </div>
      </div>

     
      <div class="col">
        <div class="card text-center p-4 shadow">
          <div class="card-body">
            <?php
            $select_users = mysqli_query($conn, "SELECT * FROM `register` WHERE user_type='user'") or die('query failed');
            $number_of_users = mysqli_num_rows($select_users);
            ?>
            <h3><?php echo $number_of_users; ?></h3>
            <p>User Present</p>
          </div>
        </div>
      </div>

    </div>

  </section>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <script src="admin_js.js"></script>

</body>

</html>

<?php
include "footer.php";
?>
