<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:index.php');
}
include('headerAdmin.php');
include('includes/connection.php');
?>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Doctors</h4>
            </div>
            <div class="col-sm-8 col-9 text-right m-b-20">
                <a href="add-doctor.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add
                    Doctor</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="datatable table table-stripped ">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Speciality</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['username'])) {
                        $id = $_GET['username'];
                        $delete_query = mysqli_query($connection, "delete from doctors_tbl where username='$id'");
                    }
                    $fetching = mysqli_query($connection, "SELECT * FROM doctors_tbl");
                    while ($row = mysqli_fetch_array($fetching)) {
                    ?>
                    <tr>
                        <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['speciality']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td class="text-right">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false"><i class="fa fa-ellipsis-v"></i>
                                    <a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item"
                                                href="doctorsAdmin.php?username=<?php echo $row['username']; ?>"
                                                onclick="return confirmDelete()"><i class="fa fa-trash-o m-r-5"></i>
                                                Delete</a>
                                        </div>
                            </div>
                        </td>
                        <?php } ?>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</div>

<script type="text/javascript">
function confirmDelete() {
    return confirm('Are you sure want to delete this Doctor?');
}
</script>