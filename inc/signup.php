<?php
include 'config.php';

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
                // Send email for successful creation
                require './PHPMailer/src/PHPMailer.php';
                require './PHPMailer/src/SMTP.php';
                require './PHPMailer/src/Exception.php';

                $mail = new PHPMailer\PHPMailer\PHPMailer(true);

                try {
                    $mail->SMTPDebug = 2;
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'aderomourice7@gmail.com';
                    $mail->Password   = 'xlgjtfeubzpmtgjp';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port       = 587;

                    $mail->setFrom('aderomourice7@gmail.com', 'Megamind Library');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = 'Account Creation';
                    $mail->Body    = "<p>You have successfully signed up to Meganind Library website!</p> <p>Welcome! <br> Find amaizing readers contents from our website</p>";

                    if ($mail->send()) {
                        echo "<script>alert('Your account has been created successfully. Check your email!')</script>";
                        header("location: login.php");
                    }
                    exit();
                } catch (Exception $e) {
                    $email_err = "An error occurred while sending the email: " . $mail->ErrorInfo;
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            $stmt->close();
        }
    }

    $conn->close();
}
?>

<?php include 'header.php'; ?>
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
                            <input required type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span id="email-help" class="help-block text-warning"><?php echo $email_err; ?></span>
                        </div>

                        <script>
                            const emailInput = document.querySelector('input[name="email"]');
                            const emailHelp = document.querySelector('#email-help');
                            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                            emailInput.addEventListener('input', () => {
                                const email = emailInput.value;

                                if (!emailPattern.test(email)) {
                                    emailHelp.textContent = 'Please enter a valid email address.';
                                    emailHelp.classList.add('text-danger');
                                } else {
                                    emailHelp.textContent = '';
                                    emailHelp.classList.remove('text-danger');
                                }
                            });
                        </script>

                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>Username</label>
                            <input required type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                            <span id="username-help" class="help-block text-warning"><?php echo $username_err; ?></span>
                        </div>

                        <script>
                            const usernameInput = document.querySelector('input[name="username"]');
                            const usernameHelp = document.querySelector('#username-help');

                            usernameInput.addEventListener('input', () => {
                                const username = usernameInput.value;

                                if (/\d/.test(username)) {
                                    usernameHelp.textContent = 'Username must not contain any numbers.';
                                    usernameHelp.classList.add('text-danger');
                                } else {
                                    usernameHelp.textContent = '';
                                    usernameHelp.classList.remove('text-danger');
                                }
                            });
                        </script>

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
                            <input required type="password" name="password" class="form-control" value="<?php echo $password; ?>" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,16}$">
                            <span id="password-help" class="help-block text-warning"><?php echo $password_err; ?></span>
                        </div>

                        <script>
                            const passwordInput = document.querySelector('input[name="password"]');
                            const passwordHelp = document.querySelector('#password-help');
                            const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,16}$/;

                            passwordInput.addEventListener('input', () => {
                                const password = passwordInput.value;
                                const errors = [];

                                if (!passwordPattern.test(password)) {
                                    if (password.length < 8) {
                                        errors.push('Password must be at least 8 characters.');
                                    } else if (password.length > 16) {
                                        errors.push('Password must be no more than 16 characters.');
                                    }
                                    if (!/[a-z]/.test(password)) {
                                        errors.push('Password must contain at least one lowercase letter.');
                                    }
                                    if (!/[A-Z]/.test(password)) {
                                        errors.push('Password must contain at least one uppercase letter.');
                                    }
                                    if (!/[0-9]/.test(password)) {
                                        errors.push('Password must contain at least one number.');
                                    }
                                    if (!/[!@#$%^&*_=+-]/.test(password)) {
                                        errors.push('Password must contain at least one special character (!@#$%^&*_=+-).');
                                    }
                                }

                                if (errors.length > 0) {
                                    passwordHelp.textContent = errors.join(' ');
                                    passwordHelp.classList.add('text-danger');
                                } else {
                                    passwordHelp.textContent = '';
                                    passwordHelp.classList.remove('text-danger');
                                }
                            });
                        </script>

                        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                            <label>Confirm Password</label>
                            <input required type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                            <span class="help-block text-warning"><?php echo $confirm_password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input required type="submit" class="btn btn-primary m-2" value="Submit">
                            <input required type="reset" class="btn btn-default m-2" value="Reset">
                        </div>
                        <p class="m-2">Already have an account? <br><a href="login.php" class="btn btn-primary">Login here</a>.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php include 'footer.php'; ?>