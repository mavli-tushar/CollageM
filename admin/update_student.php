<?php 

    include '../components/connect.php';

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    $stud_id = $_GET['stud_id'];
    $select_stud = "SELECT * FROM `students` WHERE stud_id = '$stud_id'";
    $stud_id_data = mysqli_query($conn, $select_stud);
    $result = mysqli_fetch_assoc($stud_id_data);

    $hobbies_arr = explode(",", $result['hobbies']);
    
    if (isset($_POST['update'])) {
        
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $fees = $_POST['fees'];

        $full_name = $fname." ".$lname;

        $update_student = "UPDATE `students` SET fees = '$fees' WHERE stud_id = '$stud_id'";
        $data = mysqli_query($conn, $update_student);
    
        $update_user = "UPDATE `users` SET name = '$full_name', email = '$email' WHERE stud_id = '$stud_id'";
        $data = mysqli_query($conn, $update_user);

        if($data){
            $message[] = 'update data successfully!';
            header('location:students.php');
        }else{
            $message[] = 'failed to update data!';
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
    <link rel="stylesheet" href="../css/admin_style.css" />

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
        <form action="" method="post">
            <h3>update student's fees details</h3>

            <input type="text" name="stud_id" readonly placeholder="Stud ID (Ex: p101)" readonly
                value="<?= $result['stud_id']; ?>" required class="box" />
            <input type="text" name="fname" readonly placeholder="First Name" value="<?= $result['fname']; ?>" required
                class="box" />
            <input type="text" name="lname" readonly placeholder="Last Name" value="<?= $result['lname']; ?>" required
                class="box" />
            <input type="text" name="email" readonly placeholder="Email ID" value="<?= $result['email']; ?>" required
                class="box" />
            <select name="fees" class="box">
                <option value="Not Selected">Select Fees Status</option>
                <option value="Remaining" <?php
                    if($result['fees'] == 'Remaining'){
                        echo "selected";
                    }
                ?>>Remaining</option>
                <option value="Paid" <?php
                    if($result['fees'] == 'Paid'){
                        echo "selected";
                    }
                ?>>Paid</option>
            </select>
            <div class="my-flex-btn">
                <input type="submit" value="save" name="update" class="option-btn" />
                <a href="students.php" class="delete-btn">go back</a>
            </div>
        </form>
    </section>

</body>

<script src="../js/admin_logic1.js"></script>

</html>