 <?php
    $showAlert = false;
    $showError = false;
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        
        include 'Partials/_dbconnect.php';
         $username = $_POST["username"];
         $password = $_POST["password"];
         $phoneno = $_POST["pno"];
         $email = $_POST["email"];
         $cpassword= $_POST["cpassword"];
         
         if($password == $cpassword)
        {
            $sql = "INSERT INTO `users` ( `username`, `phoneno`, `email`, `password`) VALUES ( '$username', '$phoneno', '$email', '$password');";
            $result = mysqli_query($conn,$sql);
            if($result)
            {
              $showAlert=true;
              header("Location: signup.php?signup=success");
              exit();
            }
        }
        else{
          $showError = true;
          header("Location: signup.php?signup=error");
          exit();
        }
   }
   if (isset($_GET['signup']) && $_GET['signup'] == 'success') {
    $showAlert = true;
} elseif (isset($_GET['signup']) && $_GET['signup'] == 'error') {
    $showError = true;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SignUp</title>
    <link rel="stylesheet" href="one.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .alert-position {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
        width: 80%;
        max-width: 500px;
      }

      body{
        background:  #c3cfe2;
      }
    </style>
  </head>
  <body>
    
    <?php
    if($showAlert)
    {
    echo '<div class="alert alert-success alert-position" id="success" role="alert">
          SuccessFully created account!Go back to login page
          </div> ';
    }
    if($showError)
    {
    echo '<div class="alert alert-danger alert-position" id="erroralert" role="alert">
          Password Do Not Match
          </div> ';
    }
?>
<div class="container">
  <div class="left-section">
   <form id="signupForm" class="signup-form" action="signup.php" method="post">
                    <input type="hidden" name="action" value="signup">
                    <div class="form-group"> 
                        <label for="newEmail"> UserName</label>
                        <input type="name" id="newName" placeholder="User Name" name="username" style ="width:25rem;border:1px solid">
                    </div>
                    <div class="form-group"> 
                        <label for="newEmail"> PhoneNumber</label>
                        <input type="text" id="newNumber" placeholder="Phone Number" name="pno" style ="width:25rem;border:1px solid">
                    </div>
                    <div class="form-group">

                        <label for="newEmail"> Email Address</label>
                        <input type="text" id="newEmail" placeholder="newuser@digital.com" name="email" style ="width:25rem;border:1px solid">
                    </div>
                    <div class="form-group">
                        <label for="newPassword">Password</label>
                        <input type="text" id="newPassword" name="password" style ="width:25rem;border:1px solid">
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="text" id="confirmPassword" name="cpassword" style ="width:25rem;border:1px solid">
                    </div>
                    <div class="buttons">
                        <input type="submit" class="btn btn-primary" value="Click" id="signupButton">
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='login.php'" id="loginBtn">Back to Login</button>
                        <br>
                        <div class="alert alert-success" role="alert" id="msg" style="display: none;">
                           Login Success <a href="#" class="alert-link">Redricting to Login page....</a>
                          </div>
                    </div>
                </form>
    
               
                <div class="social-login">
                    <p>Or login with</p>
                    <div class="social-buttons">
                        <a href="#">Facebook</a>
                        <a href="#">LinkedIn</a>
                        <a href="#">Google</a>
                    </div>
                </div>
</div>    
            
            <div class="right-section">
                <nav class="nav">
                    <a href="login.php" >Home</a>
                    <a href="#">About us</a>
                   
                </nav>
                <svg class="illustration" viewBox="0 0 250 250" xmlns="http://www.w3.org/2000/svg">
                <!-- Background -->
                <circle cx="125" cy="125" r="100" fill="#e3f2fd" opacity="0.3"/>
                
                <!-- Left User -->
                <g transform="translate(50 100)">
                    <!-- User Head -->
                    <circle cx="25" cy="0" r="20" fill="#78909c"/>
                    <!-- User Body -->
                    <path d="M25 20 v40 l-15 30 h30 l-15-30 z" fill="#546e7a"/>
                    <!-- E-Waste Items -->
                    <rect x="10" y="60" width="20" height="15" rx="3" fill="#455a64"/>
                    <path d="M20 75 l7.5-15 l7.5 15 z" fill="#757575"/>
                </g>
            
                <!-- Right User -->
                <g transform="translate(175 100)">
                    <!-- User Head -->
                    <circle cx="0" cy="0" r="20" fill="#78909c"/>
                    <!-- User Body -->
                    <path d="M0 20 v40 l-15 30 h30 l-15-30 z" fill="#546e7a"/>
                    <!-- Money/Exchange -->
                    <circle cx="0" cy="60" r="15" fill="#4caf50"/>
                    <text x="0" y="68" font-size="14" text-anchor="middle" fill="white" font-family="Arial">₹</text>
                </g>
            
                <!-- E-Waste Transfer -->
                <g transform="translate(112.5 125)">
                    <!-- Laptop -->
                    <path d="M0 0 l25-12.5 l0 20 l-25 12.5 z" fill="#607d8b"/>
                    <rect x="6" y="2.5" width="13" height="10" fill="#455a64"/>
                    <!-- Phone -->
                    <rect x="-20" y="25" width="10" height="20" rx="2" fill="#757575"/>
                    <rect x="-18" y="27" width="8" height="16" fill="#455a64"/>
                    <!-- Transfer Arrow -->
                    <path d="M-25 65 l50 0 M0 65 l-12.5-7.5 M0 65 l-12.5 7.5" 
                          stroke="#4caf50" 
                          stroke-width="2"/>
                </g>
            
                <!-- Platform Name -->
                <text x="125" y="240" 
                      font-family="Arial" 
                      font-size="22" 
                      text-anchor="middle" 
                      fill="#2e7d32"
                      font-weight="bold">
                    E-HUB
                </text>
            
                <!-- Connection Line -->
                <path d="M75 125 Q125 62.5 175 125" 
                      stroke="#78909c" 
                      fill="none" 
                      stroke-width="2" 
                      stroke-dasharray="4"/>
            </svg>
            </div>
</div>
<script src="a.js">
        
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>