<?php 

    include 'components/connect.php';

    session_start();

    $main_stud_id = $_SESSION['stud_id'];

    if(!isset($main_stud_id)){
        header('location:student_login.php');
    }

    $select_student_id = "SELECT * FROM `students` WHERE id = '$main_stud_id'";
    $student_id_data = mysqli_query($conn, $select_student_id);
    $result = mysqli_fetch_assoc($student_id_data);
    $stud_id = $result['id'];

    $hobbies_arr = explode(",", $result['hobbies']);

    if (isset($_POST['update'])) {
  
        $fileName = $_FILES['profile_pic']['name'];
        $tempName = $_FILES['profile_pic']['tmp_name'];   

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $gender = $_POST['gender'];
        $date_of_birth = $_POST['date_of_birth'];
        $course = $_POST['course'];
        $hobbies_str = implode(",",$_POST['hobby']);
        $email = $_POST['email'];
        $phone_no = $_POST['phone_no'];
        $address = $_POST['address'];

        $full_name = $fname." ".$lname;

        if($fileName){
            $folder = 'uploaded_images/students/'.$fileName;
            move_uploaded_file($tempName, $folder);
            unlink($result['student_img']); 
            $errMSG = "New Profile Picture Update!!!";
        }else{
            $folder = $result['student_img'];
        }

        if(!isset($errMsg)){
            $update_student = "UPDATE `students` SET student_img = '$folder',fname = '$fname', lname = '$lname', gender = '$gender', DOB = '$date_of_birth', course='$course', hobbies='$hobbies_str', email = '$email', phone_no = '$phone_no', address ='$address' WHERE id = '$stud_id'";
            $data = mysqli_query($conn, $update_student);
        
            $update_user = "UPDATE `users` SET name = '$full_name', email = '$email' WHERE stud_id = '$stud_id'";
            $data = mysqli_query($conn, $update_user);

            if($data){
                $message[] = 'update data successfully!';
                header('location:student_home.php');
            }else{
                $message[] = 'failed to update data!';
            }
        }else{
            $message[] = 'Somethings went to Wrong 😥';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update Student Details</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="css/user_style1.css" />

</head>

<body>

    <?php 

        if(isset($message)){
            foreach($message as $message){
                echo '
                    <div class="message">
                        <span>'.$message.'</span>
                        <a onclick="this.parentElement.remove();"><img src="images/cancel.png" alt=""></a>
                    </div>
                ';
            }
        }

    ?>

    <section class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>update student details</h3>

            <input type="text" name="stud_id" placeholder="Stud ID (Ex: p101)" readonly
                value="<?= $result['id']; ?>" required class="box" />
            <input type="file" name="profile_pic" class="box" />
            <input type="text" name="fname" placeholder="First Name" value="<?= $result['fname']; ?>"
                required class="box" />
            <input type="text" name="lname" placeholder="Last Name" value="<?= $result['lname']; ?>" required
                class="box" />
            <div class="box">
                <input type="radio" name="gender" value="male" required <?php
                    if($result['gender'] == 'male'){
                        echo "checked";
                    }
                ?>> Male
                <input type="radio" name="gender" value="female" required style="margin-left: 5rem;" <?php
                    if($result['gender'] == 'female'){
                        echo "checked";
                    }
                ?>> Female
            </div>
            <input type="date" name="date_of_birth" value="<?php echo $result['DOB']; ?>" class="box" />
            <select name="course" class="box">
                <option value="Not Selected">Select your course</option>
                <option value="BCA" <?php
                    if($result['course'] == 'BCA'){
                        echo "selected";
                    }
                ?>>BCA</option>
                <option value="BBA" <?php
                    if($result['course'] == 'BBA'){
                        echo "selected";
                    }
                ?>>BBA</option>
                <option value="B.COM" <?php
                    if($result['course'] == 'B.COM'){
                        echo "selected";
                    }
                ?>>B.COM</option>
                <option value="B.TECH" <?php
                    if($result['course'] == 'B.TECH'){
                        echo "selected";
                    }
                ?>>B.TECH</option>
                <option value="B.sc" <?php
                    if($result['course'] == 'B.sc'){
                        echo "selected";
                    }
                ?>>B.sc</option>
                <option value="MSCIT" <?php
                    if($result['course'] == 'MSCIT'){
                        echo "selected";
                    }
                ?>>MSCIT</option>
            </select>
            <div class="box">
                <div class="my-flex">
                    <input type="checkbox" name="hobby[]" value="reading" style="margin-left: 1.8rem;" <?php
                    if(in_array('reading', $hobbies_arr)){
                        echo "checked";
                    }
                ?>> Reading
                    <input type="checkbox" name="hobby[]" value="swimming" style="margin-left: 6.5rem;" <?php
                    if(in_array('swimming', $hobbies_arr)){
                        echo "checked";
                    }
                ?>> Swimming
                </div>
                <br />
                <div class="my-flex">
                    <input type="checkbox" name="hobby[]" value="travelling" <?php
                    if(in_array('travelling', $hobbies_arr)){
                        echo "checked";
                    }
                ?>> Travelling
                    <input type="checkbox" name="hobby[]" value="cooking" style="margin-left: 5.5rem;" <?php
                    if(in_array('cooking', $hobbies_arr)){
                        echo "checked";
                    }
                ?>> Cooking
                </div>
            </div>
            <input type="text" name="email" placeholder="Email ID" value="<?= $result['email']; ?>" required
                class="box" />
            <input type="text" name="phone_no" placeholder="Phone Number" value="<?= $result['phone_no']; ?>"
                required class="box" />
                
            <textarea name="address" rows="5" placeholder="Address"
                class="box my_textarea"><?php echo $result['address']; ?></textarea>
            <div class="my-flex-btn">
                <input type="submit" value="save" name="update" class="option-btnf" />
                <a href="student_home.php" class="delete-btnf">go back</a>
            </div>
        </form>
    </section>

</body>

<script src="../js/admin_logic1.js"></script>

</html>