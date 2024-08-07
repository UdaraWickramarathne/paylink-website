<?php 
    $servername = "udara-mssql-udniko25-1cfd.e.aivencloud.com";
    $username = "avnadmin";
    $password = "AVNS_Q5mHKsjZjlm1NeRLbdj";
    $dbname = "paylink_db";
    $port = 14502;


    try{
        $conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        header('Location: index.php?error= Database Connection failed');
        exit();
    }
?>