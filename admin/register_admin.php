<?php 

include '../components/connect.php';

session_start();

$main_admin_id = $_SESSION['admin_id'];

if(!isset($main_admin_id)){
    header('location:admin_login.php');
}

if (isset($_POST['register'])) {
    
    $admin_id = $_POST['admin_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = sha1($_POST['password']);
    $cpass = sha1($_POST['cpassword']);

    $select_admin = "SELECT * FROM `admins` WHERE admin_id = '$admin_id'";
    $admin_id_data = mysqli_query($conn, $select_admin);

    $select_admin = "SELECT * FROM `admins` WHERE name = '$name'";
    $admin_name_data = mysqli_query($conn, $select_admin);
    
    if(mysqli_num_rows($admin_id_data) > 0){
        $message[] = 'Admin ID already exists!';
    }else if(mysqli_num_rows($admin_id_data) > 0){
        $message[] = 'Username already exists!';
    }else{
        if($pass != $cpass){
            $message[] = 'confirm password not matched!';
        }else{
            $insert_admin = "INSERT INTO `admins`(admin_id, name, email, password) VALUES('$admin_id', '$name', '$email', '$pass')";
            $data = mysqli_query($conn, $insert_admin);
            $insert_user = "INSERT INTO `users`(admin_id, name, email, password) VALUES('$admin_id', '$name', '$email', '$pass')";
            $data = mysqli_query($conn, $insert_user);
            $message[] = 'new admin registered!';
            session_unset();
            header('location:admin_login.php');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../css/admin_style.css" />

</head>

<body>

    <section class="form-container">
        <form action="" method="post">
            <h3>register as admin</h3>

            <input type="text" name="admin_id" placeholder="Admin ID (Ex: a101)" required class="box" />
            <input type="text" name="name" placeholder="Username" required class="box" />
            <input type="text" name="email" placeholder="Email ID" required class="box" />
            <input type="password" name="password" maxlength="20" placeholder="Password" required class="box" />
            <input type="password" name="cpassword" placeholder="Confirm Password" required class="box" />
            <div class="my-flex-btn">
                <input type="submit" value="register now" name="register" class="btn" />
                <a href="dashboard.php" class="delete-btn">go back</a>
            </div>
        </form>
    </section>

</body>

<script src="../js/admin_logic1.js"></script>

</html>