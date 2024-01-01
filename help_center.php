<?php
session_start();
include 'inc/config.php';
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

        .list-group .active {
            background-color: #023047;
            border-color: #023047;
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

    <div class="container mt-3" style="min-height: 58vh;">
        <h1>Help Center</h1>

        <div class="row">
            <div class="col-md-4 mb-2" style="min-height: 50vh;">
                <div class="list-group bg-white" id="list-tab" role="tablist">
                    <a class="list-group-item list-group-item-action active" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="home">Search</a>
                    <a class="list-group-item list-group-item-action" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Download</a>
                    <a class="list-group-item list-group-item-action" id="list-messages-list" data-bs-toggle="list" href="#list-messages" role="tab" aria-controls="messages">Read</a>
                    <a class="list-group-item list-group-item-action" id="list-settings-list" data-bs-toggle="list" href="#list-settings" role="tab" aria-controls="settings">Request</a>
                    <a class="list-group-item list-group-item-action" id="list-settings-list" data-bs-toggle="list" href="#list-manage" role="tab" aria-controls="manage">Manage Profile</a>
                </div>
            </div>
            <div class="col-md-8 bg-white p-4 mb-2" style="min-height: 50vh;">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                        <h2>How do I search for a book?</h2>
                        <p>To search for a book, simply enter the title or author in the search bar on the homepage. You can also browse books by genre by clicking on the "Filter" button.</p>
                        <div class="text-center p-4">
                            <p>Find the seach form like below on the items page navbar</p>
                            <img src="./images/search.png" alt="search form">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                        <h2>How do I download a book?</h2>
                        <li>Find the book you want to dowload</li>
                        <li>Open the book view page</li>
                        <li>To download a book, click on the "Download" button on the book's page. </li>
                        <li>If the book is not available for download, you can request it from the "Request" tab.</li>
                        <div class="text-center p-4">
                            <img src="./images/download.png" alt="Download Book" class="w-100">
                            <p class="p-3 text-start">Example: <a href="http://localhost/LibWebsite/inc/view_item.php?id=33" class="p-2">Dowload Programming Android Pdf Book</a>
                            </p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
                        <h2>How do I read a book/item?</h2>
                        <li>Find the book you want to read from the books page or that items page</li>
                        <li>To read the book, click on the "Read" button on the book's page.</li>
                        <li>This will open the book in your browser, where you can read it online.</li>
                        <li>You can also download the book using the download button from the read book page</li>
                    </div>
                    <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
                        <h2>How do I request a book?</h2>
                        <li>Find the "Request Item button on the navbar"</li>
                        <li>The button is found in most of the pages at the top navigations</li>
                        <li>Click on the "Request Item" button that will take you to the request page</li>
                        <li>Fill the 'Request Material Form' and submit</li>
                        <li>You will get the reply on the same page under 'Your Requests'</li>
                    </div>
                    <div class="tab-pane fade" id="list-manage" role="tabpanel" aria-labelledby="list-manage-list">
                        <h2>How do I manage my profile?</h2>
                        <li>To manage your profile, click on the username tab at the top right.</li>
                        <li>This will open the profile page</li>
                        <li>The profile page has options for changing password, manage profile and loggingout of your account.</li>
                        <li>You can also view your requests and replies through the "Request item" button that will go to request materials page</li>
                        <li>From there, you can update your personal information, change your password, and view your account history.</li>
                    </div>

                </div>
            </div>
        </div>

        <?php include 'inc/footer.php'; ?>