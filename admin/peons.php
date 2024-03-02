<?php 

    include '../components/connect.php';

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    if (isset($_POST['register'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone_no = $_POST['phone_no'];
        $gender = $_POST['gender'];
        $pass = sha1($_POST['password']);        

            $insert_peon = "INSERT INTO `peons`(admin_id, name, email, password, phone_no, gender) VALUES ( '$admin_id', '$name', '$email', '$pass', '$phone_no', '$gender')";
            $data = mysqli_query($conn, $insert_peon);
        
            $peon_id =mysqli_insert_id($conn);

            $insert_user = "INSERT INTO `users`(peon_id, name, email, password) VALUES('$peon_id','$name', '$email', '$pass')";
            $data = mysqli_query($conn, $insert_user);

            if($data){
                $message[] = 'new Peon registered!';
                header('location:dashboard.php');
            }else{
                $message[] = 'failed to add new peon!';
            }
        
    }

    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $delete_user = $_GET['peon_id'];

        $delete_peon = "DELETE FROM `peons` WHERE id='$delete_id'";
        $data = mysqli_query($conn, $delete_peon);
        $delete_user = "DELETE FROM `users` WHERE peon_id='$delete_user'";
        $data = mysqli_query($conn, $delete_user);
        header('location:peons.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Poen Window</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../css/admin_style.css" />

    <style>.custom-btn {
    float: right;
    display: block;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    color: #fff;
    background-color: #007bff;
    border: 2px solid #007bff;
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s, border-color 0.3s;
    cursor: pointer;
}

.custom-btn:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.btn-link {
    color: #fff;
    text-decoration: none;

}

</style>

</head>

<body>

    <?php include '../components/admin_header.php'; ?>
    <button class="custom-btn"><a href="displayPeon.php" class="btn-link">View Peon</a></button>
    <section class="form-container">
        <form action="" method="post">
            <h3>add new peon</h3>
            <input type="text" name="name" placeholder="Peon Name" required class="box" />
            <input type="text" name="email" placeholder="Email ID" required class="box" />
            <input type="password" name="password" readonly value="peon123" placeholder="Password" required
                class="box" />
            <input type="text" name="phone_no" placeholder="Contact Number" required class="box" />
            <div class="box">
                <input type="radio" name="gender" value="Male" required> Male
                <input type="radio" name="gender" value="Female" required style="margin-left: 5rem;"> Female
            </div>
            <input type="submit" value="add new peon" name="register" class="option-btnf" />
        </form>
    </section>
</body>

<script src="../js/admin_logic1.js"></script>

</html>