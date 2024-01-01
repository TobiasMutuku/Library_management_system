<?php
session_start();
include './inc/config.php';
include './inc/functions.php';


if (!isset($_SESSION["user_id"])) {
    header("location: ./inc/login.php");
    exit;
}

$user_name = $_SESSION['username'];

$query1 = isset($_GET['q']) ? $_GET['q'] : "programming";
$url = "https://www.googleapis.com/books/v1/volumes?q=" . urlencode($query1);
$response = @file_get_contents($url);
$data = json_decode($response, true);
?>
<?php
include __DIR__ . '/inc/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MegaMind Library</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css" crossorigin="anonymous" />
    <script type="text/javascript" src="https://www.google.com/items/jsapi.js"></script>
    <script type="text/javascript">
        google.items.load();

        function initialize() {
            var viewer = new google.books.DefaultViewer(document.getElementById('viewerCanvas'));
            viewer.load('ISBN:0738531367');
        }

        google.books.setOnLoadCallback(initialize);
    </script>
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
                        <a class="nav-link dropdown-toggle" href="#" id="booksDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Books
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="booksDropdown">
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/books.php">All Books</a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/index.php#top-books">Top Books</a></li>
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
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="booksDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo htmlspecialchars($_SESSION["username"]); ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="booksDropdown">
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

    <div class="container mt-3" style="min-height: 58vh;">
        <form action="google_books.php" method="get" class="w-50 mx-auto m-2">
            <div class="form-group d-flex gap-3">
                <input type="text" name="q" class="form-control" placeholder="Search for books" value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>">
                <button type="submit" class="btn btn-primary m-2">Search</button>
            </div>
        </form>

        <div class="row">
            <div class="col-12">
                <?php if (isset($data['items']) && count($data['items'])) : ?>
                    <div class="row">
                        <?php foreach ($data['items'] as $book) : ?>
                            <div class="col-md-3 mb-3">
                                <div class="card">
                                    <?php if (isset($book['volumeInfo']['imageLinks']['thumbnail'])) : ?>
                                        <img src="<?php echo $book['volumeInfo']['imageLinks']['thumbnail']; ?>" alt="<?php echo $book['volumeInfo']['title']; ?>" class="card-img-top" height="250px">
                                    <?php else : ?>
                                        <div class="card-img-top bg-secondary text-light text-center py-5">
                                            No Image Available
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-body" style="height: 250px;">
                                        <h5 class="card-title"><?php echo $book['volumeInfo']['title']; ?></h5>
                                        <p class="card-text"><?php echo isset($book['volumeInfo']['description']) ? substr($book['volumeInfo']['description'], 0, 100) . '...' : ''; ?></p>
                                        <a href="<?php echo $book['volumeInfo']['infoLink']; ?>" class="btn btn-primary btn-sm" target="_blank">Details</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php elseif (isset($data['error'])) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $data['error']['message']; ?>
                    </div>
                <?php else : ?>
                    <div class="alert alert-info" role="alert">
                        No results found for "<?php echo htmlspecialchars($query1); ?>"
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php include 'inc/footer.php'; ?>