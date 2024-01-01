<?php
include __DIR__ . '/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MegaMind Library</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css" crossorigin="anonymous" />
    <script type="text/javascript" src="https://www.google.com/items/jsapi.js"></script>
    <script type="text/javascript">
        google.items.load();

        function initialize() {
            var viewer = new google.items.DefaultViewer(document.getElementById('viewerCanvas'));
            viewer.load('ISBN:0738531367');
        }

        google.items.setOnLoadCallback(initialize);
    </script>
    <!-- <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="./css/bootstrap.min.css">
        <link rel="stylesheet" href="./css/style.css"> -->
    <link rel="stylesheet" href="../css/style.css">
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
                            echo '<a href="' . BASE_URL . '/request_material.php" class="btn btn-primary">Request Item</a>';
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
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="itemsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo htmlspecialchars($_SESSION["username"]); ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="itemsDropdown">
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/inc/profile.php">View Profile</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/inc/logout.php">Logout</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>