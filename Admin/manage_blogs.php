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

$records_per_page = 7;

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

$offset = ($current_page - 1) * $records_per_page;

$total_blogs = getTotalBlogs();
 $total_pages = ceil($total_blogs / $records_per_page);
$blogs = getBlogsByPage($offset, $records_per_page);

?>

<h1>Manage Blogs</h1>

 <div class="mb-3">
    <a href="./../inc/blog_upload_form.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Blog</a>
</div>

<div class="container" style="min-height: 50vh;">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($blogs as $blog) {
            ?>
                <tr>
                    <td><?php echo $blog['id']; ?></td>
                    <td><?php echo $blog['title']; ?></td>
                    <td><?php echo $blog['category']; ?></td>
                    <td>
                        <a href="./../inc/update_blog.php?id=<?php echo $blog['id']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                        <a href="./../inc/delete_blog.php?id=<?php echo $blog['id']; ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

     <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($current_page > 1) { ?>
                <li class="page-item"><a class="page-link" href="?tab=blogs&page=<?php echo $current_page - 1; ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i></a></li>
            <?php } ?>

            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?php echo $current_page == $i ? 'active' : ''; ?>"><a class="page-link" href="?tab=blogs&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php } ?>

            <?php if ($current_page < $total_pages) { ?>
                <li class="page-item"><a class="page-link" href="?tab=blogs&page=<?php echo $current_page + 1; ?>"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></li>
            <?php } ?>
        </ul>
    </nav>
</div>