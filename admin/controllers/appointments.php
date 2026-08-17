<?php
    // MODULE 3: APPOINTMENTS & LEAD ACTIONS
    // ==========================================
    if ($page === 'appointments') {
        if ($action === 'status') {
            $targetId = (int)$_POST['id'];
            $status = trim($_POST['status']);
            $assigned_sale_id = $_POST['assigned_sale_id'] ? (int)$_POST['assigned_sale_id'] : null;

            $stmt = $db->prepare("UPDATE leads SET status = ?, assigned_sale_id = ? WHERE id = ?");
            $stmt->execute([$status, $assigned_sale_id, $targetId]);
            logActivity('Cập nhật trạng thái lái thử', "Cập nhật Lịch hẹn ID #$targetId sang trạng thái: $status");
            $successMessage = 'Đã cập nhật trạng thái lịch hẹn & phân công nhân viên Sale thành công!';

            // Auto VIP CRM insertion upon successful deal closing
            if ($status === 'Đã chốt') {
                $stmtLead = $db->prepare("SELECT * FROM leads WHERE id = ?");
                $stmtLead->execute([$targetId]);
                $lead = $stmtLead->fetch();
                if ($lead) {
                    // Check if customer exists in CRM
                    $stmtCheck = $db->prepare("SELECT id FROM customers WHERE phone = ?");
                    $stmtCheck->execute([$lead['phone']]);
                    $custId = $stmtCheck->fetchColumn();

                    if (!$custId) {
                        $stmtCust = $db->prepare("INSERT INTO customers (fullname, phone, email, classification) VALUES (?, ?, ?, 'VIP')");
                        $stmtCust->execute([$lead['fullname'], $lead['phone'], $lead['email']]);
                        $custId = $db->lastInsertId();
                    } else {
                        $stmtCust = $db->prepare("UPDATE customers SET classification = 'VIP' WHERE id = ?");
                        $stmtCust->execute([$custId]);
                    }

                    // Log purchase history automatically
                    $stmtCar = $db->prepare("SELECT model_name, price FROM cars WHERE id = ?");
                    $stmtCar->execute([$lead['car_id']]);
                    $carData = $stmtCar->fetch();
                    $carName = $carData ? $carData['model_name'] : 'Dòng xe VinFast';
                    $carPrice = $carData ? $carData['price'] : 'Liên hệ';

                    $stmtCheckPurchase = $db->prepare("SELECT COUNT(*) FROM customer_cars WHERE customer_id = ? AND car_model = ?");
                    $stmtCheckPurchase->execute([$custId, $carName]);
                    if ($stmtCheckPurchase->fetchColumn() == 0) {
                        $stmtPur = $db->prepare("INSERT INTO customer_cars (customer_id, car_model, purchase_date, license_plate, price) VALUES (?, ?, ?, 'Đang đăng ký', ?)");
                        $stmtPur->execute([$custId, $carName, date('Y-m-d'), $carPrice]);
                    }
                }
            }
        }
        if ($action === 'delete') {
            $targetId = (int)$_POST['id'];
            $stmt = $db->prepare("DELETE FROM leads WHERE id = ?");
            $stmt->execute([$targetId]);
            logActivity('Xóa yêu cầu lái thử', "Xóa Lịch hẹn ID #$targetId");
            $successMessage = 'Đã xóa yêu cầu lái thử thành công!';
        }
    }





