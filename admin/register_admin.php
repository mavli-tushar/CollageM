<?php 

include '../components/connect.php';

session_start();

$main_admin_id = $_SESSION['admin_id'];

if(!isset($main_admin_id)){
    header('location:admin_login.php');
}

if (isset($_POST['register'])) {
    $phone_no=$_POST['phone_no'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = sha1($_POST['password']);
    $cpass = sha1($_POST['cpassword']);

        if($pass != $cpass){
           
        }else{
            $insert_admin = "INSERT INTO `admins`(name, email, password,phone_no) VALUES('$name', '$email', '$pass',$phone_no)";
            $data = mysqli_query($conn, $insert_admin);
            $admin_id=mysqli_insert_id($conn);
            $insert_user = "INSERT INTO `users`(admin_id, name, email, password) VALUES('$admin_id', '$name', '$email', '$pass')";
            $data = mysqli_query($conn, $insert_user);
            $message[] = 'new admin registered!';
            session_unset();
            header('location:admin_login.php');
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
        <form action="" method="post"  onsubmit="return checkPasswordMatch()">
            <h3>register as admin</h3>
            <input type="text" name="name" placeholder="Username" required class="box" />
            <input type="text" name="email" placeholder="Email ID" required class="box" />
            <input type="text" name="phone_no" placeholder="Phone Number" required class="box" />
            <input type="password" name="password" maxlength="20" placeholder="Password" required class="box" />
            <input type="password" name="cpassword"  placeholder="Confirm Password" required class="box" />
            <div class="my-flex-btn">
                <input type="submit" value="register now" name="register" class="btn" />
                <a href="dashboard.php" class="delete-btn">go back</a>
            </div>
        </form>
    </section>

</body>

<script src="../js/admin_logic1.js"></script>

<script>
        function checkPasswordMatch() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("cpassword").value;

            if (password != confirmPassword) {
                 alert("Passwords do not match!");
                return false;
            }
            return true;
        }
    </script>
</html>