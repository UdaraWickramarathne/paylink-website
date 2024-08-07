<?php 
    include 'conf.php';
    session_start();

    function decrypt($encryptedText, $key, $iv){
        $cipher = "AES-128-CBC";
        $encryptedText = base64_decode($encryptedText);
        $decryptedText = openssl_decrypt($encryptedText, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        return $decryptedText;
    }


    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $reciever = $_POST['reciever'];
        $password = $_POST['password'];
        $amount = $_POST['amount'];
        
        $key = '0123456789abcdef';
        $iv = 'RandomInitVector';

        $decryptedAddress = decrypt($reciever, $key, $iv);
        $decryptedAmount = decrypt($amount, $key, $iv);
    
        $stmt = $conn->prepare("SELECT PayeeAddress,Password FROM Clients WHERE PayeeAddress = '$username';");
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row){
            if(password_verify($password, $row['Password'])){
                $_SESSION['payeeAdd'] = $row['PayeeAddress'];
                $_SESSION['pAddress'] = $decryptedAddress;
                $_SESSION['amount'] = $decryptedAmount;

                header('Location: send-money.php');
                exit();
            }
            else{
                $_SESSION['error'] = 'Invalid Login Credentials';
                header("Location: index.php?pAddress=".urlencode($reciever)."&amount=".urlencode($amount));
                exit();
            }      
        }
        else{
            $_SESSION['error'] = 'Invalid Login Credentials';
            header("Location: index.php?pAddress=".urlencode($reciever)."&amount=".urlencode($amount));
            exit();
        }

    }
 
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1fe1956322.js" crossorigin="anonymous"></script>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgb(61, 61, 61);
            overflow: hidden;
        }
        form {
            display: flex;
            width: 900px;
            height: 550px;
            background-color: black;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }
        #particles-js {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .img-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 300px;
            background-color: hsl(0, 0%, 18%);
            height: 100%;
            padding: 1em;
            box-sizing: border-box;
        }
        .img-container img {
            margin-top: 1.8em;
            margin-bottom: 10em;
        }
        .img-container p, h4 {
            margin: 0;
            color: #ffffff;
        }
        .img-container h4 {
            margin-bottom: 1em;
        }
        .login-container {
            display: flex;
            flex-direction: column;
            width: 600px;
            background-color: black;
            height: 100%;
            padding: 1em;
            box-sizing: border-box;
            position: relative;
        }
        .login-container h5, label {
            color: #ffffff;
        }
        .login-container h5 {
            font-size: 1.5em;
            margin-left: 2.6em;
            margin-top: 3em;
            margin-bottom: 4em;
        }
        .input-field {
            margin-left: 5em;
            margin-right: 5em;
            margin-bottom: 3em;
            background-color: transparent;
            border: none;
            border-bottom: white 2px solid;
            outline: none;
            color: white;
            font-size: 1em;
        }
        .checkbox-container {
            align-self: flex-end;
            margin-right: 5em;
        }
        .checkbox-container input:hover {
            cursor: pointer;
        }
        #submit-btn {
            background-color: #007BFF;
            color: white;
            font-size: 1.2em;
            margin-top: 3.4em;
            margin-left: 8em;
            margin-right: 8em;
            height: 2.8em;
            border: none;
            border-radius: 25px;
            transition: background-color 0.15s;
        }
        #submit-btn:hover{
            cursor: pointer;
            background-color: black;
            border: 1px solid #007BFF;
        }

        .error{
            position: absolute;
            bottom: 7.8em;
            left: 5.8em;
            color: red;
            width: 100%;
        }
        #reciever {
            display: none;
        }
        @media (max-width: 768px) {
            body {
                padding: 0 1em;
            }

            form {
                flex-direction: column;
                width: 100%;
                height: auto;
                margin: 0 1em;
                border-radius: 15px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .img-container, .login-container {
                width: 100%;
                height: auto;
                background-color: black;
                border-radius: 30px;
            }

            .img-container img {
                margin-bottom: 1em;
            }

            .login-container h5 {
                margin-left: 1em;
                margin-top: 1em;
                margin-bottom: 1em;
            }

            .input-field {
                margin-left: 1em;
                margin-right: 1em;
            }

            .checkbox-container {
                margin-right: 1em;
            }

            #submit-btn {
                margin-left: 1em;
                margin-right: 1em;
                margin-bottom: 1em;
            }

            .error {
                left: 2em;
                bottom: 6em;
            }

        }

        @media (max-width: 480px) {

            body {
                padding: 0 0.5em;
            }

            form {
                flex-direction: column;
                width: 100%;
                height: auto;
                margin: 0 0.5em;
                border-radius: 15px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            
            .login-container h5 {
                font-size: 1.2em;
                margin-left: 1em;
                margin-top: 1em;
                margin-bottom: 1em;
            }

            .input-field {
                margin-left: 1em;
                margin-right: 1em;
                font-size: 0.9em;
            }

            .checkbox-container {
                margin-right: 1em;
            }
               
            #submit-btn {
                margin-left: 1em;
                margin-right: 1em;
                margin-bottom: 1em;
                font-size: 1em;
                height: 2.5em;
            }

        }
    </style>
</head>
<body>
    <div id="particles-js"></div>
    <form action="index.php" method="post">
        <div class="img-container">
            <img src="logo.png" width="164px">
            <h4><i class="fa-solid fa-bug" style="color: #ffffff;"></i> Having Problems?</h4>
            <p>Contact us <i class="fa-solid fa-phone" style="color: #ffffff;"></i></p>
            <p>(011) 232 6203/ (011) 535 2748</p>
        </div>
        <div class="login-container">
            <h5>Welcome Back!</h5>
            <input type="text" placeholder="Payee Address" class="input-field" required id="username" name="username">
            <input type="hidden" name="reciever" id="reciever" value="<?php echo isset($_GET['pAddress']) ? htmlspecialchars($_GET['pAddress'], ENT_QUOTES, 'UTF-8') : ''; ?>">
            <input type="hidden" name="amount" id="amount" value="<?php echo isset($_GET['amount']) ? $_GET['amount'] : ''; ?>">
            <input type="password" placeholder="Password" class="input-field" required id="password" name="password">
            <div class="checkbox-container">
                <input type="checkbox" name="showPassword" id="show-password" onclick="togglePasswordVisibility()"><label for="showPassword">Show Password</label>
            </div>
            <span class="error" id="error-message">
                <?php
                    if(isset($_SESSION['error'])){
                        echo $_SESSION['error'];

                        unset($_SESSION['error']);
                    }
                ?>
            </span>
            <input type="submit" value="Login" id="submit-btn" name="submit">
        </div>
    </form>
    <script src="particles.js"></script>
    <script src="app.js"></script>
    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById("password");
            const showPasswordCheckbox = document.getElementById("show-password");
            if (showPasswordCheckbox.checked) {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            const form = document.querySelector('form');
            const errorMessage = document.getElementById('error-message');

            form.addEventListener('submit', () => {
                errorMessage.textContent = '';
            });
        });
    </script>
</body>
</html>

