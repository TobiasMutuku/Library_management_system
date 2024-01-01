<?php
session_start();
include './config.php';
$username = '';
$db_email = '';


if (!isset($_SESSION["user_id"])) {
    header("location: ./login.php");
    exit;
}

$user_name = $_SESSION['username'];
$email = $_SESSION['email'];

$sql = 'SELECT username, email FROM user WHERE id = ?';

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('i', $_SESSION['id']);

    if ($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($username, $db_email);
            $stmt->fetch();
        }
    }
    $stmt->close();
}

$conn->close();
?>

<?php include './header.php'; ?>
<div class="container mt-3">
    <div class="container mt-5" style="min-height: 58vh;">
        <div class="d-flex justify-content-between p-3">
            <p>Welcome, <b><?php echo htmlspecialchars($user_name); ?></b></p>
            <div>
                <?php
                $user_id = $_SESSION["user_id"];
                $query = "SELECT user_level FROM user WHERE id = $user_id AND user_level = 'regular'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) == 1) {
                    echo '<a href="./../request_material.php" class="btn btn-primary">Request Item</a>';
                }
                ?>

            </div>
        </div>
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <td><b>Username</b></td>
                    <td><?php echo htmlspecialchars($user_name); ?></td>
                </tr>
                <tr>
                    <td><b>Email</b></td>
                    <td><?php echo htmlspecialchars($email); ?></td>
                </tr>
            </tbody>
        </table>
        <p>
            <a href="reset_password.php" class="btn btn-warning">Reset Your Password</a>
            <a href="update_profile.php" class="btn btn-warning">Update Profile</a>
            <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
        </p>
    </div>
    <?php include './footer.php'; ?>