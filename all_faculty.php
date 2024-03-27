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
    <title>All Faculties</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="css/user_style1.css" />

</head>

<body>
    <?php include 'components/student_header.php'; ?>

    <section class="show-notices">

        <h1 class="heading">All faculties</h1>

        <div class="box-container">

            <?php
        $select_faculty = "SELECT * FROM `faculty`";
        $data = mysqli_query($conn, $select_faculty);

        $total = mysqli_num_rows($data);

        if($total > 0){
         while($fetch_faculty = mysqli_fetch_assoc($data)){ 
        ?>
            <div class="box">
                <div class="my-flex-box">
                    <image src="<?php
                        $str = $fetch_faculty['faculty_img'];
                        $str = ltrim($str, './');
                        echo $str; 
                    ?>" class="all_image" />
                </div>
                <!-- <div class='id'> Faculty ID : <?= $fetch_faculty['id']; ?></div> -->
                <div class="name"> Name : <?= $fetch_faculty['name']; ?></div>
                <div class="detail"> Email : <?= $fetch_faculty['email']; ?></div>
                <div class="detail"> Gender : <?= $fetch_faculty['gender']; ?></div>
                <div class="detail"> Course : <?= $fetch_faculty['degree']; ?></div>
                <div class="detail"> Contact No : <?= $fetch_faculty['phone_no']; ?></div>
            </div>
            <?php
         }
      }else{
         echo '<p class="empty">no faculties added yet!</p>';
      }
   ?>

        </div>
    </section>


    
</body>
<script src="js/user_logic1.js"></script>


</html>