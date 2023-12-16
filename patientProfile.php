<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:index.php');
}
include('headerPatient.php');
include('includes/connection.php');
$id = $_SESSION['name'];
$fetch_data = mysqli_query($connection, "SELECT * FROM patients_tbl WHERE username = '$id'");
$row = mysqli_fetch_array($fetch_data);

if (isset($_POST['save-patient'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $emailid = $_POST['email'];
    $dob = $_POST['dob'];
    $pwd = $_POST['pwd'];
    $gender = $_POST['gender'];
    $patient_type = $_POST['patient_type'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $update_query = mysqli_query($connection, "update patients_tbl set first_name='$first_name', last_name='$last_name', email='$emailid', dob='$dob', pwd = '$pwd', gender='$gender', patient_type='$patient_type',Paddress='$address', phone='$phone' where username='$id'");
    if ($update_query > 0) {
        $msg = "Patient updated successfully";
        $fetch_query = mysqli_query($connection, "SELECT * FROM patients_tbl WHERE username = '$id'");
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
                <h4 class="page-title">Your Profile</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Username</label>
                                <input class="form-control" type="text" name="username"
                                    value="<?php echo $row['username'];  ?>" readonly required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Medical History</label>
                                <a href="<?php echo $row['medical_history'] ?>" download><button type="button"
                                        class="form-control btn btn-outline-primary">Download</button></a>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>First Name</label>
                                <input class="form-control" type="text" name="first_name"
                                    value="<?php echo $row['first_name'];  ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input class="form-control" type="text" name="last_name"
                                    value="<?php echo $row['last_name']; ?>" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="email" name="email"
                                    value="<?php echo $row['email']; ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input class="form-control" type="text" name="pwd" value="<?php echo $row['pwd']; ?>"
                                    required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <div class="cal-icon">
                                    <input type="text" class="form-control datetimepicker" name="dob"
                                        value="<?php echo $row['dob']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Phone </label>
                                <input class="form-control" type="text" name="phone"
                                    value="<?php echo $row['phone']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Patient's Type</label>
                                <select class="select" name="patient_type" required>
                                    <option value="">Select</option>
                                    <option <?php if ($row['patient_type'] == 'InPatient') { ?> selected="selected"
                                        ;<?php } ?>>InPatient
                                    </option>
                                    <option <?php if ($row['patient_type'] == 'OutPatient') { ?> selected="selected"
                                        ;<?php } ?>>OutPatient
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group gender-select">
                                <label class="gen-label">Gender:</label>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="gender" class="form-check-input" value="Male"
                                            <?php if ($row['gender'] == 'Male') {
                                                                                                                    echo 'checked';
                                                                                                                } ?>>Male
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="gender" class="form-check-input" value="Female"
                                            <?php if ($row['gender'] == 'Female') {
                                                                                                                        echo 'checked';
                                                                                                                    } ?>>Female
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address"
                                            value="<?php echo $row['Paddress']; ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn" name="save-patient">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<?php
include('footer.php');
?>

<script type="text/javascript">
<?php
    if (isset($msg)) {

        echo 'swal("' . $msg . '");';
    }
    ?>
</script>