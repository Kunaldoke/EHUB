<?php
session_start();
include 'Partials/_dbconnect.php';
if (!isset($_SESSION['username'])) {
    die("Login to see notification");
}
$current_user = mysqli_real_escape_string($conn, $_SESSION['username']);
$sql = "SELECT * FROM `notification` WHERE `seller`='$current_user' ORDER BY createdAt DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification</title>
    <style>
        #search-cnt {
            display: none;
        }

        .notifications-container {
            max-width: 600px;
            margin: 50px auto;
        }

        .notifications-header {
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include 'nav.php'; ?>
    <div class="notifications-container">
        <h4 class="notifications-header"><i class="fas fa-bell"></i> Notifications</h4>
        <hr>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <ul class="list-group">

                    <li class="list-group-item">
                        <i class="fas fa-check-circle text-success"></i> <?php echo nl2br( htmlspecialchars($row['message']))?>
                        <br>
                        <small><?= date('M d, Y h:i A', strtotime($row['createdAt'])) ?></small>
                    </li>

                </ul>
            <?php endwhile; ?>
            <?php
            $update_sql = "UPDATE `notification` SET `is_read`='1' WHERE `seller`='$current_user'";
            mysqli_query($conn, $update_sql);
            ?>


        <?php else: ?>
            <p class="text-muted text-center"><i class="fas fa-inbox"></i> No new notifications.</p>
        <?php endif; ?>
        <div class="text-center mt-3">
            <a href="home.php" class="btn btn-primary">Back to Home</a>
        </div>
    </div>
</body>

</html>