<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title>CHU</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<?php
session_start();
include('includes/connection.php');
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $pwd = mysqli_real_escape_string($connection, $_POST['pwd']);

    $fetch_query = mysqli_query($connection, "select * from admin_tbl where username ='$username' and password = '$pwd'");
    $res = mysqli_num_rows($fetch_query);
    if ($res > 0) {
        $data = mysqli_fetch_array($fetch_query);
        $name = $username;
        $role = 'Admin';
        $_SESSION['name'] = $name;
        $_SESSION['role'] = $role;
        header('location:dashboardAdmin.php');
    } else {
        $msg = "Incorrect login details.";
    }
}
?>

<body>
    <div class="main-wrapper account-wrapper">
        <div class="account-page">
            <div class="account-center">
                <div class="account-box">
                    <form method="post" class="form-signin" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="account-logo">
                            <a href="index.php"><img src="assets/img/logo-dark.png" alt=""></a>
                        </div>
                        <h2 class="text-center">Admin Login</h2>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" autofocus="" class="form-control" name="username" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="pwd" required>
                        </div>
                        <span style="color:red;"><?php if (!empty($msg)) {
                                                        echo $msg;
                                                    } ?></span>
                        <br>
                        <div class="form-group text-center">
                            <button type="submit" name="login" class="btn btn-primary account-btn">Login</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>