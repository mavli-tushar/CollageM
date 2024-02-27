<?php 

    include '../components/connect.php';

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    if (isset($_POST['register'])) {
        
        $faculty_id = $_POST['faculty_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone_no = $_POST['phone_no'];
        $gender = $_POST['gender'];
        $degree = $_POST['course'];
        $pass = sha1($_POST['password']);        

        $select_faculty = "SELECT * FROM `faculty` WHERE faculty_id = '$faculty_id'";
        $faculty_id_data = mysqli_query($conn, $select_faculty);

        if(mysqli_num_rows($faculty_id_data) > 0){
            $message[] = 'Faculty ID already exists!';
        }else{

            $insert_faculty = "INSERT INTO `faculty`(faculty_id, admin_id, name, email, password ,phone_no, gender, degree) VALUES ('$faculty_id', '$admin_id', '$name', '$email', '$pass', '$phone_no', '$gender', '$degree')";
            $data = mysqli_query($conn, $insert_faculty);
        
            $insert_user = "INSERT INTO `users`(faculty_id, name, email, password) VALUES('$faculty_id','$name', '$email', '$pass')";
            $data = mysqli_query($conn, $insert_user);

            if($data){
                $message[] = 'new faculty registered!';
                // header('location:dashboard.php');
            }else{
                $message[] = 'failed to add new faculty!';
            }
        }
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

    <section class="form-container">
        <form action="" method="post">
            <h3>add new faculty</h3>

            <input type="text" name="faculty_id" placeholder="Faculty ID (Ex: f101)" required class="box" />
            <input type="text" name="name" placeholder="Faculty Name" required class="box" />
            <input type="text" name="email" placeholder="Email ID" required class="box" />
            <input type="password" name="password" readonly value="faculty123" placeholder="Password" required
                class="box" />
            <input type="text" name="phone_no" placeholder="Contact Number" required class="box" />
            <div class="box">
                <input type="radio" name="gender" value="Male" required> Male
                <input type="radio" name="gender" value="Female" required style="margin-left: 5rem;"> Female
            </div>
            <select name="course" class="box">
                <option value="Not Selected">Select your Course</option>
                <option value="MCA">MCA</option>
                <option value="MBA">MBA</option>
                <option value="M.COM">M.COM</option>
                <option value="MSCIT">MSCIT</option>
            </select>
            <input type="submit" value="add new faculty" name="register" class="option-btn" />
        </form>
    </section>

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
                <div class="id"> Faculty ID : <?= $fetch_faculty['faculty_id']; ?></div>
                <div class="name"> Name : <?= $fetch_faculty['name']; ?></div>
                <div class="detail"> Email : <?= $fetch_faculty['email']; ?></div>
                <div class="detail"> Contact No : <?= $fetch_faculty['phone_no']; ?></div>
                <div class="detail"> Gender : <?= $fetch_faculty['gender']; ?></div>
                <div class="detail"> Course : <?= $fetch_faculty['degree']; ?></div>
                <div class="my-flex-btn">
                    <a href="faculties.php?delete=<?= $fetch_faculty['id']; ?>&faculty_id=<?= $fetch_faculty['faculty_id'] ?>"
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