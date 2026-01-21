<?php
session_start();

$pageTitle = 'Reset Password';
include 'connect.php';
include 'Includes/functions/functions.php';

$message = '';
$messageType = '';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['reset-button'])) {

    $username = test_input($_POST['username'] ?? '');
    $password = test_input($_POST['password'] ?? '');
    $confirm  = test_input($_POST['confirm_password'] ?? '');

    if (empty($username) || empty($password) || empty($confirm)) {
        $message = "All fields are required.";
        $messageType = "danger";
    } elseif ($password !== $confirm) {
        $message = "Passwords do not match.";
        $messageType = "danger";
    } else {

        $hashedPass = sha1($password);

        $stmt = $con->prepare("SELECT user_id FROM users WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {

            $update = $con->prepare(
                "UPDATE users SET password = ? WHERE username = ?"
            );
            $update->execute([$hashedPass, $username]);

            $message = "Password has been reset successfully. You can now login.";
            $messageType = "success";

        } else {
            $message = "Username not found.";
            $messageType = "danger";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

    <!-- FONTS -->
    <link href="Design/fonts/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <!-- CSS -->
    <link href="Design/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="Design/css/main.css" rel="stylesheet">
</head>
<body>

<div class="login">
    <form class="login-container validate-form" method="POST">

        <span class="login100-form-title p-b-32">
            Reset Password
        </span>

        <?php if (!empty($message)) { ?>
            <div class="alert alert-<?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php } ?>

        <!-- USERNAME -->
        <div class="form-input">
            <span class="txt1">Username</span>
            <input type="text" name="username" class="form-control" required>
        </div>

        <!-- NEW PASSWORD -->
        <div class="form-input">
            <span class="txt1">New Password</span>
            <input type="password" name="password" class="form-control" required>
        </div>

        <!-- CONFIRM PASSWORD -->
        <div class="form-input">
            <span class="txt1">Confirm Password</span>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>

        <p>
            <button type="submit" name="reset-button">Reset Password</button>
        </p>

        <span class="forgotPW">
            Back to <a href="index.php">Login</a>
        </span>

    </form>
</div>

<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; PT Pradana Mesari Jarot 2025</span>
        </div>
    </div>
</footer>

<!-- JS -->
<script src="Design/js/jquery.min.js"></script>
<script src="Design/js/bootstrap.bundle.min.js"></script>
<script src="Design/js/sb-admin-2.min.js"></script>
<script src="Design/js/main.js"></script>

</body>
</html>