<?php
require_once 'auth.php';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$success = '';
$resetLink = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    
    if (empty($email)) {
        $error = 'Please enter your email address';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address';
    } else {
        $result = createPasswordResetToken($email);
        if ($result['success']) {
            $resetLink = SITE_URL . '/reset-password.php?token=' . $result['token'];
            $success = 'Password reset link generated! (In a real app, this would be sent via email)';
        } else {
            $error = $result['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Auth System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="auth-box">
            <div class="auth-header">
                <h1>Forgot Password?</h1>
                <p>Enter your email to reset your password</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success); ?>
                    <?php if ($resetLink): ?>
                        <div class="reset-link-box">
                            <p><strong>Reset Link:</strong></p>
                            <input type="text" value="<?php echo htmlspecialchars($resetLink); ?>" readonly onclick="this.select();" class="reset-link-input">
                            <small>Copy this link to reset your password. Link expires in 1 hour.</small>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" class="auth-form">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                </div>
                
                <button type="submit" class="btn btn-primary">Send Reset Link</button>
            </form>
            
            <div class="auth-footer">
                <p>Remember your password? <a href="index.php" class="link">Sign In</a></p>
            </div>
        </div>
    </div>
</body>
</html>
