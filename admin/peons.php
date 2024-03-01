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

</head>

<body>

    <?php include '../components/admin_header.php'; ?>

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

    <section class="show-notices">

        <h1 class="heading">All Peons </h1>

        <div class="box-container">

            <?php
        $select_peon = "SELECT * FROM `peons`";
        $data = mysqli_query($conn, $select_peon);

        $total = mysqli_num_rows($data);

        if($total > 0){
         while($fetch_peon = mysqli_fetch_assoc($data)){ 
        ?>
            <div class="box">
                <div class="id"> Peon ID : <?= $fetch_peon['id']; ?></div>
                <div class="name"> Name : <?= $fetch_peon['name']; ?></div>
                <div class="detail"> Email : <?= $fetch_peon['email']; ?></div>
                <div class="detail"> Contact No : <?= $fetch_peon['phone_no']; ?></div>
                <div class="detail"> Gender : <?= $fetch_peon['gender']; ?></div>
                <div class="my-flex-btn">
                    <a href="update_peon.php?peon_id=<?= $fetch_peon['id']; ?>" class="option-btn">update</a>
                    <a href="peons.php?delete=<?= $fetch_peon['id']; ?>&peon_id=<?= $fetch_peon['id'] ?>"
                        class="delete-btn" onclick="return confirm('delete this peon details?');">delete</a>
                </div>
            </div>
            <?php
         }
      }else{
         echo '<p class="empty">no peons added yet!</p>';
      }
   ?>

        </div>

    </section>

</body>

<script src="../js/admin_logic1.js"></script>

</html>