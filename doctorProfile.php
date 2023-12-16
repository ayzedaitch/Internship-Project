<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:index.php');
}
include('headerDoctor.php');
include('includes/connection.php');
$id = $_SESSION['name'];
$fetch_data = mysqli_query($connection, "SELECT * FROM doctors_tbl WHERE username = '$id'");
$row = mysqli_fetch_array($fetch_data);

$options = array(
    "Cardiology",
    "Oncology",
    "Neurology",
    "Orthopedics",
    "Radiology"
);

if (isset($_POST['save-doctor'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $emailid = $_POST['email'];
    $dob = $_POST['dob'];
    $pwd = $_POST['pwd'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $bio = $_POST['bio'];
    $speciality = $_POST['speciality'];
    $joining_date = $_POST['joining_date'];

    $update_query = mysqli_query($connection, "update doctors_tbl set first_name='$first_name', last_name='$last_name',
email='$emailid', dob='$dob', pwd = '$pwd', gender='$gender', Daddress='$address', speciality='$speciality', joining_date = '$joining_date',phone='$phone', bio='$bio' where username='$id'");
    if ($update_query > 0) {
        $msg = "Doctor updated successfully";
        $fetch_query = mysqli_query($connection, "SELECT * FROM doctors_tbl WHERE username = '$id'");
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
                                <input class="form-control" type="text" name="username" value="<?php echo $row['username'];  ?>" readonly required>
                            </div>
                        </div>
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>First Name</label>
                                <input class="form-control" type="text" name="first_name" value="<?php echo $row['first_name'];  ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input class="form-control" type="text" name="last_name" value="<?php echo $row['last_name']; ?>" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="email" name="email" value="<?php echo $row['email']; ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input class="form-control" type="text" name="pwd" value="<?php echo $row['pwd']; ?>" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <div class="cal-icon">
                                    <input type="text" class="form-control datetimepicker" name="dob" value="<?php echo $row['dob']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Phone </label>
                                <input class="form-control" type="text" name="phone" value="<?php echo $row['phone']; ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Joining Date</label>
                                <div class="cal-icon">
                                    <input type="text" class="form-control datetimepicker" name="joining_date" value="<?php echo $row['joining_date']; ?>" required readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Speciality</label>
                                <select name="speciality" class="custom-select">
                                    <?php foreach ($options as $option) { ?>
                                        <option value="<?php echo $option; ?>" <?php if ($option === $row['speciality']) echo "selected"; ?>>
                                            <?php echo $option; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group gender-select">
                                <label class="gen-label">Gender:</label>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="gender" class="form-check-input" value="Male" <?php if ($row['gender'] == 'Male') {
                                                                                                                    echo 'checked';
                                                                                                                } ?>>Male
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="gender" class="form-check-input" value="Female" <?php if ($row['gender'] == 'Female') {
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
                                        <input type="text" class="form-control" name="address" value="<?php echo $row['Daddress']; ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Bio</label>
                                        <textarea class="form-control" name="bio" required><?php echo $row['bio']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn" name="save-doctor">Save</button>
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