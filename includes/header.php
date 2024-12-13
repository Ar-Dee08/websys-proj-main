<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crumbs & Brew</title>
    <!-- Offcanvas Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <!-- NavBar -->
    <nav class="navbar navbar-expand-lg navbar-light border-bottom shadow-sm custom-navbar" id="mainNavbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Crumbs & Brew</a>
            <button class="btn btn-primary me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                Menu
            </button>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="transaction.php">Transaction</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_admin.php">Administrator</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">
                            <i class="fa-solid fa-shopping-cart"></i> Cart
                        </a>
                    </li>
                </ul>
                <div class="logout-btn">
                    <a class="nav-link" href="signout.php">
                        <i class="fa-solid fa-right-from-bracket"></i> Sign Out
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Offcanvas Sidebar -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div>
        <br>
        <ul class="form-list">
        <li class="form-it">
            <a class="form-lin" href="dashboard.php">
                <i class="fa-solid fa-house"></i> Home
            </a>
        </li>
        <li class="form-it">
            <a class="form-lin collapsible" href="#">
                <i class="fa-solid fa-box"></i> Products
            </a>
            <ul class="form-list sub-list">
                <li class="form-it">
                    <a class="form-lin" href="view_category.php">
                        <i class="fa-solid fa-tags"></i> Category
                    </a>
                </li>
                <li class="form-it">
                    <a class="form-lin" href="add_product.php">
                        <i class="fa-solid fa-plus"></i> Add Products
                    </a>
                </li>
                <li class="form-it">
                    <a class="form-lin" href="view_product.php">
                        <i class="fa-solid fa-images"></i> Product Gallery
                    </a>
                </li>
                <li class="form-it">
                    <a class="form-lin" href="add_order.php">
                        <i class="fa-solid fa-cart-plus"></i> Add New Order
                    </a>
                </li>
            </ul>
        </li>
        <li class="form-it">
            <a class="form-lin" href="view_admin.php">
                <i class="fa-solid fa-user-shield"></i> Administrator
            </a>
        </li>
        <li class="form-it">
            <a class="form-lin" href="view_profile.php">
                <i class="fa-solid fa-user"></i> Profile
            </a>
        </li>
        <li class="form-it">
            <a class="form-lin" href="cart.php">
                <i class="fa-solid fa-shopping-cart"></i> Cart
            </a>
        </li>
        <li class="form-it">
            <a class="form-lin" href="signout.php">
                <i class="fa-solid fa-right-from-bracket"></i> Sign Out
            </a>
        </li>
    </ul>
</div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!-- Additional JavaScript for Offcanvas functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var offcanvasElementList = [].slice.call(document.querySelectorAll('.offcanvas'))
        var offcanvasList = offcanvasElementList.map(function (offcanvasEl) {
            return new bootstrap.Offcanvas(offcanvasEl)
        })
    });
</script>