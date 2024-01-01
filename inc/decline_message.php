<?php
include './config.php';

session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: ./login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["username"];
$query = "SELECT user_level FROM user WHERE id = $user_id AND user_level = 'admin'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) != 1) {
    header("location: ./login.php");
    exit;
}
if (isset($_GET['id'])) {
    $request_id = $_GET['id'];
} else {
    $request_id = Null;
}
include "./header.php";

$reason = $explanation = "";
$reason_err = $explanation_err = "";

if (isset($_POST['send_reply'])) {
    $request_id = $_POST['req_id'];
    if (empty(trim($_POST["reason"]))) {
        $reason_err = "Please enter a reason.";
    } else {
        $reason = trim($_POST["reason"]);
    }

    $explanation = trim($_POST["explanation"]);



    if (empty($reason_err)) {
        $update = mysqli_query($conn, "UPDATE requests SET status = 'rejected', admin_response = '$explanation' , decline_reason = '$reason' WHERE id = '$request_id'");
        if ($update) {
            echo "<script>alert('Reply Successful!')</script>";
        }
        header("location: ./../Admin/admin_dashboard.php?tab=messages");
    }

    $conn->close();
}
?>
<div class="container mt-3" style="min-height: 58vh;">
    <div class="container mt-5">
        <h2>Reason for decline</h2>
        <p>Please fill in the form below</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Select Reason</label>
                <select name="reason" id="reason" class="form-select" required>
                    <option value="">Select a Reason</option>
                    <option value="inapropriate">Inapropriate</option>
                    <option value="item not available">Item not avalilable</option>
                    <option value="other reasons">Other</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="req_id" value="<?php echo $request_id ?>" hidden>
            </div>
            <div class="form-group">
                <label>Explanation</label>
                <input type="text" name="explanation" class="form-control <?php echo (!empty($explanation_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $explanation; ?>">
                <span class="invalid-feedback"><?php echo $explanation_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="send_reply" value="Send Reply">
                <a href="./../Admin/admin_dashboard.php?tab=messages" class="btn btn-secondary ml-2">Cancel</a>
            </div>
        </form>

    </div>
    <?php
    include "./footer.php"; ?>