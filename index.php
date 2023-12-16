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
if (isset($_POST['doc'])) {
    header('location:loginDoctor.php');
} elseif (isset($_POST['pat'])) {
    header('location:loginPatient.php');
} elseif (isset($_POST['adm'])) {
    header('location:loginAdmin.php');
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
                        <div class="form-group text-center">
                            <button class="btn btn-primary account-btn" name="adm">Login As
                                Admin</button>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-primary account-btn" name="doc">Login As
                                Doctor</button>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-primary account-btn" name="pat">Login As
                                Patient</button>
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