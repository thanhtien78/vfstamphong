<?php
if ($action === 'save_settings') {
    $hero_headline = trim($_POST['hero_headline']);
    $hero_subline = trim($_POST['hero_subline']);
    $hero_btn1 = trim($_POST['hero_btn1']);
    $hero_btn2 = trim($_POST['hero_btn2']);
    $s6_headline = trim($_POST['s6_headline'] ?? '');
    $s6_desc = trim($_POST['s6_desc'] ?? '');

    // Dynamic Image Management with robust old value fallbacks
    $stmtImg = $db->query("SELECT * FROM settings WHERE `key` IN ('hero_banner_image', 'spotlight_image', 'dealer_image')");
    $currSettings = [];
    while ($r = $stmtImg->fetch()) {
        $currSettings[$r['key']] = $r['value'];
    }

    $old_hero = $currSettings['hero_banner_image'] ?? '';
    $old_spot = $currSettings['spotlight_image'] ?? '';
    $old_deal = $currSettings['dealer_image'] ?? '';

    $hero_input = trim($_POST['hero_banner_image']);
    $spot_input = trim($_POST['spotlight_image']);
    $deal_input = trim($_POST['dealer_image']);

    $hero_fallback = ($hero_input !== '') ? $hero_input : $old_hero;
    $spot_fallback = ($spot_input !== '') ? $spot_input : $old_spot;
    $deal_fallback = ($deal_input !== '') ? $deal_input : $old_deal;

    $hero_banner_image = handleImageUpload('hero_banner_file', $hero_fallback);
    $spotlight_image = handleImageUpload('spotlight_file', $spot_fallback);
    $dealer_image = handleImageUpload('dealer_file', $deal_fallback);

    $stmt = $db->prepare("REPLACE INTO settings (`key`, `value`) VALUES (?, ?)");
    $stmt->execute(['hero_headline', $hero_headline]);
    $stmt->execute(['hero_subline', $hero_subline]);
    $stmt->execute(['hero_btn1', $hero_btn1]);
    $stmt->execute(['hero_btn2', $hero_btn2]);
    $stmt->execute(['s6_headline', $s6_headline]);
    $stmt->execute(['s6_desc', $s6_desc]);

    // Save dynamic images
    $stmt->execute(['hero_banner_image', $hero_banner_image]);
    $stmt->execute(['spotlight_image', $spotlight_image]);
    $stmt->execute(['dealer_image', $dealer_image]);
    logActivity('Cập nhật Banner trang chủ', "Cập nhật headline: $hero_headline");
    $successMessage = 'Cập nhật cấu hình Banner & Hình ảnh trang chủ thành công!';
}
if ($action === 'save_s5_privileges') {
    $s5 = [];
    for ($i = 0; $i < 4; $i++) {
        $s5[] = [
            'watermark' => trim($_POST['s5_watermark'][$i] ?? ''),
            'title' => trim($_POST['s5_title'][$i] ?? ''),
            'desc' => trim($_POST['s5_desc'][$i] ?? ''),
            'link_text' => trim($_POST['s5_link_text'][$i] ?? ''),
            'link_href' => trim($_POST['s5_link_href'][$i] ?? ''),
        ];
    }
    $stmt = $db->prepare("REPLACE INTO settings (`key`, `value`) VALUES (?, ?)");
    $stmt->execute(['s5_privileges', json_encode($s5, JSON_UNESCAPED_UNICODE)]);
    logActivity('Cập nhật Đặc quyền CMS', "Cập nhật danh sách Đặc quyền Phần 5");
    $successMessage = 'Cập nhật Đặc quyền sở hữu chính hãng (Phần 5) thành công!';
}
if ($action === 'save_s6_reasons') {
    $s6_quote = trim($_POST['s6_signature_quote'] ?? '');
    $s6_reasons = [];
    for ($i = 0; $i < 4; $i++) {
        $s6_reasons[] = [
            'title' => trim($_POST['s6_reason_title'][$i] ?? ''),
            'desc' => trim($_POST['s6_reason_desc'][$i] ?? ''),
        ];
    }
    $stmt = $db->prepare("REPLACE INTO settings (`key`, `value`) VALUES (?, ?)");
    $stmt->execute(['s6_signature_quote', $s6_quote]);
    $stmt->execute(['s6_reasons', json_encode($s6_reasons, JSON_UNESCAPED_UNICODE)]);
    logActivity('Cập nhật Lý do chọn CMS', "Cập nhật danh sách Lý do Phần 6");
    $successMessage = 'Cập nhật Lý do chọn Đại lý ủy quyền (Phần 6) thành công!';
}
if ($action === 'save_s8_offers') {
    $s8 = [];
    for ($i = 0; $i < 4; $i++) {
        $bullets = [];
        for ($j = 0; $j < 3; $j++) {
            $bullets[] = trim($_POST['s8_bullets'][$i][$j] ?? '');
        }
        $s8[] = [
            'tag' => trim($_POST['s8_tag'][$i] ?? ''),
            'title' => trim($_POST['s8_title'][$i] ?? ''),
            'desc' => trim($_POST['s8_desc'][$i] ?? ''),
            'bullets' => $bullets
        ];
    }
    $stmt = $db->prepare("REPLACE INTO settings (`key`, `value`) VALUES (?, ?)");
    $stmt->execute(['s8_offers', json_encode($s8, JSON_UNESCAPED_UNICODE)]);
    logActivity('Cập nhật Ưu đãi CMS', "Cập nhật danh sách Ưu đãi Phần 8");
    $successMessage = 'Cập nhật Ưu đãi đặc quyền từ đại lý VinFast (Phần 8) thành công!';
}
if ($action === 'save_homepage_faqs') {
    $faqs = [];
    $faq_questions = $_POST['faq_question'] ?? [];
    $faq_answers = $_POST['faq_answer'] ?? [];
    for ($i = 0; $i < count($faq_questions); $i++) {
        if (trim($faq_questions[$i]) !== '') {
            $faqs[] = [
                'question' => trim($faq_questions[$i]),
                'answer' => trim($faq_answers[$i] ?? '')
            ];
        }
    }
    $stmt = $db->prepare("REPLACE INTO settings (`key`, `value`) VALUES (?, ?)");
    $stmt->execute(['homepage_faqs', json_encode($faqs, JSON_UNESCAPED_UNICODE)]);
    logActivity('Cập nhật CMS FAQ Trang Chủ', "Cập nhật danh sách câu hỏi thường gặp trang chủ");
    $successMessage = 'Cập nhật danh sách Câu hỏi thường gặp FAQ Trang Chủ thành công!';
}
if ($action === 'save_s7_tradein') {
    $title = trim($_POST['s7_tradein_title']);
    $desc = trim($_POST['s7_tradein_desc']);
    $counselor_name = trim($_POST['s7_default_counselor_name']);
    $counselor_title = trim($_POST['s7_default_counselor_title']);

    $steps = [];
    for ($i = 0; $i < 3; $i++) {
        $steps[] = [
            'num' => trim($_POST['s7_step_num'][$i] ?? '0' . ($i + 1)),
            'title' => trim($_POST['s7_step_title'][$i] ?? ''),
            'desc' => trim($_POST['s7_step_desc'][$i] ?? ''),
        ];
    }

    $stmt = $db->prepare("REPLACE INTO settings (`key`, `value`) VALUES (?, ?)");
    $stmt->execute(['s7_tradein_title', $title]);
    $stmt->execute(['s7_tradein_desc', $desc]);
    $stmt->execute(['s7_default_counselor_name', $counselor_name]);
    $stmt->execute(['s7_default_counselor_title', $counselor_title]);
    $stmt->execute(['s7_tradein_steps', json_encode($steps, JSON_UNESCAPED_UNICODE)]);

    logActivity('Cập nhật Thu cũ đổi mới CMS', "Cập nhật cấu hình Phần 7");
    $successMessage = 'Cập nhật cấu hình Thu cũ đổi mới (Phần 7) thành công!';
}
if ($action === 'save_s9_dual_actions') {
    $actions = [];
    for ($i = 0; $i < 2; $i++) {
        $actions[] = [
            'tag' => trim($_POST['s9_tag'][$i] ?? ''),
            'title' => trim($_POST['s9_title'][$i] ?? ''),
            'desc' => trim($_POST['s9_desc'][$i] ?? ''),
            'btn_text' => trim($_POST['s9_btn_text'][$i] ?? ''),
            'btn_href' => trim($_POST['s9_btn_href'][$i] ?? ''),
            'bg_class' => trim($_POST['s9_bg_class'][$i] ?? '')
        ];
    }

    $stmt = $db->prepare("REPLACE INTO settings (`key`, `value`) VALUES (?, ?)");
    $stmt->execute(['s9_dual_actions', json_encode($actions, JSON_UNESCAPED_UNICODE)]);

    logActivity('Cập nhật Khối hành động kép CMS', "Cập nhật cấu hình Phần 9");
    $successMessage = 'Cập nhật Khối hành động kép (Phần 9) thành công!';
}




