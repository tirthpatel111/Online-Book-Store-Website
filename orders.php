<?php
include 'config.php';
session_start();

// Check if user_id is set in the session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $not_logged_in_message = "Login is necessary to view your orders.";
    $user_id = null; // Ensure $user_id is not used if the user is not logged in
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders Page</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ3QqNGr1jPzF6xYwbw68fSffM4+XQxhYOpxLZjj+YuPeUtM0g3tGz4k1tQ8" crossorigin="anonymous">

  <!-- Font Awesome (for icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  
<?php include 'user_header.php'; ?>

<!-- Orders Section -->
<section class="orders py-5">
  <div class="container">
    <?php if (isset($not_logged_in_message)): ?>
      <!-- Display the login necessary message -->
      <p class="alert alert-warning text-center"><?php echo $not_logged_in_message; ?></p>
    <?php else: ?>
      <div class="row">
      <?php
      // Join the 'orders' table with 'register' table to get user details
      // Assuming 'user_id' is in the 'orders' table and 'id' is in the 'register' table
      $order_query = mysqli_query($conn, "
        SELECT o.*, r.name AS user_name, r.number AS user_number, r.email AS user_email 
        FROM orders o 
        JOIN register r ON o.user_id = r.id  -- Corrected: 'id' in register table
        WHERE o.user_id='$user_id'") or die('query failed');

      if (mysqli_num_rows($order_query) > 0) {
        while ($fetch_orders = mysqli_fetch_assoc($order_query)) {
      ?>
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm">
            <div class="card-body">
              <ul class="list-unstyled order-details">
                <li><strong>Name:</strong> <?php echo $fetch_orders['user_name']; ?></li>
                <li><strong>Mobile Number:</strong> <?php echo $fetch_orders['user_number']; ?></li>
                <li><strong>Email:</strong> <?php echo $fetch_orders['user_email']; ?></li>
                <li><strong>Address:</strong> <?php echo $fetch_orders['address']; ?></li>
                <li><strong>Payment Method:</strong> <?php echo $fetch_orders['method']; ?></li>
                <li><strong>Your Orders:</strong> <?php echo $fetch_orders['total_products']; ?></li>
                <li><strong>Total Price:</strong> <?php echo $fetch_orders['total_price']; ?> rupees</li>
                <li><strong>Payment Status:</strong> 
                  <span class="badge <?php echo $fetch_orders['payment_status'] == 'pending' ? 'bg-danger' : 'bg-success'; ?>">
                    <?php echo $fetch_orders['payment_status']; ?>
                  </span>
                </li>
              </ul>
              <!-- Add Invoice Button -->
              <button class="btn btn-primary mt-3 download-invoice" onclick="downloadInvoice(this)">Download Invoice</button>
            </div>
          </div>
        </div>
      <?php
        }
      } else {
        echo '<p class="empty text-center w-100">No orders placed yet!</p>';
      }
      ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php include 'footer.php'; ?>

<!-- Bootstrap JS & Dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb4mCkYemLJytabC7QTfnFJrgHmqNG4W8pyH1lNUa4rI0epyt" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0ed5H6rM6SzmQmK9l5r0cXnBdAmCj6p0P6O28j53y0WwQzYh" crossorigin="anonymous"></script>

<!-- Include jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

<script>
  async function downloadInvoice(button) {
    // Select the order details closest to the button
    const orderDetails = button.closest('.card').querySelector('.order-details').innerText;

    // Create a new PDF instance
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Add content to the PDF
    doc.setFontSize(14);
    doc.text("Order Invoice", 20, 20); // Title
    doc.setFontSize(12);
    doc.text(orderDetails, 20, 30); // Add order details

    // Save the PDF
    doc.save("invoice.pdf");
  }
</script>

<script src="script.js"></script>

</body>
</html>
