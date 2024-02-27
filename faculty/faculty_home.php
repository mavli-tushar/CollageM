<?php 

    include '../components/connect.php';

    session_start();

    $faculty_id = $_SESSION['faculty_id'];

    if(!isset($faculty_id)){
        header('location:faculty_login.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty - Home Page</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../css/user_style1.css" />
</head>

<body>

    <?php include '../components/faculty_header.php'; ?>

    <section class="dashboard">

        <h1 class="heading">faculty dashboard</h1>

        <div class="box-container2">
            <div class="my-flex-box">
                <image src="<?php echo $result['faculty_img']; ?>" class="stud_box image" />
            </div>
            <div class="stud_box">
                <h3>Welcome  <?= $result['name']; ?></h3>
                <a href="update_faculty.php" class="btn">update profile</a>
                <a href="update_faculty_pass.php" class="option-btn">change password</a>

                <a href="../components/faculty_logout.php" onclick="return confirm('logout from this website?')"
                    class="delete-btn">log
                    out</a>
            </div>
        </div>


        <div class="box-container">

            <div class="box">
                <h3>Faculty ID</h3>
                <p><?= $result['faculty_id']; ?></p>
            </div>

            <div class="box">
                <h3>Email ID</h3>
                <p><?= $result['email']; ?></p>
            </div>

            <div class="box">
                <h3>Gender</h3>
                <p><?= $result['gender']; ?></p>
            </div>

            <div class="box">
                <h3>Phone No</h3>
                <p><?= $result['phone_no']; ?></p>
            </div>

            <div class="box">
                <h3>Degree</h3>
                <p><?= $result['degree']; ?></p>
            </div>

        </div>
    </section>

</body>
<script src="../js/user_logic1.js"></script>


</html>