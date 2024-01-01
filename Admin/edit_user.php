<?php
include './../inc/config.php';

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

$user_id = $_GET["id"];
$sql = "SELECT id FROM user WHERE id = ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) == 0) {
        header("location: ./admin_dashboard.php?tab=users");
        exit();
    }
    mysqli_stmt_close($stmt);
}

$post = array();
$sql = "SELECT email, username, user_level, field FROM user WHERE id = ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $email, $username, $user_level, $field);
        if (mysqli_stmt_fetch($stmt)) {
            $post = array("id" => $user_id, "email" => $email, "username" => $username, "user_level" => $user_level, "field" => $field);
        } else {
            header("location: ./admin_dashboard.php?tab=users");
            exit;
        }
    } else {
         echo "Error: " . mysqli_error($conn);
        exit;
    }
    mysqli_stmt_close($stmt);
}
$email_err = $username_err = $user_level_err = $field_err = "";

 if (isset($_POST["update_user"])) {

     if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email address.";
    } else {
         $sql = "SELECT id FROM user WHERE email = ? AND id != ?";

        if ($stmt = $conn->prepare($sql)) {
             $stmt->bind_param("si", $param_email, $user_id);

             $param_email = trim($_POST["email"]);

             if ($stmt->execute()) {
                 $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $email_err = "This email address is already taken.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

             $stmt->close();
        }
    }

     if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
         $sql = "SELECT id FROM user WHERE username = ? AND id != ?";

        if ($stmt = $conn->prepare($sql)) {
             $stmt->bind_param("si", $param_username, $user_id);

             $param_username = trim($_POST["username"]);

             if ($stmt->execute()) {
                 $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

             $stmt->close();
        }
    }

     if (empty(trim($_POST["user_level"]))) {
        $user_level_err = "Please select a user level.";
    } else {
        $user_level = trim($_POST["user_level"]);
    }

     if (empty(trim($_POST["field"]))) {
        $field_err = "Please select a field of your interest or 'Other' if not listed.";
    } else {
        $field = trim($_POST["field"]);
    }

     if (empty($email_err) && empty($username_err) && empty($user_level_err) && empty($field_err)) {

         $sql = "UPDATE user SET email=?, username=?, user_level=?, field=? WHERE id=?";
        if ($stmt = $conn->prepare($sql)) {
             $stmt->bind_param("ssssi", $param_email, $param_username, $param_user_level, $param_field, $user_id);

             $param_email = $email;
            $param_username = $username;
            $param_user_level = $user_level;
            $param_field = $field;
            $user_id;

             if ($stmt->execute()) {
                 header("location: ./admin_dashboard.php?tab=users");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

             $stmt->close();
        }
    }


     $conn->close();
}
?>

<?php include './../inc/header.php'; ?>
<div class="container mt-3">
    <div class="container">
        <div class="">
            <div class="col-lg-6 mx-auto">
                <div style="min-height: 56vh;">
                    <h2>Register</h2>
                    <p>Please fill this form to create an account.</p>
                    <form method="post">
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block text-warning"><?php echo $email_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                            <span class="help-block text-warning"><?php echo $username_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($user_level_err)) ? 'has-error' : ''; ?>">
                            <label>User Level</label>
                            <select name="user_level" id="user_level" class="form-select">
                                <option value="<?php echo $user_level; ?>"><?php echo $user_level; ?></option>
                                <option value="admin">Admin</option>
                                <option value="regular">Regular</option>
                            </select>
                            <span class="help-block text-warning"><?php echo $user_level_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($field_err)) ? 'has-error' : ''; ?>">
                            <label>Field Of Interest</label>
                            <select name="field" id="field" class="form-select">
                                <option value="<?php echo $field; ?>"><?php echo $field; ?></option>
                                <?php
                                $query = "SELECT field_name FROM fields";
                                                   $result = mysqli_query($conn, $query);
                                                   while ($row = mysqli_fetch_array($result)) {
                                    $field_name = $row['field_name'];
                                    echo "<option value='$field_name'>$field_name</option>";
                                }
                                ?>
                            </select>

                            <span class="help-block text-warning"><?php echo $field_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary m-2" name="update_user" value="Update User">
                            <input type="reset" class="btn btn-default m-2" value="Reset">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php include './../inc/footer.php'; ?>