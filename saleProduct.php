<?php

    session_start(); 
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $showAlert = false;
    $showError = false;
    if (isset($_GET['signup'])) {
        if ($_GET['signup'] == 'success') {
            $showAlert = true;
        } elseif ($_GET['signup'] == 'error') {
            $showError = true;
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'Partials/_dbconnect.php';
        $ptype = $_POST["productType"];
        $name = $_POST["productName"];
        $desc = $_POST["proDesc"];
        $no = $_POST["mobile"];
        $saletype = $_POST["type"];
        $amount = ($saletype == "paid") ? $_POST["amount"] : null;
        $photo = $_FILES["photo"]["name"];
        $targetDir = "C:/xampp/htdocs/EHUB/"; 
        $targetFile = $targetDir . basename($_FILES["photo"]["name"]);
        
        
        if ($_FILES["photo"]["error"] > 0) {
            echo "Error: " . $_FILES["photo"]["error"];
        } else {
            echo "Uploaded file: " . $_FILES["photo"]["name"];
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
                $username = $_SESSION['username'];
                $sql = "INSERT INTO `product`(`productType`, `productname`, `productDesc`, `mobno`, `saletype`, `amount`, `image`,`username`) 
                        VALUES ('$ptype', '$name', '$desc', '$no', '$saletype','$amount','$photo','$username')";
                $result = mysqli_query($conn, $sql);
                
                if ($result) {
                    $_SESSION['amount'] = $amount;
                    $showAlert = true;
                    header("Location:saleProduct.php?signup=success");
                    exit();
                } else {
                    $showError = true;
                    header("Location: saleProduct.php?signup=error");
                    exit();
                }
            } else {
                $showError = true;
                header("Location: saleproduct.php?signup=error");
                exit();
            }
        }
    }
   
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Uploading</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   
    <style>
    body, html {
    height: 100%;
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
   
    }
.container {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
}
.form-container {
    background: white;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    text-align: center;
}
.form-container h2 {
    margin-bottom: 20px;
    color: #2980b9;
}
.form-group {
    position: relative;
    margin-bottom: 20px;
}
.form-group input {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.form-group input:focus {
    outline: none;
    border-color: #2980b9;
}
.form-group label {
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: 16px;
    color: #999;
    transition: all 0.2s;
    pointer-events: none;
}
.form-group input:focus + label,
.form-group input:not(:placeholder-shown) + label {
    top: -15px;
    left: 10px;
    font-size: 12px;
    color: #2980b9;
}
.btn-submit {
    background: #2980b9;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.2s;
}
.btn-submit:hover {
    background: #1f5a8b;
}
                #search-cnt{
                    display: none;
                    }
    </style>
</head>
<body>

<?php include 'nav.php'; ?>
<?php
    if($showAlert)
    {
        echo'<div class="alert alert-success" id="success" role="alert">
                product Upload Succesfully.
          </div> ';
    }
    if($showError)
    {
    echo '<div class="alert alert-danger" id="erroralert" role="alert">
          Invaldi Info Re-enter
          </div> ';
    }
?>
  
    <div class="container">
        <div class="form-container">
            <h2>Submit Product Details</h2>
            <form action="saleProduct.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" id="productType" name='productType' required placeholder="">
                    <label for="productName">Product Type(Eg:Mobile/Laptop)</label>
                </div>
                <div class="form-group">
                    <input type="text" id="productName" name="productName" required placeholder=" ">
                    <label for="productName">Product Name</label>
                </div>
                <div class="form-group">
                    <input type="text" id="productDescription" name="proDesc" required placeholder=" ">
                    <label for="Description">Product Description</label>
                </div>

                <div class="form-group">
                    <input type="number" id="mobileNumber" name="mobile"required placeholder=" ">
                    <label for="mobileNumber">Mobile Number</label>
                </div>
                    <p>Choose Sale Type: </p>
                    <input type="radio" id="free" name="type" value="free" onclick="toggleAmountInput(false)">
                    <label for="free" style="margin-right: 20px;">Sell Free Product</label>
                   
                    <input type="radio" id="paid" name="type" value="paid" onclick="toggleAmountInput(true)">
                    <label for="paid">Sell Paid Product</label>
                
                <div class="form-group">
                    <input type="number"  id="amount" name="amount" style="display:none;" placeholder="Product Amount">
                 
                </div>
               
                <div class="form-group">
                <p>Upload Product Image</p>
                    <input type='file' id="productPhoto" name="photo" required placeholder=" ">
                    <label for="photo"></label>
                </div>
                <input type="submit" class="btn btn-primary" value="Submit" id="signupButton">
            </form>
        </div>
    </div>
    <script src="a.js"></script>

</body>
</html>