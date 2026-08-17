<?php
/**
 * VinFast Administrative Helper Functions
 * Includes secure image upload utilities, multi-image WebP conversions, and database activity logger.
 */

// Secure helper function to handle server-side image uploads
function handleImageUpload($fileKey, $defaultUrl = '', &$errorOut = null) {
    if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['name'] !== '') {
        $error = $_FILES[$fileKey]['error'];
        if ($error !== UPLOAD_ERR_OK) {
            switch ($error) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $errorOut = 'Kích thước tệp tin quá lớn. Giới hạn tối đa của hệ thống là ' . ini_get('upload_max_filesize') . '.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $errorOut = 'Tệp tin chỉ được tải lên một phần. Vui lòng thử lại.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    break;
                default:
                    $errorOut = 'Lỗi tải tệp tin lên máy chủ (Mã lỗi: ' . $error . ').';
                    break;
            }
            return false;
        }

        $fileTmpPath = $_FILES[$fileKey]['tmp_name'];
        $fileName = $_FILES[$fileKey]['name'];
        $fileSize = $_FILES[$fileKey]['size'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($fileExtension, $allowedExtensions)) {
            $errorOut = 'Định dạng tệp không được hỗ trợ. Chỉ cho phép các định dạng: ' . implode(', ', $allowedExtensions) . '.';
            return false;
        }
        
        if ($fileSize > 15 * 1024 * 1024) { // limit 15MB
            $errorOut = 'Dung lượng ảnh vượt quá giới hạn cho phép (Tối đa 15MB).';
            return false;
        }

        $uploadFileDir = dirname(__DIR__) . '/assets/uploads/';
        if (!is_dir($uploadFileDir)) {
            if (!mkdir($uploadFileDir, 0755, true)) {
                $errorOut = 'Không thể tạo thư mục lưu trữ ảnh tải lên. Vui lòng kiểm tra quyền ghi của thư mục assets/uploads/.';
                return false;
            }
        }
        
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $dest_path = $uploadFileDir . $newFileName;
        
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            // Automatically convert JPG, JPEG, and PNG to optimized WebP format on the fly if GD library is enabled!
            if (extension_loaded('gd') && function_exists('imagewebp') && in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
                $webpFileName = md5(time() . $fileName) . '.webp';
                $webpPath = $uploadFileDir . $webpFileName;
                $gdImg = @imagecreatefromstring(file_get_contents($dest_path));
                if ($gdImg) {
                    if ($fileExtension === 'png') {
                        imagealphablending($gdImg, false);
                        imagesavealpha($gdImg, true);
                    }
                    if (imagewebp($gdImg, $webpPath, 75)) {
                        @unlink($dest_path); // delete original heavy file
                        imagedestroy($gdImg);
                        return 'assets/uploads/' . $webpFileName;
                    }
                    imagedestroy($gdImg);
                }
            }
            return 'assets/uploads/' . $newFileName;
        } else {
            $errorOut = 'Lỗi di chuyển tệp tin đã tải lên vào thư mục lưu trữ. Vui lòng kiểm tra quyền ghi thư mục.';
            return false;
        }
    }
    return $defaultUrl;
}

// Robust helper function to handle multiple uploaded files, convert them to WebP, and return a comma-separated list of paths
function handleMultipleImagesUpload($filesKey, $defaultString = '', &$errorOut = null) {
    if (!isset($_FILES[$filesKey]) || !is_array($_FILES[$filesKey]['name']) || empty($_FILES[$filesKey]['name'][0])) {
        return $defaultString;
    }
    
    $uploadedPaths = [];
    $files = $_FILES[$filesKey];
    $numFiles = count($files['name']);
    
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $uploadFileDir = dirname(__DIR__) . '/assets/uploads/';
    if (!is_dir($uploadFileDir)) {
        if (!mkdir($uploadFileDir, 0755, true)) {
            $errorOut = 'Không thể tạo thư mục lưu trữ ảnh.';
            return false;
        }
    }
    
    for ($i = 0; $i < $numFiles; $i++) {
        $error = $files['error'][$i];
        if ($error !== UPLOAD_ERR_OK) {
            continue; // Skip failed uploads
        }
        
        $fileTmpPath = $files['tmp_name'][$i];
        $fileName = $files['name'][$i];
        $fileSize = $files['size'][$i];
        
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        
        if (!in_array($fileExtension, $allowedExtensions)) {
            continue; // Skip invalid extensions
        }
        
        if ($fileSize > 15 * 1024 * 1024) {
            continue; // Skip large files
        }
        
        $newFileName = md5(time() . $fileName . rand(1, 1000)) . '.' . $fileExtension;
        $dest_path = $uploadFileDir . $newFileName;
        
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            // Convert to webp if GD library is enabled
            if (extension_loaded('gd') && function_exists('imagewebp')) {
                $webpPath = $uploadFileDir . md5($newFileName) . '.webp';
                $gdImg = @imagecreatefromstring(file_get_contents($dest_path));
                if ($gdImg) {
                    if ($fileExtension === 'png') {
                        imagealphablending($gdImg, false);
                        imagesavealpha($gdImg, true);
                    }
                    if (imagewebp($gdImg, $webpPath, 75)) {
                        unlink($dest_path); // delete original
                        $uploadedPaths[] = 'assets/uploads/' . basename($webpPath);
                    } else {
                        $uploadedPaths[] = 'assets/uploads/' . $newFileName;
                    }
                    imagedestroy($gdImg);
                } else {
                    $uploadedPaths[] = 'assets/uploads/' . $newFileName;
                }
            } else {
                $uploadedPaths[] = 'assets/uploads/' . $newFileName;
            }
        }
    }
    
    if (!empty($uploadedPaths)) {
        if (!empty($defaultString)) {
            return $defaultString . ',' . implode(',', $uploadedPaths);
        }
        return implode(',', $uploadedPaths);
    }
    
    return $defaultString;
}

// Secure helper function to record administrative activity logs in database
function logActivity($action, $detail = '') {
    global $db;
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $username = 'System';
    if ($userId) {
        try {
            $stmt = $db->prepare("SELECT username FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $username = $stmt->fetchColumn() ?: 'System';
        } catch (Exception $e) {}
    }
    try {
        $stmt = $db->prepare("INSERT INTO activity_logs (user_id, username, action, detail) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $username, $action, $detail]);
    } catch (Exception $e) {
        // Silently fail if logging error happens to prevent blocking core operations
    }
}
