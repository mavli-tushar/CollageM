<?php

include '../components/connect.php';

session_start();

$faculty_id = $_SESSION['faculty_id'];

if (!isset($faculty_id)) {
    header('location:faculty_login.php');
    exit; // Stop further execution
}



if(isset($_POST['submit_attendance'])){
    $selectedCourse = $_POST['course'];
    $attendanceRecords = $_POST['attendance'];
    $date = date('Y-m-d');

    foreach($attendanceRecords as $studentId => $record){
        $status = $record['status'];
        $query = "INSERT INTO attendance (student_id, course_name, date, status) VALUES ('$studentId', '$selectedCourse', '$date', '$status')";
       $data= mysqli_query($conn, $query);
    }
    if ($data) {
        $_SESSION['message1'] = 'Record added successfully!';
    } else {
        $_SESSION['message1'] = 'Something went wrong!';
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../css/user_style1.css" />

    <style>
        /* Reset default table styles */
        .custom-table {
            border-collapse: collapse;
            width: 100%;
            font-size: 20px;
        }
       
        .custom-table th,
        .custom-table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        /* Style table header */
        .custom-table th {
            background-color: #f2f2f2;
            color: #333;
        }

        /* Style alternate rows */
        .custom-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Style table cell with image */
        .custom-table td img {
            max-width: 100px;
            height: 75px;
        }

        /* Style table cell with icons */
        .custom-table td a {
            color: #333;
            text-decoration: none;
        }

        .custom-table td a:hover {
            color: #555;
        }
        
.custom-table th {
    background-color: #343a40;
    color: white;
}

/* Striped rows */
.custom-table tbody tr:nth-child(odd) {
    background-color: #f8f9fa;
}

/* Hover effect */
.custom-table tbody tr:hover {
    background-color: #e9ecef;
}

        #attendanceForm .row {
    display: flex;
    justify-content: space-between;
}

#attendanceForm select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

#attendanceForm select:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}



#attendanceSubmitForm input[type="submit"] {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 2rem;
}

#attendanceSubmitForm input[type="submit"]:hover {
    background-color: #0056b3;
}

    </style>
</head>

<body>
    <?php include '../components/faculty_header.php'; ?>
   
    <section class="Attendance">

        <h1 class="heading">Students Attendance</h1>

            <form method="post" id="attendanceForm">
            <div class="row">
                    <select  class="col-md-4" name="course"  id="coursSelected" required>
                        <option>Select Course</option>
                        <?php
                        $query = "SELECT * FROM course";
                        $run = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_array($run)) {
                            echo "<option value='" . $row['courseName'] . "'>" . $row['courseName'] . "</option>";
                        }
                        ?>
                    </select>
                    <select  class="col-md-4" name="year" id="year" required>
                    <option>Select Year</option>
                        <option value="Fy">First Year</option>
                        <option value="Sy">Secound Year</option>
                        <option value="Ty">Third Year</option>
                    </select>
                    <select name="division" id="division" required>
                    <option>Select division</option>
                        <option value="Div-1" >Div-1</option>
                        <option value="Div-2">Div-2</option>
                        <option value="Div-3">Div-3</option>
                    </select>
            </div>
            </form>
        
        <br><br>
        <form method="post" id="attendanceSubmitForm">
            <input type="hidden" name="course" id="courseField">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact No</th>
                        <th>Present/Absent</th>
                    </tr>
                </thead>
                <tbody id="attendanceTableBody">
                    <!-- Table rows will be added dynamically here -->
                </tbody>
            </table>
            <center><input type="submit"  name="submit_attendance" value="Submit Attendance"></center>
        </form>

    </section>

</body>
<script src="../js/user_logic1.js"></script>

<script>document.getElementById('coursSelected').addEventListener('change', function() {
    var course = document.getElementById('coursSelected').value;
    document.getElementById('courseField').value = course;
    var year = document.getElementById('year').value;
    var division = document.getElementById('division').value;
    fetchStudents(course, year, division);
});

document.getElementById('year').addEventListener('change', function() {
    var course = document.getElementById('coursSelected').value;
    var year = document.getElementById('year').value;
    var division = document.getElementById('division').value;
    fetchStudents(course, year, division);
});

document.getElementById('division').addEventListener('change', function() {
    var course = document.getElementById('coursSelected').value;
    var year = document.getElementById('year').value;
    var division = document.getElementById('division').value;
    fetchStudents(course, year, division);
});

function fetchStudents(course, year, division) {
    var formData = new FormData();
    formData.append('course', course);
    formData.append('year', year);
    formData.append('division', division);
    
    fetch('temp2.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('attendanceTableBody').innerHTML = data;
    })
    .catch(error => console.error('Error:', error));
}

    
</script>

</html>
