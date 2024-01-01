<?php
include './../inc/config.php';

session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: ./../inc/login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$query = "SELECT user_level FROM user WHERE id = $user_id AND user_level = 'admin'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) != 1) {
    header("location: ./../inc/login.php");
    exit;
}

$field_name = "";
$field_name_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["field_name"]))) {
        $field_name_err = "Please enter an field name.";
    } else {
        $sql = "SELECT id FROM fields WHERE field_name = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_field_name);

            $param_field_name = trim($_POST["field_name"]);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $field_name_err = "This field already exits.";
                } else {
                    $field_name = trim($_POST["field_name"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            $stmt->close();
        }
    }


    if (empty($field_name_err)) {
        $sql = "INSERT INTO fields (field_name) VALUES (?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $field_name);

            $field_name = $conn->real_escape_string($field_name);

            if ($stmt->execute()) {
                header("location: ./admin_dashboard.php?tab=fields");
                exit;
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        $stmt->close();
    }
}

$conn->close();


include "./../inc/header.php";
?>
<div class="container mt-3" style="min-height: 58vh;">

    <div class="container mt-5">
        <h2>Add Field</h2>
        <form method="post">
            <div class="form-group">
                <label for="field_name">Field Name</label>
                <input class="form-control p-2 <?php if (isset($field_name_err) && !empty($field_name_err)) echo 'is-invalid'; ?>" type="text" id="field_name" name="field_name" required>
                <span class="invalid-feedback"><?php echo $field_name_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="./admin_dashboard.php?tab=fields" class="btn btn-secondary ml-2">Cancel</a>
            </div>
        </form>
    </div>

    <?php include './../inc/footer.php'; ?>