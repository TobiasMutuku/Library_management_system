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

$post_id = $_GET['id'];
$post = array();
$sql = "SELECT content, title, category FROM blogs WHERE id = ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $post_id);
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $content, $title, $category);
        if (mysqli_stmt_fetch($stmt)) {
            $post = array("id" => $post_id, "content" => $content, "title" => $title, "category" => $category);
        } else {
            header("location: ./admin_dashboard.php?tab=blogs");
            exit;
        }
    } else {
        echo "Error: " . mysqli_error($conn);
        exit;
    }
    mysqli_stmt_close($stmt);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);
    $category = trim($_POST["category"]);

    $sql = "UPDATE blogs SET title = ?, content = ?, category = ? WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssi", $title, $content, $category, $post_id);
        if (mysqli_stmt_execute($stmt)) {
            header("location: ./../Admin/admin_dashboard.php?tab=blogs");
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
            exit;
        }
        mysqli_stmt_close($stmt);
    }
}

include "./header.php";
?>
<div class="container mt-3">
    <h1>Update Post</h1>
    <form method="post">
        <div class="form-group">
            <label for="title" class="p-2">Title:</label>
            <input class="p-2 form-control" type="text" id="title" name="title" value="<?php echo $post['title']; ?>">
        </div>

        <div class="form-group">
            <div class="form-group">
                <label for="category">Category: </label>
                <select id="category" name="category" class="form-select" required>
                    <option value="<?php echo $post['category']; ?>"><?php echo $post['category']; ?></option>
                    <?php
                    $query = "SELECT category_name FROM categories";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_array($result)) {
                        $field_name = $row['category_name'];
                        echo "<option value='$field_name'>$field_name</option>";
                    }
                    ?>
                </select>
            </div>

        </div>
        <div class="form-group">
            <label for="content" class="p-2">Content:</label> <br>
            <textarea class="p-2" style="width: 100%;" id="content" name="content"><?php echo $post['content']; ?></textarea>
        </div>

        <div class="form-group">
            <input type="submit" value="Update Post" class="m-3 btn btn-primary">
            <a href="./../Admin/admin_dashboard.php?tab=blogs" class="btn btn-secondary m-3">Cancel</a>
        </div>
    </form>

    <?php include "./footer.php" ?>