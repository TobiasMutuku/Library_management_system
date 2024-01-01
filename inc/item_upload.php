<?php
include './config.php';
error_reporting(0);
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: ./login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["username"];
$query = "SELECT user_level FROM user WHERE id = $user_id AND user_level = 'admin'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) != 1) {
    header("location: ./login.php");
    exit;
}

include "./header.php";

$success = $title = $author = $file_name = $description = $category = $image = $doc_type = "";
$posted_by = $user_name;
$title_err = $author_err = $file_err = $desc_err = $category_err = $item_exists_err = $image_err = $doc_type_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    if (empty(trim($_POST["type_name"]))) {
        $doc_type_err = "Please select the type of document.";
    } else {
        $doc_type = trim($_POST["type_name"]);
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


    $sql_check = "SELECT id FROM items WHERE title = ? AND author = ? AND user_id = ?";
    if ($stmt_check = $conn->prepare($sql_check)) {
        $stmt_check->bind_param("ssi", $title, $author, $user_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        if ($result_check->num_rows > 0) {
            $item_exists_err = "A item with similar title and author already exists.";
        }
        $stmt_check->close();
    }

    if (empty($title_err) && empty($author_err) && empty($file_err) && empty($desc_err) && empty($category_err) && empty($item_exists_err) && empty($doc_type_err)) {
        $sql = "INSERT INTO items (title, author, description, filename, user_id, file_path, file_size, category, posted_by,image_path,image, doc_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssssssssss", $title, $author, $description, $file_name, $user_id, $file_path, $file_size, $category, $posted_by, $image_path, $image, $doc_type);

            $file_path = $target_file;
            $file_size = filesize($target_file);
            $image_path = "../uploads/images/" . $image;

            if ($stmt->execute()) {
                echo "<script>alert('Item Upload successful!')</script>";
                $success = "Item Upload successful!";
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            $stmt->close();
        }


        $conn->close();
    }
}
?>
<div class="container mt-3">
    <div class="container mt-5">
        <h2>Upload a Item</h2>
        <p>Please fill in the form below to upload a item.</p>
        <div class="d-flex justify-content-between">
            <p class="text-secondary"><?php echo $success; ?></p>
        <a href="./../Admin/admin_dashboard.php?tab=items" class="btn btn-secondary ml-2">Back</a>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
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
                    <option value="">Select Category</option>
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
            <div class="form-group">
                <label for="type_name">Type</label>
                <select id="type_name" name="type_name" class="form-select" required>
                    <option value="">Select Type</option>
                    <?php
                    $query = "SELECT type_name FROM doc_types";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_array($result)) {
                        $doc_type = $row['type_name'];
                        echo "<option value='$doc_type'>$doc_type</option>";
                    }
                    ?>
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
            <input type="hidden" name="posted_by" value="<?php echo $user_name ?>">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="./../Admin/admin_dashboard.php?tab=items" class="btn btn-secondary ml-2">Cancel</a>
            </div>
        </form>

    </div>
    <?php
    include "./footer.php"; ?>