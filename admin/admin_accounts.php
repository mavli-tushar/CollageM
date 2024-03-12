<?php 

    include '../components/connect.php';

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $delete_user = $_GET['admin_id'];
        
        $delete_admin = "DELETE FROM `admins` WHERE id='$delete_id'";
        $data = mysqli_query($conn, $delete_admin);
        
        $delete_user = "DELETE FROM `users` WHERE admin_id='$delete_user'";
        $data = mysqli_query($conn, $delete_user);
        
        header('location:admin_login.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../css/admin_style.css" />
    <title>Admin Accounts</title>

    <style>
        /* Custom CSS for table */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            font-size: medium;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

       

        .btn {
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 10px;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
        }
        .btns {
            float: right;
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            width: 20%;
            font-size: medium;
            text-align: center;

        }

        .btns:hover {
            background-color: #0056b3;
        }

        .btns-danger {
            background-color: #dc3545;
        }
    </style>
</head>

<body>

<?php include '../components/admin_header.php'; ?>

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
<a href="register_admin.php" class="btns">Register New Admin</a>
    <section class="show-notices">
    
        <h1 class="heading">Admin Staff</h1>

        <div class="containe">
            <table>
                <thead>
                    <tr>
                        <th>Admin ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <!--  <th>Actions</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $select_admin = "SELECT * FROM `admins`";
                    $data = mysqli_query($conn, $select_admin);

                    $total = mysqli_num_rows($data);

                    if ($total > 0) {
                        while ($fetch_admin = mysqli_fetch_assoc($data)) {
                    ?>
                            <tr>
                                <td><?= $fetch_admin['id']; ?></td>
                                <td><?= $fetch_admin['name']; ?></td>
                                <td><?= $fetch_admin['email']; ?></td>
                                <td><?= $fetch_admin['phone_no']; ?></td>
                                <!-- <td>
                                    <?php
                                        echo '<a href="update_profile.php" class="btn">Update</a>';
                                        echo '<a href="admin_accounts.php?delete=' . $fetch_admin['id'] . '&admin_id=' . $fetch_admin['id'] . '" class="btn btn-danger" onclick="return confirm(\'Delete this admin?\');">Delete</a>';
                                    
                                    ?>
                                </td> -->
                            </tr>
                        <?php
                        }
                    } else {
                        echo "<tr><td colspan='4'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </section>

</body>
<script src="../js/admin_logic1.js"></script>
</html>
