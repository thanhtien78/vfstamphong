      <?php
        $serviceIdToEdit = isset($_GET['edit_service_id']) ? (int)$_GET['edit_service_id'] : 0;
        $editService = null;
        if ($serviceIdToEdit > 0) {
            $stmt = $db->prepare("SELECT * FROM service_appointments WHERE id = ?");
            $stmt->execute([$serviceIdToEdit]);
            $editService = $stmt->fetch();
        }
      ?>
      <div class="layout-split layout-split--wide-left">
        <div>
          <!-- Active Service Workshop Live Monitor -->
          <div class="card">
            <div class="card__title" style="color:#ef5350; border-left-color:#ef5350;">
              <span class="pulse-dot pulse-dot--red"></span>Giám sát Xưởng bảo dưỡng (Workshop Live Monitor)
            </div>
            <p style="font-size:13px; color:var(--color-text-muted); margin-bottom:10px;">
              Dưới đây là các phương tiện hiện đang nằm trong xưởng dịch vụ và đang được đội ngũ kỹ thuật viên tiến hành bảo trì/sửa chữa thực tế.
            </p>

            <div class="table-container">
              <table class="cms-table">
                <thead>
                  <tr>
                    <th>Biển số xe</th>
                    <th>Dòng xe</th>
                    <th>Khách hàng</th>
                    <th>Phân loại dịch vụ</th>
                    <th>Kỹ thuật viên phụ trách</th>
                    <th>Mô tả lỗi / Ghi chú</th>
                    <th>Thao tác</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $stmtWorkshop = $db->prepare("SELECT sa.*, u.fullname as tech_name FROM service_appointments sa LEFT JOIN users u ON sa.assigned_tech_id = u.id WHERE sa.status = 'Đang sửa chữa' ORDER BY sa.id DESC");
                    $stmtWorkshop->execute();
                    $workshopCars = $workshopCarsList = $workshopCarsResult = $stmtWorkshop->fetchAll();
                    if (empty($workshopCars)) {
                        echo '<tr><td colspan="7" style="text-align:center; color:var(--color-text-muted); padding:20px;">Hiện tại không có phương tiện nào đang sửa chữa trong xưởng dịch vụ.</td></tr>';
                    } else {
                        foreach ($workshopCars as $wc) {
                            echo '<tr>';
                            echo '<td><span style="font-family:monospace; background:#e53935; color:#fff; padding:6px 10px; border-radius:4px; font-weight:bold;">' . htmlspecialchars($wc['license_plate']) . '</span></td>';
                            echo '<td><strong>' . htmlspecialchars($wc['car_model']) . '</strong></td>';
                            echo '<td>' . htmlspecialchars($wc['fullname']) . '<br><span style="font-size:11px; color:var(--color-text-muted);">' . htmlspecialchars($wc['phone']) . '</span></td>';
                            echo '<td><span class="status-badge status-badge--contacting">' . htmlspecialchars($wc['service_type']) . '</span></td>';
                            echo '<td><strong>' . htmlspecialchars($wc['tech_name'] ?? 'Chưa chỉ định') . '</strong></td>';
                            echo '<td style="font-size:12px;">' . htmlspecialchars($wc['notes']) . '</td>';
                            echo '<td>';
                            echo '<form method="POST" action="admin.php?p=service" style="display:inline-block;">';
                            echo '<input type="hidden" name="action" value="edit_appointment">';
                            echo '<input type="hidden" name="id" value="' . $wc['id'] . '">';
                            echo '<input type="hidden" name="fullname" value="' . htmlspecialchars($wc['fullname']) . '">';
                            echo '<input type="hidden" name="phone" value="' . htmlspecialchars($wc['phone']) . '">';
                            echo '<input type="hidden" name="license_plate" value="' . htmlspecialchars($wc['license_plate']) . '">';
                            echo '<input type="hidden" name="car_model" value="' . htmlspecialchars($wc['car_model']) . '">';
                            echo '<input type="hidden" name="appointment_date" value="' . htmlspecialchars($wc['appointment_date']) . '">';
                            echo '<input type="hidden" name="service_type" value="' . htmlspecialchars($wc['service_type']) . '">';
                            echo '<input type="hidden" name="assigned_tech_id" value="' . $wc['assigned_tech_id'] . '">';
                            echo '<input type="hidden" name="notes" value="' . htmlspecialchars($wc['notes']) . '">';
                            echo '<input type="hidden" name="status" value="Đã hoàn thành">';
                            echo '<button type="submit" class="btn-gold" style="padding:6px 12px; font-size:10px; box-shadow:none; color:#a5d6a7; border-color:#a5d6a7;">✓ Hoàn thành</button>';
                            echo '</form>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- All Service Scheduling Appointments list -->
          <div class="card">
            <div class="card__title">Nhật ký tiếp nhận dịch vụ & Lịch bảo dưỡng</div>
            <div style="margin-top: 15px; margin-bottom: 15px; display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 15px;">
              <div>
                <input class="form-input" type="text" id="search_svc" placeholder="🔍 Nhập biển kiểm soát, tên chủ xe hoặc dòng xe..." onkeyup="filterServiceTable()">
              </div>
              <div>
                <select class="form-input" id="filter_svc_status" onchange="filterServiceTable()">
                  <option value="">-- Tất cả trạng thái --</option>
                  <option value="Chờ tiếp nhận">Chờ tiếp nhận</option>
                  <option value="Đang sửa chữa">Đang sửa chữa</option>
                  <option value="Đã hoàn thành">Đã hoàn thành</option>
                  <option value="Đã giao xe">Đã giao xe</option>
                  <option value="Hủy">Hủy</option>
                </select>
              </div>
            </div>

            <script>
              function filterServiceTable() {
                const query = document.getElementById('search_svc').value.toLowerCase();
                const statusFilter = document.getElementById('filter_svc_status').value;
                const rows = document.querySelectorAll('.cms-table tbody tr');
                
                rows.forEach(row => {
                  const parentCard = row.closest('.card');
                  if (!parentCard || !parentCard.contains(document.getElementById('search_svc'))) return;
                  
                  if (row.cells.length < 8) return;
                  const plate = row.cells[1] ? row.cells[1].textContent.toLowerCase() : '';
                  const name = row.cells[2] ? row.cells[2].textContent.toLowerCase() : '';
                  const model = row.cells[3] ? row.cells[3].textContent.toLowerCase() : '';
                  const status = row.cells[6] ? row.cells[6].textContent.trim() : '';
                  
                  const matchesSearch = plate.includes(query) || name.includes(query) || model.includes(query);
                  const matchesStatus = !statusFilter || status === statusFilter;
                  
                  if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                  } else {
                    row.style.display = 'none';
                  }
                });
              }
            </script>

            <div class="table-container">
              <table class="cms-table">
                <thead>
                  <tr>
                    <th>Ngày hẹn</th>
                    <th>Biển kiểm soát</th>
                    <th>Khách hàng</th>
                    <th>Dòng xe</th>
                    <th>Nội dung bảo dưỡng</th>
                    <th>Kỹ thuật viên</th>
                    <th>Trạng thái xe</th>
                    <th>Thao tác</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $stmtAllService = $db->query("SELECT sa.*, u.fullname as tech_name FROM service_appointments sa LEFT JOIN users u ON sa.assigned_tech_id = u.id ORDER BY sa.id DESC");
                    $allServices = $allServicesList = $allServicesResult = $stmtAllService->fetchAll();
                    foreach ($allServices as $as) {
                        $statusBadge = 'status-badge--pending'; // Chờ tiếp nhận
                        if ($as['status'] === 'Đang sửa chữa') $statusBadge = 'status-badge--contacting';
                        elseif ($as['status'] === 'Đã hoàn thành') $statusBadge = 'status-badge--success';
                        elseif ($as['status'] === 'Đã giao xe') $statusBadge = 'status-badge--completed';
                        elseif ($as['status'] === 'Hủy') $statusBadge = 'status-badge--failed';

                        echo '<tr>';
                        echo '<td style="font-weight:600; color:var(--color-primary);">' . date('d/m/Y H:i', strtotime($as['appointment_date'])) . '</td>';
                        echo '<td><span style="font-family:monospace; background:rgba(0,0,0,0.3); padding:4px 8px; border-radius:4px; border:1px solid var(--color-border); font-weight:bold;">' . htmlspecialchars($as['license_plate']) . '</span></td>';
                        echo '<td><strong>' . htmlspecialchars($as['fullname']) . '</strong><br><span style="font-size:11px; color:var(--color-text-muted);">' . htmlspecialchars($as['phone']) . '</span></td>';
                        echo '<td>' . htmlspecialchars($as['car_model']) . '</td>';
                        echo '<td>' . htmlspecialchars($as['service_type']) . '</td>';
                        echo '<td>' . htmlspecialchars($as['tech_name'] ?? 'Chưa phân công') . '</td>';
                        echo '<td><span class="status-badge ' . $statusBadge . '">' . htmlspecialchars($as['status']) . '</span></td>';
                        echo '<td>';
                        echo '<a href="admin.php?p=service&edit_service_id=' . $as['id'] . '" class="btn-gold" style="padding:4px 8px; font-size:10px; box-shadow:none; margin-right:5px;">Sửa</a>';
                        echo '<form method="POST" action="admin.php?p=service" style="display:inline-block;" onsubmit="return confirm(\'Xóa lịch hẹn dịch vụ này?\')">';
                        echo '<input type="hidden" name="action" value="delete_appointment">';
                        echo '<input type="hidden" name="id" value="' . $as['id'] . '">';
                        echo '<button type="submit" class="btn-danger" style="font-size:10px;">Xóa</button>';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div>
          <!-- Service registration / Editing panel -->
          <div class="card inline-action-card">
            <div class="card__title"><?php echo $editService ? 'Cập nhật lịch bảo dưỡng #' . $editService['id'] : 'Đăng ký tiếp nhận bảo dưỡng mới'; ?></div>
            <form method="POST" action="admin.php?p=service">
              <input type="hidden" name="action" value="<?php echo $editService ? 'edit_appointment' : 'create_appointment'; ?>">
              <?php if ($editService): ?>
                <input type="hidden" name="id" value="<?php echo $editService['id']; ?>">
              <?php endif; ?>

              <div class="form-group">
                <label class="form-label" for="cust_fullname">Họ tên chủ xe *</label>
                <input class="form-input" type="text" name="fullname" id="cust_fullname" required value="<?php echo $editService ? htmlspecialchars($editService['fullname']) : ''; ?>" placeholder="Nguyễn Văn A">
              </div>

              <div class="form-row" style="margin-top:12px;">
                <div class="form-group">
                  <label class="form-label" for="cust_phone">Số điện thoại *</label>
                  <input class="form-input" type="text" name="phone" id="cust_phone" required value="<?php echo $editService ? htmlspecialchars($editService['phone']) : ''; ?>" placeholder="09xxxxxxx">
                </div>
                <div class="form-group">
                  <label class="form-label" for="cust_email">Email liên hệ</label>
                  <input class="form-input" type="email" name="email" id="cust_email" value="<?php echo $editService ? htmlspecialchars($editService['email']) : ''; ?>" placeholder="name@domain.com">
                </div>
              </div>

              <div class="form-row" style="margin-top:12px;">
                <div class="form-group">
                  <label class="form-label" for="license_plate">Biển kiểm soát xe *</label>
                  <input class="form-input" type="text" name="license_plate" id="license_plate" required value="<?php echo $editService ? htmlspecialchars($editService['license_plate']) : ''; ?>" placeholder="Ví dụ: 30A-999.99">
                </div>
                <div class="form-group">
                  <label class="form-label" for="car_model">Dòng xe bảo dưỡng *</label>
                  <input class="form-input" type="text" name="car_model" id="car_model" required value="<?php echo $editService ? htmlspecialchars($editService['car_model']) : ''; ?>" placeholder="Ví dụ: VinFast VF 9 SUV">
                </div>
              </div>

              <div class="form-row" style="margin-top:12px;">
                <div class="form-group">
                  <label class="form-label" for="appointment_date">Ngày giờ tiếp nhận *</label>
                  <input class="form-input" type="datetime-local" name="appointment_date" id="appointment_date" required value="<?php echo $editService ? date('Y-m-d\TH:i', strtotime($editService['appointment_date'])) : date('Y-m-d\T09:00'); ?>">
                </div>
                <div class="form-group">
                  <label class="form-label" for="service_type">Nội dung yêu cầu</label>
                  <select class="form-input" name="service_type" id="service_type">
                    <option value="Bảo dưỡng định kỳ" <?php echo ($editService && $editService['service_type'] === 'Bảo dưỡng định kỳ') ? 'selected' : ''; ?>>Bảo dưỡng định kỳ</option>
                    <option value="Sửa chữa" <?php echo ($editService && $editService['service_type'] === 'Sửa chữa') ? 'selected' : ''; ?>>Sửa chữa hư hỏng</option>
                    <option value="Đồng sơn" <?php echo ($editService && $editService['service_type'] === 'Đồng sơn') ? 'selected' : ''; ?>>Đồng sơn / Làm đẹp</option>
                    <option value="Bảo hành" <?php echo ($editService && $editService['service_type'] === 'Bảo hành') ? 'selected' : ''; ?>>Kiểm tra bảo hành</option>
                  </select>
                </div>
              </div>

              <div class="form-row" style="margin-top:12px;">
                <div class="form-group">
                  <label class="form-label" for="assigned_tech_id">Chỉ định Kỹ thuật viên</label>
                  <select class="form-input" name="assigned_tech_id" id="assigned_tech_id">
                    <option value="">-- Chưa chỉ định --</option>
                    <?php
                      foreach ($techStaff as $tech) {
                          $selected = ($editService && $editService['assigned_tech_id'] == $tech['id']) ? 'selected' : '';
                          echo '<option value="' . $tech['id'] . '" ' . $selected . '>' . htmlspecialchars($tech['fullname']) . '</option>';
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="form-label" for="service_status">Trạng thái xe</label>
                  <select class="form-input" name="status" id="service_status">
                    <option value="Chờ tiếp nhận" <?php echo ($editService && $editService['status'] === 'Chờ tiếp nhận') ? 'selected' : ''; ?>>Chờ tiếp nhận</option>
                    <option value="Đang sửa chữa" <?php echo ($editService && $editService['status'] === 'Đang sửa chữa') ? 'selected' : ''; ?>>Đang sửa chữa</option>
                    <option value="Đã hoàn thành" <?php echo ($editService && $editService['status'] === 'Đã hoàn thành') ? 'selected' : ''; ?>>Đã hoàn thành</option>
                    <option value="Đã giao xe" <?php echo ($editService && $editService['status'] === 'Đã giao xe') ? 'selected' : ''; ?>>Đã giao xe (Hủy lưu kho)</option>
                    <option value="Hủy" <?php echo ($editService && $editService['status'] === 'Hủy') ? 'selected' : ''; ?>>Hủy lịch hẹn</option>
                  </select>
                </div>
              </div>

              <div class="form-group" style="margin-top:12px;">
                <label class="form-label" for="service_notes">Ghi chú sửa chữa (Tình trạng xe/Triệu chứng báo hỏng)</label>
                <textarea class="form-input" name="notes" id="service_notes" placeholder="Nhập chuẩn đoán ban đầu hoặc yêu cầu cụ thể của chủ xe..."><?php echo $editService ? htmlspecialchars($editService['notes']) : ''; ?></textarea>
              </div>

              <div style="margin-top:15px; display:flex; gap:10px;">
                <button class="btn-gold" type="submit"><?php echo $editService ? 'Cập nhật lịch hẹn' : 'Đăng ký tiếp nhận'; ?></button>
                <?php if ($editService): ?>
                  <a href="admin.php?p=service" class="btn-gold" style="border-color:#aaa; color:#aaa; box-shadow:none;">Hủy</a>
                <?php endif; ?>
              </div>
            </form>
          </div>
        </div>
      </div>

    <!-- ==================================================== -->
    <!-- VIEW: 6. CONTENT MANAGEMENT (CMS & SEO) - TABBED DASHBOARD -->





