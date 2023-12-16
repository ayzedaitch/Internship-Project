<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:index.php');
}
include('headerDoctor.php');
include('includes/connection.php');

$doc = $_SESSION['name'];
?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Appointments</h4>
            </div>
            <div class="col-sm-8 col-9 text-right m-b-20">
                <a href="add-appointment.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i>
                    Add Appointment</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="datatable table table-stripped ">
                <thead>
                    <tr>
                        <th>Appointment ID</th>
                        <th>Patient Name</th>
                        <th>username</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $delete_query = mysqli_query($connection, "delete from doc_appointments where ID='$id'");
                    }
                    $fetch_query = mysqli_query($connection, "select * from doc_appointments where doc_username = '$doc'");
                    while ($row = mysqli_fetch_array($fetch_query)) {

                    ?>
                        <tr>
                            <td><?php echo $row['appointment_id']; ?></td>
                            <td><?php echo $row['patient_name']; ?></td>
                            <td><?php echo $row['pat_username']; ?></td>
                            <td><?php echo $row['appt_date']; ?></td>
                            <td><?php echo $row['appt_time']; ?></td>
                            <td><?php echo $row['appt_description']; ?></td>
                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="edit-appointment.php?id=<?php echo $row['ID']; ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="doctorsAppointments.php?id=<?php echo $row['ID']; ?>" onclick="return confirmDelete()"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
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
<script language="JavaScript" type="text/javascript">
    function confirmDelete() {
        return confirm('Are you sure want to delete this Appointments?');
    }
</script>