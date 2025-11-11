<?php
session_start();
include 'Partials/_dbconnect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied! Only Admins can access this page.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_product'])) {
    $pid = mysqli_real_escape_string($conn, $_POST['pid']);
    
    $check_sql = "SELECT * FROM `product` WHERE `pid` = '$pid'";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) == 1) {
        $sql = "DELETE FROM `product` WHERE `pid` = '$pid'";
        if (mysqli_query($conn, $sql)) {
            $msg = "Product Deleted Successfully";
        } else {
            $msg = "Error deleting product: " . mysqli_error($conn);
        }
    } else {
        $msg = "Product not found!";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);

   
    if ($username === "admin") {
        $msg = "Cannot delete admin account!";
    } else {
        $check_sql = "SELECT * FROM `users` WHERE `username` = '$username'";
        $check_result = mysqli_query($conn, $check_sql);
        
        if (mysqli_num_rows($check_result) == 1) {
            $sql = "DELETE FROM `users` WHERE `username` = '$username'";
            if (mysqli_query($conn, $sql)) {
                $msg = "User Deleted Successfully";
            } else {
                $msg = "Error deleting user: " . mysqli_error($conn);
            }
        } else {
            $msg = "User not found!";
        }
    }
}

$sql_products = "SELECT * FROM `product`";
$result_products = mysqli_query($conn, $sql_products);

$sql_users = "SELECT * FROM `users` WHERE `username` != 'admin'"; 
$result_users = mysqli_query($conn, $sql_users);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
        body{
            background-color: #c3cfe2 ;
            color:black;
        }
    </style>
</head>
<body>

    <div class="container mt-4">
        <h2>Welcome, Admin</h2>
        <a href="logout.php" class="btn btn-secondary">Logout</a>

        <?php if (isset($msg)): ?>
            <div id="erroralert" class="alert alert-info "><?php echo $msg; ?></div>
        <?php endif; ?>

        <h3>Manage Products</h3>
        <table class="table table-bordered">
            <tr>
                <th>Product Name</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result_products)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['productname']); ?></td>
                    <td>
                        <form method="POST" action="admin_dashboard.php">
                            <input type="hidden" name="pid" value="<?php echo $row['pid']; ?>">
                            <button type="submit" name="delete_product" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <h3>Manage Users</h3>
        <table class="table table-bordered">
            <tr>
                <th>Username</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result_users)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td>
                        <form method="POST" action="admin_dashboard.php">
                            <input type="hidden" name="username" value="<?php echo $row['username']; ?>">
                            <button type="submit" name="delete_user" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <script src="a.js">
        
        </script>
</body>
</html>
