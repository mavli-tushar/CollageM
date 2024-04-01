<?php 

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
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
            background-color: blue;
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

        .sh:hover {
            color: aliceblue;
        }

        .b {
            background-color: var(--orange);
            margin-top: 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            width: 500px;
            padding: 1rem 4rem;
            font-size: 1.6rem;


        }

        select[name="course_filter"] {
            margin-left: 10px;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            cursor: pointer;
            background-color:  var(--orange);
        }

        /* Style for the search button */
        .sh {
            background-color: var(--orange);
            margin-left: 10px;
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            font-size: 16px;
            cursor: pointer;
            color: #fff;
        }

        .sh:hover {
            background-color: blue;
        }
    </style>
</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="show-notices">

        <h1 class="heading">student</h1>
        <form class="heading" action="" method="post">
            <input class="b" type="text" name="search" placeholder="Search Data Here">
            <select name="course_filter">
                <option value="">Select Course</option>
                <?php
                // Fetch distinct courses from the students table
                $query = "SELECT *  FROM course";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    $course = $row['courseName'];
                    echo "<option value='$course'>$course</option>";
                }
                ?>
            </select>
            <button name="submit" type="submit" class="sh"><i class="fa fa-search"></i></button>
        </form>
        <div class="box-container">
            <?php
            if (isset($_POST['submit'])) {
                $search = $_POST['search'];
                $courseFilter = isset($_POST['course_filter']) ? $_POST['course_filter'] : '';

                $select_student = "SELECT * FROM students WHERE (fname LIKE '%$search%' OR course LIKE '%$search%')";
                if (!empty($courseFilter)) {
                    $select_student .= " AND course = '$courseFilter'";
                }

                $data = mysqli_query($conn, $select_student);

                $total = mysqli_num_rows($data);

                if ($total > 0) {
                    while ($fetch_student = mysqli_fetch_assoc($data)) {
            ?>
                        <div class="box">
                            <div class="my-flex-box">
                                <image src="<?php echo '../' . $fetch_student['student_img'] ?>" class="all_image" />
                            </div>
                            <!-- <div class="id">Student ID : <?= $fetch_student['id']; ?></div> -->
                            <div class="name"><?= $fetch_student['fname'] . " " . $fetch_student['lname']; ?></div>
                            <div class="content"><?= $fetch_student['email']; ?></div>
                            <div class="detail">Gender : <?= $fetch_student['gender']; ?></div>
                            <div class="detail">DOB : <?= $fetch_student['DOB']; ?></div>
                            <div class="detail">Phone No : <?= $fetch_student['phone_no']; ?></div>
                            <div class="detail">Course : <?= $fetch_student['course']; ?></div>
                            <div class="detail">Fees Status : <?= $fetch_student['fees']; ?></div>
                            <div class="detail">Address : <?= $fetch_student['address']; ?></div>
                            <div class="my-flex-btn">
                                <a href="update_student.php?stud_id=<?= $fetch_student['id']; ?>" class="option-btn"><i class="fa fa-edit"></i>Update</a>
                                <a href="search.php?delete=<?= $fetch_student['id']; ?>&stud_id=<?= $fetch_student['id'] ?>" class="delete-btn" onclick="return confirm('delete this student details?');"><i class="fa fa-trash"></i>Delete</a>
                            </div>
                        </div>
            <?php
                    }
                } else {
                    echo '<p class="empty">no student found!</p>';
                }
            }
            ?>
        </div>

    </section>


</body>

<script src="../js/admin_logic1.js"></script>

</html>
