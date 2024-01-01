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
    header("location: ./admin_dashboard.php?tab=fields");
    exit;
}

$field_id = $_GET["id"];
$sql = "SELECT id FROM fields WHERE id = ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $field_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
     if (mysqli_stmt_num_rows($stmt) == 0) {
        header("location: ./admin_dashboard.php?tab=fields");
        exit();
    }
    mysqli_stmt_close($stmt);
}

$post = array();
$sql = "SELECT field_name FROM fields WHERE id = ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $field_id);
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $field_name);
        if (mysqli_stmt_fetch($stmt)) {
            $post = array("field_name" => $field_name);
        } else {
            header("./admin_dashboard.php?tab=fields");
            exit;
        }
    } else {
         echo "Error: " . mysqli_error($conn);
        exit;
    }
    mysqli_stmt_close($stmt);
}

if (isset($_POST['update_field'])) {
    $field_name = trim($_POST["field_name"]);

    $sql = "SELECT id FROM fields WHERE field_name = ? AND id != ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "si", $field_name, $field_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $field_err = "Similar field already exists";
        } else {
            $sql = "UPDATE fields SET field_name = ? WHERE id = ?";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "si", $field_name, $field_id);
                if (mysqli_stmt_execute($stmt)) {
                    header("location: ./admin_dashboard.php?tab=fields");
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
    <h1>Update Post</h1>
    <form method="post" action="" class="d-flex flex-column mx-auto">

        <label for="field" class="p-2">Field:</label>
        <input class="p-2 <?php if (isset($field_err)) echo 'is-invalid'; ?>" type="text" id="field_name" name="field_name" value="<?php echo $post['field_name']; ?>">
        <span class="invalid-feedback"><?php echo $field_err; ?></span>
        <div class="d-flex p-2">
            <input type="submit" name="update_field" value="Update Field" class="m-3">
            <a href="./admin_dashboard.php?tab=fields" class="btn btn-secondary m-3">Cancel</a>
        </div>
    </form>


    <?php include "./../inc/footer.php" ?>