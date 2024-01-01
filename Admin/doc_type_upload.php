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

 $type_name = "";
$type_name_err = "";

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["type_name"]))) {
        $type_name_err = "Please enter an doc_type name.";
    } else {
         $sql = "SELECT id FROM doc_types WHERE type_name = ?";

        if ($stmt = $conn->prepare($sql)) {
             $stmt->bind_param("s", $param_type_name);

             $param_type_name = trim($_POST["type_name"]);

             if ($stmt->execute()) {
                 $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $type_name_err = "This doc_type already exits.";
                } else {
                    $type_name = trim($_POST["type_name"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

             $stmt->close();
        }
    }


    if (empty($type_name_err)) {
         $sql = "INSERT INTO doc_types (type_name) VALUES (?)";

        if ($stmt = $conn->prepare($sql)) {
             $stmt->bind_param("s", $type_name);

             $type_name = $conn->real_escape_string($type_name);

             if ($stmt->execute()) {
                header("location: ./admin_dashboard.php?tab=doc_types");
                exit;
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         $stmt->close();
    } else {
         echo "Error: " . $conn->error;
    }
}

$conn->close();


 include "./../inc/header.php";
?>
<div class="container mt-3" style="min-height: 58vh;">

    <div class="container mt-5">
        <h2>Add Document Type</h2>
        <form method="post">
            <div class="form-group">
                <label for="type_name">Document Type</label>
                <input type="text" id="type_name" name="type_name" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="./admin_dashboard.php?tab=doc_types" class="btn btn-secondary ml-2">Cancel</a>
            </div>
        </form>
    </div>

    <?php include './../inc/footer.php'; ?>