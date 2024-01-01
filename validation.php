<!-- Password check as user types -->
<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
    <label>Password</label>
    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,16}$">
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


<!-- Email checks as user types -->
<div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
    <label>Email</label>
    <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
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

<!-- Username Checks as user types -->
<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
    <label>Username</label>
    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
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