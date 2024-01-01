<?php
include 'inc/config.php';
include 'inc/functions.php';

$page_title = 'Page Not Found';
include 'inc/header.php';
?>
<div class="container mt-3">
  <div class="container" style="min-height: 58vh;">
    <div class="row">
      <div class="col-md-8 offset-md-2 text-center">
        <h1 class="display-1">404</h1>
        <h2 class="display-4">Page Not Found</h2>
        <p class="lead">The page you requested could not be found on this server.</p>
        <a href="<?= BASE_URL ?>" class="btn btn-primary">Go to Homepage</a>
      </div>
    </div>
  </div>

  <?php
  include 'inc/footer.php';
  ?>