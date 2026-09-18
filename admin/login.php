<?php
// admin/login.php - Wales & Webs Admin Login
session_start();
require_once __DIR__ . '/../includes/db.php';

// If already logged in, redirect to admin dashboard
if (!empty($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid username or password. Please try again.";
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login — Wales & Webs CMS</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@1,400;1,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #050508;
      background-image: 
        radial-gradient(circle at 20% 30%, rgba(139, 92, 246, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(0, 255, 102, 0.1) 0%, transparent 50%);
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
      padding: 24px;
      color: #e2e8f0;
    }
    .login-card {
      width: 100%;
      max-width: 440px;
      background: rgba(14, 17, 27, 0.92);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 20px;
      padding: 40px 32px;
      box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8), 0 0 35px rgba(139, 92, 246, 0.15);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
    }
    .login-brand {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 24px;
    }
    .brand-icon {
      width: 42px;
      height: 42px;
      border-radius: 10px;
      background: linear-gradient(135deg, #8b5cf6, #00FF66);
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 800;
      color: #050508;
      font-size: 20px;
    }
    .brand-name {
      font-size: 18px;
      font-weight: 700;
      color: #ffffff;
      letter-spacing: -0.3px;
    }
    .brand-sub {
      font-size: 11px;
      color: #94a3b8;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    .login-title {
      font-size: 22px;
      font-weight: 800;
      color: #ffffff;
      margin-bottom: 8px;
    }
    .login-desc {
      font-size: 13.5px;
      color: #94a3b8;
      margin-bottom: 24px;
    }
    .form-group {
      margin-bottom: 18px;
    }
    .form-label {
      display: block;
      font-size: 13px;
      font-weight: 600;
      color: #cbd5e1;
      margin-bottom: 6px;
    }
    .form-input {
      width: 100%;
      background: rgba(5, 7, 13, 0.8);
      border: 1px solid rgba(255, 255, 255, 0.12);
      border-radius: 10px;
      padding: 12px 14px;
      color: #ffffff;
      font-size: 14px;
      transition: all 0.2s;
    }
    .form-input:focus {
      outline: none;
      border-color: #00FF66;
      box-shadow: 0 0 15px rgba(0, 255, 102, 0.2);
    }
    .btn-login {
      width: 100%;
      background: linear-gradient(135deg, #00FF66, #00c74e);
      color: #050508;
      font-weight: 700;
      font-size: 14.5px;
      padding: 14px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      margin-top: 8px;
      transition: transform 0.2s, box-shadow 0.2s;
      box-shadow: 0 8px 25px rgba(0, 255, 102, 0.3);
    }
    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 30px rgba(0, 255, 102, 0.45);
    }
    .alert-error {
      background: rgba(239, 68, 68, 0.15);
      border: 1px solid rgba(239, 68, 68, 0.4);
      color: #f87171;
      padding: 10px 14px;
      border-radius: 8px;
      font-size: 13px;
      margin-bottom: 18px;
    }
    .hint-box {
      margin-top: 24px;
      background: rgba(139, 92, 246, 0.1);
      border: 1px solid rgba(139, 92, 246, 0.25);
      border-radius: 10px;
      padding: 12px 16px;
      font-size: 12.5px;
      color: #c4b5fd;
    }
    .hint-box code {
      background: rgba(0, 0, 0, 0.3);
      padding: 2px 6px;
      border-radius: 4px;
      color: #00FF66;
      font-family: monospace;
      font-weight: bold;
    }
    .back-home {
      display: inline-block;
      margin-top: 18px;
      font-size: 13px;
      color: #94a3b8;
      text-decoration: none;
      transition: color 0.2s;
    }
    .back-home:hover {
      color: #00FF66;
    }
  </style>
</head>
<body>

  <div class="login-card">
    <div class="login-brand">
      <div class="brand-icon">W</div>
      <div>
        <div class="brand-name">Wales & Webs</div>
        <div class="brand-sub">Build · Automate · Grow</div>
      </div>
    </div>

    <h1 class="login-title">Admin Dashboard</h1>
    <p class="login-desc">Sign in to manage portfolio case studies, blog posts, and site content.</p>

    <?php if (!empty($error)): ?>
      <div class="alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
      <div class="form-group">
        <label class="form-label" for="username">Username</label>
        <input type="text" id="username" name="username" class="form-input" required autocomplete="username" placeholder="admin" value="admin">
      </div>

      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <input type="password" id="password" name="password" class="form-input" required autocomplete="current-password" placeholder="••••••••" value="admin123">
      </div>

      <button type="submit" class="btn-login">Sign In to Dashboard &rarr;</button>
    </form>

    <div class="hint-box">
      <strong>Default Credentials:</strong><br>
      Username: <code>admin</code> &nbsp;|&nbsp; Password: <code>admin123</code>
    </div>

    <div style="text-align: center;">
      <a href="../index.php" class="back-home">&larr; Return to Wales & Webs Homepage</a>
    </div>
  </div>

</body>
</html>
