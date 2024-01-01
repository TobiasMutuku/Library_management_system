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

 $category_name = "";
$category_name_err = "";

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["category_name"]))) {
        $category_name_err = "Please enter an category name.";
    } else {
         $sql = "SELECT id FROM categories WHERE category_name = ?";

        if ($stmt = $conn->prepare($sql)) {
             $stmt->bind_param("s", $param_category_name);

             $param_category_name = trim($_POST["category_name"]);

             if ($stmt->execute()) {
                 $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $category_name_err = "This category already exits.";
                } else {
                    $category_name = trim($_POST["category_name"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

             $stmt->close();
        }
    }


    if (empty($category_name_err)) {
         $sql = "INSERT INTO categories (category_name) VALUES (?)";

        if ($stmt = $conn->prepare($sql)) {
             $stmt->bind_param("s", $category_name);

             $category_name = $conn->real_escape_string($category_name);

             if ($stmt->execute()) {
                header("location: ./admin_dashboard.php?tab=categories");
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
        <h2>Add Category</h2>
        <form method="post">
            <div class="form-group">
                <label for="category_name">Category Name</label>
                <input type="text" id="category_name" name="category_name" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="./admin_dashboard.php?tab=categories" class="btn btn-secondary ml-2">Cancel</a>
            </div>
        </form>
    </div>

    <?php include './../inc/footer.php'; ?>