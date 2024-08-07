<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayLink Login Page</title>
    <script src="https://kit.fontawesome.com/ff0d0f7bd0.js" crossorigin="anonymous"></script>
    
    <style>

    body {
    font-family: 'poppins';
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background-color: #9bb3ff;
    }

    .container{
        display: flex;
        width: 100%;
        max-width: 900px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        border-radius: 30px;
        overflow: hidden;
    }

    .sidebar {
        width: 60%; 
        background-color: #0d1e36;
        color: #fff;
        padding: 100px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .sidebar .logo img {
        width: 50%; 
        margin-bottom: 20px;
    }

    .sidebar p {
        font-size: 14px;
        margin: 5px 0;
        line-height: 1.5;
    }

    .contact-info {
        margin-top: 40px;
    }

    .contact-info h3 {
        font-size: 14px;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .contact-info p {
        font-size: 12px;
    }

    .login-form {
        padding: 100px;
        text-align: center;
        color: white;
        width: 80%; 
        background-color: rgb(54, 54, 54);
    }
    .input-field input{
        font-size: 16px;
        align-items: center;
        background-color: rgb(54, 54, 54);
        width: 80%;
        text-align: center;
        color: white;
        padding: 10px;
        margin: 10px;
        border: none;
        border-bottom: 2px solid white;
        transition: border 0.3s ease;
    }
    .input-field input:valid,
    .input-field input:focus{
        border-bottom: 3px solid #3b70b9 ;
        outline: none;
        transition: border 0.3s ease;
    }
    .checkbox {
            justify-content: center;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            margin-right: 28px;
    }
    .checkbox input {
            margin-right: 10px;
            transform: scale(1.2);
            cursor: pointer;
    }
    .show-password{
        text-align: center;
    }
    .error-message{
        margin: 0;
        color: rgb(255, 73, 73);
        text-align: center;
    }
    .login-button{
        font-family: 'poppins';
        font-weight: bold;
        background-color: #0d1e36;
        color: white;
        border: none;
        border-radius: 10px;
        width: 40%;
        padding: 10px;
        cursor: pointer;
        font-size: 16px;
    }
    .login-button:hover{
        background-color: #8995a7;
        transition: background-color 0.3s ease;
    }
    .forget-password {
            color: #5599ff;
            font-size: 14px;
            text-decoration: none;
            transition: color 0.3s ease;
            display: block;
            text-align: center;
    }
    .forget-password:hover {
            color: #fff;
    }

    @media (max-width: 768px) {
            .container {
                flex-direction: column;
                width: 95%;
            }

            .sidebar, .login-form {
                width: 100%;
                padding: 20px;
            }

            .login-form {
            align-items: center;
            }

            .input-field, .login-button {
                width: 80%;
            }
    }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="logo">
                <img src="paylink-high-resolution-logo-transparent.png" alt="PayLink Logo">
            </div>
            <div class="contact-info">
                <h3>Having Problems? <i class="fa-solid fa-bug" style="color: #ffffff;"></i></h3>
                <p>Contact us <i class="fa-solid fa-phone" style="color: #ffffff;"></i></p>
                <p> (011) 232 6203 / (011) 535 2748</p>
            </div>
        </div>
        <div class="login-form">
            <h2>Welcome Back!</h2>
            <form action="login.php" method="POST">
                <div class="input-field">                   
                    <input type="text" id="username" placeholder="Enter your username" required name="username">
                </div>
                <div class="input-field">
                    
                    <input type="password" id="password" placeholder="Enter your password" required name="password">
                </div>
                <?php if (isset($_GET['error'])): ?>
                    <p class="error-message" id="errorMessage"><?php echo htmlspecialchars($_GET['error']); ?></p>
                <?php else: ?>
                    <p class="error-message" id="errorMessage">Invalid username or password</p>
                <?php endif; ?>
                <div class="checkbox">
                <div class="checkbox">
                    <input type="checkbox" id="show-password" onclick="togglePasswordVisibility()">
                    <label for="show-password">Show Password</label>
                </div>
                <input type="submit" class="login-button" name="submit" value="Login">
                <br>
                <a href="#" class="forget-password">Forget Password</a>
            </form>
        </div>
    </div>

    <script>
        // Function to toggle password visibility
        function togglePasswordVisibility() {
            const passwordField = document.getElementById("password");
            const showPasswordCheckbox = document.getElementById("show-password");
            if (showPasswordCheckbox.checked) {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }

        function validateForm() {
            // Replace this with actual validation logic or API call
            const username = document.getElementById("username").value;
            const password = document.getElementById("password").value;

            if (username !== "admin" || password !== "password123") {
                // Show error message
                const errorMessage = document.getElementById("errorMessage");
                errorMessage.style.display = "block";
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
    </script>
</body>
</html>

<?php 
    $servername = "udara-mssql-udniko25-1cfd.e.aivencloud.com";
    $username = "avnadmin";
    $password = "AVNS_Q5mHKsjZjlm1NeRLbdj";
    $dbname = "paylink_db";
    $port = 14502;
    

    $conn = mysqli_connect($servername, $username, $password, $dbname, $port);

    if(!$conn){
        die("error");
    }

    if(isset($_POST['submit'])){
        $user = $_POST['username'];
        $pass = $_POST['password'];

        $result = mysqli_query($conn, "SELECT * FROM Clients WHERE PayeeAddress = '$user' AND Password = '$pass'");

        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            echo $row['FirstName'];
        }
        else{
            header("Location: login.php?error=Invalid login");
            exit();
        }
    }

    


?>