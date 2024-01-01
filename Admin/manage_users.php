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

$total_users = getTotalUsers();
$total_pages = ceil($total_users / $records_per_page);
$users = getUsersByPage($offset, $records_per_page);
?>
<style>
    @media print {
        body * {
            visibility: hidden;
        }

        table {
            visibility: visible;
        }

        table {
            position: absolute;
            left: 0;
            top: 0;
        }

        /* Exclude buttons from print */
        td.hide {
            display: none;
        }

        .table-wrapper {
            display: block;
        }
    }
</style>
<h1>Manage Users</h1>
<div class="mb-3">
    <a href="./add_user.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New User</a>
    <a href="./add_admin.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Admin</a>
    <button class="btn btn-secondary" onclick="printTable()"><i class="fas fa-print"></i> Print</button>
</div>

<div class="container" style="min-height: 50vh;">
    <table class="table table-hover" style="min-height: 50vh;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>User Level</th>
                <th>Field</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td>ML<?php echo $user['id']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td class="<?php echo $user['user_level'] == 'admin' ? 'text-warning' : 'text-primary'; ?>">
                        <?php echo $user['user_level']; ?>
                    </td>
                    <td><?php echo $user['user_level'] == 'admin' ? 'Administrator' : $user['field']; ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                        <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="table-wrapper d-none" id="table-wrapper">
        <table class="table table-hover" style="min-height: 50vh;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>User Level</th>
                    <th>Field</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $users2 = get_all_users();
                $count = 1;
                foreach ($users2 as $user) { ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td>ML<?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td class="<?php echo $user['user_level'] == 'admin' ? 'text-warning' : 'text-primary'; ?>">
                            <?php echo $user['user_level']; ?>
                        </td>
                        <td><?php echo $user['user_level'] == 'admin' ? 'Administrator' : $user['field']; ?></td>
                    </tr>
                <?php $count++;
                } ?>
            </tbody>
        </table>
    </div>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($current_page > 1) { ?>
                <li class="page-item"><a class="page-link" href="?tab=users&page=<?php echo $current_page - 1; ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i></a></li>
            <?php } ?>

            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?php echo $current_page == $i ? 'active' : ''; ?>"><a class="page-link" href="?tab=users&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php } ?>

            <?php if ($current_page < $total_pages) { ?>
                <li class="page-item"><a class="page-link" href="?tab=users&page=<?php echo $current_page + 1; ?>"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></li>
            <?php } ?>
        </ul>
    </nav>
</div>
<script>
    function printTable() {
        var printContents = document.getElementById('table-wrapper').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>