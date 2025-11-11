<?php 
include 'Partials/_dbconnect.php'; 
session_start();
if (!isset($_SESSION['username'])) {
    die("Session not started. Please log in.");
}
    
$current_user = mysqli_real_escape_string($conn, $_SESSION['username']);
?>
<head>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Home Page</title>
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
    
    <?php
    $searchQuery = "";
    if (isset($_GET['search'])) {
        $searchQuery = $_GET['search'];
    }
    if (!empty($searchQuery)) {
        $sql = "SELECT * FROM `product` 
                    WHERE productType LIKE '%$searchQuery%' 
                    AND `status`='available' 
                    ORDER BY 
                        CASE 
                            WHEN productType LIKE '$searchQuery%' THEN 1 
                            ELSE 2 
                        END, productType ASC";
    } else {
        $sql = "SELECT * FROM `product` WHERE `saletype` = 'paid' AND `status`='available' ";
    }

    $result = mysqli_query($conn, $sql);
    ?>
   <?php  include 'nav.php'; ?>
    <div class="row">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $pid = $row['pid'];
                $ptype = $row['productType'];
                $pname = $row['productname'];
                $price = $row['amount'];
                $img = $row['image'];
                $name=$row['username'];
                echo '<div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card mt-4 ml-3" style="width: 18rem;">
                                    <img class="card-img-top fixed-img" src="' . $img . '" alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">' . $ptype . '</h5>
                                        <h5 class="card-title">' . $pname . '</h5>   
                                    </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">₹' . $price . '</li>
                                        </ul>
                                    
                                    <div class="card-body">';
                                    if(strtolower($current_user) !== strtolower($name)) 
                                    {
                                       echo' <a href="buy.php?pid='.$pid.'" class="btn btn-primary">Buy</a>';
                                    }
                                      echo'   <a href="productdetails.php?pid=' . $pid . '" class="btn btn-secondary">View Details</a>';
                if (!empty($searchQuery)) {
                    echo '<a href="home.php" class="btn btn-outline-secondary d-block mt-2">Back to Products</a>';
                }
                echo '</div>
                        </div>
                         </div>';
            }
        } else {
            echo '<div class="col-12 text-center mt-5">
                        <h3>No products found for "' . $searchQuery . '"</h3>
                        <a href="home.php" class="btn btn-primary mt-3">Back to Products</a>
                    </div>';
        }

        ?>
    </div>
</body>

</html>