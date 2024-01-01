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

$blog_id = $_GET["id"];
$sql = "SELECT id FROM blogs WHERE id = ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $blog_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) == 0) {
        header("location: ./admin_dashboard.php?tab=blogs");
        exit();
    }
    mysqli_stmt_close($stmt);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "DELETE FROM blogs WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $blog_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    header("location: ./admin_dashboard.php?tab=blogs");
    exit();
}
?>

<?php include  './../inc/header.php'; ?>
<div class="container mt-3">
    <div style="min-height: 70vh;">
        <h1>Delete blog</h1>
        <p>
            Are you sure you want to delete this blog?
        </p>
        <form method="post">
            <input type="submit" value="Delete" class="btn btn-danger">
            <a href="./admin_dashboard.php?tab=blogs" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <?php include './../inc/footer.php'; ?>