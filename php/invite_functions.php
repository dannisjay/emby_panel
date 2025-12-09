<?php
// /opt/emby_signup/invite_functions.php
// 邀请码相关函数

/**
 * 生成邀请码
 */
function generateInviteCode($length = null, $config = null) {
    if ($config === null) {
        global $config;
    }
    
    $invite_config = $config['invite'];
    $length = $length ?? $invite_config['code_length'];
    $chars = $invite_config['allowed_chars'];
    $code = '';
    
    for ($i = 0; $i < $length; $i++) {
        $code .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $code;
}

/**
 * 加载邀请码列表
 */
function loadInviteCodes($config = null) {
    if ($config === null) {
        global $config;
    }
    
    $user_config = $config['user'];
    
    if (file_exists($user_config['invite_file'])) {
        $data = file_get_contents($user_config['invite_file']);
        return json_decode($data, true) ?: [];
    }
    return [];
}

/**
 * 保存邀请码列表
 */
function saveInviteCodes($codes, $config = null) {
    if ($config === null) {
        global $config;
    }
    
    $user_config = $config['user'];
    file_put_contents($user_config['invite_file'], json_encode($codes, JSON_PRETTY_PRINT));
}

/**
 * 验证邀请码
 */
function validateInviteCode($code, $config = null) {
    if ($config === null) {
        global $config;
    }
    
    $codes = loadInviteCodes($config);
    $code = strtoupper(trim($code));
    if (isset($codes[$code]) && $codes[$code]['used'] === false) {
        return true;
    }
    return false;
}

/**
 * 标记邀请码为已使用
 */
function markInviteCodeUsed($code, $config = null) {
    if ($config === null) {
        global $config;
    }
    
    $codes = loadInviteCodes($config);
    $code = strtoupper(trim($code));
    if (isset($codes[$code])) {
        $codes[$code]['used'] = true;
        $codes[$code]['used_at'] = date('Y-m-d H:i:s');
        saveInviteCodes($codes, $config);
        return true;
    }
    return false;
}

/**
 * 创建邀请码
 */
function createInviteCode($note = '', $config = null) {
    if ($config === null) {
        global $config;
    }
    
    $code = generateInviteCode(null, $config);
    $codes = loadInviteCodes($config);
    
    $codes[$code] = [
        'created_at' => date('Y-m-d H:i:s'),
        'used' => false,
        'used_at' => null,
        'note' => $note
    ];
    
    // 保存到 invite_codes.json 文件
    saveInviteCodes($codes, $config);
    return $code;
}

/**
 * 删除邀请码
 */
function deleteInviteCode($code, $config = null) {
    if ($config === null) {
        global $config;
    }
    
    $codes = loadInviteCodes($config);
    if (isset($codes[$code])) {
        unset($codes[$code]);
        saveInviteCodes($codes, $config);
        return true;
    }
    return false;
}

/**
 * 恢复邀请码状态
 */
function restoreInviteCode($code, $config = null) {
    if ($config === null) {
        global $config;
    }
    
    $codes = loadInviteCodes($config);
    $code = strtoupper(trim($code));
    if (isset($codes[$code])) {
        $codes[$code]['used'] = false;
        $codes[$code]['used_at'] = null;
        saveInviteCodes($codes, $config);
        return true;
    }
    return false;
}

/**
 * 生成注册链接
 */
function generateRegisterLink($invite_code, $config = null) {
    if ($config === null) {
        global $config;
    }
    
    $invite_config = $config['invite'];
    $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $base_url = preg_replace('/\?.*/', '', $base_url);
    
    if ($invite_config['auto_generate_link']) {
        return $base_url . "?invite_code=" . $invite_code;
    }
    
    return $base_url;
}
?>
