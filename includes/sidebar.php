<div class="sidebar">
    <a href="dashboard.php">Home</a>
    <a href="products.php">Products</a>
    <a href="customer.php">Customer</a>
    <a href="profile.php">Profile</a>
    <a href="signout.php">Sign Out</a>
</div>

<style>
.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  width: 200px; /* adjust the width as needed */
  height: 100vh;
  background-color: #f0f0f0;
  padding: 20px;
  box-sizing: border-box;
}

.sidebar a {
  display: block;
  padding: 10px;
  text-decoration: none;
  color: #333;
  border-bottom: 1px solid #ccc;
}

.sidebar a:hover {
  color: #666;
}

.sidebar a:last-child {
  border-bottom: none;
}
</style>