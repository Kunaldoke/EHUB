<?php
session_start();
include 'Partials/_dbconnect.php';
include 'nav.php';
if (!isset($_SESSION['username'])) {
    die("Session not started. Please log in.");
}
$username = $_SESSION['username'] ?? null;
if(isset($_GET['pid'])) {
    $product_id = $_GET['pid'];
    
    $sql = "SELECT * FROM `product` WHERE pid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows == 1) {
        $product = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Product Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
        body{
            background-color: #c3cfe2;
        }
        .product-container {
            max-width: 800px;
            margin: 80px auto 30px;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .product-img {
            max-width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
        }
        #search-cnt{
                    display: none;
                    }
    </style>
</head>
<body>
    <div class="product-container">
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" class="product-img" alt="Product Image">
            </div>
            <div class="col-md-6">
                <h2><?php echo htmlspecialchars($product['productname']); ?></h2>
                <h4 class="text-muted"><?php echo htmlspecialchars($product['productType']); ?></h4>
                <hr>
                <h3 class="text-primary">₹<?php echo number_format($product['amount'], 2); ?></h3>
                <p class="mt-4"><?php echo htmlspecialchars($product['productDesc']); ?></p>
               
                <div class="mt-4">
                <?php if ($username !== $product['username']) { ?>
                    <a href="buy.php" class="btn btn-primary">Buy</a>
                 <?php } else { ?>
                 <p class="text-muted"><strong>This is your product listing.</strong></p>
                <?php } ?>
                    <a href="home.php" class="btn btn-outline-secondary">Back to Products</a>
                    <a href="history.php" class="btn btn-outline-secondary">History</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    } else {
        echo "<div class='alert alert-danger mt-5'>Product not found</div>";
    }
} else {
    echo "<div class='alert alert-danger mt-5'>Invalid product request</div>";
}

