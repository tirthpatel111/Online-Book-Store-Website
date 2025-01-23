<?php
include 'config.php';
// session_start();

// $user_id = $_SESSION['user_id'];

// if(!isset($user_id)){
//   header('location:login.php');
// }

if (isset($_POST['send'])) {

  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $number = $_POST['number'];
  $msg = mysqli_real_escape_string($conn, $_POST['message']);

  $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

  if (mysqli_num_rows($select_message) > 0) {
     $message[] = 'Message already sent!';
  } else {
     mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
     $message[] = 'Message sent successfully!';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Page</title>

  <!-- Font Awesome for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom Stylesheets -->
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="home.css">
</head>

<body>

  <?php
  include 'user_header.php';
  ?>

  <!-- Contact Us Section -->
  <section class="contact-container container my-5 p-4 shadow-sm bg-white rounded">
    <h2 class="text-center mb-4">Contact Us</h2>
    

    <!-- Contact Information Section -->
    <div class="contact-info mb-4">
      <h3 class="h4 mb-3">Our Bookstore Information</h3>
      <p><strong>Address:</strong> 123,Booksmat, Anand, Gujarat, India</p>
      <p><strong>Phone:</strong>1234567890</p>
      <p><strong>Email:</strong> <a href="mailto:support@bookhaven.com">booksmart@.com</a></p>
      <p><strong>Working Hours:</strong></p>
      <ul class="list-unstyled">
        <li>Monday - Saturday: 9:00 AM - 9:00 PM</li>
  
        
      </ul>
    </div>

    <!-- Map Section showing Anand, Gujarat -->
    <div class="contact-map mb-4">
      <h3 class="h4 mb-3">Find Us on the Map</h3>
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3700.013210040719!2d72.92965341472533!3d22.560482544027407!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395c4971da65a97f%3A0x8862bbbd9e39bb3b!2sAnand%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1628091224406!5m2!1sen!2sin" width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    </div>

  </section>

  <?php
  include 'footer.php';
  ?>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JS -->
  <script src="script.js"></script>

</body>

</html>
