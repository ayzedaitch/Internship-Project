<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:index.php');
}
include('headerDoctor.php');
include('includes/connection.php');
$sesID = $_SESSION['name'];
?>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Schedule</h4>
            </div>
            <div class="col-sm-8 col-9 text-right m-b-20">
                <a href="add-schedule.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i>
                    Add Schedule</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="datatable table table-stripped ">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Available Days</th>
                        <th>Available Time</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['ids'])) {
                        $id = $_GET['ids'];
                        $delete_query = mysqli_query($connection, "delete from schedule where ID='$id'");
                    }
                    $fetch_query = mysqli_query($connection, "SELECT schedule.ID, doctors_tbl.first_name,doctors_tbl.last_name,schedule.available_days,schedule.start_time,schedule.end_time,schedule.message FROM schedule,doctors_tbl WHERE schedule.username = doctors_tbl.username AND doctors_tbl.username='$sesID'");
                    while ($row = mysqli_fetch_array($fetch_query)) {
                    ?>
                    <tr>
                        <td><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></td>
                        <td><?php echo $row['available_days'] ?></td>
                        <td><?php echo $row['start_time'] . ' - ' . $row['end_time'] ?></td>
                        <td><?php echo $row['message'] ?></td>
                        <td class="text-right">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="schedule.php?ids=<?php echo $row['ID']; ?>"
                                        onclick="return confirmDelete()"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php  }
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
    return confirm('Are you sure want to delete this Schedule?');
}
</script>