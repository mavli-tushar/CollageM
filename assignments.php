<?php 

    include 'components/connect.php';

    session_start();

    $stud_id = $_SESSION['stud_id'];

    if(!isset($stud_id)){
        header('location:student_login.php');
    }

    if (isset($_GET['file_id'])) {
        $id = $_GET['file_id'];

        $select_assignment = "SELECT * FROM `assignments` WHERE id = '$id'";
        $data = mysqli_query($conn, $select_assignment);

        $file = mysqli_fetch_assoc($data);
        $filepath = 'uploaded_assignment/' . $file['pdf_file'];

        if (file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($filepath));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize('uploaded_assignment/' . $file['pdf_file']));
            readfile('uploaded_assignment/' . $file['pdf_file']);

            $newCount = $file['downloads'] + 1;
            $update_downloads = "UPDATE `assignments` SET downloads = '$newCount' WHERE id = '$id'";
            mysqli_query($conn, $update_downloads);
            exit;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignments</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="css/user_style1.css" />
    
</head>

<body>
    <?php include 'components/student_header.php'; ?>

    <section class="show-notices">

        <h1 class="heading">All Assignments</h1>

        <div class="box-container">

            <?php
        $select_assignment = "SELECT * FROM `assignments`";
        $data = mysqli_query($conn, $select_assignment);

        $total = mysqli_num_rows($data);

        if($total > 0){
         while($fetch_assignment = mysqli_fetch_assoc($data)){ 
        ?>
            <div class="box">
                <div class='id'> Faculty ID : <?= $fetch_assignment['faculty_id']; ?></div>
                <div class="name"> Subject Name : <?= $fetch_assignment['subject_name']; ?></div>
                <div class="content"> File Name : <?= $fetch_assignment['pdf_file']; ?></div>
                <div class="content"> Faculty Name : <?= $fetch_assignment['faculty_name']; ?></div>
                <div class="detail"> Email : <?= $fetch_assignment['faculty_email']; ?></div>
                <div class="detail"> Assigned    Date : <?= $fetch_assignment['issue_date']; ?></div>
                <div class="detail"> Last Date : <?= $fetch_assignment['submission_date']; ?></div>
                <a href="assignments.php?file_id=<?= $fetch_assignment['id']; ?>" class="btn">Download</a>
            </div>
            <?php
         }
      }else{
         echo '<p class="empty">no assignmets added yet!</p>';
      }
   ?>

        </div>
    </section>

</body>
<script src="js/user_logic1.js"></script>


</html>