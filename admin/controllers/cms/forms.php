<?php
if ($action === 'save_forms_config') {
    // 1. VIP Popup
    $vip_badge = trim($_POST['vip_popup_cover_badge'] ?? '');
    $vip_title = trim($_POST['vip_popup_cover_title'] ?? '');
    $vip_desc = trim($_POST['vip_popup_cover_desc'] ?? '');
    $vip_form_tag = trim($_POST['vip_popup_form_tag'] ?? '');
    $vip_form_title = trim($_POST['vip_popup_form_title'] ?? '');
    $vip_form_subtitle = trim($_POST['vip_popup_form_subtitle'] ?? '');
    
    // Get existing cover image
    $stmtImg = $db->prepare("SELECT value FROM settings WHERE `key` = ?");
    $stmtImg->execute(['vip_popup_cover_image']);
    $old_vip_img = $stmtImg->fetchColumn() ?: '';
    
    $vip_img_input = trim($_POST['vip_popup_cover_image'] ?? '');
    $vip_img_fallback = ($vip_img_input !== '') ? $vip_img_input : $old_vip_img;
    $vip_popup_cover_image = handleImageUpload('vip_popup_cover_file', $vip_img_fallback);

    // Save VIP Popup settings
    $stmt = $db->prepare("REPLACE INTO settings (`key`, `value`) VALUES (?, ?)");
    $stmt->execute(['vip_popup_cover_badge', $vip_badge]);
    $stmt->execute(['vip_popup_cover_title', $vip_title]);
    $stmt->execute(['vip_popup_cover_desc', $vip_desc]);
    $stmt->execute(['vip_popup_form_tag', $vip_form_tag]);
    $stmt->execute(['vip_popup_form_title', $vip_form_title]);
    $stmt->execute(['vip_popup_form_subtitle', $vip_form_subtitle]);
    $stmt->execute(['vip_popup_cover_image', $vip_popup_cover_image]);

    // 2. Section 7 Trade-in
    $s7_title = trim($_POST['s7_tradein_title'] ?? '');
    $s7_desc = trim($_POST['s7_tradein_desc'] ?? '');
    $s7_counselor_name = trim($_POST['s7_default_counselor_name'] ?? '');
    $s7_counselor_title = trim($_POST['s7_default_counselor_title'] ?? '');

    $steps = [];
    for ($i = 0; $i < 3; $i++) {
        $steps[] = [
            'num' => trim($_POST['s7_step_num'][$i] ?? '0' . ($i + 1)),
            'title' => trim($_POST['s7_step_title'][$i] ?? ''),
            'desc' => trim($_POST['s7_step_desc'][$i] ?? ''),
        ];
    }

    $stmt->execute(['s7_tradein_title', $s7_title]);
    $stmt->execute(['s7_tradein_desc', $s7_desc]);
    $stmt->execute(['s7_default_counselor_name', $s7_counselor_name]);
    $stmt->execute(['s7_default_counselor_title', $s7_counselor_title]);
    $stmt->execute(['s7_tradein_steps', json_encode($steps, JSON_UNESCAPED_UNICODE)]);

    // 3. Section 9 Dual CTAs
    // Get existing dual actions
    $stmtActions = $db->prepare("SELECT value FROM settings WHERE `key` = ?");
    $stmtActions->execute(['s9_dual_actions']);
    $old_actions_json = $stmtActions->fetchColumn();
    $old_actions = json_decode($old_actions_json ?? '', true) ?: [];

    $actions = [];
    for ($i = 0; $i < 2; $i++) {
        $old_img = $old_actions[$i]['bg_image'] ?? '';
        $img_input = trim($_POST['s9_bg_image'][$i] ?? '');
        $img_fallback = ($img_input !== '') ? $img_input : $old_img;
        
        $bg_image = handleImageUpload('s9_bg_file_' . $i, $img_fallback);

        $actions[] = [
            'tag' => trim($_POST['s9_tag'][$i] ?? ''),
            'title' => trim($_POST['s9_title'][$i] ?? ''),
            'desc' => trim($_POST['s9_desc'][$i] ?? ''),
            'btn_text' => trim($_POST['s9_btn_text'][$i] ?? ''),
            'btn_href' => trim($_POST['s9_btn_href'][$i] ?? ''),
            'bg_class' => trim($_POST['s9_bg_class'][$i] ?? ''),
            'bg_image' => $bg_image
        ];
    }

    $stmt->execute(['s9_dual_actions', json_encode($actions, JSON_UNESCAPED_UNICODE)]);

    logActivity('Cập nhật Form và Popup CMS', 'Cập nhật cấu hình hợp nhất các Form đăng ký, VIP Popup và thẻ hành động');
    $successMessage = 'Cập nhật cấu hình Form đăng ký và Hộp thoại VIP thành công!';
}




