<?php 

    include '../components/connect.php';

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:admin_login.php');
    }

    if (isset($_POST['register'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $password = sha1($_POST['password']);
        $gender = $_POST['gender'];
        $date_of_birth = $_POST['date_of_birth'];
        $course = $_POST['course'];
        $fees = $_POST['fees'];
        $hobbies = implode(",",$_POST['hobby']);
        $email = $_POST['email'];
        $phone_no = $_POST['phone_no'];
        $address = $_POST['address'];
        
        $full_name = $fname." ".$lname;

            $insert_student = "INSERT INTO `students`(admin_id, fname, lname, email, password, phone_no, gender, DOB, course, hobbies, address, fees , student_img) VALUES ('$admin_id', '$fname', '$lname', '$email', '$password', '$phone_no', '$gender', '$date_of_birth', '$course', '$hobbies', '$address', '$fees','')";
            $data = mysqli_query($conn, $insert_student);
            $stud_id=mysqli_insert_id($conn);
            $insert_user = "INSERT INTO `users`(stud_id, name, email, password) VALUES('$stud_id','$full_name', '$email', '$password')";
            $data = mysqli_query($conn, $insert_user);

            if($data){
                echo "<script>alert('Student added successfully!'); window.location.href = 'displayStud.php';</script>";
               
            }else{
                $message[] = 'failed to add new student!';
            }
            // header('location:displayStud.php');
            exit();
        }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student Window</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../css/admin_style.css" />
<style>.custom-btn {
    float: right;
    display: block;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    color: #fff;
    background-color: #007bff;
    border: 2px solid #007bff;
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s, border-color 0.3s;
    cursor: pointer;
}

.custom-btn:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.btn-link {
    color: #fff;
    text-decoration: none;

}

</style>
</head>

<body>

    <?php include '../components/admin_header.php'; ?>
    <button class="custom-btn"><a href="displayStud.php" class="btn-link">View Students</a></button>
    <section class="form-container">
    
        <form action="" method="post" autocomplete="on" enctype="multipart/form-data" onsubmit="return validatePhoneNumber();">
            <h3>Add New Student</h3>
            <input type="text" name="fname" placeholder="First Name" class="box" />
            <input type="text" name="lname" placeholder="Last Name" class="box" />
            <input type="password" name="password" value="stud123" readonly placeholder="Password" class="box" />
            <div class="box">
                <input type="radio" name="gender" value="Male" required> Male
                <input type="radio" name="gender" value="Female" required style="margin-left: 5rem;"> Female
            </div>
            <input type="date" name="date_of_birth" class="box" />
            <select name="course" class="box">
            <option >Select Course</option>
				<?php
				$query="select  * from course";
				$run=mysqli_query($conn,$query);
				while($row=mysqli_fetch_array($run)) {
				echo	"<option value=".$row['courseName'].">".$row['courseName']."</option>";
				}
				?>
            </select>

            
            <div class="box">
                <label for="hobby">Hobbies</label>
                <div class="my-flex">
                    <input type="checkbox" id="hobby" name="hobby[]" value="reading" style="margin-left: 1.8rem;"> Reading
                    <input type="checkbox" name="hobby[]" value="swimming" style="margin-left: 6.5rem;"> Swimming
                </div>
                <br />
                <div class="my-flex">
                    <input type="checkbox" name="hobby[]" value="travelling"> Travelling
                    <input type="checkbox" name="hobby[]" value="cooking" style="margin-left: 5.5rem;"> Cooking
                </div>
            </div>
            <input type="text" name="email" placeholder="Email ID" class="box" />
            <input type="text" id="phone_no" name="phone_no" placeholder="Contact Number" class="box" />
            <span id="phone_error" style="color: red; display: none;">Contact number must be 10 digits</span>
            <select name="fees" class="box">
                <option value="Not Selected" disabled Selected>Fees Status</option>
                <option value="Remaining">Remaining</option>
                <option value="Paid">Paid</option>
            </select>
            <textarea name="address" rows="5" placeholder="Address" class="box my_textarea"></textarea>

            <input type="submit" value="ADD DATA" name="register" class="btnf"/>
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