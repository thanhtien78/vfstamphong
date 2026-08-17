<?php
    if ($page === 'counselors') {
        if ($action === 'create_counselor') {
            $fullname = trim($_POST['fullname']);
            $phone = trim($_POST['phone']);
            $zalo = trim($_POST['zalo']);
            $status = trim($_POST['status']);
            $assigned_areas = '';
            if (isset($_POST['assigned_areas'])) {
                $areas = array_filter(array_map('trim', explode(',', $_POST['assigned_areas'])));
                $assigned_areas = implode(',', array_map('strtolower', $areas));
            }
            
            $uploadError = null;
            $avatar = handleImageUpload('avatar_file', trim($_POST['avatar'] ?? ''), $uploadError);

            if ($fullname && $phone && $zalo && !$uploadError) {
                $stmt = $db->prepare("INSERT INTO counselors (fullname, phone, zalo, avatar, status, assigned_areas) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$fullname, $phone, $zalo, $avatar, $status, $assigned_areas]);
                logActivity('Tạo mới tư vấn viên', "Thêm tư vấn viên: $fullname ($phone)");
                $successMessage = 'Tạo mới tư vấn viên hỗ trợ VIP thành công!';
            } else {
                $errorMessage = $uploadError ? 'Tải ảnh đại diện thất bại: ' . $uploadError : 'Vui lòng điền đầy đủ các trường thông tin bắt buộc!';
            }
        }
        if ($action === 'edit_counselor') {
            $id = (int)$_POST['id'];
            $fullname = trim($_POST['fullname']);
            $phone = trim($_POST['phone']);
            $zalo = trim($_POST['zalo']);
            $status = trim($_POST['status']);
            $assigned_areas = '';
            if (isset($_POST['assigned_areas'])) {
                $areas = array_filter(array_map('trim', explode(',', $_POST['assigned_areas'])));
                $assigned_areas = implode(',', array_map('strtolower', $areas));
            }
            
            $uploadError = null;
            $avatar = handleImageUpload('avatar_file', trim($_POST['avatar'] ?? ''), $uploadError);

            if ($id && $fullname && $phone && $zalo && !$uploadError) {
                $stmt = $db->prepare("UPDATE counselors SET fullname = ?, phone = ?, zalo = ?, avatar = ?, status = ?, assigned_areas = ? WHERE id = ?");
                $stmt->execute([$fullname, $phone, $zalo, $avatar, $status, $assigned_areas, $id]);
                logActivity('Cập nhật tư vấn viên', "Cập nhật tư vấn viên ID #$id: $fullname");
                $successMessage = 'Cập nhật thông tin tư vấn viên thành công!';
            } else {
                $errorMessage = $uploadError ? 'Tải ảnh đại diện thất bại: ' . $uploadError : 'Vui lòng điền đầy đủ các thông tin bắt buộc!';
            }
        }
        if ($action === 'delete_counselor') {
            $id = (int)$_POST['id'];
            if ($id > 0) {
                $stmtFetch = $db->prepare("SELECT fullname FROM counselors WHERE id = ?");
                $stmtFetch->execute([$id]);
                $name = $stmtFetch->fetchColumn();

                $stmt = $db->prepare("DELETE FROM counselors WHERE id = ?");
                $stmt->execute([$id]);
                logActivity('Xóa tư vấn viên', "Xóa tư vấn viên ID #$id: $name");
                $successMessage = 'Đã xóa tư vấn viên khỏi danh sách hiển thị!';
            }
        }
    }
