<?php

if (!isset($_SESSION["user_id"])) {
  header("location: ./inc/login.php");
  exit;
}


$email = $_SESSION['email'];

$sql = "SELECT * FROM requests WHERE email='$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
?>
  <div class="container mt-5 bg-white">
    <div class="row">
      <div class="col-md-6 mx-auto">
        <h2>Your Requests</h2>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Material Requested</th>
              <th>Status</th>
              <th>Reply</th>
              <th>View item</th>
              <th>Delete Request</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
              <tr>
                <td><?php echo $row['request_title']; ?></td>
                <td><?php echo ucfirst($row['status']); ?></td>
                <td><?php echo ucfirst($row['decline_reason']) . "<br>" . $row['admin_response']; ?></td>
                <?php if ($row['status'] == 'replied') {  ?>
                  <td><?php echo "<a href='inc/view_item.php?id=" . $row['item_id'] . "' class='btn btn-primary'>" . $row['item_title'] . "</a>"; ?>
                  </td>
                <?php } elseif ($row['status'] == 'pending') {
                  echo "<td>Wait for reply</td>";
                } else {
                  echo "<td>Request Rejected</td>";
                } ?>
                <td><a href="./inc/delete_request.php?id=<?php $request_id = $row['id'];
                                                          echo $request_id; ?>" class="btn btn-danger">Delete</a></td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php
} else {
?>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6 mx-auto">
        <p>You have no requests at this time.</p>
      </div>
    </div>
  </div>
<?php
}
?>