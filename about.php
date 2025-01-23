<?php
include 'config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Page</title>

  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ3QqNGr1jPzF6xYwbw68fSffM4+XQxhYOpxLZjj+YuPeUtM0g3tGz4k1tQ8" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> 
</head>
<body>

<?php include 'user_header.php'; ?>


<section class="about py-5">
  <div class="container">
    
    <div class="row justify-content-center mb-5">
      <div class="col-12 col-md-8">
        
        <img class="img-fluid rounded mx-auto d-block" src="about1.jpg" alt="About Us" style="max-height: 400px; object-fit: cover;">
      </div>
    </div>


    <div class="row">
      <div class="col-12">
        <h2 class="text-center mb-4 text-dark">Why Choose Us?</h2>
        <p class="text-dark lead">
          At Book Store, we are more than just an online bookstore - we are your trusted partner in the world of literature. Here’s why you should choose us for your next book purchase:
        </p>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">1. <strong>Extensive Selection</strong></li>
          <li class="list-group-item">2. <strong>Competitive Prices</strong></li>
          <li class="list-group-item">3. <strong>Personalized Recommendations</strong></li>
          <li class="list-group-item">4. <strong>Fast & Reliable Delivery</strong></li>
          <li class="list-group-item">5. <strong>Customer-Focused Service</strong></li>
          <li class="list-group-item">6. <strong>User-Friendly Experience</strong></li>
          <li class="list-group-item">7. <strong>Supporting Independent Authors</strong></li>
          <li class="list-group-item">8. <strong>Passion for Books</strong></li>
        </ul>
      </div>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb4mCkYemLJytabC7QTfnFJrgHmqNG4W8pyH1lNUa4rI0epyt" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0ed5H6rM6SzmQmK9l5r0cXnBdAmCj6p0P6O28j53y0WwQzYh" crossorigin="anonymous"></script>

<script src="script.js"></script>
</body>
</html>
