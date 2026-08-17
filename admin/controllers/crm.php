<?php
    // MODULE 4: CRM CUSTOMER ACTIONS
    // ==========================================
    if ($page === 'crm') {
        // Automatically check & initialize database column next_followup_date
        try {
            $db->exec("ALTER TABLE customers ADD COLUMN next_followup_date DATE NULL");
        } catch (Exception $e) {
            // Column already exists, ignore
        }

        if ($action === 'create_customer') {
            $fullname = trim($_POST['fullname']);
            $phone = trim($_POST['phone']);
            $email = trim($_POST['email']);
            $classification = trim($_POST['classification']);
            $next_followup = !empty($_POST['next_followup_date']) ? $_POST['next_followup_date'] : null;

            if ($fullname && $phone) {
                $stmt = $db->prepare("INSERT INTO customers (fullname, phone, email, classification, next_followup_date) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$fullname, $phone, $email, $classification, $next_followup]);
                logActivity('Thêm hồ sơ CRM', "Thêm khách hàng: $fullname ($phone)");
                $successMessage = 'Thêm hồ sơ khách hàng mới vào hệ thống CRM thành công!';
            } else {
                $errorMessage = 'Vui lòng nhập đầy đủ Tên và Số điện thoại khách hàng!';
            }
        }
        
        if ($action === 'edit_customer') {
            $targetId = (int)$_POST['id'];
            $fullname = trim($_POST['fullname']);
            $phone = trim($_POST['phone']);
            $email = trim($_POST['email']);
            $classification = trim($_POST['classification']);
            $next_followup = !empty($_POST['next_followup_date']) ? $_POST['next_followup_date'] : null;

            if ($fullname && $phone) {
                $stmt = $db->prepare("UPDATE customers SET fullname = ?, phone = ?, email = ?, classification = ?, next_followup_date = ? WHERE id = ?");
                $stmt->execute([$fullname, $phone, $email, $classification, $next_followup, $targetId]);
                logActivity('Cập nhật CRM', "Cập nhật hồ sơ khách hàng ID #$targetId ($fullname)");
                $successMessage = 'Cập nhật thông tin khách hàng thành công!';
            } else {
                $errorMessage = 'Vui lòng điền Tên và Số điện thoại!';
            }
        }

        if ($action === 'delete_customer') {
            $targetId = (int)$_POST['id'];
            $db->prepare("DELETE FROM customers WHERE id = ?")->execute([$targetId]);
            $db->prepare("DELETE FROM customer_cars WHERE customer_id = ?")->execute([$targetId]);
            $db->prepare("DELETE FROM customer_care_logs WHERE customer_id = ?")->execute([$targetId]);
            logActivity('Xóa hồ sơ CRM', "Xóa khách hàng ID #$targetId");
            $successMessage = 'Đã xóa hoàn toàn hồ sơ khách hàng và dữ liệu liên quan!';
        }

        if ($action === 'add_purchase') {
            $customer_id = (int)$_POST['customer_id'];
            $car_model = trim($_POST['car_model']);
            $license_plate = trim($_POST['license_plate']);
            $purchase_date = trim($_POST['purchase_date']);
            $price = trim($_POST['price']);

            if ($car_model) {
                $stmt = $db->prepare("INSERT INTO customer_cars (customer_id, car_model, purchase_date, license_plate, price) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$customer_id, $car_model, $purchase_date, $license_plate, $price]);
                
                // Auto upgrade classification to vip/bought
                $db->prepare("UPDATE customers SET classification = 'Đã mua xe' WHERE id = ? AND classification != 'VIP'")->execute([$customer_id]);
                logActivity('Ghi nhận mua xe', "Khách hàng ID #$customer_id mua xe: $car_model ($license_plate)");
                $successMessage = 'Ghi nhận lịch sử mua xe thành công!';
            }
        }

        if ($action === 'add_care_log') {
            $customer_id = (int)$_POST['customer_id'];
            $notes = trim($_POST['notes']);
            $next_followup = !empty($_POST['next_followup_date']) ? $_POST['next_followup_date'] : null;
            $sale_id = $userId; // current logged-in sale user

            if ($notes) {
                $stmt = $db->prepare("INSERT INTO customer_care_logs (customer_id, sale_id, notes) VALUES (?, ?, ?)");
                $stmt->execute([$customer_id, $sale_id, $notes]);
                
                // Update next follow-up date on the customer
                $stmtUpdate = $db->prepare("UPDATE customers SET next_followup_date = ? WHERE id = ?");
                $stmtUpdate->execute([$next_followup, $customer_id]);
                
                logActivity('Thêm nhật ký chăm sóc', "Thêm nhật ký cho khách hàng ID #$customer_id");
                $successMessage = 'Thêm nhật ký chăm sóc khách hàng mới thành công!';
            }
        }

        // Advanced Feature: Import Homepage Test Drive Lead to CRM
        if ($action === 'import_lead') {
            $leadId = (int)$_POST['lead_id'];
            
            $stmtLead = $db->prepare("SELECT * FROM leads WHERE id = ?");
            $stmtLead->execute([$leadId]);
            $lead = $stmtLead->fetch();
            
            if ($lead) {
                // Check if already exists in CRM via phone
                $stmtCheck = $db->prepare("SELECT id FROM customers WHERE phone = ?");
                $stmtCheck->execute([$lead['phone']]);
                $existsId = $stmtCheck->fetchColumn();
                
                if (!$existsId) {
                    // Create customer profile
                    $stmtCust = $db->prepare("INSERT INTO customers (fullname, phone, email, classification) VALUES (?, ?, ?, 'Tiềm năng')");
                    $stmtCust->execute([$lead['fullname'], $lead['phone'], $lead['email']]);
                    $existsId = $db->lastInsertId();
                    
                    // Create first care log indicating website source
                    $stmtCar = $db->prepare("SELECT model_name FROM cars WHERE id = ?");
                    $stmtCar->execute([$lead['car_id']]);
                    $carName = $stmtCar->fetchColumn() ?: 'Dòng xe VinFast';
                    
                    $careNote = "Đồng bộ từ yêu cầu lái thử trên website. Xe quan tâm: $carName. Ngày lái thử mong muốn: " . ($lead['preferred_date'] ?: 'N/A');
                    $db->prepare("INSERT INTO customer_care_logs (customer_id, sale_id, notes) VALUES (?, ?, ?)")->execute([$existsId, $userId, $careNote]);
                    
                    // Update lead status
                    $db->prepare("UPDATE leads SET status = 'Đã tiếp nhận' WHERE id = ?")->execute([$leadId]);
                    
                    logActivity('Đồng bộ Lead sang CRM', "Chuyển đổi lead #$leadId ({$lead['fullname']}) thành khách hàng CRM");
                    $successMessage = 'Đã chuyển đổi và đồng bộ Lead đăng ký lái thử thành công!';
                } else {
                    $errorMessage = 'Khách hàng này đã tồn tại trong hệ thống CRM (trùng số điện thoại)!';
                }
            } else {
                $errorMessage = 'Không tìm thấy Lead tương ứng!';
            }
        }

        // Action to convert lead directly to a customer who has purchased a vehicle
        if ($action === 'convert_lead_to_buyer') {
            $leadId = (int)$_POST['lead_id'];
            
            $stmtLead = $db->prepare("SELECT * FROM leads WHERE id = ?");
            $stmtLead->execute([$leadId]);
            $lead = $stmtLead->fetch();
            
            if ($lead) {
                // Check if already exists in CRM via phone
                $stmtCheck = $db->prepare("SELECT id FROM customers WHERE phone = ?");
                $stmtCheck->execute([$lead['phone']]);
                $existsId = $stmtCheck->fetchColumn();
                
                if (!$existsId) {
                    // Create customer profile with status 'Đã mua xe'
                    $stmtCust = $db->prepare("INSERT INTO customers (fullname, phone, email, classification) VALUES (?, ?, ?, 'Đã mua xe')");
                    $stmtCust->execute([$lead['fullname'], $lead['phone'], $lead['email']]);
                    $existsId = $db->lastInsertId();
                } else {
                    // Update classification to 'Đã mua xe'
                    $stmtUpdateCust = $db->prepare("UPDATE customers SET classification = 'Đã mua xe' WHERE id = ?");
                    $stmtUpdateCust->execute([$existsId]);
                }
                
                // Get car model name and price
                $stmtCar = $db->prepare("SELECT model_name, price FROM cars WHERE id = ?");
                $stmtCar->execute([$lead['car_id']]);
                $car = $stmtCar->fetch();
                $carName = $car ? $car['model_name'] : 'Dòng xe VinFast';
                $carPrice = $car ? $car['price'] : '-';
                
                // Insert into customer_cars
                $stmtInsertCar = $db->prepare("INSERT INTO customer_cars (customer_id, car_model, purchase_date, price) VALUES (?, ?, ?, ?)");
                $stmtInsertCar->execute([$existsId, $carName, date('Y-m-d'), $carPrice]);
                
                // Create a care log indicating purchase
                $careNote = "Hệ thống tự động chuyển đổi từ Lead đăng ký. KHÁCH ĐÃ CHỐT MUA XE: $carName. Giá hợp đồng: $carPrice.";
                $db->prepare("INSERT INTO customer_care_logs (customer_id, sale_id, notes) VALUES (?, ?, ?)")->execute([$existsId, $userId, $careNote]);
                
                // Update lead status
                $db->prepare("UPDATE leads SET status = 'Đã chốt mua xe' WHERE id = ?")->execute([$leadId]);
                
                logActivity('Lead chốt mua xe sang CRM', "Chuyển đổi lead #$leadId ({$lead['fullname']}) sang khách hàng đã mua xe: $carName");
                $successMessage = 'Đã chuyển đổi thành công khách hàng đăng ký sang nhóm Đã mua xe trong CRM!';
            } else {
                $errorMessage = 'Không tìm thấy Lead tương ứng!';
            }
        }

        // AJAX Action: Clear follow-up reminder date
        if ($action === 'clear_followup_ajax') {
            header('Content-Type: application/json');
            $targetId = (int)$_POST['id'];
            if ($targetId > 0) {
                $stmt = $db->prepare("UPDATE customers SET next_followup_date = NULL WHERE id = ?");
                $stmt->execute([$targetId]);
                logActivity('Xử lý lịch hẹn CRM', "Hoàn tất lịch hẹn chăm sóc khách hàng ID #$targetId");
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'ID không hợp lệ']);
            }
            exit;
        }

        // AJAX Action: Drag-drop classification pipeline updater
        if ($action === 'update_classification_ajax') {
            header('Content-Type: application/json');
            $targetId = (int)$_POST['id'];
            $classification = trim($_POST['classification']);
            $allowed = ['Tiềm năng', 'VIP', 'Đã mua xe', 'Thành viên'];
            
            if ($targetId > 0 && in_array($classification, $allowed)) {
                $stmt = $db->prepare("UPDATE customers SET classification = ? WHERE id = ?");
                $stmt->execute([$classification, $targetId]);
                logActivity('Cập nhật phân loại CRM', "Chuyển đổi khách hàng ID #$targetId sang: $classification");
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Dữ liệu không hợp lệ']);
            }
            exit;
        }
    }






