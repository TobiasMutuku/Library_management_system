<?php
include './config.php';

session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: ./login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$query = "SELECT user_level FROM user WHERE id = $user_id AND user_level = 'admin'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) != 1) {
    header("location: ./login.php");
    exit;
}
$user_id = $_SESSION['user_id'];
if (!isset($_GET["id"])) {
    header("location: ./items.php");
    exit;
}

$item_id = $_GET["id"];
$sql = "SELECT id, title, author, filename FROM items WHERE user_id = ? AND id = ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $item_id);
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $id, $title, $author, $filename);
            mysqli_stmt_fetch($stmt);
        } else {
            header("location: ./items.php");
            exit;
        }
    } else {
        echo "Error: " . mysqli_error($conn);
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Error: " . mysqli_error($conn);
    exit;
}

if (isset($_POST["delete_item"])) {
    $sql = "DELETE FROM items WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $item_id);
        if (mysqli_stmt_execute($stmt)) {
            header("location: ./items_posts.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
            exit;
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
        exit;
    }
}

include "./header.php";
?>

<div class="container mt-3">
    <h1>Delete Item</h1>
    <form method="post" action="">
        <p>Are you sure you want to delete the item "<?php echo $title; ?>"?</p>
        <div class="form-group">
            <input type="submit" name="delete_item" value="Delete" class="btn btn-danger">
            <a href="./items.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>


    <?php
    include "./footer.php";
    ?>