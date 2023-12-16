<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:index.php');
}
include('headerPatient.php');
include('includes/connection.php');
$selectedOption = 'All';
if (isset($_POST['search'])) {

    $selectedOption = $_POST['depar'];
}
$options = array(
    "All",
    "Cardiology",
    "Oncology",
    "Neurology",
    "Orthopedics",
    "Radiology"
);

if (isset($_POST['docusername'])) {
    echo $docusername;
}
?>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Doctors</h4>
                <br>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="input-group">
                        <select name="depar" class="custom-select">
                            <?php foreach ($options as $option) { ?>
                            <option value="<?php echo $option; ?>"
                                <?php if ($option === $selectedOption) echo "selected"; ?>>
                                <?php echo $option; ?>
                            </option>
                            <?php } ?>
                        </select>
                        <div class="input-group-append">
                            <input class="btn btn-outline-primary" type="submit" name="search" id="search"
                                value="Search By Speciality">
                        </div>
                    </div>
                </form>
                <br>
                <br>
            </div>
        </div>

        <div class="table-responsive">
            <table class="datatable table table-stripped ">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Speciality</th>
                        <th>Bio</th>
                        <th>Schedule</th>
                        <th>Appointment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($selectedOption == 'All') {
                        $fetch_query = mysqli_query($connection, "select * from doctors_tbl");
                    } else {
                        $fetch_query = mysqli_query($connection, "select * from doctors_tbl where speciality = '$selectedOption'");
                    }
                    while ($row = mysqli_fetch_array($fetch_query)) {
                    ?>
                    <tr>
                        <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['speciality']; ?></td>
                        <td><?php echo $row['bio']; ?></td>
                        <td>
                            <span class="custom-badge status-blue">
                                <button type="button" class="btn-show-schedule"
                                    style="background:none; cursor: pointer; outline:none; border:none; color:#008cff;"
                                    data-toggle="modal" data-target="#exampleModalCenter"
                                    data-doctor-name="<?php echo $row['first_name'] . ' ' . $row['last_name']; ?>"
                                    data-username="<?php echo $row['username']; ?>">
                                    Show
                                </button>
                            </span>
                        </td>
                        <td><span class="custom-badge status-green"><button type="button" data-toggle="modal"
                                    data-target="#exampleModal"
                                    style="background:none; cursor: pointer; outline:none; border:none; color:#0dd183;">Book</button></span>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message to</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                        <input type="text" class="form-control recipient-name" name="recipient" readonly>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Message:</label>
                        <textarea class="form-control" id="message-text"
                            placeholder="Please leave a message to book an appointment, and one of the doctor's secretaries will contact you to schedule the date and time."
                            name="message"></textarea>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="sendEmail" value="Send message">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Doctor Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="schedule-details"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<?php
include('footer.php'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var bookButtons = document.querySelectorAll('.custom-badge.status-green button');
    var exampleModalLabel = document.getElementById('exampleModalLabel');
    var recipientName = document.querySelector('.recipient-name');
    var showButtons = document.querySelectorAll('.btn-show-schedule');
    var modalTitle = document.getElementById('exampleModalLongTitle');
    var scheduleDetails = document.getElementById('schedule-details');

    for (var i = 0; i < bookButtons.length; i++) {
        bookButtons[i].addEventListener('click', function() {
            var td = this.parentNode.parentNode.parentNode.querySelectorAll('td');
            var doctorName = td[0].innerText;
            var email = td[1].innerText;
            console.log(email);

            exampleModalLabel.innerText = 'New message to DR.' + doctorName;
            recipientName.value = email;
        });
    }

    for (var i = 0; i < showButtons.length; i++) {
        showButtons[i].addEventListener('click', function() {
            var doctorName = this.getAttribute('data-doctor-name');
            var username = this.getAttribute('data-username');

            modalTitle.innerText = 'Dr. ' + doctorName + ' Schedule';

            // Perform an AJAX request to fetch the doctor's schedule
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    scheduleDetails.innerHTML = xhr.responseText;
                }
            };
            xhr.open('GET', 'get_schedule.php?username=' + username, true);
            xhr.send();
        });
    }


});
</script>


<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "vendor/autoload.php";

$sendinMessage = null;
if (isset($_POST['sendEmail'])) {
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->Username   = 'noreply.chu.project@gmail.com';
        $mail->Password   = 'fhcidqnwpiuadhnb';

        $emailRec =  $_POST['recipient'];
        $message = $_POST['message'];

        // in session name i stored just the username i don't want to store the full name too
        // now i am fetching the full name to display it in the email better than username
        // note: i stored the username in session because it is unique key it helps me in many thing like destroying the session
        $nameSender = $_SESSION['name'];
        $fetchName = mysqli_query($connection, "SELECT * FROM patients_tbl WHERE username = '$nameSender'");

        $dataFetch = mysqli_fetch_array($fetchName);
        $fnameSender = $dataFetch['first_name'] . ' ' . $dataFetch['last_name'];
        $emailSender = $dataFetch['email'];
        $mail->addAttachment($dataFetch['medical_history']); // medical history will be sent automatically
        $mail->setFrom('noreply.chu.project@gmail.com', $fnameSender);
        $mail->addAddress($emailRec);
        $mail->Subject = 'Booking Of An Appointment';
        $mail->Body = $message . "\n\nInformations About the Patient:\nUsername: " . $nameSender . "\nEmail: " . $emailSender . "\nPhone: " . $dataFetch['phone'] . "\n\nYou will find the patient's medical history as an attachement!";

        $mail->send();
        $sendinMessage = 'Message has been sent!';
    } catch (Exception $e) {
        $sendinMessage = "Message could not be sent!";
    }
}
?>

<script type="text/javascript">
<?php
    if (isset($sendinMessage)) {
        echo 'swal("' . $sendinMessage . '");';
    }

    ?>
</script>