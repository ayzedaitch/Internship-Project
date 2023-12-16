<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:index.php');
}
include('headerDoctor.php');
include('includes/connection.php');

$ID = $_GET['id'];

$query = mysqli_query($connection, "SELECT * FROM patients_tbl WHERE username='$ID'");
$data = mysqli_fetch_array($query);
?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4">
                <h4 class="page-title">Send Prescription</h4>
            </div>
            <div class="col-sm-8 text-right m-b-20">
                <a href="patientOfDoctor.php" class="btn btn-primary btn-rounded float-right">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $ID; ?>">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Patient Name</label>
                                <input class="form-control" type="text" name="patient_name"
                                    value="<?php echo $data['first_name'] . ' ' . $data['last_name'] ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="text" value="<?php echo $data['email'] ?>"
                                    name="patient_email" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Upload prescription</label>
                            <input class="form-control" type="file" id="formFile" name="file" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea cols="30" rows="4" class="form-control" name="message" required></textarea>
                    </div>
                    <div class="m-t-20 text-center">
                        <button name="send" class="btn btn-primary submit-btn">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    require "vendor/autoload.php";

    $sendinMessage = null;

    if (isset($_POST['send'])) {
        $postedID = $_POST['id'];
        $emailRec = $_POST['patient_email'];
        $patname = $_POST['patient_name'];
        $postMessage = $_POST['message'];
        $nameArray = explode('.', $_FILES['file']['name']);
        $timestamp = time();
        $nameArray[0] = $_SESSION['name'] . '-' . $timestamp; //everytime it will be unique file thanks to timestamp
        $filename = $nameArray[0] . '.' . $nameArray[1];
        $sourceFilePath = $_FILES['file']['tmp_name'];
        $destinationFilePath = "prescriptions/" . $filename;
        move_uploaded_file($sourceFilePath, $destinationFilePath);
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->Username   = 'noreply.chu.project@gmail.com';
            $mail->Password   = 'fhcidqnwpiuadhnb';


            $message = "Hello " . $patname . ", Here is Your Perscription\nThis is the doctor's description:\n" . $postMessage;

            $mail->addAttachment($destinationFilePath);

            $nameSender = $_SESSION['name'];
            $fetchName = mysqli_query($connection, "SELECT first_name,last_name FROM doctors_tbl WHERE username = '$nameSender'");

            $dataFetch = mysqli_fetch_array($fetchName);
            $fnameSender = 'DR.' . $dataFetch['first_name'] . ' ' . $dataFetch['last_name'];
            $mail->setFrom('noreply.chu.project@gmail.com', $fnameSender);
            $mail->addAddress($emailRec);
            $mail->Subject = "Your Prescription";
            $mail->Body = $message;

            $mail->send();
            echo ' <center><h4 style="color:green;">Perscription Sent!</h4></center>';
        } catch (Exception $e) {
            echo ' <center><h4 style="color:red;">Error!</h4></center>';
        }

        echo '<script>window.location.href = "sendPerscription.php?id=' . $postedID . '";</script>'; // after email sending it is not suitable to use header so i used javascript
        exit();
    }
    ?>

</div>

<?php
include('footer.php'); ?>