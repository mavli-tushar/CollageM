<?php 

    include '../components/connect.php';

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    $peon_id = $_GET['peon_id'];
    $select_peon = "SELECT * FROM `peons` WHERE id = '$peon_id'";
    $peon_id_data = mysqli_query($conn, $select_peon);
    $result = mysqli_fetch_assoc($peon_id_data);
    
    if (isset($_POST['update'])) {
        
        
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone_no = $_POST['phone_no'];
        $gender = $_POST['gender'];

        $update_peon = "UPDATE `peons` SET name = '$name', email = '$email', phone_no = '$phone_no',gender = '$gender' WHERE id = '$peon_id'";
        $data = mysqli_query($conn, $update_peon);
    
        $update_user = "UPDATE `users` SET name = '$name', email = '$email' WHERE peon_id = '$peon_id'";
        $data = mysqli_query($conn, $update_user);

        if($data){
            $message[] = 'update data successfully!';
            header('location:displayPeon.php');
        }else{
            $message[] = 'failed to update data!';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update Peon Details</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../css/admin_style.css" />
</head>

<body>

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

    <section class="form-container">
        <form action="" method="post" onsubmit="return validatePhoneNumber();">
            <h3>update peon details</h3>

            <input type="text" name="peon_id" placeholder="Peon ID (Ex: p101)" readonly
                value="<?= $result['id']; ?>" required class="box" />
            <input type="text" name="name" placeholder="Peon Name" value="<?= $result['name']; ?>" required
                class="box" />
            <input type="text" name="email" placeholder="Email ID" value="<?= $result['email']; ?>" required
                class="box" />
            <input type="text" id="phone_no" name="phone_no" placeholder="Phone Number" value="<?= $result['phone_no']; ?>" required
                class="box" />
                <span id="phone_error" style="color: red; display: none;">Contact number must be 10 digits</span>

                <div class="box">
    <input type="radio" name="gender" value="Male" <?= $result['gender'] === 'Male' ? 'checked' : '' ?> required> Male
    <input type="radio" name="gender" value="Female" <?= $result['gender'] === 'Female' ? 'checked' : '' ?> required style="margin-left: 5rem;"> Female
</div>
            <div class="my-flex-btn">
                <input type="submit" value="save" name="update" class="option-btnf" />
                <a href="displayPeon.php" class="delete-btn">go back</a>
            </div>
        </form>
    </section>

</body>

<script src="../js/admin_logic1.js"></script>

<script>
    const phoneInput = document.getElementById('phone_no');
    const phoneError = document.getElementById('phone_error');

    function validatePhoneNumber() {
        if (phoneInput.value.length !== 10) {
            phoneError.style.display = 'block';
            return false;
        } else {
            phoneError.style.display = 'none';
            return true;
        }
    }

    phoneInput.addEventListener('input', validatePhoneNumber);
</script>
</html>