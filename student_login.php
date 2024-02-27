<?php

include 'components/connect.php';

session_start();

if(isset($_POST['login'])){

   $email = $_POST['email'];
   $password = sha1($_POST['password']);

   $select_student = "SELECT * FROM `students` WHERE email = '$email' AND password = '$password'";
   $data = mysqli_query($conn, $select_student);

    $result = mysqli_fetch_assoc($data);

    $total = mysqli_num_rows($data);
    
    if($total > 0){
        $_SESSION['stud_id'] = $result['id'];
        header('location:change_default_pass.php');
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
    <title>Login - Student</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/user_style1.css">

</head>

<body>

    <?php 

        if(isset($message)){
            foreach($message as $message){
                echo '
                    <div class="message">
                        <span>'.$message.'</span>
                        <a onclick="this.parentElement.remove();"><img src="images/cancel.png" alt=""></a>
                    </div>
                ';
            }
        }

    ?>

    <section class="form-container">

        <form action="" method="post">
            <h3>login now</h3>
            <p>Default Password : <span>stud123</span></p>
            <input type="email" name="email" required placeholder="Email ID" class="box">
            <input type="password" name="password" required placeholder="Password" class="box">
            <input type="submit" value="login now" class="btn" name="login">
            <p>Contact the admin for registration of the new student.</p>
            <a href="faculty/faculty_login.php" class="option-btn">log in as faculty</a>
        </form>

    </section>

</body>
<script src="js/user_logic1.js"></script>

</html>