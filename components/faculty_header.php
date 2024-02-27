<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <a onclick="this.parentElement.remove();"><img src="../images/cancel.png" alt=""></a>
         </div>
         ';
      }
   }
?>
 <?php
    if (isset($_SESSION['message1'])) {
        echo '
        <div class="message">
            <span>' . $_SESSION['message1'] . '</span>
            <a onclick="this.parentElement.remove();"><img src="../images/cancel.png" alt=""></a>
        </div>
        ';
        unset($_SESSION['message1']); // Remove the message after displaying
    }
    ?>


<header class="header">

    <section class="flex">

        <a href="faculty_home.php" class="logo">Faculty <span>Panel</span></a>

        <nav class="navbar">
            <a href="faculty_home.php">home</a>
            <a href="all_faculty.php">all faculties</a>
            <a href="all_students.php">all students</a>
            <a href="assignments.php">assignment</a>
            <a href="notices.php">notices</a>
            <a href="message.php">contact</a>
            <a href="stud_attendence.php">Attendance</a>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>

        <div class="profile">
            <?php
            
                $select_profile = "SELECT * FROM `faculty` WHERE id = '$faculty_id'";
                $data = mysqli_query($conn, $select_profile);

                $result = mysqli_fetch_assoc($data);

            ?>
            <!-- <p><?= $result['name']; ?></p> -->
            <a href="update_faculty.php" class="btn">update profile</a>
            <a href="update_faculty_pass.php" class="option-btn">change password</a>
            <a href="../components/faculty_logout.php" onclick="return confirm('logout from this website?')"
                class="delete-btn">logout</a>
        </div>

    </section>

</header>