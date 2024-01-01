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

$records_per_page = 6;

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

$offset = ($current_page - 1) * $records_per_page;
$total_fields = getTotalFields();
$total_pages = ceil($total_fields / $records_per_page);
$fields = getFieldsByPage($offset, $records_per_page);

?>

<h1>Manage fields</h1>
<div class="mb-3">
    <a href="./field_upload.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New field</a>
</div>

<div class="container" style="min-height: 50vh;">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fields as $field) { ?>
                <tr>
                    <td><?php echo $field['id']; ?></td>
                    <td><?php echo $field['field_name']; ?></td>
                    <td>
                        <a href="edit_field.php?id=<?php echo $field['id']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                        <a href="delete_field.php?id=<?php echo $field['id']; ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</a>
                    </td>
                </tr>

            <?php } ?>
        </tbody>
    </table>

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($current_page > 1) { ?>
                <li class="page-item"><a class="page-link" href="?tab=fields&page=<?php echo $current_page - 1; ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i></a></li>
            <?php } ?>

            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?php echo $current_page == $i ? 'active' : ''; ?>"><a class="page-link" href="?tab=fields&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php } ?>

            <?php if ($current_page < $total_pages) { ?>
                <li class="page-item"><a class="page-link" href="?tab=fields&page=<?php echo $current_page + 1; ?>"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></li>
            <?php } ?>
        </ul>
    </nav>
</div>