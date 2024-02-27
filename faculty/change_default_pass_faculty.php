<?php 

    include '../components/connect.php';

    session_start();

    $faculty_id = $_SESSION['faculty_id'];

    if(!isset($faculty_id)){
        header('location:faculty_login.php');
    }

    $select_faculty_id = "SELECT * FROM `faculty` WHERE id = '$faculty_id'";
    $faculty_id_data = mysqli_query($conn, $select_faculty_id);
    $result_faculty_id = mysqli_fetch_assoc($faculty_id_data);
    $faculty_id = $result_faculty_id['faculty_id'];

    $default_pass = '46ae7dd65fd3268b0dc974dff7fcc0e85a8b9cc3';

    if($result_faculty_id['password'] == $default_pass){
        if(isset($_POST['update'])){

            $email = $_POST['email'];
            $fileName = $_FILES['profile_pic']['name'];
            $tempName = $_FILES['profile_pic']['tmp_name'];   
            $folder = '../uploaded_images/faculties/'.$fileName; 
            move_uploaded_file($tempName, $folder);

            $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
            $select_old_pass = "SELECT password FROM `faculty` WHERE faculty_id = '$faculty_id'";
            $data = mysqli_query($conn, $select_old_pass);

            $result_password = mysqli_fetch_assoc($data);
            $prev_pass = $result_password['password'];

            $old_pass = sha1($_POST['old_password']);
            $new_pass = sha1($_POST['new_password']);
            $confirm_pass = sha1($_POST['new_cpassword']);

            if($old_pass == $empty_pass){
                $message[] = 'please enter old password! 😟';
            }elseif($old_pass != $prev_pass){
                $message[] = 'old password not matched! 😟';
            }elseif($new_pass != $confirm_pass){
                $message[] = 'confirm password not matched! 😟';
            }elseif($new_pass == $old_pass){
                $message[] = 'this is current password! 😟';
            }else{
                if($new_pass != $empty_pass){
                    $update_faculty_pass = "UPDATE `faculty` SET email = '$email', password = '$confirm_pass', faculty_img = '$folder' WHERE faculty_id = '$faculty_id'";
                    $data_change_password = mysqli_query($conn, $update_faculty_pass);

                    $updated_user_password = "UPDATE `users` SET email = '$email', password = '$confirm_pass' WHERE faculty_id = '$faculty_id'";
                    $data_user = mysqli_query($conn, $updated_user_password);

                    $message[] = 'profile updated successfully! 😊';
                    header('location:faculty_home.php');
                }else{
                    $message[] = 'please enter a new password! 😟';
                }
            }
        }
    }else{
        header('location:faculty_home.php');
    }
    

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update Profile</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../css/user_style1.css" />
    
</head>

<body>
    <?php 

        if(isset($message)){
            foreach($message as $message){
                echo '
                    <div class="message">
                        <span>'.$message.'</span>
                        <a onclick="this.parentElement.remove();"><img src="../images/cancel.png" alt=""></a>
                    </div>
                ';
            }
        }

    ?>

    <section class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>update password</h3>

            <input type="text" name="name" placeholder="SID" disabled required class="box"
                value="<?= $result_faculty_id['faculty_id']; ?>" />
            <input type="text" name="email" placeholder="Username" required class="box"
                value="<?= $result_faculty_id['email']; ?>" />
            <input type="file" name="profile_pic" class="box" />
            <input type="password" name="old_password" placeholder="Old Password" class="box" />
            <input type="password" name="new_password" placeholder="New Password" class="box" />
            <input type="password" name="new_cpassword" placeholder="Confirm New Password" class="box" />
            <dov class="my-flex-btn">
                <input type="submit" value="update now" name="update" class="btn" />
                <a href="faculty_home.php" class="delete-btn">go back</a>
            </dov>
        </form>
    </section>


</body>

<script src="../js/user_logic1.js"></script>

</html>