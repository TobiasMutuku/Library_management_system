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
$doc_types = getAllDocTypes();
?>

<h1>Manage Document Types</h1>
<div class="mb-3">
    <a href="./doc_type_upload.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Document Type</a>
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
            <?php foreach ($doc_types as $doc_type) { ?>
                <tr>
                    <td><?php echo $doc_type['id']; ?></td>
                    <td><?php echo $doc_type['type_name']; ?></td>
                    <td>
                        <a href="edit_doc_type.php?id=<?php echo $doc_type['id']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                        <a href="delete_doc_type.php?id=<?php echo $doc_type['id']; ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</a>
                    </td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
</div>