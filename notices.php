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
    <title>All Notices</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="css/user_style1.css" />

</head>

<body>
    <?php include 'components/student_header.php'; ?>

    <section class="show-notices">

        <h1 class="heading">All Notices</h1>

        <div class="box-container">

            <?php
        $select_notices = "SELECT * FROM `notice` WHERE for_whom = 'student' OR for_whom = 'all'";
        $data = mysqli_query($conn, $select_notices);

        $total = mysqli_num_rows($data);

        if($total > 0){
         while($fetch_notices = mysqli_fetch_assoc($data)){ 
        ?>
            <div class="box">
                <!-- <div class='id'> Admin ID : <?= $fetch_notices['id']; ?></div> -->
                <div class='name'> Title : <?= $fetch_notices['name']; ?></div>
                <div class='detail'> Description : <?= $fetch_notices['content']; ?></div>
                <div class='date'> Issue Date : <?= $fetch_notices['issue_date']; ?></div>
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
<script src="js/user_logic1.js"></script>


</html>