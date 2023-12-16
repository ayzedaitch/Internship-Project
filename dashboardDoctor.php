<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:index.php');
}
include('headerDoctor.php');
include('includes/connection.php');

$daname = $_SESSION['name'];
?>


<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <span class="dash-widget-bg2"><i class="fa fa-user-o"></i></span>
                    <?php
                    $fetchPat = mysqli_query($connection, "SELECT COUNT(DISTINCT patients_tbl.username) AS total FROM patients_tbl,doctors_tbl,doc_appointments WHERE doc_appointments.pat_username = patients_tbl.username AND doc_appointments.doc_username = doctors_tbl.username AND doc_appointments.doc_username = '$daname'");
                    $pat = mysqli_fetch_assoc($fetchPat)['total'];
                    ?>
                    <div class="dash-widget-info text-right">
                        <h3><?php echo $pat; ?></h3>
                        <span class="widget-title2">Patients <i class="fa fa-check" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <span class="dash-widget-bg4"><i class="fa fa-heartbeat" aria-hidden="true"></i></span>
                    <?php
                    $fetchout = mysqli_query($connection, "SELECT COUNT(DISTINCT patients_tbl.username) AS total FROM patients_tbl,doctors_tbl,doc_appointments WHERE doc_appointments.pat_username = patients_tbl.username AND doc_appointments.doc_username = doctors_tbl.username AND doc_appointments.doc_username = '$daname' AND patients_tbl.patient_type = 'OutPatient'");
                    $outpatient = mysqli_fetch_assoc($fetchout)['total'];
                    ?>
                    <div class="dash-widget-info text-right">
                        <h3><?php echo $outpatient; ?></h3>
                        <span class="widget-title4">Out Patients <i class="fa fa-check" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <span class="dash-widget-bg4"><i class="fa fa-heartbeat" aria-hidden="true"></i></span>
                    <?php
                    $fetchin = mysqli_query($connection, "SELECT COUNT(DISTINCT patients_tbl.username) AS total FROM patients_tbl,doctors_tbl,doc_appointments WHERE doc_appointments.pat_username = patients_tbl.username AND doc_appointments.doc_username = doctors_tbl.username AND doc_appointments.doc_username = '$daname' AND patients_tbl.patient_type = 'InPatient'");
                    $inpatient = mysqli_fetch_assoc($fetchin)['total'];
                    ?>
                    <div class="dash-widget-info text-right">
                        <h3><?php echo $inpatient; ?></h3>
                        <span class="widget-title4">In Patients <i class="fa fa-check" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-8 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title d-inline-block">My Patients </h4> <a href="patientsAdmin.php" class="btn btn-primary float-right">View all</a>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table mb-0 new-patient-table">
                                <tbody>
                                    <?php
                                    $fetch_query = mysqli_query($connection, "SELECT DISTINCT patients_tbl.first_name,patients_tbl.last_name,patients_tbl.username,patients_tbl.dob,patients_tbl.Paddress,patients_tbl.email,patients_tbl.phone,patients_tbl.patient_type,patients_tbl.created_at FROM patients_tbl,doctors_tbl,doc_appointments WHERE doc_appointments.pat_username = patients_tbl.username AND doc_appointments.doc_username = doctors_tbl.username AND doc_appointments.doc_username = '$daname' ORDER BY patients_tbl.created_at DESC LIMIT 5");
                                    while ($row = mysqli_fetch_array($fetch_query)) { ?>
                                        <tr>
                                            <td>
                                                <img width="28" height="28" class="rounded-circle" src="assets/img/user.jpg" alt="">
                                                <h2><?php echo $row['first_name'] . " " . $row['last_name']; ?></h2>
                                            </td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['phone']; ?></td>
                                            <?php if ($row['patient_type'] == "InPatient") { ?>
                                                <td><span class="custom-badge status-red"><?php echo $row['patient_type']; ?></span>
                                                </td>
                                            <?php } else { ?>
                                                <td><span class="custom-badge status-green"><?php echo $row['patient_type']; ?></span>
                                                </td>
                                            <?php } ?>

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