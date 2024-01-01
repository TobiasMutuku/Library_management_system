<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  header("location: ./inc/login.php");
  exit;
}

include './inc/config.php';
include 'inc/functions.php';

$user_name = $_SESSION['username'];

$finterest = "SELECT field FROM user WHERE username = '$user_name'";
$get_field = mysqli_query($conn, $finterest);
if ($get_field) {
  $result = mysqli_fetch_assoc($get_field);
  $field = $result['field'];
  $field = "tech";
} else {
  echo "Error: " . mysqli_error($conn);
}

$category = $field;
if (isset($_GET['category'])) {
  $category = $_GET['category'];
  $blogs = get_blogs_by_category($category);
} else {
  $search_query = '';
  if (isset($_GET['q'])) {
    $search_query = $_GET['q'];
  }

  if (!empty($search_query)) {
    $blogs = search_blogs($search_query, $field);
  } else {
    $blogs = get_all_blogs($field);
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blogs</title>
  <link rel="stylesheet" href="./css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/style.css">
  <style>
    body::before {
      content: "";
      position: fixed;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      z-index: -1;
      background-image: url(./images/item_images/item-2.jpg);
      background-size: 100%;
      background-position: center center;
      background-attachment: fixed;
      opacity: 1;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="<?php echo BASE_URL; ?>">MegaMind Library</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>/index.php">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="blogsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Blogs
            </a>
            <ul class="dropdown-menu" aria-labelledby="blogsDropdown">
              <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/blogs.php">Blogs</a></li>
              <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/index.php#top-blogs">Top Blogs</a></li>
              <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/all_blogs.php">Other Blogs</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="itemsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Items
            </a>
            <ul class="dropdown-menu" aria-labelledby="itemsDropdown">
              <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/items.php">All Items</a></li>
              <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/index.php#top-items">Top Items</a></li>
              <?php
              $query = "SELECT type_name FROM doc_types";
              $result = mysqli_query($conn, $query);
              while ($row = mysqli_fetch_array($result)) {
                $doc_type = strtolower($row['type_name']);
                echo "<li><a class='dropdown-item' href='" . BASE_URL . "/$doc_type" . "s.php'>$doc_type" . "s</a></li>";
              }
              ?>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>/google_books.php">Google Books</a>
          </li>
        </ul>
        <div>
          <?php
          if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION["user_id"];
            $query = "SELECT user_level FROM user WHERE id = $user_id AND user_level = 'regular'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
              echo '<a href="./request_material.php" class="btn btn-primary">Request Item</a>';
            }
          }
          ?>
        </div>
        <div class="mx-2">
          <?php
          if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION["user_id"];
            $query = "SELECT user_level FROM user WHERE id = $user_id AND user_level = 'regular'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
              echo '<form method="get">
                            <input type="text" name="q" placeholder="Search">
                            <button type="submit">Search</button>
                        </form>';
            }
          }
          ?>
        </div>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>/help_center.php">Help Center</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <?php if (!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"])) : ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo BASE_URL; ?>/inc/signup.php">Register</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo BASE_URL; ?>/inc/login.php">Login</a>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo BASE_URL; ?>/inc/profile.php">Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo BASE_URL; ?>/inc/logout.php">Logout</a>
            </li>
          <?php endif; ?>

        </ul>
      </div>
    </div>
  </nav>

  <div class="d-flex justify-content-between mx-3">
    <a href="./blogs.php" class="btn btn-primary p-2">Prefered Blogs</a>
    <p class="bg-white p-2">Other Blogs</p>
    <p></p>
  </div>
  <form method="GET" action="blogs.php" class="p-4 w-50 mx-auto">
    <label for="category" class="p-2 text-light">Filter by Category:</label>
    <div class="form-group d-flex gap-3">
      <select class="form-control" name="category" id="category">
        <option value=""><?php if (isset($_GET['category'])) {
                            echo $category;
                          } else {
                            echo 'Select a category';
                          } ?></option>
        <?php
        $query = "SELECT category_name FROM categories";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_array($result)) {
          $field_name = $row['category_name'];
          echo "<option value='$field_name'>$field_name</option>";
        }
        ?>
      </select>
      <button type="submit" class="btn btn-primary">Filter</button>
    </div>
  </form>


  <div class="container py-5" style="min-height: 58vh;">
    <div class="row">
      <?php foreach ($blogs as $blog) :
        $category_name = get_category_name($blog['category']);

        if (isset($_GET['category']) && $blog['category'] != $_GET['category']) {
          continue;
        }

      ?>
        <div class="col-md-4 mb-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><?= $blog['title'] ?></h5>
              <p class="card-text"><?= substr($blog['content'], 0, 100) ?>...</p>
              <a href="inc/blog.php?id=<?= $blog['id'] ?>" class="btn btn-primary">Read More</a>
            </div>
            <div class="card-footer text-muted">
              <?php
              $created_at = new DateTime($blog['created_at']);
              $current_time = new DateTime();
              $interval = $created_at->diff($current_time);
              $date_str = $created_at->format('l, j, F');
              $minutes_ago = $interval->format('%i');

              if ($minutes_ago < 60) {
                $time_str = "$minutes_ago minutes ago";
              } else {
                $hours_ago = $interval->format('%h');
                $time_str = "$hours_ago hours ago";
              }
              echo "<small>On $date_str</small>";
              ?>
              <?php
              $category = get_category_name($blog['category']);
              echo "<br>Category: $category";
              ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>


      <?php if (empty($blogs)) : ?>
        <div class="col-md-12">
          <p>No blogs found.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <?php include 'inc/footer.php'; ?>