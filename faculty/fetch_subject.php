<?php
include '../components/connect.php';

if(isset($_POST['course']) && isset($_POST['year'])){
    $selectedCourse = $_POST['course'];
    $selectedYear = $_POST['year'];

    // Query to fetch subjects based on the selected course and year
    $query = "SELECT * FROM subjects WHERE course_name='$selectedCourse' AND year='$selectedYear'";
    $result = mysqli_query($conn, $query);
    echo " <option disabled Selected>Select Subject</option> ";
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            echo "<option value='" . $row['subject_name'] . "'>" . $row['subject_name'] . "</option>";
        }
    } else {
        echo "<option disabled selected>No Subjects Found</option>";
    }
}
?>
