<?php
include('includes/connection.php');

if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $scheduleQuery = mysqli_query($connection, "SELECT * FROM schedule WHERE username = '$username'");
    $rowCount = mysqli_num_rows($scheduleQuery);
    $currentRow = 0;
    if ($rowCount == 0) {
        echo "This doctor didn't set his schedule yet.";
    } else {
        while ($data = mysqli_fetch_array($scheduleQuery)) {
            $currentRow++;
            if ($currentRow == $rowCount) {
                echo 'Available Days: ' . $data['available_days'] . '<br>';
                echo 'Start Time: ' . $data['start_time'] . '<br>';
                echo 'End Time: ' . $data['end_time'] . '<br>';
                echo 'Message: ' . $data['message'] . '<br>';
            } else {
                echo 'Available Days: ' . $data['available_days'] . '<br>';
                echo 'Start Time: ' . $data['start_time'] . '<br>';
                echo 'End Time: ' . $data['end_time'] . '<br>';
                echo 'Message: ' . $data['message'] . '<br>';
                echo '<hr>';
            }
        }
    }
}
