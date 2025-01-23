<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
}

.user_header {
    background-color:003049; 
    padding: 15px 20px;
}

.header_1 {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.user_flex {
    display: flex;
    align-items: center; 
}


.logo_cont {
    display: flex;
    align-items: center;
}

.logo_cont img {
    width: 50px; 
    margin-right: 10px; 
}

.book_logo {
    font-size: 24px;
    color:white; 
    text-decoration: none;
    font-weight: bold;
}

.navbar {
    margin-left: 300px;
    display: flex;
    gap: 20px; 
}

.navbar a {
    text-decoration: none;
    color: white; 
    padding: 10px 15px;
    transition: color 0.3s ease;
}

.navbar a:hover {
    color: #0056b3; 
    border-bottom: 2px solid #0056b3; 
}

.login a{
    color:white;
    justify-content: flex-end;
    gap: 20px;

    
}
.home_cont{
  width: 100%;
  height: 60vh;
  background: linear-gradient(rgba(0,0,0,0.7),rgba(0,0,0,0.7)), url("b.avif") no-repeat;
  background-size: cover;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.home_cont .main_descrip h1{
  font-size: 3.5rem;
  letter-spacing: 2.5px;
  text-transform: uppercase;
  color: white;
}

.home_cont .main_descrip p{
  font-size: 2rem;
  font-weight: 500;
  letter-spacing: 1px;
  color: white;
}

.home_cont .main_descrip button{
  margin: 1rem;
  padding: 1rem 2rem;
  background-color: #669bbc;
  border: none;
  font-size: 1.2rem;
  font-weight: 600;
  letter-spacing: 1px;
  border-radius: 20px;
  box-shadow: 2px 2px 10px rgb(92, 92, 92);
}

.home_cont .main_descrip button:hover{
  background-color: white;
  color: #003049;
}
</style>
<?php

?>
<header class="user_header">
    <div class="header_1">
        <div class="user_flex">
            <div class="logo_cont">
                <img src="book_logo.png" alt="Bookiee Logo">
                <a href="" class="book_logo">Bookiee</a>
            </div>
           
            </div>
                
            <nav class="login"> 
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
            </nav>   
    </div>
</header>
<section class="home_cont">
    <div class="main_descrip">
      <h1>The Bookshelf</h1>
      <p>Explore, Discover, and Buy Your Favorite Books</p>
      <!-- <button>Discover More</button> -->
    </div>
  </section>

  <style>
  .footer{
    background-color: #003049;
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding-bottom: 2rem;
    gap: 1rem;
    cursor: pointer;
}

.footer_box_container{
    width: 90%;
    display: flex;
    padding: 2rem;
    justify-content: space-between;
}

.footer_box{
    display: flex;
    flex-direction: column;
    cursor: pointer;
    width: 25%;
}

.footer_box h3{
    font-size: 1.5rem;
    font-weight: 500;
    letter-spacing: 1px;
    margin-bottom: 0.5rem;
}

.footer_box p{
    font-size: 1rem;
    letter-spacing: 1px;
    margin-top: 0.5rem;
}

.footer_box a{
    color: white;
    text-decoration: none;
    font-size: 1rem;
    letter-spacing: 0.6px;
    margin-top: 0.5rem;
}

.footer_box a:hover::after{
    content: "";
    display: block;
    width: 35px;
    border-bottom: 2px solid #669bbc;
}

.footer_logo_cont{
    width: 100%;
    display: flex;
    gap: 0.5rem;
    align-items: center;
    margin-bottom: 0.5rem;
    
}
.footer_logo_cont a{
    font-size: 1.5rem;
    font-weight: 500;
    letter-spacing: 1px;
}
.footer_logo_cont img{
    width: 10%;
}
.footer_box .footer_logo_cont a:hover::after{
    display: none;
}
</style>


  <?php
  include "footer.php";
  ?>