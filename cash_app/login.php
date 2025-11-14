<?php   
require 'header.php';
    // $username = 'lila';
    // $password = "lila";
    $connectionString = "mysql:host=localhost;dbname=cash;charset=utf8mb4";
    $connectionOptions= [
        PDO :: ATTR_DEFAULT_FETCH_MODE => PDO :: FETCH_ASSOC,
    ]
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging In</title>
</head>
<body>
    <?php
        try{
            $pdo = new PDO($connectionString, 'root', '', $connectionOptions);
            $sqlRequest = ("SELECT email ,role FROM users WHERE email = :username AND password = :password");
            $preq= $pdo->prepare($sqlRequest,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY,]);
            $preq->execute([':username' => $_POST['username'], ':password' => $_POST['password']]);
            $result = $preq->fetch();
            echo($result);
        }catch (PDOException $e){
            print_r($e);
        }
        if ($result['email'] === $_POST['username']) {
            $_SESSION['loggedin'] = true;
            $_SESSION['role'] = $result['role'];
            $_SESSION['email'] = $result['email'];
            header('Location: private.php');
        } else {
            header('Location: tryagain.php');
        }
    ?>

</body>
</html>