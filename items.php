<?php
session_start();
include './inc/config.php';
include './inc/functions.php';

if (!isset($_SESSION["user_id"])) {
  header("location: ./inc/login.php");
  exit;
}

$user_name = $_SESSION['username'];

$finterest = "SELECT field FROM user WHERE username =  '$user_name'";
$get_field = mysqli_query($conn, $finterest);
if ($get_field) {
  $result = mysqli_fetch_assoc($get_field);
  $field = $result['field'];
} else {
  echo "Error: " . mysqli_error($conn);
}

// Check if a search query was submitted
if (isset($_GET['q'])) {
  $search_query = $_GET['q'];
  $items = search_items($search_query);
  $newspapers = search_newspapers($search_query);
  $articles = search_articles($search_query);
} else {
  if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $items = get_items_by_category(100, $category);
    $newspapers = get_newspapers_by_category(10, $category);
    $articles = get_articles_by_category(10, $category);
  } else {
    if ($field == "Other") {
      $items = get_all_items(10);
      $newspapers = get_all_newspapers(10);
      $articles = get_all_articles(10);
    } else {
      $items = get_items(10, $field);
      $newspapers = get_newspapers(100, $field);
      $articles = get_articles(100, $field);
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Items</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css" crossorigin="anonymous" />
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

  <form method="GET" action="items.php" class="w-50 mx-auto">
    <label for="category" class="p-2 text-light">Filter by Category:</label>
    <div class="form-group d-flex gap-3">
      <select id="category" name="category" class="form-select" required>
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

  <div class="container mt-4" style="min-height: 58vh;">
    <div class="w-full border-bottom mb-1">
      <h3 class="p-2">Books</h3>
    </div>
    <div class="row">
      <?php
      foreach ($items as $item) :
        $img_url = BASE_URL . '/uploads/images/' . $item['image'];
      ?>
        <div class="col-md-4 mb-4">
          <div class="card">
            <img src="<?= $img_url ?>" class="card-img-top" alt="Cover Image" onerror="this.onerror=null;this.src='./uploads/images/default_cover.jpeg'; " width="auto" height="300">
            <div class="card-body">
              <h5 class="card-title"><?= $item['title'] ?></h5>
              <p class="card-text"><?= substr($item['description'], 0, 30) ?>...</p>
              <a href="inc/view_item.php?id=<?= $item['id'] ?>" class="btn btn-primary">Read More</a>
            </div>
            <div class="card-footer text-muted">
              <?php
              $created_at = new DateTime($item['created_at']);
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

              echo "<small>Author: {$item['author']} <br>Post by: {$item['posted_by']}. On $date_str</small> <br> Category: {$item['category']}";
              ?>
            </div>
          </div>
        </div>

      <?php endforeach; ?>
      <?php if (empty($items)) : ?>
        <div class="col-md-12">
          <p>There are no books under this area.</p>
        </div>
      <?php endif; ?>
    </div>


    <div class="w-full border-bottom mb-1">
      <h3 class="p-2">NewsPapers</h3>
    </div>
    <div class="row">
      <?php
      foreach ($newspapers as $newspaper) :
        $img_url = BASE_URL . '/uploads/images/' . $newspaper['image'];
      ?>
        <div class="col-md-4 mb-4">
          <div class="card">
            <img src="<?= $img_url ?>" class="card-img-top" alt="Cover Image" onerror="this.onerror=null;this.src='./uploads/images/default_cover.jpeg'; " width="auto" height="300">
            <div class="card-body">
              <h5 class="card-title"><?= $newspaper['title'] ?></h5>
              <p class="card-text"><?= substr($newspaper['description'], 0, 30) ?>...</p>
              <a href="inc/view_item.php?id=<?= $newspaper['id'] ?>" class="btn btn-primary">Read More</a>
            </div>
            <div class="card-footer text-muted">
              <?php
              $created_at = new DateTime($newspaper['created_at']);
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

              echo "<small>Author: {$newspaper['author']} <br>Posted On $date_str</small> <br> Category: {$newspaper['category']}";
              ?>
            </div>
          </div>
        </div>

      <?php endforeach; ?>
      <?php if (empty($newspapers)) : ?>
        <div class="col-md-12">
          <p>There are no newspapers under this area.</p>
        </div>
      <?php endif; ?>
    </div>


    <div class="w-full border-bottom mb-1">
      <h3 class="p-2">Articles</h3>
    </div>
    <div class="row">
      <?php
      foreach ($articles as $article) :
        $img_url = BASE_URL . '/uploads/images/' . $article['image'];
      ?>
        <div class="col-md-4 mb-4">
          <div class="card">
            <img src="<?= $img_url ?>" class="card-img-top" alt="Cover Image" onerror="this.onerror=null;this.src='./uploads/images/default_cover.jpeg'; " width="auto" height="300">
            <div class="card-body">
              <h5 class="card-title"><?= $article['title'] ?></h5>
              <p class="card-text"><?= substr($article['description'], 0, 30) ?>...</p>
              <a href="inc/view_item.php?id=<?= $article['id'] ?>" class="btn btn-primary">Read More</a>
            </div>
            <div class="card-footer text-muted">
              <?php
              $created_at = new DateTime($article['created_at']);
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

              echo "<small>Author: {$article['author']} <br>Post by: {$article['posted_by']}. On $date_str</small> <br> Category: {$article['category']}";
              ?>
            </div>
          </div>
        </div>

      <?php endforeach; ?>
      <?php if (empty($articles)) : ?>
        <div class="col-md-12">
          <p>There are no articles under this area.</p>
        </div>
      <?php endif; ?>
    </div>



  </div>

  <footer class="bg-light text-center text-lg-start mt-3">
    <div class="px-auto p-4 w-full footer-1">
      <div class="row">
        <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
          <h5 class="text-uppercase">MegaMind Library</h5>
          <p>A place to read and share items online.</p>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Links</h5>
          <ul class="list-unstyled mb-0">
            <li>
              <a href="<?php echo BASE_URL; ?>" class="text-decoration-none">Home</a>
            </li>
            <li>
              <a href="<?php echo BASE_URL; ?>/items.php" class="text-decoration-none">Items</a>
            </li>
            <li>
              <a href="<?php echo BASE_URL; ?>/blogs.php" class="text-decoration-none">Blogs</a>
            </li>
          </ul>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Contact</h5>
          <ul class="list-unstyled mb-0">
            <li>
              <a href="#!" class="text-decoration-none">Address: 56 6301, Nakuru, Kenya</a>
            </li>
            <li>
              <a href="#!" class="text-decoration-none">Phone: +(254) 746 301 104</a>
            </li>
            <li>
              <a href="#!" class="text-decoration-none">Email: info@megamindlibrary.com</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="text-center p-3 text-white" style="background-color: #023047;">
      &copy; <?php echo date('Y'); ?> MegaMind Library
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>