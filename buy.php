<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'Partials/_dbconnect.php';
    $cardNo = $_POST["cardNo"];
    $date = $_POST["date"];
    $cvc = $_POST["cvc"];
    $cname = $_POST["cName"];
    $country = $_POST["country"];
    $zipCode = $_POST["zipCode"];
    $username = $_SESSION['username'];
    if (!isset($_SESSION['pid'])) {
        die("Product ID not specified!");
    }
    $pid = $_SESSION['pid'];
    $sql_product = "SELECT productname,amount,username,mobno FROM product WHERE pid = '$pid'";
    $result_product = mysqli_query($conn, $sql_product);
    $product = mysqli_fetch_assoc($result_product);
    $amount = $product['amount'];
    $pname = $product['productname'];
    $contact=$product['mobno'];
    $sql = "INSERT INTO `payment`(`CardNumber`,`cardHolderName`, `ExpiryDate`, `CVC`, `Country`, `ZipCode`, `Username`, `amount`,`pid`,`pname`) VALUES ('$cardNo','$cname','$date','$cvc','$country','$zipCode','$username','$amount','$pid','$pname')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script>document.getElementById('loading').style.display = 'flex';</script>";
        sleep(4);
        $update_sql = "UPDATE `product` SET `status` = 'sold' WHERE `pid` = '$pid'";
        mysqli_query($conn, $update_sql);
        $seller = mysqli_real_escape_string($conn, $product['username']);
        $message = mysqli_real_escape_string($conn, "Your product $pname was bought by $username.\n Contact No : $contact ");
        $sql1="INSERT INTO `notification`( `seller`, `message`) VALUES ('$seller','$message')";
        mysqli_query($conn,$sql1);
        header("Location: sucess.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Payment Form</title>
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #4f46e5;
            --background: #f8fafc;
            --text: #1e293b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--background);
            min-height: 100vh;
            display: grid;
            place-items: center;
            margin: 0;
            padding: 20px;
        }

        .payment-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            margin-top: 20px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header h1 {
            color: var(--text);
            margin: 0 0 0.5rem;
            font-size: 1.8rem;
        }

        .payment-methods {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .payment-method {
            flex: 1;
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }

        .payment-method.active {
            border-color: var(--primary);
            background: #eef2ff;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .input-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #64748b;
            font-weight: 500;
        }

        .input-field {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .input-field:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .split-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .submit-btn:hover {
            background: var(--secondary);
            transform: translateY(-1px);
        }

        @media (max-width: 480px) {
            .payment-card {
                padding: 1.5rem;
            }

            .split-inputs {
                grid-template-columns: 1fr;
            }
        }

        #search-cnt {
            display: none;
        }
    </style>
</head>

<body>
    <?php include 'nav.php'; ?>
    <?php include 'Partials/_dbconnect.php'; ?>
    <?php
    $name = '';
    $price = 0;
    if (isset($_GET['pid'])) {
        $product_id = mysqli_real_escape_string($conn, $_GET['pid']);
        $sql = "SELECT * FROM `product` WHERE pid = '$product_id'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $price = $row['amount'];
            $name = $row['productname'];
            $_SESSION['amount'] = $price;
            $_SESSION['pid'] = $product_id;
        }
    }

    ?>
    <div class="payment-card">
        <div class="form-header">
            <h1>Secure Payment</h1>
            <p>Complete your purchase</p>
            <p>Payment For: <?php echo htmlspecialchars($name) ?></p>
        </div>

        <div class="payment-methods">
            <div class="payment-method active">
                <img src="visa.webp" alt="Visa" width="60">
            </div>
            <div class="payment-method">
                <img src="mastercard.jpg" alt="Mastercard" width="60">
            </div>
            <div class="payment-method">
                <img src="paypal.png" alt="PayPal" width="60">
            </div>
        </div>

        <form action="buy.php" method="post">
            <div class="form-group">
                <label class="input-label">Card Number</label>
                <input type="text" class="input-field" name="cardNo" placeholder="4242 4242 4242 4242" required>
            </div>

            <div class="split-inputs">
                <div class="form-group">
                    <label class="input-label">Expiration Date</label>
                    <input type="month" name="date" class="input-field" required>
                </div>
                <div class="form-group">
                    <label class="input-label">CVC</label>
                    <input type="text" name="cvc" class="input-field" placeholder="123" required>
                </div>
            </div>

            <div class="form-group">
                <label class="input-label">Cardholder Name</label>
                <input type="text" name="cName" class="input-field" placeholder="John Doe" required>
            </div>

            <div class="split-inputs">
                <div class="form-group">
                    <label class="input-label">Country</label>
                    <select class="input-field" name="country" required>
                        <option>India</option>
                        <option>USA</option>
                        <option>UK</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="input-label">ZIP Code</label>
                    <input type="text" name="zipCode" class="input-field" placeholder="400001" required>
                </div>
            </div>
            <input type="hidden" name="pid" value="<?php echo $product_id; ?>">

            <button type="submit" class="submit-btn">
                Pay ₹<?php echo isset($price) ? htmlspecialchars($price) : 0; ?>
            </button>

        </form>
    </div>

    <script>
        document.querySelectorAll('.payment-method').forEach(item => {
            item.addEventListener('click', () => {
                document.querySelectorAll('.payment-method').forEach(el => {
                    el.classList.remove('active');
                });
                item.classList.add('active');
            });
        });
    </script>
</body>

</html>