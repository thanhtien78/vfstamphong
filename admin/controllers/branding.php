<?php
    if ($page === 'branding') {
        if ($action === 'save_branding') {
            // Header & SEO
            $site_title = trim($_POST['site_title']);
            $site_desc = trim($_POST['site_desc']);
            $site_keywords = trim($_POST['site_keywords']);
            $agency_phone = trim($_POST['agency_phone']);

            // Socials
            $footer_facebook = trim($_POST['footer_facebook']);
            $footer_instagram = trim($_POST['footer_instagram']);
            $footer_youtube = trim($_POST['footer_youtube']);

            // Footer & Showroom & Legal
            $footer_tagline = trim($_POST['footer_tagline']);
            $footer_copyright = trim($_POST['footer_copyright']);
            $agency_name = trim($_POST['agency_name']);
            $agency_email = trim($_POST['agency_email']);
            $agency_address = trim($_POST['agency_address']);
            $agency_hours = trim($_POST['agency_hours']);
            
            $policy_privacy_link = trim($_POST['policy_privacy_link']);
            $policy_terms_link = trim($_POST['policy_terms_link']);
            $portal_cms_link = trim($_POST['portal_cms_link']);

 
            // Save Footer Quick Links Column 2
            $footer_col2_title = trim($_POST['footer_col2_title']);
            $footer_col2_link1_text = trim($_POST['footer_col2_link1_text']);
            $footer_col2_link1_url = trim($_POST['footer_col2_link1_url']);
            $footer_col2_link2_text = trim($_POST['footer_col2_link2_text']);
            $footer_col2_link2_url = trim($_POST['footer_col2_link2_url']);
            $footer_col2_link3_text = trim($_POST['footer_col2_link3_text']);
            $footer_col2_link3_url = trim($_POST['footer_col2_link3_url']);
            $footer_col2_link4_text = trim($_POST['footer_col2_link4_text']);
            $footer_col2_link4_url = trim($_POST['footer_col2_link4_url']);
 
            // Footer Quick Links Column 3
            $footer_col3_title = trim($_POST['footer_col3_title']);
            $footer_col3_link1_text = trim($_POST['footer_col3_link1_text']);
            $footer_col3_link1_url = trim($_POST['footer_col3_link1_url']);
            $footer_col3_link2_text = trim($_POST['footer_col3_link2_text']);
            $footer_col3_link2_url = trim($_POST['footer_col3_link2_url']);
            $footer_col3_link3_text = trim($_POST['footer_col3_link3_text']);
            $footer_col3_link3_url = trim($_POST['footer_col3_link3_url']);
            $footer_col3_link4_text = trim($_POST['footer_col3_link4_text']);
            $footer_col3_link4_url = trim($_POST['footer_col3_link4_url']);
 
            $stmt = $db->prepare("REPLACE INTO settings (`key`, `value`) VALUES (?, ?)");
            $stmt->execute(['site_title', $site_title]);
            $stmt->execute(['site_desc', $site_desc]);
            $stmt->execute(['site_keywords', $site_keywords]);
            $stmt->execute(['agency_phone', $agency_phone]);
            $stmt->execute(['footer_facebook', $footer_facebook]);
            $stmt->execute(['footer_instagram', $footer_instagram]);
            $stmt->execute(['footer_youtube', $footer_youtube]);
            $stmt->execute(['footer_tagline', $footer_tagline]);
            $stmt->execute(['footer_copyright', $footer_copyright]);
            $stmt->execute(['agency_name', $agency_name]);
            $stmt->execute(['agency_email', $agency_email]);
            $stmt->execute(['agency_address', $agency_address]);
            $stmt->execute(['agency_hours', $agency_hours]);
            $stmt->execute(['policy_privacy_link', $policy_privacy_link]);
            $stmt->execute(['policy_terms_link', $policy_terms_link]);
            $stmt->execute(['portal_cms_link', $portal_cms_link]);
            

            // Save Footer Quick Links Column 2
            $stmt->execute(['footer_col2_title', $footer_col2_title]);
            $stmt->execute(['footer_col2_link1_text', $footer_col2_link1_text]);
            $stmt->execute(['footer_col2_link1_url', $footer_col2_link1_url]);
            $stmt->execute(['footer_col2_link2_text', $footer_col2_link2_text]);
            $stmt->execute(['footer_col2_link2_url', $footer_col2_link2_url]);
            $stmt->execute(['footer_col2_link3_text', $footer_col2_link3_text]);
            $stmt->execute(['footer_col2_link3_url', $footer_col2_link3_url]);
            $stmt->execute(['footer_col2_link4_text', $footer_col2_link4_text]);
            $stmt->execute(['footer_col2_link4_url', $footer_col2_link4_url]);

            // Save Footer Quick Links Column 3
            $stmt->execute(['footer_col3_title', $footer_col3_title]);
            $stmt->execute(['footer_col3_link1_text', $footer_col3_link1_text]);
            $stmt->execute(['footer_col3_link1_url', $footer_col3_link1_url]);
            $stmt->execute(['footer_col3_link2_text', $footer_col3_link2_text]);
            $stmt->execute(['footer_col3_link2_url', $footer_col3_link2_url]);
            $stmt->execute(['footer_col3_link3_text', $footer_col3_link3_text]);
            $stmt->execute(['footer_col3_link3_url', $footer_col3_link3_url]);
            $stmt->execute(['footer_col3_link4_text', $footer_col3_link4_text]);
            $stmt->execute(['footer_col3_link4_url', $footer_col3_link4_url]);

            logActivity('Cập nhật Header & Footer', "Cập nhật cấu hình toàn hệ thống");
            $successMessage = 'Đã cập nhật toàn bộ cấu hình giao diện Header, Footer và SEO Meta thành công!';
        }
    }

    if ($page === 'settings') {
        if ($action === 'save_integrations') {
            $sms_gateway = trim($_POST['sms_gateway']);
            $sms_apikey = trim($_POST['sms_apikey']);
            $email_smtp_host = trim($_POST['email_smtp_host']);
            $email_smtp_user = trim($_POST['email_smtp_user']);

            $stmt = $db->prepare("REPLACE INTO settings (`key`, `value`) VALUES (?, ?)");
            $stmt->execute(['sms_gateway', $sms_gateway]);
            $stmt->execute(['sms_apikey', $sms_apikey]);
            $stmt->execute(['email_smtp_host', $email_smtp_host]);
            $stmt->execute(['email_smtp_user', $email_smtp_user]);
            logActivity('Cập nhật API Cổng tích hợp', "Cập nhật cấu hình SMS & Email SMTP");
            $successMessage = 'Cấu hình tích hợp hệ thống SMS & Email SMTP thành công!';
        }
        if ($action === 'change_personal_password') {
            $oldPass = isset($_POST['old_password']) ? trim($_POST['old_password']) : '';
            $newPass = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
            $confirmPass = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';
            
            if ($oldPass && $newPass && $confirmPass) {
                if ($newPass === $confirmPass) {
                    $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
                    $stmt->execute([$userId]);
                    $hash = $stmt->fetchColumn();
                    
                    if ($hash && password_verify($oldPass, $hash)) {
                        $newHash = password_hash($newPass, PASSWORD_DEFAULT);
                        $stmtUpdate = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
                        $stmtUpdate->execute([$newHash, $userId]);
                        logActivity('Thay đổi mật khẩu cá nhân', "Đổi mật khẩu tài khoản ID #$userId");
                        $successMessage = 'Thay đổi mật khẩu cá nhân thành công!';
                    } else {
                        $errorMessage = 'Mật khẩu hiện tại không chính xác!';
                    }
                } else {
                    $errorMessage = 'Mật khẩu mới và xác nhận mật khẩu không trùng khớp!';
                }
            } else {
                $errorMessage = 'Vui lòng điền đầy đủ các thông tin mật khẩu!';
            }
        }
    }





