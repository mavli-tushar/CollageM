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
    $faculty_id = $result_faculty_id['id'];

    if (isset($_POST['update'])) {

        $fileName = $_FILES['profile_pic']['name'];
        $tempName = $_FILES['profile_pic']['tmp_name'];   

        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone_no = $_POST['phone_no'];
        $gender = $_POST['gender'];
        $degree = $_POST['degree'];

        if($fileName){
            $folder = '../uploaded_images/faculties/'.$fileName;
            move_uploaded_file($tempName, $folder);
            unlink($result_faculty_id['faculty_img']); 
            $errMSG = "New Profile Picture Update!!!";
        }else{
            $folder = $result_faculty_id['faculty_img'];
        }

        if(!isset($sucMSG)){
            $update_faculty = "UPDATE `faculty` SET faculty_img = '$folder', name = '$name', email = '$email', phone_no = '$phone_no',gender = '$gender', degree = '$degree' WHERE id = '$faculty_id'";
            $data = mysqli_query($conn, $update_faculty);
        
            $update_user = "UPDATE `users` SET name = '$name', email = '$email' WHERE faculty_id = '$faculty_id'";
            $data = mysqli_query($conn, $update_user);

            if($data){
                $message[] = 'update data successfully!';
                header('location:faculty_home.php');
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
    <title>Update Faculty Details</title>

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
            <h3>Update Faculty Details</h3>

            <input type="text" name="stud_id" readonly
                value="<?= $result_faculty_id['id']; ?>" required class="box" />
            <input type="file" name="profile_pic" class="box" />
            <input type="text" name="name" placeholder="Name" value="<?= $result_faculty_id['name']; ?>" required
                class="box" />
            <input type="text" name="email" placeholder="Email ID" value="<?= $result_faculty_id['email']; ?>" required
                class="box" />
            <input type="text" name="phone_no" placeholder="Phone Number" value="<?= $result_faculty_id['phone_no']; ?>"
                required class="box" />
            <div class="box">
                <input type="radio" name="gender" value="male" required <?php
                    if($result_faculty_id['gender'] == 'male'){
                        echo "checked";
                    }
                ?>> Male
                <input type="radio" name="gender" value="female" required style="margin-left: 5rem;" <?php
                    if($result_faculty_id['gender'] == 'female'){
                        echo "checked";
                    }
                ?>> Female
            </div>
            <select name="degree" class="box">
                <option value="Not Selected">Select your degree</option>
                <option value="MCA" <?php
                    if($result_faculty_id['degree'] == 'MCA'){
                        echo "selected";
                    }
                ?>>MCA</option>
                <option value="MBA" <?php
                    if($result_faculty_id['degree'] == 'MBA'){
                        echo "selected";
                    }
                ?>>MBA</option>
                <option value="M.COM" <?php
                    if($result_faculty_id['degree'] == 'M.COM'){
                        echo "selected";
                    }
                ?>>M.COM</option>
                <option value="MSCIT" <?php
                    if($result_faculty_id['degree'] == 'MSCIT'){
                        echo "selected";
                    }
                ?>>MSCIT</option>
            </select>
            <div class="my-flex-btn">
                <input type="submit" value="save" name="update" class="option-btnf" />
                <a href="faculty_home.php" class="delete-btnf">go back</a>
            </div>
        </form>
                    
    </section>

</body>

<script src="../js/user_logic1.js"></script>

</html>