<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require "vendor/autoload.php";

session_start();
if (empty($_SESSION['name'])) {
    header('location:index.php');
}
include('headerAdmin.php');
include('includes/connection.php');

if (isset($_POST['add-patient'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $patient_type = $_POST['patient_type'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    try {
        $insert = mysqli_query($connection, "INSERT INTO patients_tbl (username,first_name,last_name,email,pwd,dob,gender,patient_type,phone,Paddress) VALUES ('$username', '$first_name', '$last_name', '$email', '$pwd', '$dob', '$gender', '$patient_type', '$phone', '$address')");
        if ($insert > 0) {
            $msg = "Patient created successfully";
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->Username   = 'noreply.chu.project@gmail.com';
            $mail->Password   = 'fhcidqnwpiuadhnb';

            $message = "Hello " . $first_name . ' ' . $last_name . ", Here is Your Login Credentials for CHU application\n\nUsername: " . $username . "\nPassword: " . $pwd . "\nNB: You can modify your profile after login.";

            $mail->setFrom('noreply.chu.project@gmail.com', 'Admin');
            $mail->addAddress($email);
            $mail->Subject = "Your Login Credentials";
            $mail->Body = $message;

            $mail->send();
        } else {
            $msg = "Error!";
        }
    } catch (Exception $e) {
        if ($e->getCode() === 1062) {
            // Unique key violation (username already exists)
            $msg =  "Username already exists!";
        } else {
            $msg = "Error!";
        }
    }
}
?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 ">
                <h4 class="page-title">Add Patient</h4>

            </div>
            <div class="col-sm-8  text-right m-b-20">
                <a href="patientsAdmin.php" class="btn btn-primary btn-rounded float-right">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>First Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="first_name" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input class="form-control" type="text" name="last_name" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Username <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="username" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input class="form-control" type="email" name="email" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input class="form-control" type="password" name="pwd" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <div class="cal-icon">
                                    <input type="text" class="form-control datetimepicker" name="dob" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Phone </label>
                                <input class="form-control" type="text" name="phone" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Patient's Type</label>
                                <select class="select" name="patient_type" required>
                                    <option value="">Select</option>
                                    <option>InPatient</option>
                                    <option>OutPatient</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group gender-select">
                                <label class="gen-label">Gender:</label>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="gender" class="form-check-input" value="Male">Male
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="gender" class="form-check-input" value="Female">Female
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-t-20 text-center">

                        <button name="add-patient" class="btn btn-primary submit-btn">Create Patient</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
<?php
    if (isset($msg)) {
        echo 'swal("' . $msg . '");';
    }

    ?>
</script>