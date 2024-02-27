<?php 

    include '../components/connect.php';

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Users Accounts</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../css/admin_style.css" />
</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="show-notices">

        <h1 class="heading">All Users</h1>

        <div class="box-container">

        <?php
        $select_user = "SELECT * FROM users";
        $data = mysqli_query($conn, $select_user);

        $total = mysqli_num_rows($data);

        if($total > 0){
         while($fetch_user = mysqli_fetch_assoc($data)){ 
        ?>
            <div class="box">
                <?php
                    $admin_id = $fetch_user['admin_id'];
                    $faculty_id = $fetch_user['faculty_id'];
                    $peon_id = $fetch_user['peon_id'];
                    $stud_id = $fetch_user['stud_id'];

                    if($admin_id != null){
                        echo "<div class='id'> Admin ID : ".$fetch_user['admin_id']."</div>";
                    }else if($faculty_id != null){
                        echo "<div class='id'> Faculty ID : ".$fetch_user['faculty_id']."</div>";
                    }else if($stud_id != null){
                        echo "<div class='id'> Student ID : ".$fetch_user['stud_id']."</div>";
                    }else{
                        echo "<div class='id'> Peon ID : ".$fetch_user['peon_id']."</div>";
                    }
                ?>
                <div class="name"> Name : <?= $fetch_user['name']; ?></div>
                <div class="detail"> Email : <?= $fetch_user['email']; ?></div>
            </div>
            <?php
         }
      }else{
         echo '<p class="empty">no users added yet!</p>';
      }
   ?>

        </div>
    </section>

</body>

<script src="../js/admin_logic1.js"></script>

</html>