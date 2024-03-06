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
    <title>All Students</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="css/user_style1.css" />

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
    <?php include 'components/student_header.php'; ?>

    <section class="Attendance">

        <h1 class="heading">Students Attendance</h1>
        <br><br>
        <div id="attendanceTable">
            <?php
             $query = "SELECT a.date, a.status, s.fname, s.lname
             FROM attendance a
             INNER JOIN students s ON a.student_id = s.id
             WHERE s.id = '$stud_id'
             ORDER BY a.date DESC";

   $result = mysqli_query($conn, $query);

   if (mysqli_num_rows($result) > 0) {
       echo '<table>
               <tr>
                   <th>Date</th>
                   <th>Status</th>
                   <th>Student Name</th>
               </tr>';

       while ($row = mysqli_fetch_assoc($result)) {
           echo '<tr>
                   <td>' . $row['date'] . '</td>
                   <td>' . $row['status'] . '</td>
                   <td>' . $row['fname'] . '  '.$row['lname'].'</td>
                 </tr>';
       }

       echo '</table>';
   } else {
       echo 'No records found';
   }
            ?>
        </div>

    </section>
    
</body>


<script src="js/user_logic1.js"></script>
</html>