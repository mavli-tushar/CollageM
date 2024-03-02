<?php 

    include '../components/connect.php';

    session_start();

    $faculty_id = $_SESSION['faculty_id'];

    if(!isset($faculty_id)){
        header('location:faculty_login.php');
    }

    $select_faculty = "SELECT * FROM `faculty` WHERE id = '$faculty_id'";
    $data = mysqli_query($conn, $select_faculty);
    $result1 = mysqli_fetch_assoc($data);

    if(isset($_POST['add_assignment'])){
        $faculty_id = $_POST['id'];
        $faculty_name = $_POST['name'];
        $faculty_email = $_POST['email'];
        $subject_name = $_POST['sub_name'];
        $last_date = $_POST['last_date'];
        date_default_timezone_set('Asia/Kolkata');
        $date = date('y-m-d h:i:s');

        $pdf_file = $_FILES['assignment_pdf']['name'];
        $extension = pathinfo($pdf_file, PATHINFO_EXTENSION);
        $pdf_file_size = $_FILES['assignment_pdf']['size'];
        $pdf_tmp_name = $_FILES['assignment_pdf']['tmp_name'];
        $pdf_type=$_FILES['assignment_pdf']['type'];
        $pdf_folder = '../uploaded_assignment/'.$pdf_file;

        if (!in_array($extension, ['pdf', 'docx'])) {
            $message[] = "Your file extension must be .pdf or .docx";
        }else{
            if (move_uploaded_file($pdf_tmp_name, $pdf_folder)) {
                $insert_assignment = "INSERT INTO `assignments`(faculty_id, faculty_name, faculty_email, subject_name, pdf_file, issue_date, submission_date, downloads) VALUES ('$faculty_id', '$faculty_name', '$faculty_email', '$subject_name', '$pdf_file', '$date', '$last_date', 0)";
                $data = mysqli_query($conn, $insert_assignment);
                    
                    if($data){
                        $message[] = 'assignment added successfully!';
                    }
            }else{
                $message[] = 'Failed to upload file.';
            }
        }
    }

    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];

        $select_assignment = "SELECT * FROM `assignments` WHERE id='$delete_id'";
        $data = mysqli_query($conn, $select_assignment);
        $result = mysqli_fetch_assoc($data);
        unlink('../uploaded_assignment/'.$result['pdf_file']);
        
        $delete_assignment = "DELETE FROM `assignments` WHERE id='$delete_id'";
        $data = mysqli_query($conn, $delete_assignment);

        header('location:assignments.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty - Assignment</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../css/user_style1.css" />
    <link rel="stylesheet" href="../css/all.css">
</head>

<body>

    <?php include '../components/faculty_header.php'; ?>

    <section class="form-container">

        <form action='' method='post' enctype="multipart/form-data">
            <h3>Add new assignment</h3>
            <input type='text' name='id' readonly value="<?= $result1['id']; ?>" placeholder='Faculty ID'
                class='box'>
            <input type='text' name='name' readonly value="<?= $result1['name']; ?>" placeholder='Faculty Name'
                class='box'>
            <input type='text' name='email' readonly value="<?= $result1['email']; ?>" placeholder='Faculty Name'
                class='box'>
            <input type='text' name='sub_name' placeholder='Subject Name' class='box' required>
            <input type="file" name="assignment_pdf" accept="application/pdf, application/vnd.ms-excel" class="box" />
            <h2>Last Date of Submission</h2>
            <input type="date" name="last_date" class="box" min="<?php echo date('Y-m-d');?>" required/>
            <input type='submit' value='Add Assignment' class='option-btn' name='add_assignment' required>
        </form>

    </section>

    <section class="show-notices">

        <h1 class="heading">assignments added</h1>

        <div class="box-container">

            <?php

            $select_faculty = "SELECT * FROM `faculty` WHERE id = '$faculty_id'";
            $data = mysqli_query($conn, $select_faculty);
            // $result1 = mysqli_fetch_assoc($data);

            $faculty_id1 = $result1['id'];

            $select_assignment = "SELECT * FROM `assignments` WHERE faculty_id = '$faculty_id1'";
            $data = mysqli_query($conn, $select_assignment);

            $total = mysqli_num_rows($data);

            if($total > 0){
            while($fetch_assignment = mysqli_fetch_assoc($data)){ 
        ?>
            <div class="box">

                <div class="id">Faculty ID : <?= $fetch_assignment['faculty_id']; ?></div>
                <div class="name">Faculty Name : <?= $fetch_assignment['faculty_name']; ?></div>
                <div class="detail">Email : <?= $fetch_assignment['faculty_email']; ?></div>
                <div class="detail">Subject Name : <?= $fetch_assignment['subject_name']; ?></div>
                <div class="detail">File Name : <?= $fetch_assignment['pdf_file']; ?></div>
                <div class="detail">Assigned Date : <?= $fetch_assignment['issue_date']; ?></div>
                <div class="detail">Submission Date : <?= $fetch_assignment['submission_date']; ?></div>
                <div class="detail">Total Downloads : <?= $fetch_assignment['downloads']; ?></div>
                <a href="assignments.php?delete=<?= $fetch_assignment['id']; ?>" class="delete-btn"
                    onclick="return confirm('delete this assignment?');">delete</a>
            </div>
            <?php
         }
      }else{
         echo '<p class="empty">no assignments added yet!</p>';
      }
   ?>

        </div>

    </section>

</body>
<script src="../js/user_logic1.js"></script>


</html>