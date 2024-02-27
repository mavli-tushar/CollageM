<?php

    include "../components/connect.php";

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
    

</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="dashboard">

        <h1 class="heading">dashboard</h1>

        <div class="box-container">
            <div class="box">
                <h3>Welcome!</h3>
                <p><?= $result['name'] ?></p>
                <a href="update_profile.php" class="btn">update profile</a>
            </div>

            <div class="box">
                <?php
                    $select_notice = "SELECT * FROM `notice`";
                    $data = mysqli_query($conn, $select_notice);

                    $total_notice = mysqli_num_rows($data);
                ?>
                <h3><?= $total_notice ?></h3>
                <p>total notices</p>
                <a href="notices.php" class="btn">see notices</a>
            </div>

            <div class="box">
                <?php 
                    $select_student = "SELECT * FROM `students`";
                    $data = mysqli_query($conn, $select_student);

                    $total_students = mysqli_num_rows($data);
                ?>
                <h3><?= $total_students ?></h3>
                <p>total students</p>
                <a href="students.php" class="btn">see students</a>
            </div>

            <div class="box">
                <?php 
                    $select_faculty = "SELECT * FROM `faculty`";
                    $data = mysqli_query($conn, $select_faculty);

                    $total_faculties = mysqli_num_rows($data);
                ?>
                <h3><?= $total_faculties ?></h3>
                <p>total faculties</p>
                <a href="faculties.php" class="btn">see faculties</a>
            </div>

            <div class="box">
                <?php 
                    $select_peon = "SELECT * FROM `peons`";
                    $data = mysqli_query($conn, $select_peon);

                    $total_peons = mysqli_num_rows($data);
                ?>
                <h3><?= $total_peons ?></h3>
                <p>total peons</p>
                <a href="peons.php" class="btn">see peons</a>
            </div>

            <div class="box">
                <?php 
                    $select_admin = "SELECT * FROM `admins`";
                    $data = mysqli_query($conn, $select_admin);

                    $total_admins = mysqli_num_rows($data);
                ?>
                <h3><?= $total_admins ?></h3>
                <p>total admins</p>
                <a href="admin_accounts.php" class="btn">see admins</a>
            </div>

            <div class="box">
                <?php 
                    $select_user = "SELECT * FROM `users`";
                    $data = mysqli_query($conn, $select_user);

                    $total_users = mysqli_num_rows($data);
                ?>
                <h3><?= $total_users ?></h3>
                <p>total users</p>
                <a href="user_accounts.php" class="btn">see users</a>
            </div>

            <div class="box">
                <?php 
                    $select_messages = "SELECT * FROM `messages`";
                    $data = mysqli_query($conn, $select_messages);

                    $total_messages = mysqli_num_rows($data);
                ?>
                <h3><?= $total_messages ?></h3>
                <p>total messages</p>
                <a href="messages.php" class="btn">see messages</a>
            </div>
        </div>

    </section>

</body>

<script src="../js/admin_logic1.js"></script>

</html>