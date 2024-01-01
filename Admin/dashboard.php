<?php
include '../inc/config.php';

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

$total_items = getTotalItems();
$total_blogs = getTotalBlogs();
$total_users = getTotalUsers();
$total_categories = getTotalCategories();
$total_fields = getTotalFields();
?>

<div class="container">
    <h1>Dashboard</h1>

    <div class="container" style="min-height: 50vh;">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body d-flex">
                        <div>
                            <h4 class="card-title">Users</h4>
                            <p class="card-text"><?= $total_users ?></p>
                        </div>
                        <i class="fas fa-users m-2 mx-auto fa-3x"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body d-flex">
                        <div>
                            <h4 class="card-title">Items</h4>
                            <p class="card-text"><?= $total_items ?></p>
                        </div>
                        <i class="fas fa-item m-2 mx-auto fa-3x"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body d-flex">
                        <div>
                            <h4 class="card-title">Articels</h4>
                            <p class="card-text"><?= $total_blogs ?></p>
                        </div>
                        <i class="fas fa-file-alt m-2 mx-auto fa-3x"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body d-flex">
                        <div>
                            <h4 class="card-title">Categories</h4>
                            <p class="card-text"><?= $total_categories ?></p>
                        </div>
                        <i class="fas fa-layer-group  m-2 mx-auto fa-3x"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body d-flex">
                        <div>
                            <h4 class="card-title">Fields</h4>
                            <p class="card-text"><?= $total_fields ?></p>
                        </div>
                        <i class="fas fa-chalkboard-teacher m-2 mx-auto fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>