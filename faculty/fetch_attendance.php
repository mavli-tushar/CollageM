<?php

include "../components/connect.php"; 

if (isset($_POST['course']) && isset($_POST['year']) && isset($_POST['division'])  && isset($_POST['lecture'])) {
    $course = $_POST['course'];
    $year = $_POST['year'];
    $division = $_POST['division'];
    $lecture = $_POST['lecture'];
    
    $query = "SELECT a.date, a.status,a.lecture, s.fname
              FROM attendance a
              INNER JOIN students s ON a.student_id = s.id
              WHERE a.course_name = '$course'
              AND s.year = '$year' 
              AND a.lecture = '$lecture'
              AND s.division = '$division'
              ORDER BY a.date DESC";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<table>
                <tr>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Student Name</th>
                    <th>lecture</th>
                </tr>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
                    <td>' . $row['date'] . '</td>
                    <td>' . $row['status'] . '</td>
                    <td>' . $row['fname'] . '</td>
                    <td>' . $row['lecture'] . '</td>
                  </tr>';
        }

        echo '</table>';
    } else {
        echo 'No records found';
    }
} else {
    echo 'Invalid request';
}

?>
