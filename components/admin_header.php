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

<!DOCTYPE html>
<html lang="en">
<head>
    
</head>
<body>
    
</body>
</html>
<header class="header">
    <section class="flex">
    <div class="a">
        <img src="../images/svp.png" height="50spx" alt="Logo">
    </div>
        <a href="dashboard.php" class="logo">Admin <span>Panel</span></a>


        <nav class="navbar">
            <a href="../admin/dashboard.php">home</a>
            <a href="../admin/notices.php">notices</a>
            <a href="../admin/students.php">students</a>
            <a href="../admin/faculties.php">faculties</a>
            <a href="../admin/peons.php">peons</a>
            <a href="../admin/admin_accounts.php">admin</a>
            <a href="../admin/user_accounts.php">users</a>
            <a href="../admin/messages.php">messages</a>
            <a href="../admin/search.php">Search</a>
            
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>

        <div class="profile">
            <?php
            
                $select_profile = "SELECT * FROM `admins` WHERE id = '$admin_id'";
                $data = mysqli_query($conn, $select_profile);

                $result = mysqli_fetch_assoc($data);

            ?>
            <p><?= $result['name']; ?></p>
            <a href="../admin/update_profile.php" class="btn">update profile</a>
            <div class="my-flex-btn">
                <a href="../admin/admin_login.php" class="option-btn">login</a>
                <a href="../admin/register_admin.php" class="option-btn">signup</a>
            </div>
            <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?')"
                class="delete-btn">logout</a>
        </div>
    </section>
</header>