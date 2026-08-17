<?php
if ($action === 'save_installment_info') {
    $installment_interest_default = trim($_POST['installment_interest_default'] ?? '6.9');
    $installment_disclaimer = trim($_POST['installment_disclaimer'] ?? '');
    $installment_features = trim($_POST['installment_features'] ?? '');
    $installment_eligibility = trim($_POST['installment_eligibility'] ?? '');
    $installment_docs_personal = trim($_POST['installment_docs_personal'] ?? '');
    $installment_docs_business = trim($_POST['installment_docs_business'] ?? '');

    // 1. Partner banks grid
    $banks = [];
    $bank_names = $_POST['bank_name'] ?? [];
    $bank_rates = $_POST['bank_rate'] ?? [];
    $bank_loans = $_POST['bank_max_loan'] ?? [];
    $bank_years = $_POST['bank_max_years'] ?? [];

    for ($i = 0; $i < count($bank_names); $i++) {
        $name = trim($bank_names[$i]);
        if ($name !== '') {
            $banks[] = [
                'name' => $name,
                'rate' => trim($bank_rates[$i] ?? '0.0'),
                'max_loan' => trim($bank_loans[$i] ?? '0'),
                'max_years' => trim($bank_years[$i] ?? '0')
            ];
        }
    }

    // 2. Quy trình 4 bước
    $steps = [];
    $step_titles = $_POST['step_title'] ?? [];
    $step_descs = $_POST['step_desc'] ?? [];
    for ($i = 0; $i < 4; $i++) {
        $steps[] = [
            'title' => trim($step_titles[$i] ?? ''),
            'desc' => trim($step_descs[$i] ?? '')
        ];
    }

    // 3. Phân khúc vay tiêu biểu
    $showcases = [];
    $showcase_tags = $_POST['showcase_tag'] ?? [];
    $showcase_titles = $_POST['showcase_title'] ?? [];
    $showcase_descs = $_POST['showcase_desc'] ?? [];
    $showcase_images = $_POST['showcase_image'] ?? [];
    $showcase_prepays = $_POST['showcase_prepay'] ?? [];
    $showcase_monthlies = $_POST['showcase_monthly'] ?? [];
    $showcase_presets = $_POST['showcase_preset'] ?? [];
    
    for ($i = 0; $i < count($showcase_titles); $i++) {
        if (trim($showcase_titles[$i]) !== '') {
            $showcases[] = [
                'tag' => trim($showcase_tags[$i] ?? ''),
                'title' => trim($showcase_titles[$i]),
                'desc' => trim($showcase_descs[$i] ?? ''),
                'image' => trim($showcase_images[$i] ?? ''),
                'prepay' => trim($showcase_prepays[$i] ?? ''),
                'monthly' => trim($showcase_monthlies[$i] ?? ''),
                'preset' => trim($showcase_presets[$i] ?? '')
            ];
        }
    }

    // 4. Gallery bàn giao xe VIP
    $gallery = [];
    $gallery_tags = $_POST['gallery_tag'] ?? [];
    $gallery_titles = $_POST['gallery_title'] ?? [];
    $gallery_descs = $_POST['gallery_desc'] ?? [];
    $gallery_images = $_POST['gallery_image'] ?? [];
    $gallery_names = $_POST['gallery_customer_name'] ?? [];
    $gallery_roles = $_POST['gallery_customer_role'] ?? [];
    
    for ($i = 0; $i < count($gallery_titles); $i++) {
        if (trim($gallery_titles[$i]) !== '') {
            $gallery[] = [
                'tag' => trim($gallery_tags[$i] ?? ''),
                'title' => trim($gallery_titles[$i]),
                'desc' => trim($gallery_descs[$i] ?? ''),
                'image' => trim($gallery_images[$i] ?? ''),
                'customer_name' => trim($gallery_names[$i] ?? ''),
                'customer_role' => trim($gallery_roles[$i] ?? '')
            ];
        }
    }

    // 5. FAQs
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
    $stmt->execute(['installment_interest_default', $installment_interest_default]);
    $stmt->execute(['installment_disclaimer', $installment_disclaimer]);
    $stmt->execute(['installment_features', $installment_features]);
    $stmt->execute(['installment_eligibility', $installment_eligibility]);
    $stmt->execute(['installment_docs_personal', $installment_docs_personal]);
    $stmt->execute(['installment_docs_business', $installment_docs_business]);
    $stmt->execute(['installment_banks', json_encode($banks, JSON_UNESCAPED_UNICODE)]);
    $stmt->execute(['installment_steps', json_encode($steps, JSON_UNESCAPED_UNICODE)]);
    $stmt->execute(['installment_showcases', json_encode($showcases, JSON_UNESCAPED_UNICODE)]);
    $stmt->execute(['installment_gallery', json_encode($gallery, JSON_UNESCAPED_UNICODE)]);
    $stmt->execute(['installment_faqs', json_encode($faqs, JSON_UNESCAPED_UNICODE)]);

    logActivity('Cập nhật CMS Trả góp', "Cập nhật toàn diện cấu hình, ngân hàng & nội dung trang trả góp");
    $successMessage = 'Cập nhật cấu hình Trang Trả góp thành công!';
}




