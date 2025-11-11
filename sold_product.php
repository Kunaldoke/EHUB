<?php
session_start();
include 'Partials/_dbconnect.php';
if (!isset($_SESSION['username'])) {
    header("Location:home.php");
    exit();
}
$username = mysqli_real_escape_string($conn, $_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }
        .fixed-img {
            width: 250px;
            height: 250px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <?php include 'nav.php'; ?>
    <?include 'Partials/_dbconnect.php';?>
    <?php
    $sql="SELECT * FROM `product` WHERE username = '" . mysqli_real_escape_string($conn, $username) . "'";
             $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card mt-4 ml-3" style="width: 18rem;">
                                    <img class="card-img-top fixed-img" src="' . $row['image']. '" alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">' . $row['productType'] . '</h5>
                                        <h5 class="card-title">' . $row['productname'] . '</h5>   
                                    </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">₹' . $row['amount'] . '</li>
                                        </ul>
                                    <div class="card-body">
                                        
                                         <a href="productdetails.php?pid=' .$row['pid'] . '" class="btn btn-secondary">View Details</a>';
               
        }
    }
    else {
        echo '<div class="col-12 text-center mt-5">
                    <h3>"No products found for sale ! We Recommend You to Upload the Products for Sale!!"</h3>
                     <a href="saleProduct.php" class="btn btn-primary mt-3">Sale Product</a>
                   <a href="home.php" class="btn btn-secondary mt-3">Back to Products</a>
                    <a href="history.php" class="btn btn-secondary mt-3">Back to History</a>

                </div>';
    }
    ?>
</body>

</html>