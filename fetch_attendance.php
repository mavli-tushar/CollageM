<?php

include 'components/connect.php'; // Include your database connection file

if (isset($_POST['course']) && isset($_POST['year']) && isset($_POST['division'])) {
    $course = $_POST['course'];
    $year = $_POST['year'];
    $division = $_POST['division'];

    $query = "SELECT a.date, a.status, s.fname
              FROM attendance a
              INNER JOIN students s ON a.student_id = s.id
              WHERE a.course_name = '$course'
              AND s.year = '$year'
              AND s.division = '$division'
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
                    <td>' . $row['fname'] . '</td>
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
