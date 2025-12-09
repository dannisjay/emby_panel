<?php
// 获取统计信息
// 由于此文件在 templates 目录，需要回到上级目录查找文件
require_once __DIR__ . '/../emby_functions.php';
require_once __DIR__ . '/../invite_functions.php';
$config = include __DIR__ . '/../config.php';

$users = get_all_users();
list($library_map) = get_all_libraries();

// 加载邀请码列表
$invite_codes = loadInviteCodes($config);

$total_users = count($users);
$total_libraries = count($library_map);
$unused_codes = 0;
foreach ($invite_codes as $code_info) {
    if (!$code_info['used']) {
        $unused_codes++;
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emby 综合管理面板</title>
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
            background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), 
            url('<?php echo $config['site']['custom_image']; ?>') center/cover no-repeat fixed;
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }

        .header h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .header p {
            opacity: 0.8;
            font-size: 18px;
        }

        .dashboard {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h3 {
            color: #6b7280;
            font-size: 16px;
            margin-bottom: 15px;
            font-weight: 500;
        }

        .stat-card p {
            font-size: 42px;
            font-weight: 700;
            color: #374151;
        }

        .stat-card.user-count p {
            color: #667eea;
        }

        .stat-card.library-count p {
            color: #10b981;
        }

        .stat-card.invite-count p {
            color: #f59e0b;
        }

        .quick-actions {
            background: white;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .quick-actions h2 {
            margin-bottom: 30px;
            color: #374151;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 15px;
        }

        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .action-card {
            background: #f9fafb;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            text-decoration: none;
            color: #374151;
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .action-card:hover {
            background: #eff6ff;
            border-color: #667eea;
            transform: translateY(-3px);
        }

        .action-card .icon {
            font-size: 36px;
            margin-bottom: 15px;
        }

        .action-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #374151;
        }

        .action-card p {
            color: #6b7280;
            font-size: 14px;
        }

        .recent-activity {
            background: white;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .recent-activity h2 {
            margin-bottom: 30px;
            color: #374151;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 15px;
        }

        .activity-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .activity-item {
            display: flex;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #f3f4f6;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-item .icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            font-size: 20px;
        }

        .activity-item.user .icon {
            background: #dbeafe;
            color: #3b82f6;
        }

        .activity-item.invite .icon {
            background: #dcfce7;
            color: #10b981;
        }

        .activity-item.media .icon {
            background: #fef3c7;
            color: #f59e0b;
        }

        .activity-info {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .activity-time {
            color: #9ca3af;
            font-size: 14px;
        }

        .activity-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-success {
            background: #d1fae5;
            color: #065f46;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .nav-footer {
            text-align: center;
            margin-top: 30px;
        }

        .nav-footer a {
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        .nav-footer a:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .dashboard {
                grid-template-columns: 1fr;
            }
            
            .action-grid {
                grid-template-columns: 1fr;
            }
            
            .container {
                padding: 10px;
            }
            
            .stat-card, .quick-actions, .recent-activity {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Emby 综合管理面板</h1>
            <p>统一管理系统，一切尽在掌握</p>
        </div>

        <div class="dashboard">
            <div class="stat-card user-count">
                <h3>用户总数</h3>
                <p><?php echo $total_users; ?></p>
            </div>
            <div class="stat-card library-count">
                <h3>媒体库数量</h3>
                <p><?php echo $total_libraries; ?></p>
            </div>
            <div class="stat-card invite-count">
                <h3>可用邀请码</h3>
                <p><?php echo $unused_codes; ?></p>
            </div>
        </div>

        <div class="quick-actions">
            <h2>快速操作</h2>
            <div class="action-grid">
                <a href="index.php?admin=1" class="action-card">
                    <div class="icon">📋</div>
                    <h3>邀请码管理</h3>
                    <p>生成、删除和管理邀请码</p>
                </a>
                <a href="user_manager.php" class="action-card">
                    <div class="icon">👥</div>
                    <h3>用户管理</h3>
                    <p>管理所有用户账户和权限</p>
                </a>
                <a href="media_manager.php" class="action-card">
                    <div class="icon">📁</div>
                    <h3>媒体库权限</h3>
                    <p>管理用户媒体库访问权限</p>
                </a>
                <a href="index.php" class="action-card">
                    <div class="icon">👥</div>
                    <h3>用户注册页面</h3>
                    <p>查看用户注册界面</p>
                </a>
            </div>
        </div>

        <div class="recent-activity">
            <h2>最近活动</h2>
            <div class="activity-list">
                <?php
                // 显示最近的邀请码活动
                $recent_codes = array_slice($invite_codes, -5, 5, true);
                $recent_codes = array_reverse($recent_codes, true);
                
                foreach ($recent_codes as $code => $info):
                ?>
                <div class="activity-item invite">
                    <div class="icon">🎫</div>
                    <div class="activity-info">
                        <div class="activity-title">
                            邀请码 <?php echo $code; ?> <?php echo $info['used'] ? '已使用' : '已创建'; ?>
                        </div>
                        <div class="activity-time">
                            <?php echo $info[$info['used'] ? 'used_at' : 'created_at']; ?>
                            <?php if (!empty($info['note'])): ?>
                                - <?php echo htmlspecialchars($info['note']); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="activity-status <?php echo $info['used'] ? 'status-success' : 'status-pending'; ?>">
                        <?php echo $info['used'] ? '已使用' : '未使用'; ?>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <?php if (empty($recent_codes)): ?>
                <div style="text-align: center; padding: 40px; color: #9ca3af;">
                    暂无活动记录
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="nav-footer">
        </div>
    </div>
</body>
</html>
