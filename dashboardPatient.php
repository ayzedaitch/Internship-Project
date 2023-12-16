<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:index.php');
}
include('headerPatient.php');
include('includes/connection.php');
$fetch_advice = mysqli_query($connection, "SELECT title FROM advices");
$advices = mysqli_fetch_all($fetch_advice, MYSQLI_ASSOC);
$adviceArray = array();
foreach ($advices as $advice) {
    $adviceArray[] = $advice['title'];
}
$randomAdvice = $adviceArray[array_rand($adviceArray)]; // each time we will display a random advice
$usr = $_SESSION['name'];
$fetchAPT = mysqli_query($connection, "SELECT * FROM doc_appointments WHERE doc_appointments.pat_username='$usr' ORDER BY doc_appointments.created_at DESC LIMIT 3");
?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">
                <div class="dash-widget">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Hello, <?php echo $_SESSION['name']; ?>
                            </h5>
                            <p class="card-text"><span class="font-weight-bold">Random Advice:</span>
                                <?php echo $randomAdvice  ?></p>
                            <a href="patientProfile.php" class="btn btn-primary" id="viewProfileBtn">View Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-8 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title d-inline-block">Recent Appointments</h4> <a href="patientAppointments.php" class="btn btn-primary float-right">View all</a>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table mb-0 new-patient-table">
                                <tbody>
                                    <?php while ($data = mysqli_fetch_array($fetchAPT)) {
                                        $docusr = $data['doc_username'];
                                        $fetchDOC = mysqli_query($connection, "SELECT * FROM doctors_tbl WHERE username = '$docusr'");
                                        $docdata = mysqli_fetch_array($fetchDOC);
                                        $docFullName = $docdata['first_name'] . ' ' . $docdata['last_name'];
                                        $docphone = $docdata['phone'];
                                    ?>
                                        <tr>
                                            <td>
                                                <img width="28" height="28" class="rounded-circle" src="assets/img/user.jpg" alt="">
                                                <h2>DR.<?php echo $docFullName; ?></h2>
                                            </td>
                                            <td><?php echo $docphone; ?></td>
                                            <td><?php echo $data['appt_date']; ?></td>
                                            <td><?php echo $data['appt_time']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>