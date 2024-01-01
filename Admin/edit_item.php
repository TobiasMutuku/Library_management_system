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

$item_id = $_GET["id"];
 include "./../inc/header.php";

$title = $author = $file_name = $description = $category = $image = "";
 $title_err = $author_err = $file_err = $desc_err = $category_err = $item_exists_err = $image_err = "";

$sql = "SELECT id FROM items WHERE id = ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $item_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
     if (mysqli_stmt_num_rows($stmt) == 0) {
        header("location: ./admin_dashboard.php?tab=items");
        exit();
    }
    mysqli_stmt_close($stmt);
}

$post = array();
$sql = "SELECT id, title, author, description, created_at, category FROM items WHERE id = ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $item_id);
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $item_id, $title, $author, $description, $created_at, $category);
        if (mysqli_stmt_fetch($stmt)) {
            $post = array("id" => $item_id, "title" => $title, "author" => $author, "description" => $description, "created_at" => $created_at, "category" => $category);
        } else {
             header("Location: error.php");
            exit;
        }
    } else {
         echo "Error: " . mysqli_error($conn);
        exit;
    }
    mysqli_stmt_close($stmt);
}

if (isset($_POST["update_item"])) {
    if (empty(trim($_POST["title"]))) {
        $title_err = "Please enter a title.";
    } else {
        $title = trim($_POST["title"]);
    }

    if (empty(trim($_POST["author"]))) {
        $author_err = "Please enter an author.";
    } else {
        $author = trim($_POST["author"]);
    }

    if (empty(trim($_POST["category"]))) {
        $category_err = "Please enter a category.";
    } else {
        $category = trim($_POST["category"]);
    }

    if (empty(trim($_POST["description"]))) {
        $desc_err = "Please enter an a description.";
    } else {
        $description = trim($_POST["description"]);
    }

    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "../uploads/images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $image_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (!in_array($image_type, array("jpg", "jpeg", "png", "gif"))) {
            $image_err = "Only JPG, JPEG, PNG and GIF files are allowed.";
        } else {
            $image = $user_name . "_" . date("Ymd_His") . "." . $image_type;
            $target_file = $target_dir . $image;

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            } else {
                $image_err = "There was an error uploading your image.";
            }
        }
    }


    if (empty($_FILES["file"]["name"])) {
        $file_err = "Please select a file.";
    } else {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($file_type != "pdf") {
            $file_err = "Only PDF files are allowed.";
        } else {
            $file_name = $user_name . "_" . date("Ymd_His") . ".pdf";
            $target_file = $target_dir . $file_name;

            if (file_exists($target_file)) {
                $file_err = "File already exists.";
            } else {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                 } else {
                    $file_err = "There was an error uploading your file.";
                }
            }
        }
    }

    $sql_check = "SELECT id FROM items WHERE title = ? AND author = ?";
    if ($stmt_check = $conn->prepare($sql_check)) {
        $stmt_check->bind_param("ss", $title, $author);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        if ($result_check->num_rows > 0) {
            $item_exists_err = "A item with similar title and author already exists.";
        }
        $stmt_check->close();
    }


     $sql = "UPDATE items SET title=?, author=?, description=?, filename=?, file_path=?, file_size=?, category=?, image_path=?, image=? WHERE id=?";

    if ($stmt = $conn->prepare($sql)) {
         $stmt->bind_param("sssssssssi", $title, $author, $description, $file_name, $file_path, $file_size, $category, $image_path, $image, $item_id);

         $file_path = $target_file;
        $file_size = filesize($target_file);
         $image_path = "../uploads/images/" . $image;

         if ($stmt->execute()) {
             header("location: ./admin_dashboard.php?tab=items");
            exit;
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
         $stmt->close();
    }
}
?>
<div class="container mt-3">
    <div class="container mt-5">
        <h2>Upload a Item</h2>
        <p>Please fill in the form below to upload a item.</p>
        <form method="post" enctype="multipart/form-data">
            <span class="text-danger"><?php echo $item_exists_err; ?></span>
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>" required>
                <span class="invalid-feedback"><?php echo $title_err; ?></span>
            </div>
            <div class="form-group">
                <label>Author</label>
                <input type="text" name="author" class="form-control <?php echo (!empty($author_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $author; ?>" required>
                <span class="invalid-feedback"><?php echo $author_err; ?></span>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" class="form-select" required>
                    <option value="<?php echo $category; ?>">Select Category</option>
                    <option value="tech">Tech</option>
                    <option value="programming">Programming</option>
                    <option value="romance">Romance</option>
                    <option value="recreation">Recreation</option>
                    <option value="music">Music</option>
                    <option value="other">Others</option>
                </select>
            </div>
            <div class="form-group">
                <label>Description</label>
                <input type="textarea" name="description" class="form-control <?php echo (!empty($desc_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $description; ?>" required>
                <span class="invalid-feedback"><?php echo $desc_err; ?></span>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image" class="form-control-file <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $image_err; ?></span>
            </div>

            <div class="form-group">
                <label>Item File (PDF only)</label>
                <input type="file" name="file" class="form-control-file <?php echo (!empty($file_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $file_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="update_item" value="Update">
                <a href="./../Admin/admin_dashboard.php?tab=items" class="btn btn-secondary ml-2">Cancel</a>
            </div>
        </form>

    </div>
    <?php
     include "./../inc/footer.php"; ?>