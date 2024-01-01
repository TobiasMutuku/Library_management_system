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

 include "./header.php";
?>
<div class="container mt-3">

    <div class="container mt-5">
        <h2>Upload an Blog</h2>
        <p>Please fill in the form below to upload an blog.</p>
        <form action="blog_upload.php" method="post">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" class="form-select" required>
                    <option value="">Select a category</option>
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
            <input type="hidden" name="created_at" value="<?php echo date("Y-m-d H:i:s"); ?>">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="./../Admin/admin_dashboard.php?tab=blogs" class="btn btn-secondary ml-2">Cancel</a>
            </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>