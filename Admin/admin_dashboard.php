<?php
include './../inc/config.php';
include './../inc/functions.php';

session_start();

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
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'dashboard';

$total_items = getTotalItems();
$total_blogs = getTotalBlogs();
$total_users = getTotalUsers();
$total_categories = getTotalCategories();
$total_fields = getTotalFields();

?>

<?php include  './../inc/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" style="background: #023047; height: 95vh;">
            <!-- Sidebar -->
            <ul class="nav nav-pills flex-column sidebar">
                <li class="nav-item">
                    <a class="nav-link text-white <?php if ($active_tab == 'dashboard') echo 'active'; ?>" href="?tab=dashboard">
                        <i class="fas fa-tachometer-alt p-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?php if ($active_tab == 'items') echo 'active'; ?>" href="?tab=items">
                        <i class="fas fa-book p-1"></i> Manage Items
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?php if ($active_tab == 'blogs') echo 'active'; ?>" href="?tab=blogs">
                        <i class="fas fa-file-alt p-1"></i> Manage Blogs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?php if ($active_tab == 'users') echo 'active'; ?>" href="?tab=users">
                        <i class="fas fa-users p-1"></i> Manage Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?php if ($active_tab == 'categories') echo 'active'; ?>" href="?tab=categories">
                        <i class="fas fa-layer-group p-1"></i> Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?php if ($active_tab == 'fields') echo 'active'; ?>" href="?tab=fields">
                        <i class="fas fa-chalkboard-teacher p-1"></i> Field of Interest
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?php if ($active_tab == 'doc_types') echo 'active'; ?>" href="?tab=doc_types">
                        <i class="fas fa-chalkboard-teacher p-1"></i>Doc Types
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?php if ($active_tab == 'messages') echo 'active'; ?>" href="?tab=messages">
                        <i class="fa fa-envelope p-1" aria-hidden="true"></i> Messages
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-md-10">
            <!-- Main content area -->
            <?php
            switch ($active_tab) {
                case 'dashboard':
                    include  './dashboard.php';
                    break;
                case 'items':
                    include  './manage_items.php';
                    break;
                case 'blogs':
                    include  './manage_blogs.php';
                    break;
                case 'users':
                    include  './manage_users.php';
                    break;
                case 'categories':
                    include  './manage_categories.php';
                    break;
                case 'fields':
                    include  './manage_fields.php';
                    break;
                case 'doc_types':
                    include  './manage_doc_types.php';
                    break;
                case 'messages':
                    include  './manage_messages.php';
                    break;
                default:
                    include  './dashboard.php';
            }
            ?>
        </div>
    </div>
</div>

<?php include './../inc/footer.php'; ?>