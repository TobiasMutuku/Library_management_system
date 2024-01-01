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

$title = $content = $category = "";
$title_err = $content_err = $category_err = "";
$created_at = date("Y-m-d H:i:s");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["title"]))) {
        $title_err = "Please enter a title.";
    } else {
        $title = trim($_POST["title"]);
    }

    if (empty(trim($_POST["content"]))) {
        $content_err = "Please enter the content.";
    } else {
        $content = trim($_POST["content"]);
    }

    if (empty(trim($_POST["category"]))) {
        $category_err = "Please select a category.";
    } else {
        $category = trim($_POST["category"]);
    }

    $user_id = $_SESSION['user_id'];
    if (empty($title_err) && empty($content_err) && empty($category_err)) {
        $sql = "INSERT INTO blogs (title, content, category, user_id, created_at) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssis", $title, $content, $category, $user_id, $created_at);

            $title = $conn->real_escape_string($title);
            $content = $conn->real_escape_string($content);
            $category = $conn->real_escape_string($category);
            $user_id = $conn->real_escape_string($user_id);
            $created_at = $conn->real_escape_string($_POST["created_at"]);

            if ($stmt->execute()) {
                header("location: ../blogs.php");
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
