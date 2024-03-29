<?php
session_start();
include './config.php';

$new_password = $confirm_password = '';
$new_password_err = $confirm_password_err = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "Please enter the new password.";
    } elseif (strlen(trim($_POST["new_password"])) < 6) {
        $new_password_err = "Password must have at least 6 characters.";
    } else {
        $new_password = trim($_POST["new_password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm the password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    if (empty($new_password_err) && empty($confirm_password_err)) {
        $sql = 'UPDATE user SET password = ? WHERE id = ?';

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('si', password_hash($new_password, PASSWORD_DEFAULT), $_SESSION["user_id"]);

            if ($stmt->execute()) {
                header("location: ./profile.php");
                exit();
            } else {
                echo 'Something went wrong. Please try again later.';
            }

            $stmt->close();
        }
    }

    $conn->close();
}
?>

<?php include './header.php'; ?>
<div class="container mt-3" style="min-height: 58vh">
    <div class="container mt-5">
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-secondary" href="./profile.php">Cancel</a>
            </div>
        </form>
    </div>
    <?php include './footer.php'; ?>