<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:index.php');
}
include('headerDoctor.php');
include('includes/connection.php');

$fetch_query = mysqli_query($connection, "SELECT MAX(ID) FROM doc_appointments");
$row = mysqli_fetch_row($fetch_query);
if ($row[0] == 0) {
    $apt_id = 1;
} else {
    $apt_id = $row[0] + 1;
}

$send_email = false;

if (isset($_POST['add-appointment'])) {

    $appointment_id = 'APT-' . $apt_id;
    $patient_name = $_POST['patient_name'];
    $pat_username = $_POST['pat_username'];
    $doc_username = $_SESSION['name'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $description = $_POST['description'];

    $msg = null;
    try {
        $insert_query = mysqli_query($connection, "INSERT INTO doc_appointments (appointment_id,patient_name,pat_username,doc_username,appt_date,appt_time,appt_description) VALUES ('$appointment_id','$patient_name','$pat_username', '$doc_username','$date','$time','$description')");

        if ($insert_query > 0) {
            $msg = "Appointment created successfully";
            $send_email = true;
        } else {
            $msg = "Error!";
        }
    } catch (Exception $e) {
        $msg = "Error!";
    }
}
?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 ">
                <h4 class="page-title">Add Appointment</h4>

            </div>
            <div class="col-sm-8  text-right m-b-20">
                <a href="doctorsAppointments.php" class="btn btn-primary btn-rounded float-right">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Appointment ID <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="appointment_id"
                                    value="<?php echo 'APT-' . $apt_id; ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Patient Name</label>
                                <input class="form-control" type="text" name="patient_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Username</label>
                                <input class="form-control" type="text" name="pat_username" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date</label>
                                <div class="cal-icon">
                                    <input type="text" class="form-control datetimepicker" name="date" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Time</label>
                                <div class="time-icon">
                                    <input type="text" class="form-control" id="datetimepicker3" name="time" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea cols="30" rows="4" class="form-control" name="description" required></textarea>
                    </div>
                    <div class="m-t-20 text-center">
                        <button name="add-appointment" class="btn btn-primary submit-btn">Create Appointment</button>
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
if (isset($_POST['add-appointment']) && $send_email == true) {
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->Username   = 'noreply.chu.project@gmail.com';
        $mail->Password   = 'fhcidqnwpiuadhnb';

        $pat = $_POST['pat_username'];

        $fetchPatInfo = mysqli_query($connection, "SELECT * FROM patients_tbl WHERE username = '$pat'");
        $rowPat = mysqli_fetch_array($fetchPatInfo);

        $emailRec =  $rowPat['email'];
        $patname = $rowPat['first_name'] . ' ' . $rowPat['last_name'];
        $apptDate = $_POST['date'];
        $apptTime = $_POST['time'];
        $message = "Hello " . $patname . ", Here is Your Appointment Informations:\nAppointment Date: " . $apptDate . "\nAppointment Time: " . $apptTime;

        $nameSender = $_SESSION['name'];
        $fetchName = mysqli_query($connection, "SELECT first_name,last_name FROM doctors_tbl WHERE username = '$nameSender'");

        $dataFetch = mysqli_fetch_array($fetchName);
        $fnameSender = 'DR.' . $dataFetch['first_name'] . ' ' . $dataFetch['last_name'];
        $mail->setFrom('noreply.chu.project@gmail.com', $fnameSender);
        $mail->addAddress($emailRec);
        $mail->Subject = "Appointment Informations";
        $mail->Body = $message;

        $mail->send();
        $sendinMessage = "Informations were sent to the Patient";
    } catch (Exception $e) {
        $s = 'error';
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