<?php
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

$records_per_page = 5;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $records_per_page;

$total_items = getTotalItems();
$total_pages = ceil($total_items / $records_per_page);
$items = getItemsByPage($offset, $records_per_page);

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



<h1 class="p-2">Manage Items</h1>
<div class="mb-3">
    <a href="./../inc/item_upload.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Item</a>
    <button class="btn btn-secondary" onclick="printTable()"><i class="fas fa-print"></i> Print</button>
</div>

<div class="container" style="min-height: 50vh;">
    <!-- Item table -->
    <div class="table-wrapper">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Posted By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item) { ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['title']; ?></td>
                        <td><?php echo $item['author']; ?></td>
                        <td><?php echo $item['category']; ?></td>
                        <td><?php echo $item['doc_type']; ?></td>
                        <td><?php echo $item['posted_by']; ?></td>
                        <td>
                            <a href="delete_item.php?id=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</a>
                        </td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="table-wrapper d-none" id="table-wrapper">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Posted By</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item) { ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['title']; ?></td>
                        <td><?php echo $item['author']; ?></td>
                        <td><?php echo $item['category']; ?></td>
                        <td><?php echo $item['doc_type']; ?></td>
                        <td><?php echo $item['posted_by']; ?></td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
    </div>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($current_page > 1) { ?>
                <li class="page-item"><a class="page-link" href="?tab=items&page=<?php echo $current_page - 1; ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i></a></li>
            <?php } ?>

            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?php echo $current_page == $i ? 'active' : ''; ?>"><a class="page-link" href="?tab=items&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php } ?>

            <?php if ($current_page < $total_pages) { ?>
                <li class="page-item"><a class="page-link" href="?tab=items&page=<?php echo $current_page + 1; ?>"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></li>
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