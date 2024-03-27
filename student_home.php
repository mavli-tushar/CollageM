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
    <title>Student - Home Page</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="css/user_style1.css" />
    
</head>

<body>
    <?php include 'components/student_header.php'; ?>

    <section class="dashboard">

        <h1 class="heading">student dashboard</h1>

        <div class="box-container2">
            <div class="my-flex-box">
                <image src="<?php echo $result['student_img']; ?>" class="stud_box image" />
            </div>
            <div class="stud_box">
                <h3>Welcome <?= $result['fname']." ".$result['lname']; ?></h3>
                <p></p>

                <a href="update_student.php" class="btn">update profile</a>
                <a href="update_student_pass.php" class="option-btn">change password</a>
                <a href="components/student_logout.php" onclick="return confirm('logout from this website?')"
                    class="delete-btn">log out</a>
            </div>
        </div>


        <div class="box-container">

            <!-- <div class="box">
                <h3>Student ID</h3>
                <p><?= $result['id']; ?></p>
            </div> -->

            <div class="box">
                <h3>Email ID</h3>
                <p><?= $result['email']; ?></p>
            </div>

            <div class="box">
                <h3>Gender</h3>
                <p><?= $result['gender']; ?></p>
            </div>

            <div class="box">
                <h3>Contact No</h3>
                <p><?= $result['phone_no']; ?></p>
            </div>

            <div class="box">
                <h3>Date of Birth</h3>
                <p><?= $result['DOB']; ?></p>
            </div>

            <div class="box">
                <h3>Course</h3>
                <p><?= $result['course']; ?></p>
            </div>

            <div class="box">
                <h3>Fees Status</h3>
                <p><?= $result['fees']; ?></p>
            </div>

            <div class="box">
                <h3>Hobbies</h3>
                <p><?= $result['hobbies']; ?></p>
            </div>

            <div class="box">
                <h3>Address</h3>
                <p><?= $result['address']; ?></p>
            </div>

        </div>
    </section>


</body>
<script src="js/user_logic1.js"></script>


</html>