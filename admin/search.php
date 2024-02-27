<?php 

    include '../components/connect.php';

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    if (isset($_POST['register'])) {
        
        $stud_id = $_POST['stud_id'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $password = sha1($_POST['password']);
        $gender = $_POST['gender'];
        $date_of_birth = $_POST['date_of_birth'];
        $course = $_POST['course'];
        $fees = $_POST['fees'];
        $hobbies = implode(",",$_POST['hobby']);
        $email = $_POST['email'];
        $phone_no = $_POST['phone_no'];
        $address = $_POST['address'];
        
        $full_name = $fname." ".$lname;

        $select_student = "SELECT * FROM `students` WHERE stud_id = '$stud_id'";
        $student_id_data = mysqli_query($conn, $select_student);

        if(mysqli_num_rows($student_id_data) > 0){
            $message[] = 'Student ID already exists!';
        }else{
            $insert_student = "INSERT INTO `students`(stud_id, admin_id, fname, lname, email, password, phone_no, gender, DOB, course, hobbies, address, fees) VALUES ('$stud_id', '$admin_id', '$fname', '$lname', '$email', '$password', '$phone_no', '$gender', '$date_of_birth', '$course', '$hobbies', '$address', '$fees')";
            $data = mysqli_query($conn, $insert_student);
        
            $insert_user = "INSERT INTO `users`(stud_id, name, email, password) VALUES('$stud_id','$full_name', '$email', '$password')";
            $data = mysqli_query($conn, $insert_user);

            if($data){
                $message[] = 'new student registered!';
                // header('location:dashboard.php');
            }else{
                $message[] = 'failed to add new student!';
            }
        }

    }

    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $delete_user = $_GET['stud_id'];

        $select_student = "SELECT * FROM `students` WHERE id='$delete_id'";
        $data = mysqli_query($conn, $select_student);
        $result = mysqli_fetch_assoc($data);
        unlink('../'.$result['student_img']);
        
        $delete_student = "DELETE FROM `students` WHERE id='$delete_id'";
        $data = mysqli_query($conn, $delete_student);

        $delete_msg = "DELETE FROM `messages` WHERE stud_id = '$delete_user'";
        $data = mysqli_query($conn, $delete_msg);
        
        $delete_user = "DELETE FROM `users` WHERE stud_id='$delete_user'";
        $data = mysqli_query($conn, $delete_user);

        header('location:students.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student Window</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../css/admin_style.css" />
    <style>
.sh {
  background-color: var(--orange);
}
.sh:hover {
  background-color:blue;
}
.sh {
  
  margin-top: 1rem;
  border-radius: 0.5rem;
  cursor: pointer;
  width: 100px;
  padding: 1rem 4rem;
  font-size: 1.6rem;
  text-transform: capitalize;
  text-align: center;
}
.b{
background-color: var(--orange);
  margin-top: 1rem;
  border-radius: 0.5rem;
  cursor: pointer;
  width: 500px;
  padding: 1rem 4rem;
  font-size: 1.6rem;
  
  
}
    </style>
</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="show-notices">

        <h1 class="heading">student</h1>
            <form class="heading" action="" method="post">
                <input  class="b"type="text" name="search" placeholder="Search Data Here">
                <input class="sh" name="submit" type="submit"  value="Search">
            </form>
        <div class="box-container">
        <?php
         if (isset($_POST['submit'])) {
            $search=$_POST['search'];
        $select_student = "SELECT * FROM students where fname like'%$search%'";
        $data = mysqli_query($conn, $select_student);
        
        $total = mysqli_num_rows($data);

        if($total > 0){
         while($fetch_student = mysqli_fetch_assoc($data)){ 
        ?>
            <div class="box">
                <div class="my-flex-box">
                    <image src="<?php echo '../'.$fetch_student['student_img'] ?>" class="all_image" />
                </div>
                <div class="id">Student ID : <?= $fetch_student['stud_id']; ?></div>
                <div class="name"><?= $fetch_student['fname']." ".$fetch_student['lname']; ?></div>
                <div class="content"><?= $fetch_student['email']; ?></div>
                <div class="detail">Gender : <?= $fetch_student['gender']; ?></div>
                <div class="detail">DOB : <?= $fetch_student['DOB']; ?></div>
                <div class="detail">Phone No : <?= $fetch_student['phone_no']; ?></div>
                <div class="detail">Course : <?= $fetch_student['course']; ?></div>
                <div class="detail">Fees Status : <?= $fetch_student['fees']; ?></div>
                <div class="detail">Address : <?= $fetch_student['address']; ?></div>
                <div class="my-flex-btn">
                    <a href="update_student.php?stud_id=<?= $fetch_student['stud_id']; ?>" class="option-btn">Update</a>
                    <a href="search.php?delete=<?= $fetch_student['id']; ?>&stud_id=<?= $fetch_student['stud_id'] ?>"
                    class="delete-btn" onclick="return confirm('delete this student details?');">Delete</a>
                </div>
            </div>
            <?php
         }
      }else{
         echo '<p class="empty">no students added yet!</p>';
      }
    }
   ?>
        </div>

    </section>


</body>

<script src="../js/admin_logic1.js"></script>

</html>