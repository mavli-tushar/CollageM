<?php

    include 'components/connect.php';

    session_start();

    $stud_id = $_SESSION['stud_id'];

    if(!isset($stud_id)){
        header('location:student_login.php');
    }

    $select_student_id = "SELECT * FROM `students` WHERE id = '$stud_id'";
    $student_id_data = mysqli_query($conn, $select_student_id);
    $result = mysqli_fetch_assoc($student_id_data);
    $student_id = $result['id'];

    if(isset($_POST['send_msg'])){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone_no = $_POST['phone_no'];
            $message_content = $_POST['message'];
            
            $send_message = "INSERT INTO `messages`(faculty_id,stud_id, name, email, phone_no, message) VALUES ('','$student_id', '$name', '$email', '$phone_no', '$message_content')";
            $data = mysqli_query($conn, $send_message);

            if($data){
                $message[] = 'message send successfully!';
            }else{
                $message[] = 'failed to send message!';
            }
        }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Window</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="css/user_style1.css" />
</head>

<body>

    <?php include 'components/student_header.php'; ?>

    <section class="form-container">

        <form action='' method='post'>
            <h3>Send message to Admin</h3>
            <input type='text' name='name' required readonly placeholder='Name' class='box'
                value="<?php echo $result['fname']." ".$result['lname']; ?>">
            <input type='text' name='email' required readonly placeholder='Email ID' class='box'
                value="<?php echo $result['email']; ?>">
            <input type='text' name='phone_no' readonly placeholder='Phone No' class='box'
                value="<?php echo $result['phone_no']; ?>">
            <textarea name="message" rows="5" placeholder="Message" class="box my_textarea"></textarea>
            <input type='submit' value='Send Message' class='option-btnf' name='send_msg'>
        </form>

    </section>

</body>
<script src="js/user_logic1.js"></script>

</html>