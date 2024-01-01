<?php
 include './../inc/config.php';
include './../inc/functions.php';

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
    header("location: ./admin_dashboard.php?tab=categories");
    exit;
}

 

$category_id = $_GET["id"];
$sql = "SELECT id FROM categories WHERE id = ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $category_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
     if (mysqli_stmt_num_rows($stmt) == 0) {
        header("location: ./admin_dashboard.php?tab=categories");
        exit();
    }
    mysqli_stmt_close($stmt);
}

$post = array();
$sql = "SELECT category_name FROM categories WHERE id = ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $category_id);
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $category_name);
        if (mysqli_stmt_fetch($stmt)) {
            $post = array("category_name" => $category_name);
        } else {
            header("./admin_dashboard.php?tab=categories");
            exit;
        }
    } else {
         echo "Error: " . mysqli_error($conn);
        exit;
    }
    mysqli_stmt_close($stmt);
}

if (isset($_POST['update_category'])) {
    $category_name = trim($_POST["category_name"]);
    $sql = "SELECT id FROM categories WHERE category_name = ? AND id != ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "si", $category_name, $category_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $category_err = "Similar category already exists";
        } else {
            $sql = "UPDATE categories SET category_name = ? WHERE id = ?";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "si", $category_name, $category_id);
                if (mysqli_stmt_execute($stmt)) {
                    header("location: ./admin_dashboard.php?tab=categories");
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
<div class="container mt-3">

    <div class="container mt-5" style="min-height: 58vh;">
        <h2>Update Category</h2>
        <form method="post">
            <div class="form-group">
                <label for="category" class="p-2">Category:</label>
                <input class="form-control p-2 <?php if (isset($category_err)) echo 'is-invalid'; ?>" type="text" id="category_name" name="category_name" value="<?php echo $post['category_name']; ?>">
                <span class="invalid-feedback"><?php echo $category_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" name="update_category" value="Update Category" class="btn btn-primary">
                <a href="./admin_dashboard.php?tab=categories" class="btn btn-secondary m-3">Cancel</a>
            </div>
        </form>
    </div>
    <?php include "./../inc/footer.php" ?>