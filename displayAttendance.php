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
$query = "SELECT COUNT(*) AS total_days_present
          FROM attendance
          WHERE student_id = '$stud_id'
          AND MONTH(date) = '$currentMonth'
          AND YEAR(date) = YEAR(CURRENT_DATE())
          AND date <= '$currentDate'";

$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_days_present = $row['total_days_present'];

// Calculate total number of working days up to the current date in the month
$total_working_days = getTotalWorkingDaysInMonth(date('Y'), $currentMonth);

// Calculate attendance percentage
$attendance_percentage = ($total_days_present / $total_working_days) * 100;

function getTotalWorkingDaysInMonth($year, $month) {
    $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $workingDays = 0;

    for ($day = 1; $day <= $totalDays; $day++) {
        $date = "$year-$month-$day";
        $dayOfWeek = date('N', strtotime($date)); // 1 (Monday) to 7 (Sunday)

        // Exclude Sundays (dayOfWeek = 7)
        if ($dayOfWeek != 7) {
            $workingDays++;
        }
    }

    return $workingDays;
}

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

        <h1 class="heading">Student Attendance</h1>
        <p>Attendance Percentage: <?php echo $attendance_percentage; ?>%</p>
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