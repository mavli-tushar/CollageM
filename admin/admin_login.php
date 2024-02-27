<?php

    include "../components/connect.php";

    session_start();

    if(isset($_POST['login'])){
        $name = $_POST['name'];
        $password = sha1($_POST['pass']);

        $query = "SELECT * FROM `admins` WHERE name = '$name' AND password = '$password'";
        $data = mysqli_query($conn, $query);
        
        $result = mysqli_fetch_assoc($data);

        $total = mysqli_num_rows($data);
        
        if($total > 0){
            $_SESSION['admin_id'] = $result['id'];
            header('location:dashboard.php');
        }else{
            $message[] = 'incorrect username or password!';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="../css/all.css">

</head>

<body>

    <?php
    if(isset($message)){
        foreach($message as $message){
            echo '
            <div class="message">
                <span>'.$message.'</span>
                <a onclick="this.parentElement.remove();"><img src="../images/cancel.png" alt=""></a>
            </div>
            ';
        }
    }
    ?>

    <section class="form-container">

        <form action="" method="post">
            <h3>login now</h3>
            <p>default username = <span>admin</span> & password = <span>admin123</span></p>
            <input type="text" name="name" required placeholder="enter your username" class="box">
            <input type="password" name="pass" required placeholder="enter your password" class="box">
            <input type="submit" value="login now" class="btn" name="login">
        </form>

    </section>

</body>

</html>