<?php
include 'Partials/_dbconnect.php';
 $notification_count = 0; 
 if (isset($_SESSION['username'])) {
   $current_user = mysqli_real_escape_string($conn, $_SESSION['username']);
    $sql="SELECT COUNT(*) AS count FROM `notification` WHERE `seller` = '$current_user' AND `is_read` = '0'";
    $result1 = mysqli_query($conn, $sql);
     if ($result1) {
       $row = mysqli_fetch_assoc($result1);
       $notification_count = $row['count'];
    
}
 }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechStore - Home</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;

            --hover-color: #2980b9;
        }

        body {
            background: #c3cfe2;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 56px;
        }

        .navbar {
            background: var(--primary-color) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }


        #search-cnt {
            max-width: 500px;
            margin: 0 auto;

            align-items: center;
            justify-content: center;

            height: auto;
            padding: 0;
            position: relative;
        }

        .navbar {
            min-height: 56px;
            padding: 10px 0;
            /* Adjust padding */
        }

        .map-circle {
            width: 28px;
            height: 28px;
            background-color: #007bff;
            /* Blue Circle */
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 15px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        }

        #floating-map-btn:hover {
            background-color: #0056b3;
        }

        .map-circle i {
            color: white;
            /* Map icon in white */
        }

        .nav-link:hover .map-circle {
            background-color: #0056b3;
            /* Darker blue on hover */
        }
        .button{
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">E-Hub</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'home.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'saleProduct.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="saleProduct.php">Sale Product</a>
                    </li>
                    <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'history.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="history.php">Product History</a>
                    </li>
                    <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'profile.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="map.php" id="map-button">
                            <div class="map-circle">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="notification.php" class="btn position-relative button">
                            <i class="fas fa-bell fa-lg"></i>
                            <?php if ($notification_count > 0) { ?>
                                <span class="badge badge-danger position-absolute top-0 start-100 translate-middle">
                                    <?php echo $notification_count; ?>
                                </span>
                            <?php } ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">logout</a>
                    </li>
                </ul>
                <form class="form-inline ml-3" id="search-cnt" action="home.php" method="GET">
                    <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search products...">
                    <button class="btn btn-outline-light" type="submit">Search</button>

                </form>

            </div>
        </div>
        
    </nav>



    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

    <!-- Custom JS -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        document.querySelector('#search-cnt form').addEventListener('submit', function(e) {
            e.preventDefault();
            const searchTerm = this.querySelector('input').value;
        });
        document.addEventListener("DOMContentLoaded", function() {
            const currentPage = window.location.pathname.split('/').pop().toLowerCase();
            const searchContainer = document.getElementById("search-cnt");
            const hiddenPages = [
                "profile.php",
                "saleProduct.php",
                "productdetails.php",
                "map.php"
            ];
            if (searchContainer) {
                searchContainer.style.display = hiddenPages.includes(currentPage) ? "none" : "flex";
            }
        });
    </script>

</body>

</html>