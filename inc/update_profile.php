<?php
session_start();
include './config.php';

if (!isset($_SESSION["user_id"])) {
    header("location: ./login.php");
    exit;
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];

$new_email = $new_username = '';
$new_email_err = $new_username_err = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["new_email"]))) {
        $new_email_err = "Please enter the new password.";
    } else {
        $new_email = trim($_POST["new_email"]);
    }

    if (empty(trim($_POST["new_username"]))) {
        $new_username_err = "Please enter ne username.";
    } else {
        $new_username = trim($_POST["new_username"]);
    }

    if (empty($new_email_err) && empty($new_username_err)) {
        $sql = 'UPDATE user SET email = ?, username = ? WHERE id = ?';

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('ssi', $new_email, $new_username, $_SESSION["user_id"]);

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
        <h2>Update Profile</h2>
        <p>Please fill out this form to update your details</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($new_email_err)) ? 'has-error' : ''; ?>">
                <label>New Email</label>
                <input type="email" name="new_email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $new_email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($new_username_err)) ? 'has-error' : ''; ?>">
                <label>New Username</label>
                <input type="text" name="new_username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $new_username_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-secondary" href="./profile.php">Cancel</a>
            </div>
        </form>
    </div>
    <?php include './footer.php'; ?>