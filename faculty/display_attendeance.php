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
    <title>All Students</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../css/user_style1.css" />

    <style>
        
        #filterForm .row {
    display: flex;
    justify-content: space-between;
}

#filterForm select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

#filterForm select:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
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

form {
    margin-bottom: 20px;
}

label {
    display: inline-block;
    margin-right: 10px;
}

select {
    padding: 5px;
    border-radius: 3px;
    border: 1px solid #ccc;
    margin-right: 10px;
}

input[type="submit"] {
    padding: 5px 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th,
table td {
    padding: 10px;
    border: 3px solid #ccc;
    text-align: left;
}

table th {
    background-color: #007bff;
    color: #fff;
}

    </style>
</head>

<body>
    <?php include '../components/faculty_header.php'; ?>

    <section class="Attendance">

        <h1 class="heading">Students Attendance</h1>

        <form id="filterForm">
            <div class="row">
                <select class="col-md-4" name="course" id="course" required>
                    <option>Select Course</option>
                    <?php
                        $query = "SELECT * FROM course";
                        $run = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_array($run)) {
                            echo "<option value='" . $row['courseName'] . "'>" . $row['courseName'] . "</option>";
                        }
                        ?>
                </select>
                <select class="col-md-4" name="year" id="year" required>
                    <option>Select Year</option>
                    <option value="Fy">First Year</option>
                        <option value="Sy">Secound Year</option>
                        <option value="Ty">Third Year</option>
                </select>
                <select class="col-md-4" name="division" id="division" required>
                <option>Select divition</option>
                <option value="Div-1" >Div-1</option>
                        <option value="Div-2">Div-2</option>
                        <option value="Div-3">Div-3</option>
                </select>
                <select class="col-md-4" name="lecture" id="lecture" required>
                <option>Select lecture</option>
                <option value="lec-1" >lecture-1</option>
                        <option value="lec-2">lecture-2</option>
                        <option value="lec-3">lecture-3</option>
                </select>
            </div>
            <button type="submit">Filter</button>
        </form>

        <br><br>
        <div id="attendanceTable">
            <!-- Attendance records will be displayed here -->
        </div>

    </section>

    <script src="../js/user_logic1.js"></script>
    <script>
        document.getElementById('filterForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(this);

            fetch('fetch_attendance.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('attendanceTable').innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
<script src="../js/user_logic1.js"></script>


</html>