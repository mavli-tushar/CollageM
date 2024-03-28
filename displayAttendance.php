<?php 

    include 'components/connect.php';

    session_start();

    $stud_id = $_SESSION['stud_id'];

    if(!isset($stud_id)){
        header('location:student_login.php');
    }

     // Get the current date and month
     $currentDate = date('Y-m-d');
     $currentMonth = date('m');
 
     // Calculate total number of days present up to the current date in the month
     $query = "SELECT COUNT(DISTINCT DATE(date)) AS total_days_present
          FROM attendance
          WHERE student_id = '$stud_id'
          AND MONTH(date) = '$currentMonth'
          AND YEAR(date) = YEAR(CURRENT_DATE())
          AND date <= '$currentDate'";

     $result = mysqli_query($conn, $query);
     $row = mysqli_fetch_assoc($result);
     $total_days_present = $row['total_days_present'];
 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="css/user_style1.css" />

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: large;
        }

        table tbody tr:hover {
    background-color: #e9ecef;
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

        .present {
            background-color: lightgreen;
        }

        .absent {
            background-color: lightcoral;
        }
    </style>
</head>

<body>
    <?php include 'components/student_header.php'; ?>

    <section class="Attendance">
    
        <h1 class="heading">Student Attendance</h1>
        <h2>Total Days Present in Current Month: <?php echo $total_days_present; ?></h2>
        <br><br>
        <div id="attendanceTable">
            <?php
            $query = "SELECT a.date, a.status, s.fname, s.lname,a.lecture,a.subject
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
                            <th>Lecture</th>
                            <th>Subject</th>
                        </tr>';

                        while ($row = mysqli_fetch_assoc($result)) {
                            $statusClass = ($row['status'] == 'present') ? 'present' : 'absent';
                            echo '<tr class="' . $statusClass . '">
                                    <td>' . $row['date'] . '</td>
                                    <td>' . $row['status'] . '</td>
                                    <td>' . $row['lecture'] . '</td>
                                    <td>' . $row['subject'] . '</td>
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
