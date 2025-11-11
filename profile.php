<?php
session_start();
include 'Partials/_dbconnect.php';

// Check if the user is logged in
if (!isset($_SESSION['sno'])) {
    header("Location: logout.php"); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['sno']; // Get logged-in user's ID
$sql = "SELECT * FROM `users` WHERE sno = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows == 0) {
    echo "User not found.";
    exit();
}

$user = $result->fetch_assoc();
$product_sql = "SELECT * FROM `product` WHERE username = ?";
$product_stmt = $conn->prepare($product_sql);
$product_stmt->bind_param("s", $user['username']); // Using username from user data
$product_stmt->execute();
$product_result = $product_stmt->get_result();
?>


<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <style>
        .profile-container {
        max-width: 500px;
        margin: 80px auto 30px;
        padding: 30px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        
    }  
    .profile-actions {
        text-align: center;
        margin-top: 25px;
    }
    .profile-actions a {
        display: inline-block;
        padding: 10px 25px;
        margin: 0 10px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .profile-details {
        width: 100%;
        margin: 20px 0;
        background: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        text-align: center;
    }

    .detail-row {
        display: flex;
        border-bottom: 1px solid #eee;
        padding: 15px 20px;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        width: 200px;
        font-weight: 600;
        color: #2c3e50;
        padding-right: 20px;
    }

    .detail-value {
        flex: 1;
        color: #34495e;
    }

    .profile-actions a[href="logout.php"] {
        background-color: #e74c3c;
        color: white;
        border: 2px solid #e74c3c;
    }

    .profile-actions a:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        opacity: 0.9;
    }
    .profile-container h2{
        text-align: center;
    }
    .product-section {
        margin-top: 40px;
    }
    
    .product-section h3 {
        color: #2c3e50;
        border-bottom: 2px solid #2c3e50;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    @media (max-width: 768px) {
        .profile-container {
            margin: 80px 15px 30px;
            padding: 20px;
        }
        
      
        .profile-actions a {
            display: block;
            margin: 10px 0;
        }
    }
    #search-cnt{
        display: none;
    }
</style>
</head>
<body>
    <?php include 'nav.php'; ?>
    <div class="profile-container">
        <h2>User Profile</h2>
        
        <div class="profile-details">
            <div class="detail-row">
                <div class="detail-label">User ID</div>
                <div class="detail-value"><?php echo htmlspecialchars($user['sno']); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Username</div>
                <div class="detail-value"><?php echo htmlspecialchars($user['username']); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Phone Number</div>
                <div class="detail-value"><?php echo htmlspecialchars($user['phoneno']); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Email</div>
                <div class="detail-value"><?php echo htmlspecialchars($user['email']); ?></div>
            </div>
        </div>

               
        <div class="profile-actions">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>