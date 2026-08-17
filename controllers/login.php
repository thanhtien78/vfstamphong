<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db.php';

// Redirect to admin if session is active
if (isset($_SESSION['user_id'])) {
    $basePath = $basePath ?? rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
    header('Location: ' . $basePath . '/admin');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    
    if ($username && $password) {
        try {
            $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['fullname'] = $user['fullname'];
                $basePath = $basePath ?? rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
                header('Location: ' . $basePath . '/admin');
                exit;
            } else {
                $error = 'Tên đăng nhập hoặc mật khẩu không chính xác!';
            }
        } catch (PDOException $e) {
            $error = 'Cơ sở dữ liệu chưa được khởi tạo. <a href="admin/migrate.php" style="color: var(--color-primary); text-decoration: underline; font-weight: 600;">Nhấp vào đây để chạy cài đặt di trú (Migration)</a>';
        }
    } else {
        $error = 'Vui lòng nhập đầy đủ thông tin!';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VinFast VN - Đăng nhập hệ thống CMS</title>
  <link rel="icon" type="image/x-icon" href="assets/favicon/favicon.ico">
  <style>
    /* Google Fonts & Premium Automotive Typography */
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700;800&display=swap");

    @font-face {
      font-family: 'VinFastType';
      src: url('assets/fonts/VinFastTypeVF.woff2') format('woff2-variations');
      font-display: swap;
      font-style: normal;
      font-stretch: 100% 130%;
    }

    :root {
      --color-surface-dark: hsla(216, 23%, 8%, 1);
      --color-bg-card: hsla(216, 20%, 12%, 0.85);
      --color-bg-input: hsla(216, 21%, 15%, 0.8);
      --color-text-white: hsla(216, 33%, 99%, 1);
      --color-text-muted: hsla(216, 33%, 99%, 0.7);
      --color-border: hsla(216, 18%, 21%, 1);
      --color-primary: #0ea5e9;
      --color-primary-glow: rgba(14, 165, 233, 0.3);
      --transition-speed: 250ms;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    /* Core Unified Typography System */
    body {
      font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, sans-serif;
      background-color: var(--color-surface-dark);
      background-image: radial-gradient(circle at top right, rgba(14, 165, 233, 0.06), transparent 400px),
                        radial-gradient(circle at bottom left, rgba(0, 74, 181, 0.06), transparent 400px);
      color: var(--color-text-white);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 16px;
    }

    h1, h2, h3, h4, h5, h6,
    .login-title, .login-subtitle, .form-label, .btn-submit, button {
      font-family: 'Montserrat', sans-serif !important;
      letter-spacing: 0.5px;
      font-weight: 700 !important;
    }

    .login-container {
      width: 100%;
      max-width: 420px;
      background: var(--color-bg-card);
      backdrop-filter: blur(30px);
      -webkit-backdrop-filter: blur(30px);
      border: 1px solid var(--color-border);
      border-radius: 16px;
      padding: 40px;
      box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5);
      display: flex;
      flex-direction: column;
      gap: 32px;
      position: relative;
    }

    .login-container::before {
      content: '';
      position: absolute;
      top: 0; left: 0; width: 100%; height: 3px;
      background: linear-gradient(90deg, transparent, var(--color-primary), transparent);
    }

    .login-header {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 16px;
      text-align: center;
    }

    .login-logo {
      color: var(--color-text-white);
    }

    .login-title {
      font-size: 20px;
      font-weight: 400;
      letter-spacing: 1px;
      font-stretch: 110%;
    }

    .login-subtitle {
      font-size: 12px;
      color: var(--color-text-muted);
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 8px;
      margin-bottom: 20px;
    }

    .form-label {
      font-size: 11px;
      font-weight: 600;
      color: var(--color-text-muted);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .form-input {
      background: var(--color-bg-input);
      border: 1px solid var(--color-border);
      color: var(--color-text-white);
      padding: 14px 16px;
      border-radius: 8px;
      font-size: 14px;
      font-family: inherit;
      transition: all var(--transition-speed);
      width: 100%;
    }

    .form-input:focus {
      outline: none;
      border-color: var(--color-primary);
      box-shadow: 0 0 10px rgba(25, 96, 215, 0.15);
      background: rgba(30, 38, 52, 0.95);
    }

    .btn-login {
      background: rgba(18, 24, 38, 0.9);
      border: 1px solid var(--color-primary);
      color: var(--color-primary);
      padding: 16px;
      border-radius: 8px;
      font-size: 13px;
      font-weight: 700;
      letter-spacing: 2px;
      cursor: pointer;
      text-transform: uppercase;
      transition: all var(--transition-speed);
      box-shadow: 0 0 15px var(--color-primary-glow);
      width: 100%;
      margin-top: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      font-family: inherit;
    }

    .btn-login:hover {
      background: var(--color-primary);
      color: #000;
      box-shadow: 0 0 25px rgba(14, 165, 233, 0.6);
      transform: translateY(-2px);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .error-msg {
      background: rgba(239, 83, 80, 0.1);
      border: 1px solid rgba(239, 83, 80, 0.3);
      color: #ff8a80;
      padding: 12px;
      border-radius: 8px;
      font-size: 13px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
  </style>
</head>
<body>

  <div class="login-container">
    
    <div class="login-header">
      <div class="login-logo">
        <svg viewBox="0 0 100 35" width="80" height="26" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="16" cy="17.5" r="12" />
          <circle cx="37" cy="17.5" r="12" />
          <circle cx="58" cy="17.5" r="12" />
          <circle cx="79" cy="17.5" r="12" />
        </svg>
      </div>
      <div>
        <h1 class="login-title">Hệ thống quản trị CMS</h1>
        <p class="login-subtitle">Đăng nhập tài khoản</p>
      </div>
    </div>

    <!-- Error message element -->
    <?php if ($error): ?>
    <div class="error-msg" id="error-box">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="18" height="18">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
      </svg>
      <span id="error-text"><?php echo $error; ?></span>
    </div>
    <?php endif; ?>

    <form method="POST" action="login.php" id="login-form">
      <div class="form-group">
        <label class="form-label" for="username">Tên đăng nhập</label>
        <input class="form-input" type="text" name="username" id="username" autocomplete="username" placeholder="Nhập tài khoản" required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
      </div>

      <div class="form-group">
        <label class="form-label" for="password">Mật khẩu</label>
        <input class="form-input" type="password" name="password" id="password" autocomplete="current-password" placeholder="••••••••" required>
      </div>

      <button class="btn-login" type="submit">
        <span>Đăng nhập</span>
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" width="16" height="16">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h16.5a1.5 1.5 0 0 0 1.5-1.5V12a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 12v8.25a1.5 1.5 0 0 0 1.5 1.5Z" />
        </svg>
      </button>
    </form>

  </div>

</body>
</html>




