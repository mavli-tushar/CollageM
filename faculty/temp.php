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
            $insert_student = "INSERT INTO `students`(stud_id, admin_id, fname, lname, email, password, phone_no, gender, DOB, course, hobbies, address, fees , student_img) VALUES ('$stud_id', '$admin_id', '$fname', '$lname', '$email', '$password', '$phone_no', '$gender', '$date_of_birth', '$course', '$hobbies', '$address', '$fees','')";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="form-container">
        <form action="" method="post" class="" autocomplete="on" enctype="multipart/form-data">
            <h3>Add New Student</h3>

            <input type="text" name="stud_id" placeholder="Student ID (Ex: s101)" class="box" />
            <input type="text" name="fname" placeholder="First Name" class="box" />
            <input type="text" name="lname" placeholder="Last Name" class="box" />
            <input type="password" name="password" value="stud123" readonly placeholder="Password" class="box" />
            <div class="box">
                <input type="radio" name="gender" value="Male" required> Male
                <input type="radio" name="gender" value="Female" required style="margin-left: 5rem;"> Female
            </div>
            <input type="date" name="date_of_birth" class="box" />
            <select name="course" class="box">
            <option >Select Course</option>
				<?php
				$query="select  * from course";
				$run=mysqli_query($conn,$query);
				while($row=mysqli_fetch_array($run)) {
				echo	"<option value=".$row['courseName'].">".$row['courseName']."</option>";
				}
				?>
            </select>

            
            <div class="box">
                <label for="hobby">Hobbies</label>
                <div class="my-flex">
                    <input type="checkbox" id="hobby" name="hobby[]" value="reading" style="margin-left: 1.8rem;"> Reading
                    <input type="checkbox" name="hobby[]" value="swimming" style="margin-left: 6.5rem;"> Swimming
                </div>
                <br />
                <div class="my-flex">
                    <input type="checkbox" name="hobby[]" value="travelling"> Travelling
                    <input type="checkbox" name="hobby[]" value="cooking" style="margin-left: 5.5rem;"> Cooking
                </div>
            </div>
            <input type="text" name="email" placeholder="Email ID" class="box" />
            <input type="text" name="phone_no" placeholder="Contact Number" class="box" />
            <select name="fees" class="box">
                <option value="Not Selected">Fees Status</option>
                <option value="Remaining">Remaining</option>
                <option value="Paid">Paid</option>
            </select>
            <textarea name="address" rows="5" placeholder="Address" class="box my_textarea"></textarea>

            <input type="submit" value="ADD DATA" name="register" class="btn" />
        </form>
    </section>

    <section class="show-notices">

        <h1 class="heading">All Students</h1>

        <div class="box-container">

        <?php
        $select_student = "SELECT * FROM `students`";
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
                <div class="detail">Contact No : <?= $fetch_student['phone_no']; ?></div>
                <div class="detail">Course : <?= $fetch_student['course']; ?></div>
                <div class="detail">Fees Status : <?= $fetch_student['fees']; ?></div>
                <div class="detail">Address : <?= $fetch_student['address']; ?></div>
                <div class="my-flex-btn">
                    <a href="update_student.php?stud_id=<?= $fetch_student['stud_id']; ?>" class="option-btn">Update</a>
                    <a href="students.php?delete=<?= $fetch_student['id']; ?>&stud_id=<?= $fetch_student['stud_id'] ?>"
                    class="delete-btn" onclick="return confirm('delete this student details?');">Delete</a>
                </div>
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

<script src="../js/admin_logic1.js"></script>

</html>