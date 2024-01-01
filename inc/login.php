<?php
include './config.php';

if (isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL);
    exit();
}

 $email = $password = '';
$email_err = $password_err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

     if (empty(trim($_POST['email']))) {
        $email_err = 'Please enter your email.';
    } else {
        $email = trim($_POST['email']);
    }

     if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter your password.';
    } else {
        $password = trim($_POST['password']);
    }

    if (empty($email_err) && empty($password_err)) {

         $sql = "SELECT id, email, password FROM user WHERE email = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
             mysqli_stmt_bind_param($stmt, "s", $param_email);

             $param_email = $email;

             if (mysqli_stmt_execute($stmt)) {
                 mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $user_id, $email, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $sql = "SELECT username, user_level FROM user WHERE email = ?";
                            $stmt = mysqli_prepare($conn, $sql);
                            mysqli_stmt_bind_param($stmt, "s", $email);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $user_name, $user_level);
                            mysqli_stmt_fetch($stmt);

                            if ($user_level == "admin") {
                                $_SESSION['user_id'] = $user_id;
                                $_SESSION['email'] = $email;
                                $_SESSION['username'] = $user_name;
                                header('Location: ./../Admin/admin_dashboard.php');
                            } elseif ($user_level == "regular") {
                                $_SESSION['user_id'] = $user_id;
                                $_SESSION['email'] = $email;
                                $_SESSION['username'] = $user_name;
                                header('Location: ' . BASE_URL);
                            }
                            exit();
                        } else {
                            $password_err = 'The password you entered is not valid.';
                        }
                    }
                } else {
                    $email_err = 'No account found with that email.';
                }
            } else {
                echo 'Oops! Something went wrong. Please try again later.';
            }

             mysqli_stmt_close($stmt);
        }
    }

     mysqli_close($conn);
}

include './header.php';
?>
<div class="container mt-3">
    <div class="row" style="min-height: 58vh;">
        <div class="col-md-6 d-none d-md-block" style="background-image: url('../images/cover1.jpg'); background-size: cover; background-position: center;"></div>
        <div class="col-md-6 p-5">
            <h2>Login</h2>
            <p>Please fill in your credentials to login.</p>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                    <span class="help-block text-warning"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                    <span class="help-block text-warning"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary m-2" value="Login">
                </div>
                <a href="password_reset.php">forgot password?</a>
                <p class="m-2">Don't have an account? <br> <a href="signup.php" class="btn btn-primary">Sign up now</a>.</p>
            </form>
        </div>
    </div>
</div>
<?php include './footer.php'; ?>