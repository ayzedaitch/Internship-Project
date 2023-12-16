<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:index.php');
}
include('headerDoctor.php');
include('includes/connection.php');

$id = $_GET['id'];
$fetch_query = mysqli_query($connection, "select * from doc_appointments where ID='$id'");
$row = mysqli_fetch_array($fetch_query);
$send_email = false;

if (isset($_POST['save-appointment'])) {
    $patient_name = $_POST['patient_name'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $message = $_POST['description'];
    $username = $_POST['username'];


    $update_query = mysqli_query($connection, "update doc_appointments set patient_name='$patient_name', pat_username='$username',appt_date='$date',  appt_time='$time', appt_description='$message' where ID='$id'");
    if ($update_query > 0) {
        $msg = "Appointment updated successfully";
        $send_email = true;
        $fetch_query = mysqli_query($connection, "select * from doc_appointments where ID='$id'");
        $row = mysqli_fetch_array($fetch_query);
    } else {
        $msg = "Error!";
    }
}

?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 ">
                <h4 class="page-title">Edit Appointment</h4>
            </div>
            <div class="col-sm-8  text-right m-b-20">
                <a href="doctorsAppointments.php" class="btn btn-primary btn-rounded float-right">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Appointment ID <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="appointment_id"
                                    value="<?php echo $row['appointment_id'];  ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Patient Name</label>
                                <input type="text" class="form-control" name="patient_name"
                                    value="<?php echo $row['patient_name'];  ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username"
                                    value="<?php echo $row['pat_username'];  ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date</label>
                                <div class="cal-icon">
                                    <input type="text" class="form-control datetimepicker" name="date"
                                        value="<?php echo $row['appt_date'];  ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Time</label>
                                <div class="time-icon">
                                    <input type="text" class="form-control" id="datetimepicker3" name="time"
                                        value="<?php echo $row['appt_time'];  ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea cols="30" rows="4" class="form-control" name="description"
                            required><?php echo $row['appt_description'];  ?></textarea>
                    </div>

                    <div class="m-t-20 text-center">
                        <button name="save-appointment" class="btn btn-primary submit-btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>


<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require "vendor/autoload.php";

$sendinMessage = null;
if (isset($_POST['save-appointment']) && $send_email == true) {
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->Username   = 'noreply.chu.project@gmail.com';
        $mail->Password   = 'fhcidqnwpiuadhnb';

        $pat = $_POST['username'];

        $fetchPatInfo = mysqli_query($connection, "SELECT * FROM patients_tbl WHERE username = '$pat'");
        $rowPat = mysqli_fetch_array($fetchPatInfo);

        $emailRec =  $rowPat['email'];
        $patname = $rowPat['first_name'] . ' ' . $rowPat['last_name'];
        $apptDate = $_POST['date'];
        $apptTime = $_POST['time'];
        $message = "Hello " . $patname . ", We Updated Your Appointment Informations:\nAppointment Date: " . $apptDate . "\nAppointment Time: " . $apptTime;

        $nameSender = $_SESSION['name'];
        $fetchName = mysqli_query($connection, "SELECT first_name,last_name FROM doctors_tbl WHERE username = '$nameSender'");

        $dataFetch = mysqli_fetch_array($fetchName);
        $fnameSender = 'DR.' . $dataFetch['first_name'] . ' ' . $dataFetch['last_name'];
        $mail->setFrom('noreply.chu.project@gmail.com', $fnameSender);
        $mail->addAddress($emailRec);
        $mail->Subject = "Appointment Updates";
        $mail->Body = $message;

        $mail->send();
        $sendinMessage = "Updates were sent to the Patient";
    } catch (Exception $e) {
        $s = 'Error';
    }
}
?>


<?php
include('footer.php');
?>
<script type="text/javascript">
<?php
    if (isset($msg)) {

        echo 'swal("' . $msg . '. ' . $sendinMessage . '");';
        echo 'setTimeout(function() { window.location.href = "doctorsAppointments.php"; }, 2000);';
    }
    ?>
</script>