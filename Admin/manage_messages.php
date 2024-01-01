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
$messages_per_page = 10;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $messages_per_page;

$total_messages = getTotalMessages();
$total_pages = ceil($total_messages / $messages_per_page);
$messages = getMessagesByPage($offset, $messages_per_page);
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
  }
</style>
<h1>Manage messages</h1>
<button class="btn btn-secondary" onclick="printTable()"><i class="fas fa-print"></i> Print</button>
<div class="container" style="min-height: 50vh;">
  <div class="table-wrapper">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Subject</th>
          <th>Message</th>
          <th>Date</th>
          <th>Status</th>
          <th colspan="2" class="hide">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($messages as $message) { ?>
          <tr>
            <td><?php echo $message['id']; ?></td>
            <td><?php echo $message['username']; ?></td>
            <td><?php echo $message['email']; ?></td>
            <td><?php echo $message['request_title']; ?></td>
            <td><?php echo $message['request']; ?></td>
            <td><?php echo $message['created_at']; ?></td>
            <td><?php echo $message['status']; ?></td>
            <?php
            if ($message['status'] != 'rejected') {
              echo '<td class="hide">
              <a href="./../inc/decline_message.php?id=' . $message["id"] . '" class="btn btn-sm btn-primary"> <i class="fa fa-reply" aria-hidden="true"></i> Decline</a>
              <a href="./../inc/reply_message.php?id=' .  $message['id'] . '" class="btn btn-sm btn-primary"> <i class="fa fa-reply" aria-hidden="true"></i> Respond</a>
              </td>';
            }
            ?>

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
          <th>Name</th>
          <th>Email</th>
          <th>Subject</th>
          <th>Message</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($messages as $message) { ?>
          <tr>
            <td><?php echo $message['id']; ?></td>
            <td><?php echo $message['username']; ?></td>
            <td><?php echo $message['email']; ?></td>
            <td><?php echo $message['request_title']; ?></td>
            <td><?php echo $message['request']; ?></td>
            <td><?php echo $message['created_at']; ?></td>  
          </tr>
        <?php } ?>
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