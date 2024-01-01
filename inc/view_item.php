<?php
include 'config.php';
include 'functions.php';

session_start();
 
if (!isset($_SESSION["user_id"])) {
  header("location: ./login.php");
  exit;
}
 $user_name = $_SESSION['username'];

 $error_message = '';

 if (isset($_GET['id'])) {
  $id = $_GET['id'];

   $item = get_item($id);

   if ($item) {
    $title = $item['title'];
    $description = $item['description'];
    $file_path = $item['file_path'];

    if (empty($file_path) || $file_path === null) {
      $error_message = 'Sorry, the item content is not available.';
    }
  } else {
    $title = 'Error';
    $file_path = null;
    $error_message = 'Sorry, the item you requested was not found.';
  }
} else {
  $title = 'Title not available';
  $file_path = null;
  $error_message = 'Sorry, the item ID was not specified.';
}

include 'header.php';
?>
<div class="container mt-3">
  <main class="container py-4" style="min-height: 58vh;">
    <?php if ($file_path) : ?>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title"><?= $title ?></h5>
          <p><?= $description ?></p>
        </div>
      </div>
      <div class="embed-responsive embed-responsive-4by3 w-full" style="width: 100%; height:100vh;">
        <embed class="embed-responsive-item" style="width: 100%; height:100vh;" src="<?= $file_path ?>" type="application/pdf" />
      </div>
    <?php else : ?>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title py-2"><?= $title ?></h5>
          <p class="card-text"><?= $error_message ?></p>
        </div>
      </div>
    <?php endif; ?>
  </main>


  <?php include 'footer.php'; ?>