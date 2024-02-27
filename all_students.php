<?php 

    include 'components/connect.php';

    session_start();

    $stud_id = $_SESSION['stud_id'];

    if(!isset($stud_id)){
        header('location:student_login.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Students</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="css/user_style1.css" />

</head>

<body>
    <?php include 'components/student_header.php'; ?>

    <section class="show-notices">

        <h1 class="heading">All Students</h1>

        <div class="box-container">

            <?php
        $select_students = "SELECT * FROM `students`";
        $data = mysqli_query($conn, $select_students);

        $total = mysqli_num_rows($data);

        if($total > 0){
         while($fetch_students = mysqli_fetch_assoc($data)){ 
        ?>
            <div class="box">
                <div class="my-flex-box">
                    <image src="<?php echo $fetch_students['student_img']; ?>" class="all_image" />
                </div>
                <div class='id'> Student ID : <?= $fetch_students['stud_id']; ?></div>
                <div class="name"> Name : <?= $fetch_students['fname']." ".$fetch_students['lname']; ?></div>
                <div class="detail"> Email : <?= $fetch_students['email']; ?></div>
                <div class="detail"> DOB : <?= $fetch_students['DOB']; ?></div>
                <div class="detail"> Gender : <?= $fetch_students['gender']; ?></div>
                <div class="detail"> Course : <?= $fetch_students['course']; ?></div>
                <div class="detail"> Fees Stutas : <?= $fetch_students['fees']; ?></div>
                <div class="detail"> Contact No : <?= $fetch_students['phone_no']; ?></div>
                <div class="detail"> Hobbies : <?= $fetch_students['hobbies']; ?></div>
                <div class="detail"> Address : <?= $fetch_students['address']; ?></div>
                <?php

                    if($fetch_students['id'] == $stud_id){
                            echo '<a href="update_student.php" class="option-btn">update</a>';
                    }

                ?>
            </div>
            <?php
         }
      }else{
         echo '<p class="empty">no students added yet!</p>';
      }
   ?>

        </div>
    </section>

</body>
<script src="js/user_logic1.js"></script>


</html>