<?php
if ($action === 'save_about') {
    $about_title = trim($_POST['about_title'] ?? '');
    $about_intro_headline = trim($_POST['about_intro_headline'] ?? '');
    $about_intro_text = trim($_POST['about_intro_text'] ?? '');
    $about_map_iframe = trim($_POST['about_map_iframe'] ?? '');
    
    // Main image upload
    $curr_about_img = $db->query("SELECT value FROM settings WHERE `key` = 'about_image_url'")->fetchColumn() ?: '';
    $uploadError1 = null;
    $about_image_url = handleImageUpload('about_image_file', trim($_POST['about_image_url'] ?? $curr_about_img), $uploadError1);

    // Hero image upload
    $curr_hero_img = $db->query("SELECT value FROM settings WHERE `key` = 'about_hero_image_url'")->fetchColumn() ?: '';
    $uploadError2 = null;
    $about_hero_image_url = handleImageUpload('about_hero_image_file', trim($_POST['about_hero_image_url'] ?? $curr_hero_img), $uploadError2);

    // Quote background image upload
    $curr_quote_bg = $db->query("SELECT value FROM settings WHERE `key` = 'about_quote_bg_image'")->fetchColumn() ?: '';
    $uploadError3 = null;
    $about_quote_bg_image = handleImageUpload('about_quote_bg_image_file', trim($_POST['about_quote_bg_image'] ?? $curr_quote_bg), $uploadError3);

    if ($about_image_url === false) {
        $errorMessage = 'Lỗi tải ảnh chính Showroom: ' . $uploadError1;
    } elseif ($about_hero_image_url === false) {
        $errorMessage = 'Lỗi tải ảnh Banner Hero: ' . $uploadError2;
    } elseif ($about_quote_bg_image === false) {
        $errorMessage = 'Lỗi tải ảnh nền khối trích dẫn: ' . $uploadError3;
    } else {

    // Basic tags and sections
    $about_hero_tag = trim($_POST['about_hero_tag'] ?? '');
    $about_hero_title = trim($_POST['about_hero_title'] ?? '');
    $about_hero_desc = trim($_POST['about_hero_desc'] ?? '');
    $about_intro_tag = trim($_POST['about_intro_tag'] ?? '');
    $about_gallery_tag = trim($_POST['about_gallery_tag'] ?? '');
    $about_gallery_title = trim($_POST['about_gallery_title'] ?? '');
    $about_gallery_desc = trim($_POST['about_gallery_desc'] ?? '');
    $about_history_tag = trim($_POST['about_history_tag'] ?? '');
    $about_history_title = trim($_POST['about_history_title'] ?? '');
    $about_history_desc = trim($_POST['about_history_desc'] ?? '');
    $about_commitments_tag = trim($_POST['about_commitments_tag'] ?? '');
    $about_commitments_title = trim($_POST['about_commitments_title'] ?? '');
    $about_commitments_desc = trim($_POST['about_commitments_desc'] ?? '');
    
    // 3 Core Values
    $about_values = [];
    for ($i = 0; $i < 3; $i++) {
        $about_values[] = [
            'title' => trim($_POST['about_val_title'][$i] ?? ''),
            'desc' => trim($_POST['about_val_desc'][$i] ?? ''),
            'icon' => trim($_POST['about_val_icon'][$i] ?? 'fas fa-check')
        ];
    }

    // Showroom slides
    $gallery_slides = [];
    $slide_titles = $_POST['about_gallery_slide_title'] ?? [];
    $slide_descs = $_POST['about_gallery_slide_desc'] ?? [];
    $slide_images = $_POST['about_gallery_slide_image'] ?? [];
    for ($i = 0; $i < count($slide_titles); $i++) {
        $title = trim($slide_titles[$i]);
        if ($title !== '') {
            $img_url = trim($slide_images[$i] ?? '');
            
            // Handle file upload for this specific slide row
            if (isset($_FILES['about_gallery_slide_file']['error'][$i]) && $_FILES['about_gallery_slide_file']['error'][$i] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['about_gallery_slide_file']['tmp_name'][$i];
                $fileName = $_FILES['about_gallery_slide_file']['name'][$i];
                $fileSize = $_FILES['about_gallery_slide_file']['size'][$i];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                if (in_array($fileExtension, $allowedExtensions)) {
                    if ($fileSize < 5 * 1024 * 1024) { // limit 5MB
                        $uploadFileDir = dirname(__DIR__, 2) . '/assets/uploads/';
                        if (!is_dir($uploadFileDir)) {
                            mkdir($uploadFileDir, 0755, true);
                        }
                        $newFileName = md5(time() . $fileName . $i) . '.' . $fileExtension;
                        $dest_path = $uploadFileDir . $newFileName;
                        if (move_uploaded_file($fileTmpPath, $dest_path)) {
                            $img_url = 'assets/uploads/' . $newFileName;
                            // Automatically convert to WebP
                            if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
                                $webpFileName = md5(time() . $fileName . $i) . '.webp';
                                $webpPath = $uploadFileDir . $webpFileName;
                                $gdImg = @imagecreatefromstring(file_get_contents($dest_path));
                                if ($gdImg) {
                                    if (imagewebp($gdImg, $webpPath, 75)) {
                                        @unlink($dest_path);
                                        $img_url = 'assets/uploads/' . $webpFileName;
                                    }
                                    imagedestroy($gdImg);
                                }
                            }
                        }
                    }
                }
            }
            
            $gallery_slides[] = [
                'title' => $title,
                'desc' => trim($slide_descs[$i] ?? ''),
                'image' => $img_url
            ];
        }
    }

    // Stats
    $stats = [];
    $stat_numbers = $_POST['about_stat_number'] ?? [];
    $stat_labels = $_POST['about_stat_label'] ?? [];
    $stat_descs = $_POST['about_stat_desc'] ?? [];
    for ($i = 0; $i < count($stat_numbers); $i++) {
        $num = trim($stat_numbers[$i]);
        if ($num !== '') {
            $stats[] = [
                'number' => $num,
                'label' => trim($stat_labels[$i] ?? ''),
                'desc' => trim($stat_descs[$i] ?? '')
            ];
        }
    }

    // Blockquote quote
    $about_quote_text = trim($_POST['about_quote_text'] ?? '');
    $about_quote_author = trim($_POST['about_quote_author'] ?? '');
    $about_quote_author_title = trim($_POST['about_quote_author_title'] ?? '');

    // Historical timeline
    $history = [];
    $history_years = $_POST['about_history_year'] ?? [];
    $history_titles = $_POST['about_history_milestone_title'] ?? [];
    $history_descs = $_POST['about_history_milestone_desc'] ?? [];
    for ($i = 0; $i < count($history_years); $i++) {
        $yr = trim($history_years[$i]);
        if ($yr !== '') {
            $history[] = [
                'year' => $yr,
                'title' => trim($history_titles[$i] ?? ''),
                'desc' => trim($history_descs[$i] ?? '')
            ];
        }
    }

    // Commitments
    $commitments = [];
    $comm_icons = $_POST['about_commitment_icon'] ?? [];
    $comm_titles = $_POST['about_commitment_title'] ?? [];
    $comm_descs = $_POST['about_commitment_desc'] ?? [];
    for ($i = 0; $i < count($comm_titles); $i++) {
        $title = trim($comm_titles[$i]);
        if ($title !== '') {
            $commitments[] = [
                'icon' => trim($comm_icons[$i] ?? 'layers'),
                'title' => $title,
                'desc' => trim($comm_descs[$i] ?? '')
            ];
        }
    }

    // Tech Showcase
    $about_tech_tag = trim($_POST['about_tech_tag'] ?? '');
    $about_tech_title = trim($_POST['about_tech_title'] ?? '');
    $about_tech_desc = trim($_POST['about_tech_desc'] ?? '');
    $techs = [];
    $tech_names = $_POST['about_tech_name'] ?? [];
    $tech_tags = $_POST['about_tech_tagline'] ?? [];
    $tech_titles = $_POST['about_tech_heading'] ?? [];
    $tech_descs = $_POST['about_tech_description'] ?? [];
    $tech_features = $_POST['about_tech_features_list'] ?? [];
    $tech_images = $_POST['about_tech_image_url'] ?? [];
    for ($i = 0; $i < 3; $i++) {
        $tech_name = trim($tech_names[$i] ?? '');
        if ($tech_name !== '') {
            $techs[] = [
                'name' => $tech_name,
                'tag' => trim($tech_tags[$i] ?? ''),
                'title' => trim($tech_titles[$i] ?? ''),
                'desc' => trim($tech_descs[$i] ?? ''),
                'features' => trim($tech_features[$i] ?? ''),
                'image' => trim($tech_images[$i] ?? '')
            ];
        }
    }

    // CTAs
    $ctas = [];
    $cta_titles = $_POST['about_cta_title'] ?? [];
    $cta_descs = $_POST['about_cta_desc'] ?? [];
    $cta_links = $_POST['about_cta_link'] ?? [];
    $cta_btn_texts = $_POST['about_cta_btn_text'] ?? [];
    $cta_btn_classes = $_POST['about_cta_btn_class'] ?? [];
    for ($i = 0; $i < count($cta_titles); $i++) {
        $title = trim($cta_titles[$i]);
        if ($title !== '') {
            $ctas[] = [
                'title' => $title,
                'desc' => trim($cta_descs[$i] ?? ''),
                'link' => trim($cta_links[$i] ?? ''),
                'btn_text' => trim($cta_btn_texts[$i] ?? ''),
                'btn_class' => trim($cta_btn_classes[$i] ?? 'btn-about-gold')
            ];
        }
    }

    // Save to settings
    $stmt = $db->prepare("REPLACE INTO settings (`key`, `value`) VALUES (?, ?)");
    $stmt->execute(['about_title', $about_title]);
    $stmt->execute(['about_intro_headline', $about_intro_headline]);
    $stmt->execute(['about_intro_text', $about_intro_text]);
    $stmt->execute(['about_image_url', $about_image_url]);
    $stmt->execute(['about_map_iframe', $about_map_iframe]);
    $stmt->execute(['about_values', json_encode($about_values, JSON_UNESCAPED_UNICODE)]);
    $stmt->execute(['about_hero_image_url', $about_hero_image_url]);
    $stmt->execute(['about_hero_tag', $about_hero_tag]);
    $stmt->execute(['about_hero_title', $about_hero_title]);
    $stmt->execute(['about_hero_desc', $about_hero_desc]);
    $stmt->execute(['about_intro_tag', $about_intro_tag]);
    $stmt->execute(['about_gallery_tag', $about_gallery_tag]);
    $stmt->execute(['about_gallery_title', $about_gallery_title]);
    $stmt->execute(['about_gallery_desc', $about_gallery_desc]);
    $stmt->execute(['about_gallery_slides', json_encode($gallery_slides, JSON_UNESCAPED_UNICODE)]);
    $stmt->execute(['about_stats', json_encode($stats, JSON_UNESCAPED_UNICODE)]);
    $stmt->execute(['about_quote_text', $about_quote_text]);
    $stmt->execute(['about_quote_author', $about_quote_author]);
    $stmt->execute(['about_quote_author_title', $about_quote_author_title]);
    $stmt->execute(['about_quote_bg_image', $about_quote_bg_image]);
    $stmt->execute(['about_history_tag', $about_history_tag]);
    $stmt->execute(['about_history_title', $about_history_title]);
    $stmt->execute(['about_history_desc', $about_history_desc]);
    $stmt->execute(['about_history_timeline', json_encode($history, JSON_UNESCAPED_UNICODE)]);
    $stmt->execute(['about_commitments_tag', $about_commitments_tag]);
    $stmt->execute(['about_commitments_title', $about_commitments_title]);
    $stmt->execute(['about_commitments_desc', $about_commitments_desc]);
    $stmt->execute(['about_commitments_list', json_encode($commitments, JSON_UNESCAPED_UNICODE)]);
    $stmt->execute(['about_ctas_list', json_encode($ctas, JSON_UNESCAPED_UNICODE)]);
    $stmt->execute(['about_tech_tag', $about_tech_tag]);
    $stmt->execute(['about_tech_title', $about_tech_title]);
    $stmt->execute(['about_tech_desc', $about_tech_desc]);
    $stmt->execute(['about_tech_list', json_encode($techs, JSON_UNESCAPED_UNICODE)]);

    logActivity('Cập nhật CMS Giới thiệu', "Cập nhật nội dung trang Giới thiệu");
    $successMessage = 'Cập nhật cấu hình Trang Giới thiệu thành công!';
    }
}




