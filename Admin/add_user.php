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

 $email = $username = $field = $password = $confirm_password = "";
$email_err = $username_err = $field_err = $password_err = $confirm_password_err = "";

 if ($_SERVER["REQUEST_METHOD"] == "POST") {

     if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email address.";
    } else {
         $sql = "SELECT id FROM user WHERE email = ?";

        if ($stmt = $conn->prepare($sql)) {
             $stmt->bind_param("s", $param_email);

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
         $sql = "SELECT id FROM user WHERE username = ?";

        if ($stmt = $conn->prepare($sql)) {
             $stmt->bind_param("s", $param_username);

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

     if (empty(trim($_POST["field"]))) {
        $field_err = "Please select a field of your interest or 'Other' if not listed.";
    } else {
        $field = trim($_POST["field"]);
    }

     if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $password_err = "Password must have at least 8 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

     if (empty($email_err) && empty($username_err) && empty($field_err) && empty($password_err) && empty($confirm_password_err)) {

         $sql = "INSERT INTO user (email, username, field, password) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
             $stmt->bind_param("ssss", $param_email, $param_username, $param_field, $param_password);

             $param_email = $email;
            $param_username = $username;
            $param_field = $field;
            $param_password = password_hash($password, PASSWORD_DEFAULT);  

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
        <div class="row">
            <div class="col-md-6 d-none d-md-block" style="background-image: url('../images/cover1.jpg'); background-size: cover; background-position: center;"></div>
            <div class="col-lg-6">
                <div style="min-height: 56vh;">
                    <h2>Register</h2>
                    <p>Please fill this form to create an account.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                        <div class="form-group <?php echo (!empty($field_err)) ? 'has-error' : ''; ?>">
                            <label>Field Of Interest</label>
                            <select name="field" id="field" class="form-select">
                                <option value="">Select Field of Interest</option>
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
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                            <span class="help-block text-warning"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                            <span class="help-block text-warning"><?php echo $confirm_password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary m-2" value="Add User">
                            <input type="reset" class="btn btn-default m-2" value="Reset">
                            <a href="./admin_dashboard.php?tab=users" class="btn btn-primary m-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php include './../inc/footer.php'; ?>