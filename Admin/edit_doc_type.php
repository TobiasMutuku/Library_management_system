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

if (!isset($_GET['id'])) {
    header("location: ./admin_dashboard.php?tab=doc_types");
    exit;
}


$doc_type_id = $_GET["id"];
$sql = "SELECT id FROM doc_types WHERE id = ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $doc_type_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) == 0) {
        header("location: ./admin_dashboard.php?tab=doc_types");
        exit();
    }
    mysqli_stmt_close($stmt);
}

$post = array();
$sql = "SELECT type_name FROM doc_types WHERE id = ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $doc_type_id);
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $type_name);
        if (mysqli_stmt_fetch($stmt)) {
            $post = array("type_name" => $type_name);
        } else {
            header("./admin_dashboard.php?tab=doc_types");
            exit;
        }
    } else {
         echo "Error: " . mysqli_error($conn);
        exit;
    }
    mysqli_stmt_close($stmt);
}

if (isset($_POST['update_doc_type'])) {
    $type_name = trim($_POST["type_name"]);

    $sql = "SELECT id FROM doc_types WHERE type_name = ? AND id != ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "si", $type_name, $doc_type_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $doc_type_err = "Similar doc_type already exists";
        } else {
            $sql = "UPDATE doc_types SET type_name = ? WHERE id = ?";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "si", $type_name, $doc_type_id);
                if (mysqli_stmt_execute($stmt)) {
                    header("location: ./admin_dashboard.php?tab=doc_types");
                    exit;
                } else {
                                 echo "Error: " . mysqli_error($conn);
                    exit;
                }
                mysqli_stmt_close($stmt);
            }
        }
        mysqli_stmt_close($stmt);
    } else {
         echo "Error: " . mysqli_error($conn);
        exit;
    }
}



include "./../inc/header.php";
?>
<div class="container mt-3" style="min-height: 58vh;">
    <h1>Update Document Type</h1>
    <form method="post">

        <div class="form-group">
        <label for="doc_type" class="p-2">Document Type:</label>
        <input class="form-control p-2 <?php if (isset($doc_type_err)) echo 'is-invalid'; ?>" type="text" id="type_name" name="type_name" value="<?php echo $post['type_name']; ?>">
        <span class="invalid-feedback"><?php echo $doc_type_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" name="update_doc_type" value="Update Type" class="m-3 btn btn-primary">
            <a href="./admin_dashboard.php?tab=doc_types" class="btn btn-secondary m-3">Cancel</a>
        </div>
    </form>


    <?php include "./../inc/footer.php" ?>