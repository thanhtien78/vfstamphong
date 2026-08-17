<?php
    // MODULE 5: SERVICE & WORKSHOP ACTIONS
    // ==========================================
    if ($page === 'service') {
        if ($action === 'create_appointment') {
            $fullname = trim($_POST['fullname']);
            $phone = trim($_POST['phone']);
            $email = trim($_POST['email']);
            $license_plate = trim($_POST['license_plate']);
            $car_model = trim($_POST['car_model']);
            $appointment_date = trim($_POST['appointment_date']);
            $service_type = trim($_POST['service_type']);
            $assigned_tech_id = $_POST['assigned_tech_id'] ? (int)$_POST['assigned_tech_id'] : null;
            $status = trim($_POST['status']);
            $notes = trim($_POST['notes']);

            if ($fullname && $phone && $license_plate) {
                $stmt = $db->prepare("INSERT INTO service_appointments (fullname, phone, email, license_plate, car_model, appointment_date, service_type, assigned_tech_id, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$fullname, $phone, $email, $license_plate, $car_model, $appointment_date, $service_type, $assigned_tech_id, $status, $notes]);
                logActivity('Tạo lịch hẹn dịch vụ', "Khách hàng: $fullname, Biển xe: $license_plate");
                $successMessage = 'Tạo lịch hẹn dịch vụ mới thành công!';
            } else {
                $errorMessage = 'Vui lòng điền tên, số điện thoại và biển kiểm soát xe!';
            }
        }
        if ($action === 'edit_appointment') {
            $targetId = (int)$_POST['id'];
            $fullname = trim($_POST['fullname']);
            $phone = trim($_POST['phone']);
            $email = trim($_POST['email']);
            $license_plate = trim($_POST['license_plate']);
            $car_model = trim($_POST['car_model']);
            $appointment_date = trim($_POST['appointment_date']);
            $service_type = trim($_POST['service_type']);
            $assigned_tech_id = $_POST['assigned_tech_id'] ? (int)$_POST['assigned_tech_id'] : null;
            $status = trim($_POST['status']);
            $notes = trim($_POST['notes']);

            if ($fullname && $phone && $license_plate) {
                $stmt = $db->prepare("UPDATE service_appointments SET fullname = ?, phone = ?, email = ?, license_plate = ?, car_model = ?, appointment_date = ?, service_type = ?, assigned_tech_id = ?, status = ?, notes = ? WHERE id = ?");
                $stmt->execute([$fullname, $phone, $email, $license_plate, $car_model, $appointment_date, $service_type, $assigned_tech_id, $status, $notes, $targetId]);
                logActivity('Cập nhật hẹn dịch vụ', "Cập nhật Lịch hẹn dịch vụ ID #$targetId sang: $status");
                $successMessage = 'Cập nhật trạng thái bảo dưỡng dịch vụ thành công!';
            } else {
                $errorMessage = 'Vui lòng kiểm tra đầy đủ thông tin!';
            }
        }
        if ($action === 'delete_appointment') {
            $targetId = (int)$_POST['id'];
            $db->prepare("DELETE FROM service_appointments WHERE id = ?")->execute([$targetId]);
            logActivity('Xóa hẹn dịch vụ', "Xóa Lịch hẹn dịch vụ ID #$targetId");
            $successMessage = 'Đã xóa lịch hẹn sửa chữa!';
        }
    }





