<?php
ob_start(); // Start output buffering
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('db/db_connection.php');

// Check if category ID is provided and user confirmed the deletion
if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    $category_id = $_GET['id'];
    $query = "DELETE FROM categories WHERE category_id = '$category_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header('Location: view_category.php');
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Category</title>
    <script>
        // JavaScript to confirm deletion
        function confirmDeletion(categoryId) {
            if (confirm("Are you sure you want to delete this category?")) {
                // Redirect with confirmation
                window.location.href = "delete_category.php?id=" + categoryId + "&confirm=yes";
            } else {
                // Redirect back to categories list
                window.location.href = "view_category.php";
            }
        }
    </script>
</head>
<body>
    <?php if (isset($_GET['id']) && !isset($_GET['confirm'])): ?>
        <!-- Show confirmation prompt -->
        <script>
            confirmDeletion(<?php echo json_encode($_GET['id']); ?>);
        </script>
    <?php endif; ?>
</body>
</html>
