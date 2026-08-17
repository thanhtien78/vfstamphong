<?php
if ($action === 'create_post') {
    $title = trim($_POST['title']);
    $summary = trim($_POST['summary']);
    $content = trim($_POST['content']);
    $category = trim($_POST['category'] ?? 'Thế giới VinFast');
    $focus_keyword = trim($_POST['focus_keyword'] ?? '');
    $seo_title = trim($_POST['seo_title'] ?? '');
    $seo_desc = trim($_POST['seo_desc'] ?? '');
    $seo_canonical = trim($_POST['seo_canonical'] ?? '');
    
    $uploadError = null;
    $image = handleImageUpload('image_file', trim($_POST['image']), $uploadError);

    if ($image === false) {
        $errorMessage = 'Lỗi tải ảnh đại diện bài viết: ' . $uploadError;
    } elseif ($title) {
        // Auto generate/override SEO slug
        $slugInput = trim($_POST['slug'] ?? '');
        if (!empty($slugInput)) {
            $slugStr = mb_strtolower($slugInput, 'UTF-8');
        } else {
            $slugStr = mb_strtolower($title, 'UTF-8');
        }
        $slugStr = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $slugStr);
        $slugStr = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $slugStr);
        $slugStr = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $slugStr);
        $slugStr = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $slugStr);
        $slugStr = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $slugStr);
        $slugStr = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $slugStr);
        $slugStr = preg_replace('/(đ)/', 'd', $slugStr);
        $slugStr = preg_replace('/[^a-z0-9-\s]/', '', $slugStr);
        $slugStr = preg_replace('/([\s]+)/', '-', $slugStr);
        $slug = trim($slugStr, '-');

        $stmt = $db->prepare("INSERT INTO posts (title, summary, content, image, slug, category, focus_keyword, seo_title, seo_desc, seo_canonical) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $summary, $content, $image, $slug, $category, $focus_keyword, $seo_title, $seo_desc, $seo_canonical]);
        logActivity('Tạo bài viết mới', "Đăng bài: $title");
        $successMessage = 'Đăng tin khuyến mãi/sự kiện mới thành công!';
    } else {
        $errorMessage = 'Vui lòng nhập tiêu đề bài viết!';
    }
}
if ($action === 'edit_post') {
    $targetId = (int)$_POST['id'];
    $title = trim($_POST['title']);
    $summary = trim($_POST['summary']);
    $content = trim($_POST['content']);
    $category = trim($_POST['category'] ?? 'Thế giới VinFast');
    $focus_keyword = trim($_POST['focus_keyword'] ?? '');
    $seo_title = trim($_POST['seo_title'] ?? '');
    $seo_desc = trim($_POST['seo_desc'] ?? '');
    $seo_canonical = trim($_POST['seo_canonical'] ?? '');
    
    $uploadError = null;
    $image = handleImageUpload('image_file', trim($_POST['image']), $uploadError);

    if ($image === false) {
        $errorMessage = 'Lỗi tải ảnh đại diện bài viết: ' . $uploadError;
    } elseif ($title) {
        // Auto generate/override SEO slug
        $slugInput = trim($_POST['slug'] ?? '');
        if (!empty($slugInput)) {
            $slugStr = mb_strtolower($slugInput, 'UTF-8');
        } else {
            $slugStr = mb_strtolower($title, 'UTF-8');
        }
        $slugStr = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $slugStr);
        $slugStr = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $slugStr);
        $slugStr = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $slugStr);
        $slugStr = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $slugStr);
        $slugStr = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $slugStr);
        $slugStr = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $slugStr);
        $slugStr = preg_replace('/(đ)/', 'd', $slugStr);
        $slugStr = preg_replace('/[^a-z0-9-\s]/', '', $slugStr);
        $slugStr = preg_replace('/([\s]+)/', '-', $slugStr);
        $slug = trim($slugStr, '-');

        // Fetch the current slug to check if it's being changed
        $stmtCheck = $db->prepare("SELECT slug FROM posts WHERE id = ?");
        $stmtCheck->execute([$targetId]);
        $currentPost = $stmtCheck->fetch(PDO::FETCH_ASSOC);
        $oldPostSlug = $currentPost ? ($currentPost['slug'] ?? '') : '';

        // If old slug is different from new slug, record a 301 redirect mapping
        if (!empty($oldPostSlug) && $oldPostSlug !== $slug) {
            $stmtRedir = $db->prepare("REPLACE INTO redirects (old_url, new_url) VALUES (?, ?)");
            $stmtRedir->execute([$oldPostSlug, $slug]);
        }

        $stmt = $db->prepare("UPDATE posts SET title = ?, summary = ?, content = ?, image = ?, slug = ?, category = ?, focus_keyword = ?, seo_title = ?, seo_desc = ?, seo_canonical = ? WHERE id = ?");
        $stmt->execute([$title, $summary, $content, $image, $slug, $category, $focus_keyword, $seo_title, $seo_desc, $seo_canonical, $targetId]);
        logActivity('Cập nhật bài viết', "Cập nhật Bài viết ID #$targetId ($title)");
        $successMessage = 'Cập nhật bài viết thành công!';
    } else {
        $errorMessage = 'Vui lòng nhập tiêu đề bài viết!';
    }
}
if ($action === 'delete_post') {
    $targetId = (int)$_POST['id'];
    $db->prepare("DELETE FROM posts WHERE id = ?")->execute([$targetId]);
    logActivity('Xóa bài viết', "Xóa bài viết ID #$targetId");
    $successMessage = 'Đã xóa bài viết!';
}
if ($action === 'save_seo') {
    $site_title = trim($_POST['site_title']);
    $site_desc = trim($_POST['site_desc']);
    $site_keywords = trim($_POST['site_keywords']);
    $site_canonical = trim($_POST['site_canonical'] ?? '');
    
    $about_seo_title = trim($_POST['about_seo_title'] ?? '');
    $about_seo_desc = trim($_POST['about_seo_desc'] ?? '');
    $about_seo_keywords = trim($_POST['about_seo_keywords'] ?? '');
    $about_seo_canonical = trim($_POST['about_seo_canonical'] ?? '');
    
    $installment_seo_title = trim($_POST['installment_seo_title'] ?? '');
    $installment_seo_desc = trim($_POST['installment_seo_desc'] ?? '');
    $installment_seo_keywords = trim($_POST['installment_seo_keywords'] ?? '');
    $installment_seo_canonical = trim($_POST['installment_seo_canonical'] ?? '');

    $stmt = $db->prepare("REPLACE INTO settings (`key`, `value`) VALUES (?, ?)");
    $stmt->execute(['site_title', $site_title]);
    $stmt->execute(['site_desc', $site_desc]);
    $stmt->execute(['site_keywords', $site_keywords]);
    $stmt->execute(['site_canonical', $site_canonical]);
    
    $stmt->execute(['about_seo_title', $about_seo_title]);
    $stmt->execute(['about_seo_desc', $about_seo_desc]);
    $stmt->execute(['about_seo_keywords', $about_seo_keywords]);
    $stmt->execute(['about_seo_canonical', $about_seo_canonical]);
    
    $stmt->execute(['installment_seo_title', $installment_seo_title]);
    $stmt->execute(['installment_seo_desc', $installment_seo_desc]);
    $stmt->execute(['installment_seo_keywords', $installment_seo_keywords]);
    $stmt->execute(['installment_seo_canonical', $installment_seo_canonical]);

    logActivity('Cập nhật SEO', "Cập nhật cấu hình thẻ SEO các trang tĩnh chính");
    $successMessage = 'Cập nhật cấu hình thẻ SEO cho các trang chính thành công!';
}




