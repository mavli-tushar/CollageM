<?php 

    include '../components/connect.php';

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    if (isset($_POST['submit'])) {
        $name = $_POST['subject'];
        $course = $_POST['course'];
        $year = $_POST['year'];
    
            $insert_sub = "INSERT INTO `subjects`(subject_name, course_name,year) VALUES ( '$name', '$course', '$year')";
            $data = mysqli_query($conn, $insert_sub);

            if($data){
                echo "<script>alert('subject added successfully!'); window.location.href = 'subject.php';</script>";
            }else{
                echo "<script>alert('something is wrong !')";
            }
        
    }

    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $delete_sub = $_GET['sub_id'];

        $delete_sub = "DELETE FROM subjects WHERE subject_id='$delete_id'";
        $data = mysqli_query($conn, $delete_sub);
       
        header('location:subject.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>subject</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../css/admin_style.css" />

    <style>
        
.form-containers {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: auto;
  margin-top:5rem ;
}

.form-containers form {
  background-color: var(--white);
  border-radius: 10rem;
  margin-left: 7rem;
  box-shadow: var(--box-shadow);
  text-align: center;
  padding: 2rem;
  width: 75rem;
  color: black;
  box-shadow: 0px 5px 20px rgb(0,0,0);
}

.form-containers form h3 {
  text-transform: capitalize;
  font-size: 2.8rem;
  color: var(--main-color);
  margin-bottom: 2rem;
}

.form-containers form p {
  font-size: 1.8rem;
  color: var(--light-color);
  margin-bottom: 1rem;
  border-radius: 0.5rem;
  float: left;
  margin-top: 1rem;
}

.form-containers form p span {
  color: var(--orange);
}

.form-containers form .box {
  width: 100%;
  background-color: var(--light-bg);
  padding: 1.4rem;
  font-size: 1.8rem;
  color: var(--black);
  margin: 1rem 0;
  border: var(--border);
  border-radius: 0.5rem;
}


/* Custom CSS for table */
body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            font-size: medium;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

       

        .btn {
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            display:inline-flexbox;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
        }
        .btns {
            float: right;
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            width: 20%;
            font-size: medium;
            text-align: center;

        }

        .btns:hover {
            background-color: #0056b3;
        }

        .btns-danger {
            background-color: #dc3545;
        }
    </style>

</head>

<body>

    <?php include '../components/admin_header.php'; ?>
    <section class="form-containers">
        <form action="" method="post" onsubmit="return validatePhoneNumber();">
            <h3>Add New Subject</h3>
            <input type="text" name="subject" placeholder="enter subject name" required class="box" />
            <!-- <input type="text" name="course" placeholder="enter course name" required class="box" /> -->
            <select name="course" class="box">
            <option selected disabled>Select Course</option>
				<?php
				$query="select  * from course";
				$run=mysqli_query($conn,$query);
				while($row=mysqli_fetch_array($run)) {
				echo	"<option value=".$row['courseName'].">".$row['courseName']."</option>";
				}
				?>
            </select>

            <select name="year" class="box">
            <option selected disabled >Select year</option>
            <option value="fy">Fisrt Year</option>
            <option value="sy">Secound Year</option>
            <option value="ty">Third Year</option>
				
            </select>
        
            <input type="submit" value="Add" name="submit" class="option-btnf" />
        </form>
      </section>
        <section class="show-notices">
        <div class="containe">
            <table>
                <thead>
                    <tr>
                        <th>Admin ID</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Year</th>
                        <th>Actions</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $select_sub = "SELECT * FROM subjects";
                    $data = mysqli_query($conn, $select_sub);

                    $total = mysqli_num_rows($data);

                    if ($total > 0) {
                        while ($fetch_sub = mysqli_fetch_assoc($data)) {
                    ?>
                            <tr>
                                <td><?= $fetch_sub['subject_id']; ?></td>
                                <td><?= $fetch_sub['subject_name']; ?></td>
                                <td><?= $fetch_sub['course_name']; ?></td>
                                <td><?= $fetch_sub['year']; ?></td>
                                <td>
                                      <?php
                                          echo '<a href="subject.php?delete=' . $fetch_sub['subject_id'] . '&sub_id=' . $fetch_sub['subject_id'] . '" class="btn btn-danger" onclick="return confirm(\'Delete this admin?\');">Delete</a>';
                                      ?>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        echo "<tr><td colspan='4'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </section>
</body>

<script src="../js/admin_logic1.js"></script>


</html>