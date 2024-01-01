<?php
session_start();
include './config.php';
include './functions.php';

if (!isset($_SESSION["user_id"])) {
    header("location: ./login.php");
    exit;
}

$user_name = $_SESSION['username'];

include __DIR__ . '/header.php';


$book_id = $_GET['item'];
$title = $_GET['title'];
$url = "https://www.googleapis.com/books/v1/volumes/{$book_id}";
$response = file_get_contents($url);
$data = json_decode($response, true);

if ($data['accessInfo']['viewability'] == 'NO_PAGES') {
    // Handle the case where the book is not available for preview
    echo '<div class="container mt-3"><h2>Book not available for preview.</h2></div>';
    include __DIR__ . '/footer.php';
    exit;
}

if ($data['saleInfo']['saleability'] == 'NOT_FOR_SALE') {
    // Handle the case where the book is not available for purchase
    echo '<div class="container mt-3"><h2>Book not available for purchase.</h2></div>';
    include __DIR__ . '/footer.php';
    exit;
}

$content_url = $data['accessInfo']['webReaderLink'];
?>
<div class="container mt-3">
    <h1><?= htmlspecialchars(urldecode($title)) ?></h1>

    <div id="viewerCanvas" style="width: 100%; height: 500px"></div>

    <script type="text/javascript">
        google.books.load();

        function initialize() {
            var viewer = new google.books.DefaultViewer(document.getElementById('viewerCanvas'));
            viewer.load('ISBN:' + <?= $data['volumeInfo']['industryIdentifiers'][0]['identifier'] ?>);
        }

        google.books.setOnLoadCallback(initialize);
    </script>
</div>

<?php include __DIR__ . '/footer.php'; ?>