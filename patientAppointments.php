<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:index.php');
}
include('headerPatient.php');
include('includes/connection.php');

$pat = $_SESSION['name'];
?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Appointments</h4>
            </div>
        </div>
        <div class="table-responsive">
            <table class="datatable table table-stripped ">
                <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $fetch_query = mysqli_query($connection, "select * from doc_appointments where pat_username = '$pat'");
                    while ($row = mysqli_fetch_array($fetch_query)) {
                        $docusr = $row['doc_username'];
                        $fetchDOC = mysqli_query($connection, "SELECT * FROM doctors_tbl WHERE username = '$docusr'");
                        $docdata = mysqli_fetch_array($fetchDOC);
                        $docFullName = $docdata['first_name'] . ' ' . $docdata['last_name'];
                        $docemail = $docdata['email'];
                        $docphone = $docdata['phone'];
                    ?>
                        <tr>
                            <td><?php echo 'DR.' . $docFullName; ?></td>
                            <td><?php echo $docemail; ?></td>
                            <td><?php echo $docphone; ?></td>
                            <td><?php echo $row['appt_date']; ?></td>
                            <td><?php echo $row['appt_time']; ?></td>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

</div>


<?php
include('footer.php');
?>