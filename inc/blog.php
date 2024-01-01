<?php

session_start();
include('header.php');
include('functions.php');


if (!isset($_SESSION["user_id"])) {
  header("location: ./login.php");
  exit;
}

$user_name = $_SESSION['username'];
$selected_id = isset($_GET['id']) ? $_GET['id'] : null;
$blog = get_blog_by_id($selected_id);
?>

<div class="d-flex justify-content-between mx-3">
  <a href="./../blogs.php" class="btn btn-primary p-2">Prefered Blogs</a>
  <a href="./../all_blogs.php" class="btn btn-primary p-2">Other Blogs</a>
</div>
<div class="container mt-3">
  <div class="container mt-4" style="min-height: 56vh;">
    <h2>Blog</h2>
    <hr>

    <?php if ($blog) : ?>
      <div class="card mt-4">
        <div class="card-body">
          <h5 class="card-title"><?php echo $blog['title']; ?></h5>
          <p class="card-text" style="min-height: 15vh;"><?php echo $blog['content']; ?></p>
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
    <?php else : ?>
      <p>The blog you are looking for does not exist.</p>
    <?php endif; ?>

  </div>

  <?php include('footer.php'); ?>