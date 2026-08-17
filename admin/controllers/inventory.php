<?php
    // MODULE 2: CAR INVENTORY CRUD ACTIONS
    // ==========================================
    if ($page === 'inventory') {
        if ($action === 'create') {
            $model_name = trim($_POST['model_name']);
            $segment = trim($_POST['segment']);
            $engine = trim($_POST['engine']);
            $power = trim($_POST['power']);
            $torque = trim($_POST['torque']);
            $acceleration = trim($_POST['acceleration']);
            $top_speed = trim($_POST['top_speed']);
            $range_wltp = trim($_POST['range_wltp']);
            $price = trim($_POST['price']);
            
            $uploadError = null;
            $image = handleImageUpload('image_file', trim($_POST['image']), $uploadError);
            $image_exterior = handleMultipleImagesUpload('image_exterior_file', trim($_POST['image_exterior'] ?? ''), $uploadError);
            $image_interior = handleMultipleImagesUpload('image_interior_file', trim($_POST['image_interior'] ?? ''), $uploadError);
            $image_engine = handleMultipleImagesUpload('image_engine_file', trim($_POST['image_engine'] ?? ''), $uploadError);
            $image_specs = handleImageUpload('image_specs_file', trim($_POST['image_specs'] ?? ''), $uploadError);
            
            $video_url = trim($_POST['video_url']);
            $stock_status = trim($_POST['stock_status']);
            $stock_qty = (int)$_POST['stock_qty'];
            $exterior_colors = trim($_POST['exterior_colors']);
            $description = trim($_POST['description']);
            
            // New detailed car specifications
            $brochure_url = trim($_POST['brochure_url'] ?? '');
            $core_features = trim($_POST['core_features'] ?? '');
            
            // Process local file uploads for the 3 core features
            $core_feat_arr = json_decode($core_features, true);
            if (is_array($core_feat_arr)) {
                for ($i = 0; $i < 3; $i++) {
                    $fileKey = "core_feat_image_file_$i";
                    if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['name'] !== '') {
                        $defaultUrl = $core_feat_arr[$i]['image'] ?? '';
                        $uploadedPath = handleImageUpload($fileKey, $defaultUrl, $uploadError);
                        if ($uploadedPath === false) {
                            $image = false; // Trigger validation failure block below
                            break;
                        } else {
                            $core_feat_arr[$i]['image'] = $uploadedPath;
                        }
                    }
                }
                $core_features = json_encode($core_feat_arr, JSON_UNESCAPED_UNICODE);
            }
            
            $tech_highlights = trim($_POST['tech_highlights'] ?? '');
            $owner_benefits = trim($_POST['owner_benefits'] ?? '');

            $focus_keyword = trim($_POST['focus_keyword'] ?? '');
            $seo_title = trim($_POST['seo_title'] ?? '');
            $seo_desc = trim($_POST['seo_desc'] ?? '');
            $seo_canonical = trim($_POST['seo_canonical'] ?? '');
            
            // Custom slug handling for car
            $slugInput = trim($_POST['slug'] ?? '');
            if (!empty($slugInput)) {
                $slugStr = mb_strtolower($slugInput, 'UTF-8');
            } else {
                $slugStr = mb_strtolower($model_name, 'UTF-8');
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

            if ($image === false || $image_exterior === false || $image_interior === false || $image_engine === false || $image_specs === false) {
                $errorMessage = 'Lỗi tải ảnh dòng xe hoặc ảnh chi tiết: ' . $uploadError;
            } elseif ($model_name) {
                $stmt = $db->prepare("INSERT INTO cars (model_name, slug, segment, engine, power, torque, acceleration, top_speed, range_wltp, price, image, exterior_colors, description, video_url, stock_status, stock_qty, brochure_url, core_features, tech_highlights, owner_benefits, image_exterior, image_interior, image_engine, image_specs, focus_keyword, seo_title, seo_desc, seo_canonical) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$model_name, $slug, $segment, $engine, $power, $torque, $acceleration, $top_speed, $range_wltp, $price, $image, $exterior_colors, $description, $video_url, $stock_status, $stock_qty, $brochure_url, $core_features, $tech_highlights, $owner_benefits, $image_exterior, $image_interior, $image_engine, $image_specs, $focus_keyword, $seo_title, $seo_desc, $seo_canonical]);
                logActivity('Thêm xe mới', "Thêm dòng xe: $model_name, Giá: $price");
                $successMessage = 'Thêm dòng xe mới vào kho xe thành công!';
            } else {
                $errorMessage = 'Vui lòng điền tên dòng xe!';
            }
        }
        if ($action === 'edit') {
            $targetId = (int)$_POST['id'];
            $model_name = trim($_POST['model_name']);
            $segment = trim($_POST['segment']);
            $engine = trim($_POST['engine']);
            $power = trim($_POST['power']);
            $torque = trim($_POST['torque']);
            $acceleration = trim($_POST['acceleration']);
            $top_speed = trim($_POST['top_speed']);
            $range_wltp = trim($_POST['range_wltp']);
            $price = trim($_POST['price']);
            
            $uploadError = null;
            $image = handleImageUpload('image_file', trim($_POST['image']), $uploadError);
            $image_exterior = handleMultipleImagesUpload('image_exterior_file', trim($_POST['image_exterior'] ?? ''), $uploadError);
            $image_interior = handleMultipleImagesUpload('image_interior_file', trim($_POST['image_interior'] ?? ''), $uploadError);
            $image_engine = handleMultipleImagesUpload('image_engine_file', trim($_POST['image_engine'] ?? ''), $uploadError);
            $image_specs = handleImageUpload('image_specs_file', trim($_POST['image_specs'] ?? ''), $uploadError);
            
            $video_url = trim($_POST['video_url']);
            $stock_status = trim($_POST['stock_status']);
            $stock_qty = (int)$_POST['stock_qty'];
            $exterior_colors = trim($_POST['exterior_colors']);
            $description = trim($_POST['description']);
            
            // New detailed car specifications
            $brochure_url = trim($_POST['brochure_url'] ?? '');
            $core_features = trim($_POST['core_features'] ?? '');
            
            // Process local file uploads for the 3 core features
            $core_feat_arr = json_decode($core_features, true);
            if (is_array($core_feat_arr)) {
                for ($i = 0; $i < 3; $i++) {
                    $fileKey = "core_feat_image_file_$i";
                    if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['name'] !== '') {
                        $defaultUrl = $core_feat_arr[$i]['image'] ?? '';
                        $uploadedPath = handleImageUpload($fileKey, $defaultUrl, $uploadError);
                        if ($uploadedPath === false) {
                            $image = false; // Trigger validation failure block below
                            break;
                        } else {
                            $core_feat_arr[$i]['image'] = $uploadedPath;
                        }
                    }
                }
                $core_features = json_encode($core_feat_arr, JSON_UNESCAPED_UNICODE);
            }
            
            $tech_highlights = trim($_POST['tech_highlights'] ?? '');
            $owner_benefits = trim($_POST['owner_benefits'] ?? '');

            $focus_keyword = trim($_POST['focus_keyword'] ?? '');
            $seo_title = trim($_POST['seo_title'] ?? '');
            $seo_desc = trim($_POST['seo_desc'] ?? '');
            $seo_canonical = trim($_POST['seo_canonical'] ?? '');
            
            // Custom slug handling for car
            $slugInput = trim($_POST['slug'] ?? '');
            if (!empty($slugInput)) {
                $slugStr = mb_strtolower($slugInput, 'UTF-8');
            } else {
                $slugStr = mb_strtolower($model_name, 'UTF-8');
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

            if ($image === false || $image_exterior === false || $image_interior === false || $image_engine === false || $image_specs === false) {
                $errorMessage = 'Lỗi tải ảnh dòng xe hoặc ảnh chi tiết: ' . $uploadError;
            } elseif ($model_name) {
                // Fetch the current slug to check if it's being changed
                $stmtCheck = $db->prepare("SELECT slug FROM cars WHERE id = ?");
                $stmtCheck->execute([$targetId]);
                $currentCar = $stmtCheck->fetch(PDO::FETCH_ASSOC);
                $oldSlug = $currentCar ? ($currentCar['slug'] ?? '') : '';

                // If old slug is different from new slug, record a 301 redirect mapping
                if (!empty($oldSlug) && $oldSlug !== $slug) {
                    $stmtRedir = $db->prepare("REPLACE INTO redirects (old_url, new_url) VALUES (?, ?)");
                    $stmtRedir->execute([$oldSlug, $slug]);
                }

                $stmt = $db->prepare("UPDATE cars SET model_name = ?, slug = ?, segment = ?, engine = ?, power = ?, torque = ?, acceleration = ?, top_speed = ?, range_wltp = ?, price = ?, image = ?, exterior_colors = ?, description = ?, video_url = ?, stock_status = ?, stock_qty = ?, brochure_url = ?, core_features = ?, tech_highlights = ?, owner_benefits = ?, image_exterior = ?, image_interior = ?, image_engine = ?, image_specs = ?, focus_keyword = ?, seo_title = ?, seo_desc = ?, seo_canonical = ? WHERE id = ?");
                $stmt->execute([$model_name, $slug, $segment, $engine, $power, $torque, $acceleration, $top_speed, $range_wltp, $price, $image, $exterior_colors, $description, $video_url, $stock_status, $stock_qty, $brochure_url, $core_features, $tech_highlights, $owner_benefits, $image_exterior, $image_interior, $image_engine, $image_specs, $focus_keyword, $seo_title, $seo_desc, $seo_canonical, $targetId]);
                logActivity('Cập nhật xe', "Cập nhật thông số xe ID #$targetId ($model_name)");
                $successMessage = 'Cập nhật thông tin dòng xe thành công!';
            } else {
                $errorMessage = 'Vui lòng điền tên dòng xe!';
            }
        }
        if ($action === 'delete') {
            $targetId = (int)$_POST['id'];
            $stmt = $db->prepare("DELETE FROM cars WHERE id = ?");
            $stmt->execute([$targetId]);
            logActivity('Xóa xe', "Xóa dòng xe ID #$targetId");
            $successMessage = 'Đã xóa thông tin xe ra khỏi cơ sở dữ liệu!';
        }
    }





