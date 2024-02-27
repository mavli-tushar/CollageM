<?php 

    include '../components/connect.php';

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $delete_user = $_GET['admin_id'];
        
        $delete_admin = "DELETE FROM `admins` WHERE id='$delete_id'";
        $data = mysqli_query($conn, $delete_admin);
        
        $delete_user = "DELETE FROM `users` WHERE admin_id='$delete_user'";
        $data = mysqli_query($conn, $delete_user);
        
        header('location:admin_login.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Accounts</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../css/admin_style.css" />
</head>

<body>

    <?php include '../components/admin_header.php'; ?>

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

    <section class="show-notices">

        <h1 class="heading">Admin Staff</h1>

        <div class="box-container">

            <div class="box">
                <h1>add new admin</h1>
                <a href="register_admin.php" class="btn">register admin</a>
            </div>

            <?php
        $select_admin = "SELECT * FROM `admins`";
        $data = mysqli_query($conn, $select_admin);

        $total = mysqli_num_rows($data);

        if($total > 0){
         while($fetch_admin = mysqli_fetch_assoc($data)){ 
        ?>
            <div class="box">
                <div class="id"> Admin ID : <?= $fetch_admin['admin_id']; ?></div>
                <div class="name"> Name : <?= $fetch_admin['name']; ?></div>
                <div class="detail"> Email : <?= $fetch_admin['email']; ?></div>
                <?php
                    if($fetch_admin['id'] == $admin_id && $fetch_admin['name'] == "admin"){
                            echo '<a href="update_profile.php" class="option-btn">update</a>';
                    }
                    else if($fetch_admin['id'] == $admin_id){
                        echo '<div class="my-flex-btn">
                                <a href="update_profile.php" class="option-btn">update</a>';
                                
                    
                ?>
                <a href="admin_accounts.php?delete=<?= $fetch_admin['id']; ?>&admin_id=<?= $fetch_admin['admin_id'] ?>"
                    class="
                    delete-btn" onclick="return confirm('delete this admin?');">delete</a>
            </div>
            <?php
                    }
                    ?>


        </div>

        <?php
         }
      }else{
         echo "<div class='box'>
                    <a href='register_admin.php' class='btn'>add new admin</a>
                </div>";
      }
   ?>

        </div>

    </section>

</body>

<script src="../js/admin_logic1.js"></script>

</html>