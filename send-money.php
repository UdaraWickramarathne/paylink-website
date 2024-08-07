<?php 
    include 'conf.php';
    session_start();
    
    if(isset($_POST['submit'])){
        $sender = $_POST['sender'];
        $reciever = $_POST['reciever'];
        $amount = $_POST['amount'];
        $message = $_POST['message-box'];

        $amount = doubleval($amount);

        if($amount < getClientBal($sender)){
            reduceFromSender($sender,$amount);
            addToReciever($reciever, $amount);
            addNewTransaction($sender, $reciever, $amount,$message);
            $_SESSION['message'] = '<span class="success">Payment sent successfully!</span>';
        }
        else{
            $_SESSION['message'] = '<span class="error">Invalid amount.</span>';
        }
        
    }

    function getClientBal($sender){
        $balance = 0;
        include 'conf.php';
        $stmt = $conn->prepare("SELECT Balance FROM SavingsAccounts WHERE Owner = '$sender';");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
            $balance = $row['Balance'];
        }
        return $balance;

    }

    function reduceFromSender($sender,$amount){
        include 'conf.php';
        $newBalance = getClientBal($sender) - $amount;
        $stmt = $conn->prepare("UPDATE SavingsAccounts SET Balance = '$newBalance' WHERE Owner = '$sender';");
        $stmt->execute();
    }

    function addToReciever($reciever, $amount){
        include 'conf.php';
        $newBalance = getClientBal($reciever) + $amount;
        $stmt = $conn->prepare("UPDATE SavingsAccounts SET Balance = '$newBalance' WHERE Owner = '$reciever';");
        $stmt->execute();
    }

    function addNewTransaction($sender,$reciever,$amount,$message){
        include 'conf.php';
        $date = date('Y-m-d');
        $stmt = $conn->prepare("INSERT INTO Transactions (Sender, Receiver, Amount, Date, Message) VALUES ('$sender', '$reciever', '$amount', '$date', '$message');");
        $stmt->execute();
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
            width: 1100px;
            height: 700px;
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
            width: 400px;
            background-color: hsl(0, 0%, 18%);
            height: 100%;
            padding: 1em;
            box-sizing: border-box;
        }
        .login-container {
            display: flex;
            flex-direction: column;
            width: 700px;
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
            margin-left: 1em;
            margin-top: 0.5em;
            margin-bottom: 2em;
        }

        .login-container Label {
            margin-left: 5em;
            color: #6b6b6b;
            margin-bottom: 1em;
            font-style: italic;
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
        #submit-btn {
            background-color: #007BFF;
            color: white;
            font-size: 1.2em;
            margin-top: 3.3em;
            margin-left: 8em;
            margin-right: 8em;
            height: 2.8em;
            border: none;
            border-radius: 25px;
            transition: background-color 0.25s;
        }
        #submit-btn:hover {
            cursor: pointer;
            background-color: black;
            border: 1px solid #007BFF;
        }

        .feedback-message{
            position: absolute;
            bottom: 5.3em;
            left: 5.9em;
            width: 100%;
            color: red;
        }

        .error {
            color: red;
        }

        .success {
            color: #25d366;
        }

        .login-container TextArea {
            background-color: black;
            margin-left: 5em;
            margin-right: 5em;
            outline: white;
            color: white;
            font-size: 1em;
            resize: none;
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
                border-radius: 30px;
                width: 100%;
                height: auto;
                background-color: black;
            }

            .img-container img {
                margin-bottom: 0;
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

            .feedback-message {
                left: 2em;
                bottom: 5.4em;
            }

            .login-container Label {
                margin-left: 1em;
                margin-bottom: 1em;
            }
            .login-container TextArea {
                margin-left: 1em;
                margin-right: 1em;
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
    <form action="send-money.php" method="post">
        <div class="img-container">
            <img src="logo.png" width="164px">
        </div>
        <div class="login-container">
            <h5>Send Money</h5>
            <Label>Sender</Label>
            <input type="text" value="<?php echo $_SESSION['payeeAdd']?>" class="input-field" required id="sender" name="sender" readonly>
            <Label>Reciever</Label>
            <input type="text" value="<?php echo $_SESSION['pAddress']?>" class="input-field" required id="reciever" name="reciever" readonly>
            <Label>Amount</Label>
            <input type="number" class="input-field" required id="amount" name="amount" readonly value="<?php echo $_SESSION['amount']?>">
            <Label>Message(Optional)</Label>
            <textarea name="message-box" id="myTextarea" rows="3" placeholder="Say Something nice!"></textarea>
            <span class="feedback-message" id="feedback-message">
                <?php
                    if(isset($_SESSION['message'])){
                        echo $_SESSION['message'];
                        
                        //Clear error message
                        unset($_SESSION['message']);
                    }
                ?>
            </span>
            <input type="submit" value="Send Money" id="submit-btn" name="submit">
        </div>
    </form>
    <script src="particles.js"></script>
    <script src="app.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const form = document.querySelector('form');
            const errorMessage = document.getElementById('feedback-message');

            form.addEventListener('submit', () => {
                errorMessage.textContent = '';
            });
        });
        window.onload = function() {
            const textarea = document.getElementById('myTextarea');
            const amount = document.getElementById('amount');
            amount.focus();

            textarea.setSelectionRange(0, 0);
        };
    </script>
</body>
</html>

