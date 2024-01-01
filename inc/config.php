<?php

if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/LibWebsite');
}

if (!defined('DB_HOST')) {
    define('DB_HOST', 'localhost');
}

if (!defined('DB_USER')) {
    define('DB_USER', 'root');
}

if (!defined('DB_PASSWORD')) {
    define('DB_PASSWORD', '');
}

if (!defined('DB_NAME')) {
    define('DB_NAME', 'megamindlibrary');
}
if (!defined('UPLOAD_DIR')) {
    define('UPLOAD_DIR', '../uploads/');
}

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
