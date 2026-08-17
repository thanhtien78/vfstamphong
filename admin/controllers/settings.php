<?php
    // MODULE 7: SETTINGS & ROLE MANAGEMENT
    // ==========================================
    if ($page === 'settings') {
        // Security Gate: Restrict administrative actions to Quản trị viên role only
        $sensitiveActions = ['create_user', 'edit_user', 'delete_user', 'save_agency', 'save_sidebar_privilege', 'save_custom_codes', 'save_integrations'];
        if (in_array($action, $sensitiveActions) && ($currentUser['role'] ?? '') !== 'Quản trị viên') {
            $errorMessage = 'Bạn không có quyền thực hiện chức năng cấu hình hệ thống này!';
            return;
        }

        if ($action === 'create_user') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $fullname = trim($_POST['fullname']);
            $role = trim($_POST['role']);

            if ($username && $password) {
                try {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $db->prepare("INSERT INTO users (username, password, fullname, role) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$username, $hash, $fullname, $role]);
                    logActivity('Tạo tài khoản quản lý', "Tạo user: $username, Vai trò: $role");
                    $successMessage = 'Tạo tài khoản quản lý nhân viên thành công!';
                } catch (Exception $e) {
                    $errorMessage = 'Tên đăng nhập đã tồn tại trên hệ thống!';
                }
            }
        }
        if ($action === 'edit_user') {
            $targetId = (int)$_POST['id'];
            $username = trim($_POST['username']);
            $fullname = trim($_POST['fullname']);
            $role = trim($_POST['role']);
            $password = trim($_POST['password']);

            if ($username) {
                try {
                    if ($password) {
                        $hash = password_hash($password, PASSWORD_DEFAULT);
                        $stmt = $db->prepare("UPDATE users SET username = ?, password = ?, fullname = ?, role = ? WHERE id = ?");
                        $stmt->execute([$username, $hash, $fullname, $role, $targetId]);
                    } else {
                        $stmt = $db->prepare("UPDATE users SET username = ?, fullname = ?, role = ? WHERE id = ?");
                        $stmt->execute([$username, $fullname, $role, $targetId]);
                    }
                    logActivity('Cập nhật tài khoản quản lý', "Cập nhật user ID #$targetId ($username)");
                    $successMessage = 'Cập nhật thông tin tài khoản thành công!';
                } catch (Exception $e) {
                    $errorMessage = 'Tên đăng nhập đã trùng hoặc có lỗi xảy ra!';
                }
            }
        }
        if ($action === 'delete_user') {
            $targetId = (int)$_POST['id'];
            if ($targetId !== $userId) {
                $db->prepare("DELETE FROM users WHERE id = ?")->execute([$targetId]);
                logActivity('Xóa tài khoản quản lý', "Xóa user ID #$targetId");
                $successMessage = 'Đã xóa tài khoản nhân viên khỏi hệ thống phân quyền!';
            } else {
                $errorMessage = 'Bạn không thể tự xóa tài khoản của chính mình!';
            }
        }
        if ($action === 'save_agency') {
            $agency_name = trim($_POST['agency_name']);
            $agency_phone = trim($_POST['agency_phone']);
            $agency_address = trim($_POST['agency_address']);
            $agency_hours = trim($_POST['agency_hours']);

            $stmt = $db->prepare("REPLACE INTO settings (`key`, `value`) VALUES (?, ?)");
            $stmt->execute(['agency_name', $agency_name]);
            $stmt->execute(['agency_phone', $agency_phone]);
            $stmt->execute(['agency_address', $agency_address]);
            $stmt->execute(['agency_hours', $agency_hours]);
            logActivity('Cập nhật Cấu hình Đại lý', "Cập nhật thông tin đại lý: $agency_name");
            $successMessage = 'Cập nhật thông tin cấu hình đại lý phân phối thành công!';
        }
        if ($action === 'save_sidebar_privilege') {
            $sidebar_privilege_tag = trim($_POST['sidebar_privilege_tag']);
            $sidebar_privilege_title = trim($_POST['sidebar_privilege_title']);
            $sidebar_privilege_item1 = trim($_POST['sidebar_privilege_item1']);
            $sidebar_privilege_item2 = trim($_POST['sidebar_privilege_item2']);
            $sidebar_privilege_item3 = trim($_POST['sidebar_privilege_item3']);
            $sidebar_privilege_btn = trim($_POST['sidebar_privilege_btn']);

            $stmt = $db->prepare("REPLACE INTO settings (`key`, `value`) VALUES (?, ?)");
            $stmt->execute(['sidebar_privilege_tag', $sidebar_privilege_tag]);
            $stmt->execute(['sidebar_privilege_title', $sidebar_privilege_title]);
            $stmt->execute(['sidebar_privilege_item1', $sidebar_privilege_item1]);
            $stmt->execute(['sidebar_privilege_item2', $sidebar_privilege_item2]);
            $stmt->execute(['sidebar_privilege_item3', $sidebar_privilege_item3]);
            $stmt->execute(['sidebar_privilege_btn', $sidebar_privilege_btn]);
            logActivity('Cập nhật Đặc quyền Sidebar', "Cập nhật Đặc quyền VIP: $sidebar_privilege_title");
            $successMessage = 'Cập nhật thông tin đặc quyền VIP ở thanh bên thành công!';
        }
        if ($action === 'save_custom_codes') {
            $custom_header_code = trim($_POST['custom_header_code']);
            $custom_body_code = trim($_POST['custom_body_code']);
            $custom_footer_code = trim($_POST['custom_footer_code']);

            $stmt = $db->prepare("REPLACE INTO settings (`key`, `value`) VALUES (?, ?)");
            $stmt->execute(['custom_header_code', $custom_header_code]);
            $stmt->execute(['custom_body_code', $custom_body_code]);
            $stmt->execute(['custom_footer_code', $custom_footer_code]);
            logActivity('Cập nhật Mã nhúng Custom Scripts', 'Cập nhật mã nhúng Header, Body, Footer');
            $successMessage = 'Cập nhật các đoạn mã nhúng tùy chọn (Header, Body, Footer) thành công!';
        }
        if ($action === 'change_personal_password') {
            $old_password = trim($_POST['old_password']);
            $new_password = trim($_POST['new_password']);
            $confirm_password = trim($_POST['confirm_password']);

            // Temporary diagnostic logging
            $debugLog = date('[Y-m-d H:i:s] ') . "Attempt for user: " . ($currentUser['username'] ?? 'NULL') . " (ID: $userId)\n";
            $debugLog .= "Inputs: old_pass=" . (empty($old_password) ? 'EMPTY' : 'OK') . ", new_pass=" . (empty($new_password) ? 'EMPTY' : 'OK') . ", confirm=" . (empty($confirm_password) ? 'EMPTY' : 'OK') . "\n";
            $pwdMatch = password_verify($old_password, $currentUser['password'] ?? '');
            $debugLog .= "password_verify check: " . ($pwdMatch ? 'SUCCESS' : 'FAILED') . "\n";

            if ($old_password && $new_password && $confirm_password) {
                if ($new_password !== $confirm_password) {
                    $errorMessage = 'Mật khẩu mới và xác nhận mật khẩu không khớp!';
                    $debugLog .= "Result: error - new passwords do not match\n";
                } else {
                    if ($pwdMatch) {
                        $hash = password_hash($new_password, PASSWORD_DEFAULT);
                        $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
                        $stmt->execute([$hash, $userId]);
                        logActivity('Đổi mật khẩu cá nhân', "Đổi mật khẩu tài khoản: " . $currentUser['username']);
                        $successMessage = 'Đổi mật khẩu cá nhân thành công!';
                        $debugLog .= "Result: success - database updated\n";
                    } else {
                        $errorMessage = 'Mật khẩu hiện tại không chính xác!';
                        $debugLog .= "Result: error - current password incorrect\n";
                    }
                }
            } else {
                $errorMessage = 'Vui lòng điền đầy đủ tất cả các trường mật khẩu!';
                $debugLog .= "Result: error - empty fields\n";
            }
            
            @file_put_contents('C:/laragon/www/vfstamphong/scratch/pwd_debug.log', $debugLog . "-----------------------------------\n", FILE_APPEND);
        }
        if ($action === 'save_integrations') {
            $sms_gateway = trim($_POST['sms_gateway']);
            $sms_apikey = trim($_POST['sms_apikey']);
            $email_smtp_host = trim($_POST['email_smtp_host']);
            $email_smtp_user = trim($_POST['email_smtp_user']);
            $telegram_bot_token = trim($_POST['telegram_bot_token'] ?? '');
            $telegram_chat_id = trim($_POST['telegram_chat_id'] ?? '');

            $stmt = $db->prepare("REPLACE INTO settings (`key`, `value`) VALUES (?, ?)");
            $stmt->execute(['sms_gateway', $sms_gateway]);
            $stmt->execute(['sms_apikey', $sms_apikey]);
            $stmt->execute(['email_smtp_host', $email_smtp_host]);
            $stmt->execute(['email_smtp_user', $email_smtp_user]);
            $stmt->execute(['telegram_bot_token', $telegram_bot_token]);
            $stmt->execute(['telegram_chat_id', $telegram_chat_id]);
            logActivity('Cập nhật cấu hình tích hợp APIs', 'Cập nhật SMS Gateway, Email SMTP và Telegram settings');
            $successMessage = 'Cập nhật thông số tích hợp hệ thống (APIs) thành công!';
        }
    }






