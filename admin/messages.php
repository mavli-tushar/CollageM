<?php 

    include '../components/connect.php';

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $delete_message = "DELETE FROM `messages` WHERE id='$delete_id'";
        $data = mysqli_query($conn, $delete_message);
        header('location:messages.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Messages</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../css/admin_style.css" />
</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="show-notices">

        <h1 class="heading">All Messages</h1>

        <div class="box-container">

            <?php
        $select_message = "SELECT * FROM `messages`";
        $data = mysqli_query($conn, $select_message);

        $total = mysqli_num_rows($data);

        if($total > 0){
         while($fetch_message = mysqli_fetch_assoc($data)){ 
        ?>
            <div class="box">
                <!-- <?php
                    $faculty_id = $fetch_message['faculty_id'];
                    $stud_id = $fetch_message['stud_id'];

                    if($faculty_id != null){
                        echo "<div class='id'> Faculty ID : ".$fetch_message['faculty_id']."</div>";
                    }else {
                        echo "<div class='id'> Student ID : ".$fetch_message['stud_id']."</div>";
                    }
                ?> -->
                <div class="name"> Name : <?= $fetch_message['name']; ?></div>
                <div class="detail"> Email : <?= $fetch_message['email']; ?></div>
                <div class="detail"> Contact No : <?= $fetch_message['phone_no']; ?></div>
                <div class="detail"> Message : <?= $fetch_message['message']; ?></div>
                <a href="messages.php?delete=<?= $fetch_message['id']; ?>" class="delete-btn"
                    onclick="return confirm('delete this notice?');">delete</a>
            </div>
            <?php
         }
      }else{
         echo '<p class="empty">no messages send yet!</p>';
      }
   ?>

        </div>
    </section>

</body>

<script src="../js/admin_logic1.js"></script>

</html>