<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $config['site']['title']; ?></title>
    <link rel="icon" type="image/png" href="<?php echo $config['site']['favicon']; ?>" sizes="32x32">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: <?php echo $config['site']['theme']['primary_gradient']; ?>;
            min-height: 100vh;
            display: flex;
            color: #333;
        }

        .container {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        .image-section {
            flex: 1;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.9) 0%, rgba(118, 75, 162, 0.9) 100%);
            position: relative;
            overflow: hidden;
        }

        .background-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.1);
            z-index: 10;
        }

        .form-section {
            flex: 0 0 500px;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            overflow-y: auto;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo-section img {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .logo-section h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 8px;
        }

        .logo-section p {
            font-size: 1rem;
            color: #6b7280;
            font-weight: 400;
        }

        .form-container {
            width: 100%;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #374151;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f9fafb;
            font-family: inherit;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group input[type="submit"], .btn {
            background: <?php echo $config['site']['theme']['primary_gradient']; ?>;
            color: white;
            cursor: pointer;
            font-weight: 600;
            border: none;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            padding: 16px 24px;
            border-radius: 12px;
            width: 100%;
        }

        .form-group input[type="submit"]:hover, .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .login-link {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #e5e7eb;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .admin-link {
            text-align: center;
            margin-top: 15px;
        }

        .admin-btn {
            display: inline-block;
            background: rgba(110, 126, 234, 1);
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 500;
            border: 1px solid rgba(255,255,255,0.3);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .admin-btn:hover {
            background: rgba(255,255,255,0.25);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            color: white;
        }

        .message {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: <?php echo $config['site']['theme']['error_color']; ?>;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .success {
            background: #d1fae5;
            border: 1px solid #a7f3d0;
            color: <?php echo $config['site']['theme']['success_color']; ?>;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .success a {
            color: #065f46;
            text-decoration: underline;
            font-weight: bold;
        }

        .success a:hover {
            color: #047857;
        }

        .form-group label[for="passwd"]::after,
        .form-group label[for="confirm_passwd"]::after,
        .form-group label[for="invite_code"]::after {
            content: " *";
            color: <?php echo $config['site']['theme']['error_color']; ?>;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                position: relative;
                min-height: 100vh;
            }
    
            .image-section {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 1;
            }
     
            .form-section {
                position: relative;
                z-index: 2;
                background: rgba(255, 255, 255, 0.4);
                backdrop-filter: blur(10px);
                margin: 20px;
                border-radius: 20px;
                flex: none;
                padding: 30px;
            }
    
            .brand-text {
                top: 20px;
                right: 20px;
                font-size: 1.5rem;
            }
    
            .image-overlay {
                background: rgba(0, 0, 0, 0.2);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- 左侧图片区域 -->
        <div class="image-section">
            <img src="<?php echo $config['site']['custom_image']; ?>" alt="背景图片" class="background-image">
            <div class="image-overlay">
                 <!-- 文字已移除 -->
            </div>
        </div>

        <!-- 右侧表单区域 -->
        <div class="form-section">
            <div class="logo-section">
                <img src="<?php echo $config['site']['favicon']; ?>" alt="Logo">
                <h1><?php echo $config['site']['name']; ?></h1>
                <p>创建您的媒体账户</p>
            </div>

            <div class="form-container">
                <?php if (isset($message)): ?>
                    <div class="<?php echo strpos($message, '完成') !== false ? 'success' : 'message'; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="">
                    <div class="form-group">
                        <label for="invite_code">邀请码</label>
                        <input type="text" id="invite_code" name="invite_code" required placeholder="请输入邀请码" style="text-transform: uppercase;">
                    </div>
                    <div class="form-group">
                        <label for="username">用户名</label>
                        <input type="text" id="username" name="username" required placeholder="仅限字母和数字" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="passwd">密码</label>
                        <input type="password" id="passwd" name="passwd" required placeholder="请输入密码">
                    </div>
                    <div class="form-group">
                        <label for="confirm_passwd">确认密码</label>
                        <input type="password" id="confirm_passwd" name="confirm_passwd" required placeholder="请再次输入密码">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="创建账户">
                    </div>
                </form>

                <!-- 登录链接 -->
                <div class="login-link">
                    <a href="<?php echo $config['site']['emby_login_url']; ?>">已有账户？点击登录</a>
                </div>

                <!-- 管理员入口 -->
                <div class="admin-link">
                    <a href="?admin=1&page=dashboard" class="admin-btn">🔑 Admin</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // 自动填充邀请码
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const inviteCode = urlParams.get('invite_code');
            if (inviteCode) {
                document.getElementById('invite_code').value = inviteCode.toUpperCase();
            }
        });
    </script>
</body>
</html>
