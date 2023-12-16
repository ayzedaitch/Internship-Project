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
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Patients</h4>
                <br>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF'];
                                            ?>">
                    <div class="input-group mb-3">
                        <input type="text" name="patusr" class="form-control" placeholder="Patient's username"
                            aria-label="Patient's username" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <input class="btn btn-outline-primary" type="submit" name="search" value="Find">
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
                        <th>Name</th>
                        <th>Age</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Patient Type</th>
                        <th>Prescription</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_POST['search'])) {
                        $searchValue = $_POST['patusr'];
                        if (
                            $searchValue == ''
                        ) {
                            $fetch_query = mysqli_query($connection, "SELECT DISTINCT patients_tbl.first_name,patients_tbl.last_name,patients_tbl.username,patients_tbl.dob,patients_tbl.Paddress,patients_tbl.email,patients_tbl.phone,patients_tbl.patient_type FROM patients_tbl,doctors_tbl,doc_appointments WHERE doc_appointments.pat_username = patients_tbl.username AND doc_appointments.doc_username = doctors_tbl.username AND doc_appointments.doc_username = '$daname'");
                            while ($row = mysqli_fetch_array($fetch_query)) {
                                $dob = $row['dob'];
                                $date = str_replace('/', '-', $dob);
                                $dob = date('Y-m-d', strtotime($date));
                                $year = (date('Y') - date('Y', strtotime($dob)));

                                echo "<tr>";
                                echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                                echo "<td>" . $year . "</td>";
                                echo "<td>" . $row['Paddress'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['phone'] . "</td>";

                                if ($row['patient_type'] == "InPatient") {
                                    echo '<td><span class="custom-badge status-red">' . $row['patient_type'] . '</span></td>';
                                } else {
                                    echo '<td><span class="custom-badge status-green">' . $row['patient_type'] . '</span></td>';
                                }

                    ?>
                    <td>
                        <span class="custom-badge status-blue">
                            <a href="sendPerscription.php?id=<?php echo $row['username'] ?>"
                                style="text-decoration: none;" id="getter">Send Prescription</a>
                        </span>
                    </td>
                    <?php
                                echo "</tr>";
                            }
                        } else {
                            $fetch_query = mysqli_query($connection, "SELECT DISTINCT patients_tbl.first_name,patients_tbl.last_name,patients_tbl.username,patients_tbl.dob,patients_tbl.Paddress,patients_tbl.email,patients_tbl.phone,patients_tbl.patient_type FROM patients_tbl,doctors_tbl,doc_appointments WHERE doc_appointments.pat_username = patients_tbl.username AND doc_appointments.doc_username = doctors_tbl.username AND doc_appointments.doc_username = '$daname' AND doc_appointments.pat_username='$searchValue'");
                            while ($row = mysqli_fetch_array($fetch_query)) {
                                $dob = $row['dob'];
                                $date = str_replace('/', '-', $dob);
                                $dob = date('Y-m-d', strtotime($date));
                                $year = (date('Y') - date('Y', strtotime($dob)));

                                echo "<tr>";
                                echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                                echo "<td>" . $year . "</td>";
                                echo "<td>" . $row['Paddress'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['phone'] . "</td>";

                                if ($row['patient_type'] == "InPatient") {
                                    echo '<td><span class="custom-badge status-red">' . $row['patient_type'] . '</span></td>';
                                } else {
                                    echo '<td><span class="custom-badge status-green">' . $row['patient_type'] . '</span></td>';
                                }

                            ?>
                    <td>
                        <span class="custom-badge status-blue">
                            <a href="sendPerscription.php?id=<?php echo $row['username'] ?>"
                                style="text-decoration: none;" id="getter">Send Prescription</a>
                        </span>
                    </td>
                    <?php
                                echo "</tr>";
                            }
                        }
                    } else {
                        $fetch_query = mysqli_query($connection, "SELECT DISTINCT patients_tbl.first_name,patients_tbl.last_name,patients_tbl.username,patients_tbl.dob,patients_tbl.Paddress,patients_tbl.email,patients_tbl.phone,patients_tbl.patient_type FROM patients_tbl,doctors_tbl,doc_appointments WHERE doc_appointments.pat_username = patients_tbl.username AND doc_appointments.doc_username = doctors_tbl.username AND doc_appointments.doc_username = '$daname'");
                        while ($row = mysqli_fetch_array($fetch_query)) {
                            $dob = $row['dob'];
                            $date = str_replace('/', '-', $dob);
                            $dob = date('Y-m-d', strtotime($date));
                            $year = (date('Y') - date('Y', strtotime($dob)));

                            echo "<tr>";
                            echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                            echo "<td>" . $year . "</td>";
                            echo "<td>" . $row['Paddress'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['phone'] . "</td>";

                            if ($row['patient_type'] == "InPatient") {
                                echo '<td><span class="custom-badge status-red">' . $row['patient_type'] . '</span></td>';
                            } else {
                                echo '<td><span class="custom-badge status-green">' . $row['patient_type'] . '</span></td>';
                            }

                            ?>
                    <td>
                        <span class="custom-badge status-blue">
                            <a href="sendPerscription.php?id=<?php echo $row['username'] ?>"
                                style="text-decoration: none;" id="getter">Send Prescription</a>
                        </span>
                    </td>
                    <?php
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

<?php
include('footer.php');
?>