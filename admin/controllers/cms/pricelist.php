<?php
if ($action === 'save_pricelist_info') {
    $pricelist_intro_headline = trim($_POST['pricelist_intro_headline'] ?? '');
    $pricelist_intro_desc = trim($_POST['pricelist_intro_desc'] ?? '');
    $pricelist_tax_note = trim($_POST['pricelist_tax_note'] ?? '');
    $pricelist_editorial = trim($_POST['pricelist_editorial'] ?? '');

    // 1. Download Catalog files list
    $downloads = [];
    $dl_titles = $_POST['dl_title'] ?? [];
    $dl_urls = $_POST['dl_url'] ?? [];

    for ($i = 0; $i < count($dl_titles); $i++) {
        $title = trim($dl_titles[$i]);
        if ($title !== '') {
            $downloads[] = [
                'title' => $title,
                'url' => trim($dl_urls[$i] ?? '#')
            ];
        }
    }

    // 2. Promotion & Gifts packages
    $promos = [];
    $promo_models = $_POST['promo_model_name'] ?? [];
    $promo_texts = $_POST['promo_text'] ?? [];
    $promo_gifts = $_POST['promo_gifts'] ?? [];
    
    for ($i = 0; $i < count($promo_models); $i++) {
        $mname = trim($promo_models[$i]);
        if ($mname !== '') {
            $promos[] = [
                'model_name' => $mname,
                'promo' => trim($promo_texts[$i] ?? ''),
                'gifts' => trim($promo_gifts[$i] ?? '')
            ];
        }
    }

    // 3. Pricelist FAQs
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
    $stmt->execute(['pricelist_intro_headline', $pricelist_intro_headline]);
    $stmt->execute(['pricelist_intro_desc', $pricelist_intro_desc]);
    $stmt->execute(['pricelist_tax_note', $pricelist_tax_note]);
    $stmt->execute(['pricelist_editorial', $pricelist_editorial]);
    $stmt->execute(['pricelist_downloads', json_encode($downloads, JSON_UNESCAPED_UNICODE)]);
    $stmt->execute(['pricelist_promos', json_encode($promos, JSON_UNESCAPED_UNICODE)]);
    $stmt->execute(['pricelist_faqs', json_encode($faqs, JSON_UNESCAPED_UNICODE)]);

    logActivity('Cập nhật CMS Bảng Giá', "Cập nhật toàn diện cấu hình bảng giá, khuyến mãi, quà tặng, FAQ & cẩm nang mua xe");
    $successMessage = 'Cập nhật cấu hình Trang Bảng Giá thành công!';
}




