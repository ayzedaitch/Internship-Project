<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:index.php');
}
include('headerAdmin.php');
include('includes/connection.php');

if (isset($_POST['upload'])) {
    $ID = $_POST['recipient'];
    $nameArray = explode('.', $_FILES['file']['name']);
    $timestamp = time();
    $nameArray[0] = $ID . '-' . $timestamp; //everytime it will be unique file thanks to timestamp
    $filename = $nameArray[0] . '.' . $nameArray[1];
    $sourceFilePath = $_FILES['file']['tmp_name'];
    $destinationFilePath = "medicalHistory/" . $filename;
    move_uploaded_file($sourceFilePath, $destinationFilePath);
    $upload_query = mysqli_query($connection, "UPDATE patients_tbl SET medical_history = '$destinationFilePath' WHERE username='$ID'");
}

?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Patients</h4>
            </div>
            <div class="col-sm-8 col-9 text-right m-b-20">
                <a href="add-patient.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add
                    Patient</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="datatable table table-stripped ">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Age</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Patient Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['username'])) {
                        $id = $_GET['username'];
                        $delete_query = mysqli_query($connection, "delete from patients_tbl where username='$id'");
                    }
                    $fetch_query = mysqli_query($connection, "SELECT * from patients_tbl");
                    while ($row = mysqli_fetch_array($fetch_query)) {
                        $dob = $row['dob'];
                        $date = str_replace('/', '-', $dob);
                        $dob = date('Y-m-d', strtotime($date));
                        $year = (date('Y') - date('Y', strtotime($dob)));

                    ?>
                    <tr>
                        <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $year; ?></td>
                        <td><?php echo $row['Paddress']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <?php if ($row['patient_type'] == "InPatient") { ?>
                        <td><span class="custom-badge status-red"><?php echo $row['patient_type']; ?></span>
                        </td>
                        <?php } else { ?>
                        <td><span class="custom-badge status-green"><?php echo $row['patient_type']; ?></span>
                        </td>
                        <?php } ?>
                        <td class="text-right">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal"
                                        style="cursor:pointer;"><i class="fa fa-upload m-r-5"></i> Upload Medical
                                        History</a>
                                    <a class="dropdown-item"
                                        href="patientsAdmin.php?username=<?php echo $row['username']; ?>"
                                        onclick="return confirmDelete()"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                </div>
                            </div>
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
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Patient:</label>
                        <input type="text" class="form-control" id="recipient-name" name="recipient" readonly>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Medical History</label>
                            <input class="form-control" type="file" id="formFile" name="file" required>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="upload" value="Upload">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    var togLinks = document.querySelectorAll('.dropdown-item[data-target="#exampleModal"]');
    var exampleModalLabel = document.getElementById('exampleModalLabel');
    var recipientName = document.getElementById('recipient-name');

    for (var i = 0; i < togLinks.length; i++) {
        togLinks[i].addEventListener('click', function() {
            var td = this.parentNode.parentNode.parentNode.parentNode.querySelectorAll('td');
            var patientName = td[0].innerText;
            var username = td[1].innerText;

            exampleModalLabel.innerText = 'Upload Medical History Of: ' + patientName;
            recipientName.value = username;
        });
    }
});

function confirmDelete() {
    return confirm('Are you sure want to delete this Patient?');
}
</script>