</div>
</div>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Play&display=swap" rel="stylesheet"> 
<link rel="stylesheet" href="styles.css">

<footer>
    <div>
        <img src="" alt="">
    </div>
  <div class="footer" style="margin: 20px 0;">
    
    <!-- Icons Row -->
    <div class="row icons-row">
      <a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a>
      <a href="https://www.instagram.com"><i class="fa fa-instagram"></i></a>
      <a href="mailto:blank"><i class="fa-solid fa-envelope"></i></a>
      <a href="https://discord.com/"><i class="fa-brands fa-discord"></i></a>
    </div>

    <!-- Links Row -->
    <div class="row">
      <ul style="list-style: none; padding: 0; display: flex; justify-content: center; gap: 5.0px;">

      <!-- To change, synch with the contents. -->
      <li class="nav-item">
        <a class="nav-link" href="dashboard.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="products.php">Products</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="cart.php">Cart</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admins.php">Administrator</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="view_profile.php">Profile</a>
      </li>
      </ul>
    </div>

    <!-- Footer Text -->
    <div class="row-c" style="margin-top: 10px;">
      Crumbs and Brew © 2024 - All Rights Reserved.
    </div>
  </div>
</footer>

<!-- Footer Internal Styles -->
<style>
  .footer {
    max-height: 50%;
    width: 100%;
    background: #4a4a4a;
    color: #e0e0e0;
    padding: 30px 0;
    font-family: 'Play', sans-serif;
    text-align: center;
    margin: 20px 0px 0px 0px;
    overflow-x: hidden;
    position: absolute;
    font-family: 'Inter', sans-serif;
}

.icons-row {
    justify-content: center;
    align-items: center;
    gap: 20px;
    display: inline-block;
    bottom: 20%;
    margin-bottom: 40px;
}

.icons-row a i {
    font-size: 2em;
    color: #e0e0e0;
    transition: color 0.3s ease;
}

.icons-row a:hover i {
    color: #b0b0b0;
}

.footer .row a {
    text-decoration: none;
    color: #e0e0e0;
    transition: 0.5s;
}

.footer .row a:hover {
    color: #b0b0b0;
}

.footer .row ul {
    width: 100%;
    padding: 0;
    list-style: none;
}

.footer .row ul li {
    display: inline-block;
    margin: 0 30px;
}

.footer .row-c {
    margin-top: 10px;
}
</style>
