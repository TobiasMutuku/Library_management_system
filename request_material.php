<?php
session_start();
include('./inc/config.php');

$email = $_SESSION['email'];
$sql = "SELECT * FROM requests WHERE email='$email'";
$result = mysqli_query($conn, $sql);

$email = $_SESSION['email'];

$get_user_data = mysqli_query($conn, "SELECT id, username, email FROM user WHERE email = '$email'");

if (mysqli_num_rows($get_user_data) > 0) {
  $user_data = mysqli_fetch_assoc($get_user_data);
  $username = $user_data['username'];
  $email = $user_data['email'];
  $user_id = $user_data['id'];
} else {
  echo "User not found";
}

if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $request = $_POST['request'];
  $request_title = $_POST['request_title'];
  $created_at = date('Y-m-d H:i:s');

  $sql = "INSERT INTO requests (user_id, username, email, request, status, request_title, created_at) VALUES ('$user_id','$username', '$email', '$request', 'pending', '$request_title', '$created_at')";
  if (mysqli_query($conn, $sql)) {
    $success_msg = "Your request has been submitted successfully!";
  } else {
    $error_msg = "Sorry, there was an error submitting your request. Please try again.";
  }
}


include('./inc/header.php'); ?>
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
<?php
include('./notifications.php');
?>

<div class="container" style="min-height: 56vh;">
  <div class="row">
    <div class="col-md-6 mx-auto mt-5">
      <h2>Request Material</h2>
      <?php if (isset($success_msg)) { ?>
        <div class="alert alert-success"><?php echo $success_msg; ?></div>
      <?php } ?>
      <?php if (isset($error_msg)) { ?>
        <div class="alert alert-danger"><?php echo $error_msg; ?></div>
      <?php } ?>
      <form method="post">
        <input type="text" name="userid" class="form-control" hidden required value="<?php echo $user_id; ?>">
        <div class="form-group d-none">
          <label for="username">Your Name</label>
          <input type="text" name="username" class="form-control" required value="<?php echo $username; ?>">
        </div>
        <div class="form-group d-none">
          <label for="email">Your Email</label>
          <input type="email" name="email" class="form-control" required value="<?php echo $email; ?>">
        </div>
        <div class="form-group">
          <label for="request_title">Request Title</label>
          <input type="text" name="request_title" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="request">Request(Describe Requeste)</label>
          <input type="text" name="request" class="form-control" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary m-3">Submit Request</button>
      </form>
    </div>
  </div>
</div>

<?php
include('./inc/footer.php');
?>