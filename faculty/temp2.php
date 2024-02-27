<?php
include '../components/connect.php';

if(isset($_POST['course'])) {
    $selectedCourse = $_POST['course'];
    $selectedYear = $_POST['year'];
    $selectedDivision = $_POST['division'];
    $query = "SELECT * FROM students WHERE course='$selectedCourse' AND year='$selectedYear' AND division='$selectedDivision'";
    $run = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($run)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['fname'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>".$row['phone_no']."</td>";
        echo "<td>";
        echo "<input type='hidden' name='student_id' value='" . $row['id'] . "'>";
        echo "<input type='radio' id='present'name='attendance[" . $row['id'] . "][status]' value='present' required>";
        echo "<label for='present'>Present</label>";
        echo "<input type='radio' id='absent' name='attendance[" . $row['id'] . "][status]' value='absent' required>";
        echo "<label for='absent'>Absent</label>";
        echo "</td>";
        echo "</tr>";
    }
}
?>
