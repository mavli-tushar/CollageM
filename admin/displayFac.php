<?php 

    include '../components/connect.php';

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $delete_user = $_GET['faculty_id'];

        $select_faculty = "SELECT * FROM `faculty` WHERE id='$delete_id'";
        $data = mysqli_query($conn, $select_faculty);
        $result = mysqli_fetch_assoc($data);
        unlink($result['faculty_img']);

        $delete_faculty = "DELETE FROM `faculty` WHERE id='$delete_id'";
        $data = mysqli_query($conn, $delete_faculty);
        
        $delete_messages = "DELETE FROM `messages` WHERE faculty_id = '$delete_user'";
        $data = mysqli_query($conn, $delete_messages);

        $delete_user = "DELETE FROM `users` WHERE faculty_id='$delete_user'";
        $data = mysqli_query($conn, $delete_user);

        
        header('location:faculties.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Faculty Window</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../css/admin_style.css" />
</head>

<body>

    <?php include '../components/admin_header.php'; ?>
    <section class="show-notices">

        <h1 class="heading">All Faculties </h1>

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
                    <image src="<?php echo $fetch_faculty['faculty_img'] ?>" class="all_image" />
                </div>
                <div class="id"> Faculty ID : <?= $fetch_faculty['id']; ?></div>
                <div class="name"> Name : <?= $fetch_faculty['name']; ?></div>
                <div class="detail"> Email : <?= $fetch_faculty['email']; ?></div>
                <div class="detail"> Contact No : <?= $fetch_faculty['phone_no']; ?></div>
                <div class="detail"> Gender : <?= $fetch_faculty['gender']; ?></div>
                <div class="detail"> Course : <?= $fetch_faculty['degree']; ?></div>
                <div class="my-flex-btn">
                    <a href="displayFac.php?delete=<?= $fetch_faculty['id']; ?>&faculty_id=<?= $fetch_faculty['id'] ?>"
                    class="delete-btn" onclick="return confirm('delete this faculty details?');">delete</a>
                </div>
            </div>
            <?php
         }
      }else{
         echo '<p class="empty">no faculty added yet!</p>';
      }
   ?>

        </div>

    </section>

</body>

<script src="../js/admin_logic1.js"></script>

</html>