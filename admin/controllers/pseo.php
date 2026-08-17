<?php
/**
 * VinFast Central pSEO PRO Administrative Controller
 * Handles templates, custom keyword lists, dynamic status toggles, and AJAX chunked index rebuilding.
 */
if ($page === 'pseo') {
    require_once 'backend/includes/class-pseo-helper.php';
    require_once 'backend/includes/cache.php';

    // ----------------------------------------------------
    // AJAX CAMPAIGN IMAGES MULTI-UPLOAD
    // ----------------------------------------------------
    if ($action === 'upload_campaign_images') {
        header('Content-Type: application/json');
        try {
            $uploadedPaths = [];
            $errors = [];
            if (isset($_FILES['campaign_images']) && is_array($_FILES['campaign_images']['name'])) {
                $count = count($_FILES['campaign_images']['name']);
                for ($i = 0; $i < $count; $i++) {
                    if ($_FILES['campaign_images']['error'][$i] === UPLOAD_ERR_OK) {
                        $tmpPath = $_FILES['campaign_images']['tmp_name'][$i];
                        $origName = $_FILES['campaign_images']['name'][$i];
                        $fileSize = $_FILES['campaign_images']['size'][$i];
                        
                        $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
                        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                        
                        if (!in_array($ext, $allowed)) {
                            $errors[] = "$origName: Định dạng không hợp lệ.";
                            continue;
                        }
                        
                        if ($fileSize > 15 * 1024 * 1024) {
                            $errors[] = "$origName: Dung lượng quá lớn (>15MB).";
                            continue;
                        }
                        
                        // Generate a clean safe unique file name
                        $cleanName = PSEO_Helper::slugify(pathinfo($origName, PATHINFO_FILENAME)) . '-' . time() . '-' . rand(100, 999) . '.' . $ext;
                        $destPath = dirname(__DIR__, 2) . '/assets/uploads/' . $cleanName;
                        
                        if (move_uploaded_file($tmpPath, $destPath)) {
                            $uploadedPaths[] = 'assets/uploads/' . $cleanName;
                            logActivity('Tải ảnh pSEO Campaign', "Tải tệp ảnh lên từ chiến dịch: assets/uploads/$cleanName");
                        } else {
                            $errors[] = "$origName: Lỗi sao chép tệp tin.";
                        }
                    } else {
                        if ($_FILES['campaign_images']['error'][$i] !== UPLOAD_ERR_NO_FILE) {
                            $errors[] = $_FILES['campaign_images']['name'][$i] . ": Lỗi tải lên (Mã lỗi: " . $_FILES['campaign_images']['error'][$i] . ").";
                        }
                    }
                }
            }
            
            echo json_encode([
                'status' => count($uploadedPaths) > 0 ? 'success' : 'error',
                'uploaded' => $uploadedPaths,
                'errors' => $errors
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    // ----------------------------------------------------
    // AJAX CAMPAIGN IMPORT ENDPOINTS
    // ----------------------------------------------------
    if ($action === 'import_campaign_init') {
        header('Content-Type: application/json');
        $id = isset($_POST['campaign_id']) ? (int)$_POST['campaign_id'] : 0;
        try {
            $stmt = $db->prepare("SELECT * FROM pseo_campaigns WHERE id = ?");
            $stmt->execute([$id]);
            $campaign = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$campaign) {
                throw new Exception("Không tìm thấy chiến dịch!");
            }
            
            // Get locations/projects count matching this campaign's type
            $type = $campaign['type'];
            $stmtCount = $db->prepare("SELECT COUNT(*) FROM pseo_index WHERE type = ?");
            $stmtCount->execute([$type]);
            $expected = (int)$stmtCount->fetchColumn();
            
            if ($expected === 0) {
                throw new Exception("Hệ thống chỉ mục rỗng. Vui lòng bấm Tái thiết lập CSDL địa bàn trước khi chạy import chiến dịch.");
            }

            $start_time = date('Y-m-d H:i:s');
            $initial_log = "[" . date('H:i:s') . "] Khởi tạo tiến trình import chiến dịch: " . $campaign['keyword'] . "\n" .
                           "[" . date('H:i:s') . "] Số lượng bài viết dự kiến: " . number_format($expected) . "\n";
            
            $stmtUpdate = $db->prepare("UPDATE pseo_campaigns SET import_status = 'running', import_created = 0, import_expected = ?, import_start_time = ?, import_end_time = NULL, import_log = ? WHERE id = ?");
            $stmtUpdate->execute([$expected, $start_time, $initial_log, $id]);
            
            echo json_encode([
                'status' => 'success',
                'total_items' => $expected,
                'chunk_size' => 200,
                'total_chunks' => ceil($expected / 200)
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    if ($action === 'import_campaign_chunk') {
        header('Content-Type: application/json');
        $id = isset($_POST['campaign_id']) ? (int)$_POST['campaign_id'] : 0;
        $chunkIndex = isset($_POST['chunk_index']) ? (int)$_POST['chunk_index'] : 0;
        $chunkSize = isset($_POST['chunk_size']) ? (int)$_POST['chunk_size'] : 200;
        try {
            $stmt = $db->prepare("SELECT * FROM pseo_campaigns WHERE id = ?");
            $stmt->execute([$id]);
            $campaign = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$campaign) {
                throw new Exception("Không tìm thấy chiến dịch!");
            }
            
            $type = $campaign['type'];
            $offset = $chunkIndex * $chunkSize;
            
            // Fetch locations slice
            $stmtLocs = $db->prepare("SELECT slug, display_name FROM pseo_index WHERE type = ? ORDER BY slug ASC LIMIT ? OFFSET ?");
            $stmtLocs->bindValue(1, $type, PDO::PARAM_STR);
            $stmtLocs->bindValue(2, $chunkSize, PDO::PARAM_INT);
            $stmtLocs->bindValue(3, $offset, PDO::PARAM_INT);
            $stmtLocs->execute();
            $locs = $stmtLocs->fetchAll(PDO::FETCH_ASSOC);
            
            $count = count($locs);
            if ($count > 0) {
                // Build logs
                $logMsg = "[" . date('H:i:s') . "] Đã import nhóm " . ($chunkIndex + 1) . ": Xử lý " . $count . " bài viết thành công.\n";
                $logMsg .= "    » " . $locs[0]['display_name'];
                if ($count > 1) {
                    $logMsg .= " ... " . $locs[$count - 1]['display_name'];
                }
                $logMsg .= "\n";
                
                $newLog = ($campaign['import_log'] ?? '') . $logMsg;
                
                $stmtUpdate = $db->prepare("UPDATE pseo_campaigns SET import_created = import_created + ?, import_log = ? WHERE id = ?");
                $stmtUpdate->execute([$count, $newLog, $id]);
            }
            
            echo json_encode([
                'status' => 'success',
                'chunk_index' => $chunkIndex,
                'imported' => $count
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    if ($action === 'import_campaign_pause') {
        header('Content-Type: application/json');
        $id = isset($_POST['campaign_id']) ? (int)$_POST['campaign_id'] : 0;
        try {
            $stmt = $db->prepare("SELECT * FROM pseo_campaigns WHERE id = ?");
            $stmt->execute([$id]);
            $campaign = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$campaign) {
                throw new Exception("Không tìm thấy chiến dịch!");
            }
            
            $logMsg = "[" . date('H:i:s') . "] Tạm dừng tiến trình import chiến dịch.\n";
            $newLog = ($campaign['import_log'] ?? '') . $logMsg;
            
            $stmtUpdate = $db->prepare("UPDATE pseo_campaigns SET import_status = 'paused', import_log = ? WHERE id = ?");
            $stmtUpdate->execute([$newLog, $id]);
            
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    if ($action === 'import_campaign_resume') {
        header('Content-Type: application/json');
        $id = isset($_POST['campaign_id']) ? (int)$_POST['campaign_id'] : 0;
        try {
            $stmt = $db->prepare("SELECT * FROM pseo_campaigns WHERE id = ?");
            $stmt->execute([$id]);
            $campaign = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$campaign) {
                throw new Exception("Không tìm thấy chiến dịch!");
            }
            
            $logMsg = "[" . date('H:i:s') . "] Tiếp tục tiến trình import chiến dịch.\n";
            $newLog = ($campaign['import_log'] ?? '') . $logMsg;
            
            $stmtUpdate = $db->prepare("UPDATE pseo_campaigns SET import_status = 'running', import_log = ? WHERE id = ?");
            $stmtUpdate->execute([$newLog, $id]);
            
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    if ($action === 'import_campaign_reset') {
        header('Content-Type: application/json');
        $id = isset($_POST['campaign_id']) ? (int)$_POST['campaign_id'] : 0;
        try {
            $stmtUpdate = $db->prepare("UPDATE pseo_campaigns SET import_status = 'not_started', import_created = 0, import_expected = 0, import_start_time = NULL, import_end_time = NULL, import_log = NULL WHERE id = ?");
            $stmtUpdate->execute([$id]);
            
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    if ($action === 'import_campaign_finalize') {
        header('Content-Type: application/json');
        $id = isset($_POST['campaign_id']) ? (int)$_POST['campaign_id'] : 0;
        try {
            $stmt = $db->prepare("SELECT * FROM pseo_campaigns WHERE id = ?");
            $stmt->execute([$id]);
            $campaign = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$campaign) {
                throw new Exception("Không tìm thấy chiến dịch!");
            }
            
            $end_time = date('Y-m-d H:i:s');
            $logMsg = "[" . date('H:i:s') . "] Hoàn tất thành công import toàn bộ chiến dịch!\n" .
                      "[" . date('H:i:s') . "] Tổng số bài viết hiện tại đã sẵn sàng để truy cập và kiểm tra.\n";
            $newLog = ($campaign['import_log'] ?? '') . $logMsg;
            
            $stmtUpdate = $db->prepare("UPDATE pseo_campaigns SET import_status = 'completed', import_end_time = ?, import_log = ? WHERE id = ?");
            $stmtUpdate->execute([$end_time, $newLog, $id]);
            
            logActivity('Import chiến dịch pSEO hoàn tất', 'Import chiến dịch ID: ' . $id . ' (' . $campaign['keyword'] . ')');
            
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    if ($action === 'import_campaign_get_log') {
        header('Content-Type: application/json');
        $id = isset($_GET['campaign_id']) ? (int)$_GET['campaign_id'] : 0;
        try {
            $stmt = $db->prepare("SELECT import_log, keyword FROM pseo_campaigns WHERE id = ?");
            $stmt->execute([$id]);
            $campaign = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$campaign) {
                throw new Exception("Không tìm thấy chiến dịch!");
            }
            echo json_encode([
                'status' => 'success',
                'keyword' => $campaign['keyword'],
                'log' => $campaign['import_log'] ?: "Chưa có nhật ký hoạt động nào cho chiến dịch: " . $campaign['keyword']
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    // ----------------------------------------------------
    // AJAX REBUILD ACTION ENDPOINTS
    // ----------------------------------------------------
    if ($action === 'rebuild_ajax_init') {
        header('Content-Type: application/json');
        try {
            PSEO_Helper::prepareTempTable();
            $items = PSEO_Helper::getAllRawItems();
            echo json_encode([
                'status' => 'success',
                'total_items' => count($items),
                'chunk_size' => 400,
                'total_chunks' => ceil(count($items) / 400)
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    if ($action === 'rebuild_ajax_chunk') {
        header('Content-Type: application/json');
        $chunkIndex = isset($_POST['chunk_index']) ? (int)$_POST['chunk_index'] : 0;
        $chunkSize = isset($_POST['chunk_size']) ? (int)$_POST['chunk_size'] : 400;
        try {
            $imported = PSEO_Helper::importChunk($chunkIndex, $chunkSize);
            echo json_encode([
                'status' => 'success',
                'chunk_index' => $chunkIndex,
                'imported' => $imported
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    if ($action === 'rebuild_ajax_cancel') {
        header('Content-Type: application/json');
        try {
            PSEO_Helper::cancelRebuild();
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    if ($action === 'rebuild_ajax_finalize') {
        header('Content-Type: application/json');
        try {
            PSEO_Helper::finalizeRebuild();
            logActivity('Tái thiết lập CSDL pSEO', 'Quá trình AJAX Rebuild hoàn tất thành công');
            PageCache::clear();
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    // ----------------------------------------------------
    // SAVE GENERAL CONTACT INFO SETTINGS
    // ----------------------------------------------------
    if ($action === 'save_general_settings') {
        $pseo_phone = trim($_POST['pseo_phone'] ?? '');
        $pseo_website = trim($_POST['pseo_website'] ?? '');

        $stmt = $db->prepare("REPLACE INTO settings (`key`, `value`) VALUES ('pseo_phone', ?)");
        $stmt->execute([$pseo_phone]);
        $stmt = $db->prepare("REPLACE INTO settings (`key`, `value`) VALUES ('pseo_website', ?)");
        $stmt->execute([$pseo_website]);

        logActivity('Cập nhật pSEO Cấu hình chung', 'Lưu Số điện thoại và Website liên kết vệ tinh');
        $successMessage = 'Lưu cấu hình chung pSEO thành công!';
        PageCache::clear();
    }

    // ----------------------------------------------------
    // SAVE GLOBAL OPERATIONAL STATUS
    // ----------------------------------------------------
    if ($action === 'save_global_status') {
        $pseo_status = trim($_POST['pseo_status'] ?? 'live');
        
        $stmt = $db->prepare("REPLACE INTO settings (`key`, `value`) VALUES ('pseo_status', ?)");
        $stmt->execute([$pseo_status]);

        logActivity('Thay đổi trạng thái pSEO', 'Chuyển sang chế độ: ' . strtoupper($pseo_status));
        $successMessage = 'Cập nhật trạng thái hoạt động của Hệ thống vệ tinh pSEO thành công!';
        PageCache::clear();
    }

    // ----------------------------------------------------
    // BULK IMPORT CAMPAIGNS
    // ----------------------------------------------------
    if ($action === 'bulk_import_campaigns') {
        $bulk_text = trim($_POST['bulk_text'] ?? '');
        $default_title_price = '{Bảng Giá Xe VinFast Lăn Bánh Mới Nhất Tại|Giá Lăn Bánh Xe Ô Tô VinFast Ưu Đãi Tại|Bảng Báo Giá Xe VinFast Mới Nhất Ở} {LOCATION} | Giao Xe Tận Nhà';
        $default_title_dealer = '{Đại Lý Xe VinFast Chính Hãng Tại|Showroom Ủy Quyền VinFast 5S Sẵn Sàng Phục Vụ Tại|Đại Lý Ủy Quyền Đạt Chuẩn VinFast Terminal Tại} {LOCATION} | VIP Service';
        $default_content = '<p>Thông tin chi tiết về sản phẩm xe điện VinFast chính hãng và dịch vụ hỗ trợ tại {LOCATION}...</p>';
        
        if (empty($bulk_text)) {
            $errorMessage = 'Vui lòng nhập danh sách từ khóa!';
        } else {
            // Split by newlines
            $lines = preg_split('/\r\n|\r|\n/', $bulk_text);
            $importedCount = 0;
            $db->beginTransaction();
            try {
                $stmt = $db->prepare("INSERT INTO pseo_campaigns (keyword, slug, phone_number, website_link, title_templates, content_template, type, status, created_at) 
                                      VALUES (:keyword, :slug, :phone, :website, :title, :content, 'location', 'published', :created_at)
                                      ON DUPLICATE KEY UPDATE keyword = :keyword2, title_templates = :title2, content_template = :content2");
                
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (empty($line)) continue;
                    
                    // Format: keyword | slug (optional) | title_template (optional)
                    $parts = explode('|', $line);
                    $keyword = trim($parts[0]);
                    
                    // Slugify if slug is not specified
                    $slug = isset($parts[1]) && trim($parts[1]) !== '' ? trim($parts[1]) : PSEO_Helper::slugify($keyword);
                    $slug = PSEO_Helper::slugify($slug);
                    
                    // Custom title template if specified
                    $title = isset($parts[2]) && trim($parts[2]) !== '' ? trim($parts[2]) : (strpos($slug, 'dai-ly') !== false || strpos($slug, 'showroom') !== false ? $default_title_dealer : $default_title_price);
                    
                    $stmt->execute([
                        ':keyword' => $keyword,
                        ':slug' => $slug,
                        ':phone' => '0817777855', // Default Hotline
                        ':website' => 'http://localhost/vfstamphong/',
                        ':title' => $title,
                        ':content' => $default_content,
                        ':created_at' => date('Y-m-d H:i:s'),
                        ':keyword2' => $keyword,
                        ':title2' => $title,
                        ':content2' => $default_content
                    ]);
                    $importedCount++;
                }
                $db->commit();
                logActivity('Nhập hàng loạt chiến dịch pSEO', "Nhập thành công $importedCount chiến dịch từ quản trị");
                $successMessage = "Nhập hàng loạt thành công $importedCount chiến dịch pSEO!";
                PageCache::clear();
            } catch (Exception $e) {
                $db->rollBack();
                $errorMessage = 'Lỗi khi nhập hàng loạt: ' . $e->getMessage();
            }
        }
    }

    // ----------------------------------------------------
    // ADD NEW CAMPAIGN
    // ----------------------------------------------------
    if ($action === 'add_campaign') {
        $keyword = trim($_POST['keyword'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        if (empty($slug)) {
            $slug = PSEO_Helper::slugify($keyword);
        } else {
            $slug = PSEO_Helper::slugify($slug);
        }
        $type = trim($_POST['type'] ?? 'location');
        $phone_number = trim($_POST['phone_number'] ?? '');
        $website_link = trim($_POST['website_link'] ?? '');
        $title_templates = trim($_POST['title_templates'] ?? '');
        
        $images = $_POST['image_ids'] ?? [];
        $image_ids = is_array($images) ? implode(',', $images) : trim($images);
        
        $content_template = trim($_POST['content_template'] ?? '');
        $status = trim($_POST['status'] ?? 'published');

        if (empty($keyword) || empty($slug)) {
            $errorMessage = 'Vui lòng nhập đầy đủ Từ khóa chính và Đường dẫn tĩnh!';
        } else {
            // Check uniqueness of slug
            $stmtCheck = $db->prepare("SELECT COUNT(*) FROM pseo_campaigns WHERE slug = ?");
            $stmtCheck->execute([$slug]);
            if ($stmtCheck->fetchColumn() > 0) {
                $errorMessage = "Đường dẫn tĩnh '$slug' đã tồn tại! Vui lòng chọn đường dẫn khác.";
            } else {
                try {
                    $stmt = $db->prepare("INSERT INTO pseo_campaigns (keyword, slug, phone_number, website_link, title_templates, image_ids, content_template, type, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([
                        $keyword,
                        $slug,
                        $phone_number,
                        $website_link,
                        $title_templates,
                        $image_ids,
                        $content_template,
                        $type,
                        $status,
                        date('Y-m-d H:i:s')
                    ]);
                    logActivity('Tạo chiến dịch pSEO mới', "Tạo chiến dịch: $keyword ($slug)");
                    $successMessage = 'Tạo Chiến dịch pSEO PRO mới thành công!';
                    PageCache::clear();
                } catch (Exception $e) {
                    $errorMessage = 'Lỗi CSDL khi tạo chiến dịch: ' . $e->getMessage();
                }
            }
        }
    }

    // ----------------------------------------------------
    // UPDATE EXISTING CAMPAIGN
    // ----------------------------------------------------
    if ($action === 'update_campaign') {
        $id = (int)($_POST['id'] ?? 0);
        $keyword = trim($_POST['keyword'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $type = trim($_POST['type'] ?? 'location');
        $phone_number = trim($_POST['phone_number'] ?? '');
        $website_link = trim($_POST['website_link'] ?? '');
        $title_templates = trim($_POST['title_templates'] ?? '');
        
        $images = $_POST['image_ids'] ?? [];
        $image_ids = is_array($images) ? implode(',', $images) : trim($images);
        
        $content_template = trim($_POST['content_template'] ?? '');
        $status = trim($_POST['status'] ?? 'published');

        if (empty($keyword) || empty($slug) || $id <= 0) {
            $errorMessage = 'Dữ liệu cập nhật chiến dịch không hợp lệ!';
        } else {
            // Check uniqueness of slug ignoring current campaign
            $stmtCheck = $db->prepare("SELECT COUNT(*) FROM pseo_campaigns WHERE slug = ? AND id != ?");
            $stmtCheck->execute([$slug, $id]);
            if ($stmtCheck->fetchColumn() > 0) {
                $errorMessage = "Đường dẫn tĩnh '$slug' đã bị trùng lặp với chiến dịch khác!";
            } else {
                try {
                    $stmt = $db->prepare("UPDATE pseo_campaigns SET keyword = ?, slug = ?, phone_number = ?, website_link = ?, title_templates = ?, image_ids = ?, content_template = ?, type = ?, status = ? WHERE id = ?");
                    $stmt->execute([
                        $keyword,
                        $slug,
                        $phone_number,
                        $website_link,
                        $title_templates,
                        $image_ids,
                        $content_template,
                        $type,
                        $status,
                        $id
                    ]);
                    logActivity('Cập nhật chiến dịch pSEO', "Cập nhật chiến dịch: $keyword ($slug)");
                    $successMessage = 'Cập nhật cấu hình chiến dịch pSEO thành công!';
                    PageCache::clear();
                } catch (Exception $e) {
                    $errorMessage = 'Lỗi CSDL khi cập nhật chiến dịch: ' . $e->getMessage();
                }
            }
        }
    }

    // ----------------------------------------------------
    // DELETE CAMPAIGN
    // ----------------------------------------------------
    if ($action === 'delete_campaign') {
        $id = (int)($_POST['id'] ?? 0);
        
        // Fetch campaign to check slug and keyword name
        $stmtFetch = $db->prepare("SELECT * FROM pseo_campaigns WHERE id = ?");
        $stmtFetch->execute([$id]);
        $campaign = $stmtFetch->fetch();

        if (!$campaign) {
            $errorMessage = 'Chiến dịch không tồn tại hoặc đã bị xóa trước đó!';
        } elseif (in_array($campaign['slug'], ['gia-xe-VinFast', 'dai-ly-VinFast'])) {
            $errorMessage = 'Không thể xóa các chiến dịch mặc định cốt lõi của hệ thống!';
        } else {
            try {
                $stmt = $db->prepare("DELETE FROM pseo_campaigns WHERE id = ?");
                $stmt->execute([$id]);
                logActivity('Xóa chiến dịch pSEO', "Xóa chiến dịch vĩnh viễn: " . $campaign['keyword']);
                $successMessage = 'Đã loại bỏ chiến dịch vệ tinh pSEO khỏi hệ thống thành công!';
                PageCache::clear();
            } catch (Exception $e) {
                $errorMessage = 'Lỗi CSDL khi xóa chiến dịch: ' . $e->getMessage();
            }
        }
    }

    // ----------------------------------------------------
    // SAVE CORE OUTLINE SPIN TEXTS
    // ----------------------------------------------------
    if ($action === 'save_templates') {
        $pseo_title_price = trim($_POST['pseo_title_price']);
        $pseo_title_dealer = trim($_POST['pseo_title_dealer']);
        $pseo_desc_price = trim($_POST['pseo_desc_price']);
        $pseo_desc_dealer = trim($_POST['pseo_desc_dealer']);
        
        $pseo_content_price = trim($_POST['pseo_content_price']);
        $pseo_content_dealer = trim($_POST['pseo_content_dealer']);
        $pseo_content_project = trim($_POST['pseo_content_project']);

        $stmt = $db->prepare("REPLACE INTO settings (`key`, `value`) VALUES (?, ?)");
        $stmt->execute(['pseo_title_price', $pseo_title_price]);
        $stmt->execute(['pseo_title_dealer', $pseo_title_dealer]);
        $stmt->execute(['pseo_desc_price', $pseo_desc_price]);
        $stmt->execute(['pseo_desc_dealer', $pseo_desc_dealer]);
        
        $stmt->execute(['pseo_content_price', $pseo_content_price]);
        $stmt->execute(['pseo_content_dealer', $pseo_content_dealer]);
        $stmt->execute(['pseo_content_project', $pseo_content_project]);

        logActivity('Cập nhật pSEO Spintax Templates', 'Cập nhật tiêu đề, mô tả và nội dung Spintax vệ tinh');
        $successMessage = 'Lưu các cấu hình mẫu Spintax pSEO PRO thành công!';
        
        PageCache::clear();
    }

    if ($action === 'rebuild_index') {
        try {
            PSEO_Helper::buildIndex();
            logActivity('Xây dựng lại Chỉ mục pSEO', 'Biên dịch lại toàn bộ địa danh và chung cư từ JSON vào DB');
            $successMessage = 'Tái tạo và xây dựng lại CSDL Chỉ mục địa phương pSEO thành công!';
            PageCache::clear();
        } catch (Exception $e) {
            $errorMessage = 'Có lỗi xảy ra khi xây dựng chỉ mục: ' . $e->getMessage();
        }
    }

    if ($action === 'clear_cache') {
        PageCache::clear();
        logActivity('Xóa Bộ nhớ đệm Static Cache', 'Purge static HTML cache files');
        $successMessage = 'Xóa toàn bộ bộ nhớ đệm Static Page Cache thành công!';
    }
}






