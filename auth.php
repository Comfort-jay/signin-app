<?php
require_once 'db.php';

function registerUser($email, $password, $name) {
    $db = getDBConnection();
    
    $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        return ['success' => false, 'message' => 'Email already registered'];
    }
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    try {
        $stmt = $db->prepare("INSERT INTO users (email, password, name) VALUES (?, ?, ?)");
        $stmt->execute([$email, $hashedPassword, $name]);
        return ['success' => true, 'message' => 'Registration successful'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Registration failed'];
    }
}

function loginUser($email, $password) {
    $db = getDBConnection();
    
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];
        return ['success' => true, 'message' => 'Login successful'];
    }
    
    return ['success' => false, 'message' => 'Invalid email or password'];
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: index.php');
        exit;
    }
}

function logout() {
    session_destroy();
    header('Location: index.php');
    exit;
}

function createPasswordResetToken($email) {
    $db = getDBConnection();
    
    $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if (!$stmt->fetch()) {
        return ['success' => false, 'message' => 'Email not found'];
    }
    
    $token = bin2hex(random_bytes(32));
    $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
    $stmt = $db->prepare("DELETE FROM password_resets WHERE email = ?");
    $stmt->execute([$email]);
    
    $stmt = $db->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
    $stmt->execute([$email, $token, $expiresAt]);
    
    return ['success' => true, 'token' => $token, 'message' => 'Password reset token created'];
}

function verifyResetToken($token) {
    $db = getDBConnection();
    
    $stmt = $db->prepare("SELECT email, expires_at FROM password_resets WHERE token = ?");
    $stmt->execute([$token]);
    $reset = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$reset) {
        return ['valid' => false, 'message' => 'Invalid token'];
    }
    
    if (strtotime($reset['expires_at']) < time()) {
        return ['valid' => false, 'message' => 'Token expired'];
    }
    
    return ['valid' => true, 'email' => $reset['email']];
}

function resetPassword($token, $newPassword) {
    $verification = verifyResetToken($token);
    
    if (!$verification['valid']) {
        return $verification;
    }
    
    $db = getDBConnection();
    $email = $verification['email'];
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
    $stmt = $db->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->execute([$hashedPassword, $email]);
    
    $stmt = $db->prepare("DELETE FROM password_resets WHERE email = ?");
    $stmt->execute([$email]);
    
    return ['success' => true, 'message' => 'Password reset successful'];
}
?>
