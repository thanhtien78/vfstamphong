<?php
    // MODULE 1: MEDIA LIBRARY ACTIONS
    // ==========================================
    if ($page === 'media') {
        if ($action === 'upload_media') {
            $uploadError = null;
            $uploaded = handleImageUpload('media_file', '', $uploadError);
            if ($uploaded) {
                logActivity('Tải ảnh Media', "Tải tệp ảnh lên: $uploaded");
                $successMessage = 'Tải hình ảnh lên thư viện Media thành công!';
            } else {
                $errorMessage = 'Tải hình ảnh lên thất bại: ' . $uploadError;
            }
        }
        if ($action === 'delete_media') {
            $filePath = isset($_POST['file_path']) ? trim($_POST['file_path']) : '';
            // Security check: validate that path is strictly within assets/uploads/ to prevent arbitrary deletion
            if ($filePath && str_starts_with($filePath, 'assets/uploads/') && !str_contains($filePath, '..')) {
                $fullPath = dirname(__DIR__, 2) . '/' . $filePath;
                if (file_exists($fullPath)) {
                    if (unlink($fullPath)) {
                        logActivity('Xóa ảnh Media', "Xóa tệp ảnh vĩnh viễn: $filePath");
                        $successMessage = 'Đã xóa tệp tin hình ảnh khỏi máy chủ thành công!';
                    } else {
                        $errorMessage = 'Không thể xóa tệp tin trên máy chủ. Vui lòng kiểm tra quyền ghi của thư mục!';
                    }
                } else {
                    $errorMessage = 'Tệp tin không tồn tại hoặc đã bị xóa trước đó!';
                }
            } else {
                $errorMessage = 'Đường dẫn tệp tin không hợp lệ hoặc bị chặn vì lý do bảo mật!';
            }
        }
        if ($action === 'delete_multiple_media') {
            $filePaths = isset($_POST['file_paths']) ? $_POST['file_paths'] : '';
            $pathsArray = [];
            if (is_array($filePaths)) {
                $pathsArray = $filePaths;
            } else {
                $pathsArray = json_decode($filePaths, true) ?: [];
            }
            
            $deletedCount = 0;
            $failedCount = 0;
            foreach ($pathsArray as $filePath) {
                $filePath = trim($filePath);
                if ($filePath && str_starts_with($filePath, 'assets/uploads/') && !str_contains($filePath, '..')) {
                    $fullPath = dirname(__DIR__, 2) . '/' . $filePath;
                    if (file_exists($fullPath)) {
                        if (unlink($fullPath)) {
                            $deletedCount++;
                        } else {
                            $failedCount++;
                        }
                    }
                }
            }
            if ($deletedCount > 0) {
                logActivity('Xóa nhiều ảnh Media', "Xóa thành công $deletedCount tệp ảnh vĩnh viễn");
                $successMessage = "Đã xóa thành công $deletedCount hình ảnh khỏi máy chủ!";
                if ($failedCount > 0) {
                    $errorMessage = "Có $failedCount hình ảnh không thể xóa được.";
                }
            } else {
                $errorMessage = 'Không thể xóa các hình ảnh đã chọn. Vui lòng kiểm tra quyền ghi của thư mục!';
            }
        }
    }





