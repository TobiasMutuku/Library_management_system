<?php
session_start();
include 'inc/config.php';
include 'inc/functions.php';

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

if (isset($_GET['q'])) {
  $search_query = $_GET['q'];
}
if (isset($search_query)) {
  $items = search_items($search_query, 10);
  $blogs = search_blogs($search_query, 10);
} else {

  if ($field == "Other") {
    $items = get_all_items(10);
    $blogs = get_all_top_blogs(10);
  } else {
    $blogs = get_top_blogs(10, $field);
    $items = get_items(10, $field);
  }
}
?>


<?php include __DIR__ . '/inc/header.php'; ?>
<style>
  @media (max-width: 576px) {
    .embed-responsive-4by3 {
      padding-bottom: 75%;
    }

    .embed-responsive-4by3 embed {
      width: 100%;
      height: 100%;
    }
  }

  @media (min-width: 576px) {
    .embed-responsive-4by3 {
      padding-bottom: 56.25%;
    }
  }

  body {
    background-color: #f7f7f7;
  }

  .navbar {
    background-color: #023047;
  }

  .navbar-brand,
  .navbar-text,
  .navbar ul li a {
    color: #fff;
  }

  .navbar ul li .dropdown-item {
    color: black;
  }

  /* Main content */
  .main-content {
    min-height: calc(100vh - 56px);
    padding-top: 2rem;
    padding-bottom: 2rem;
  }

  /* Items section */
  .items-section {
    background-color: #f5f5f5;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 2rem;
  }

  .items-section h1 {
    margin-bottom: 1rem;
    font-size: 2.5rem;
    color: #023047;
    text-align: center;
  }

  .item-card {
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
    border-radius: 8px;
  }

  .item-card img {
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
  }

  .item-card .card-title {
    margin-bottom: 0.5rem;
    font-size: 1.5rem;
    color: #023047;
  }

  .item-card .card-text {
    margin-bottom: 1rem;
    font-size: 1.25rem;
    color: #5e5e5e;
  }

  .item-card .card-footer {
    background-color: #fafafa;
    border-top: 1px solid #e5e5e5;
    font-size: 0.875rem;
    color: #a5a5a5;
  }

  /* Blogs section */
  .blogs-section {
    background-color: #fff;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
    border-radius: 8px;
    padding: 1.5rem;
  }

  .blogs-section h1 {
    margin-bottom: 1rem;
    font-size: 2.5rem;
    color: #023047;
    text-align: center;
  }

  .blog-card {
    margin-bottom: 2rem;
  }

  .blog-card .card-title {
    margin-bottom: 0.5rem;
    font-size: 1.5rem;
    color: #023047;
  }

  .blog-card .card-text {
    margin-bottom: 1rem;
    font-size: 1.25rem;
    color: #5e5e5e;
  }

  .blog-card .card-footer {
    background-color: #fafafa;
    border-top: 1px solid #e5e5e5;
    font-size: 0.875rem;
    color: #a5a5a5;
  }

  /* Buttons */
  .btn-primary {
    background-color: #023047;
    border-color: #023047;
    margin: 3px;
  }

  .btn-primary:hover {
    background-color: #042a3c;
    border-color: #042a3c;
  }

  footer .footer-1 {
    box-shadow: inset 0 -5px 5px -5px #0230477c,
      inset 0 -1px 2px 0 #0230471e;
    background-color: #0230471e;
  }

  footer ul a {
    color: #023047;
  }

  .carousel-item {
    height: 50vh;
  }

  .carousel-item img {
    height: 100%;
    object-fit: cover;
  }

  .carousel-caption {
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    padding: 10px;
    font-size: 1rem;
    height: 70%;
    margin: auto;
  }

  body::before {
    content: "";
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: -1;
    background-image: url(./images/item_images/item-2.jpg);
    /*Put your image url*/
    background-size: 100%;
    background-position: center center;
    background-attachment: fixed;
    opacity: 0.4;
    /*Value from 0.0 to 1.0*/
  }
</style>

<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="./images/item_images/item-1.jpg" class="d-block w-100" alt="First slide">
      <div class="carousel-caption d-md-block">
        <h5>Find the Best Collection of Items</h5>
        <p>Immerse yourself in a thrilling adventure with our best items content ever.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="./images/item_images/item-5.jpg" class="d-block w-100" alt="Second slide">
      <div class="carousel-caption d-md-block">
        <h5>Items of All Kinds in One Place</h5>
        <p>Whether it is programming or romance, we bring you all kinds of collections from their original owners.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="./images/item_images/item-4.jpg" class="d-block w-100" alt="Third slide">
      <div class="carousel-caption d-md-block">
        <h5>Blogs of All Types</h5>
        <p>Find top items and blogs that will blow your mind.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>


<div class="container mt-3">
  <main class="container py-4" style="min-height: 58vh;">
    <div class="row">
      <div class="col-md-12">
        <h1 class="mb-4" id="top-items">Latest Items</h1>
      </div>
      <?php foreach ($items as $item) :
        $img_url = BASE_URL . '/uploads/images/' . $item['image'];
      ?>
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <img src="<?= $img_url ?>" class="card-img-top" alt="Cover Image" onerror="this.onerror=null;this.src='./uploads/images/default_cover.jpeg'; " width="auto" height="300">
            <div class="card-body">
              <h5 class="card-title"><?= $item['title'] ?></h5>
              <p class="card-text"><?= substr($item['description'], 0, 100) ?>...</p>
              <a href="inc/view_item.php?id=<?= $item['id'] ?>" class="btn btn-primary">Read More</a>
            </div>
            <div class="card-footer text-muted">
              <small>By <?= $item['author'] ?> on <?= $item['created_at'] ?></small>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      <?php if (empty($item)) : ?>
        <div class="col-md-12">
          <p>No items found.</p>
        </div>
      <?php endif; ?>
      <div class="col-md-12">
        <h1 class="mb-4" id="top-blogs">Latest Blogs</h1>
      </div>
      <?php foreach ($blogs as $blog) : ?>
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="card-title"><?= $blog['title'] ?></h5>
              <p class="card-text"><?= substr($blog['content'], 0, 100) ?>...</p>
              <a href="inc/blog.php?id=<?= $blog['id'] ?>" class="btn btn-primary">Read More</a>
            </div>
            <div class="card-footer text-muted">
              <small>By <?= get_user_name($blog['user_id']) ?> on <?= $blog['created_at'] ?></small>
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
  </main>
  <!-- Button to redirect to helpcenter page -->
  <a href="help_center.php" class="btn btn-primary btn-floating rounded-circle position-fixed bottom-0 end-0 mb-3 me-3" style="z-index: 1030; opacity: 0.8;">
    <i class="bi bi-question-circle">Help</i>
  </a>
  <?php include 'inc/footer.php'; ?>