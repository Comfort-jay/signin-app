<?php
require_once 'auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Auth System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <nav class="navbar">
            <div class="nav-content">
                <h2>Auth System</h2>
                <a href="logout.php" class="btn btn-secondary">Logout</a>
            </div>
        </nav>
        
        <div class="dashboard-content">
            <div class="welcome-card">
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
                <p class="subtitle">You are successfully logged in</p>
                
                <div class="user-info">
                    <div class="info-item">
                        <span class="info-label">Name:</span>
                        <span class="info-value"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value"><?php echo htmlspecialchars($_SESSION['user_email']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">User ID:</span>
                        <span class="info-value">#<?php echo htmlspecialchars($_SESSION['user_id']); ?></span>
                    </div>
                </div>
                
                <div class="dashboard-actions">
                    <p>This is a protected dashboard page. Only authenticated users can access this page.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
