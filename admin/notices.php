<?php

    include "../components/connect.php";

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    if(isset($_POST['add_notice'])){

        $select_admin = "SELECT * FROM `admins` WHERE id= '$admin_id'";
        $data = mysqli_query($conn, $select_admin);
        $result = mysqli_fetch_assoc($data);

        $main_admin_id = $result['id'];

        $for_whom = $_POST['for_whom'];
        $name = $_POST['name'];
        $content = $_POST['content'];
        date_default_timezone_set('Asia/Kolkata');
        $date = date('y-m-d h:i:s');

        if($name == "" || $content == ""){
            $message[]="please, Fill all fields details!";
        }else{
                $query = "INSERT INTO notice(admin_id, name, for_whom, content, issue_date) VALUES ('$main_admin_id', '$name', '$for_whom', '$content', '$date')";
                $data = mysqli_query($conn, $query);

                if($data){
                    echo "<script>alert('Notice added successfully!'); window.location.href = 'notice.php';</script>";
                }else{
                    $message[] = 'failed to upload notice!';
                }
        }
    }

    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $delete_notice = "DELETE FROM notice WHERE id='$delete_id'";
        $data = mysqli_query($conn, $delete_notice);
        header('location:notices.php');
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
    <link rel="stylesheet" href="../css/admin_style.css">

    <style>
        .custom-btn {
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
    <section class="form-container">

        <form action='' method='post'>
            <h3>Add new notice</h3>    <button id="customBtn" class="custom-btn"><a href="singleFacultyNotice.php" class="btn-link"> to single faculty</a></button>

            <input type='text' name='name' placeholder='Notice Name' class='box'>
            <select name="for_whom" id="forWhom"class="box">
                <option value="Not Selected">Who will get this notice ?</option>
                <option value="all">All</option>
                <option value="faculty">Faculty</option>
                <option value="student">Student</option>
            </select>
           
            <textarea name='content' rows='5' placeholder='Notice Content' class='box my_textarea'></textarea>
            <input type='submit' value='Add Notice' class='option-btnf' name='add_notice'>
        </form>

    </section>

    <section class="show-notices">

        <h1 class="heading">notices added</h1>

        <!-- <div class="fix">
            <span></span>
            <select name="for_whom" class="box">
                <option value="Not Selected">All Notices</option>
                <option value="faculty">Faculty Notices</option>
                <option value="student">Student Notices</option>
            </select>
            <span></span>
        </div> -->

        <div class="box-container">

            <?php
        $select_notice = "SELECT * FROM `notice`";
        $data = mysqli_query($conn, $select_notice);

        $total = mysqli_num_rows($data);

        if($total > 0){
            while($fetch_notice = mysqli_fetch_assoc($data)){ 
        ?>
            <div class="box">
                <!-- <div class="id">Admin ID : <?= $fetch_notice['id']; ?></div> -->
                <div class="detail">For : <?= $fetch_notice['for_whom']; ?></div>
                <div class="name">Title : <?= $fetch_notice['name']; ?></div>
                <div class="detail">Description: <?= $fetch_notice['content']; ?></div>
                <div class="date">Date : <?= $fetch_notice['issue_date']; ?></div>
                <a href="notices.php?delete=<?= $fetch_notice['id']; ?>" class="delete-btn"
                    onclick="return confirm('delete this notice?');">delete</a>
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

<script src="../js/admin_logic1.js"></script>
<script>
     const customBtn = document.getElementById('customBtn');
    const forWhomSelect = document.getElementById('forWhom');

    customBtn.style.display = 'none';

    forWhomSelect.addEventListener('change', function () {
        customBtn.style.display = this.value === 'faculty' ? 'block' : 'none';
    });
    customBtn.addEventListener('click', function (event) {
        event.preventDefault();
        window.location.href = 'singleFacultyNotice.php';
    });
</script>
</html>