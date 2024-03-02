<?php

    include '../components/connect.php';

    session_start();

    $faculty_id = $_SESSION['faculty_id'];

    if(!isset($faculty_id)){
        header('location:faculty_login.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notice Window</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/user_style1.css">
    

</head>

<body>

    <?php include '../components/faculty_header.php'; ?>

    <section class="show-notices">

        <h1 class="heading">All Notices</h1>

        <div class="box-container">

            <?php
        $select_notice = "SELECT * FROM `notice` WHERE for_whom = 'faculty' OR for_whom = 'all'";
        $data = mysqli_query($conn, $select_notice);

        $total = mysqli_num_rows($data);

        if($total > 0){
         while($fetch_notice = mysqli_fetch_assoc($data)){ 
        ?>
            <div class="box">
                <div class="id">Admin ID : <?= $fetch_notice['id']; ?></div>
                <div class="name">Title : <?= $fetch_notice['name']; ?></div>
                <div class="detail">Description : <?= $fetch_notice['content']; ?></div>
                <div class="date">Date : <?= $fetch_notice['issue_date']; ?></div>
            </div>
            <?php
         }
      }else{
         echo '<p class="empty">no notices added yet!</p>';
      }
   ?>

        </div>

    </section>

</body>

<script src="../js/user_logic1.js"></script>

</html>