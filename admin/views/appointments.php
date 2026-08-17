      <div class="card">
        <div class="card__title-row" style="border-bottom: 1px solid var(--color-border); padding-bottom: 15px; margin-bottom: 15px;">
          <div class="card__title">Lịch hẹn khách hàng đăng ký trải nghiệm & Lái thử</div>
          <button onclick="exportAppointmentsToCsv()" class="btn-gold" style="font-size: 11px; padding: 6px 12px; border-color: #4caf50; color: #a5d6a7; border-radius: 6px;"><i class="fas fa-file-excel"></i> Xuất Excel</button>
        </div>
        <p style="font-size:13px; color:var(--color-text-muted); margin-bottom:15px; margin-top: 10px;">
          Dưới đây là danh sách những khách hàng đăng ký lái thử trực tiếp qua cổng thông tin. Bạn có thể phân công nhân viên chuyên trách tư vấn chăm sóc và cập nhật tiến trình xử lý.
        </p>

        <div class="form-row" style="margin-bottom: 20px;">
          <div class="form-group">
            <label class="form-label" for="search_ap">Tìm kiếm lịch hẹn</label>
            <input class="form-input" type="text" id="search_ap" placeholder="🔍 Nhập họ tên khách hàng, số điện thoại để lọc nhanh..." onkeyup="filterAppointmentsTable()">
          </div>
          <div class="form-group">
            <label class="form-label" for="filter_ap_status">Lọc theo trạng thái</label>
            <select class="form-input" id="filter_ap_status" onchange="filterAppointmentsTable()">
              <option value="">-- Tất cả trạng thái --</option>
              <option value="Chưa liên hệ">Chưa liên hệ</option>
              <option value="Đang liên hệ">Đang liên hệ</option>
              <option value="Đã lái thử">Đã lái thử</option>
              <option value="Đã chốt">Đã chốt</option>
              <option value="Hủy">Hủy</option>
            </select>
          </div>
        </div>

        <script>
          function filterAppointmentsTable() {
            const query = document.getElementById('search_ap').value.toLowerCase().trim();
            const statusFilter = document.getElementById('filter_ap_status').value;
            const rows = document.querySelectorAll('.cms-table tbody tr');
            
            rows.forEach(row => {
              if (row.cells.length < 10) return; // Skip empty row
              const name = row.cells[0] ? row.cells[0].textContent.toLowerCase() : '';
              const phone = row.cells[1] ? row.cells[1].textContent.toLowerCase() : '';
              const email = row.cells[2] ? row.cells[2].textContent.toLowerCase() : '';
              const contact = phone + " " + email;
              
              const statusSelect = row.cells[8] ? row.cells[8].querySelector('select[name="status"]') : null;
              const statusValue = statusSelect ? statusSelect.value : '';
              
              const matchesSearch = name.includes(query) || contact.includes(query);
              const matchesStatus = !statusFilter || statusValue === statusFilter;
              
              if (matchesSearch && matchesStatus) {
                row.style.display = '';
              } else {
                row.style.display = 'none';
              }
            });
          }
        </script>

        <div class="table-container">
          <table class="cms-table" id="crm_appointments_table">
            <thead>
              <tr>
                <th>Khách hàng</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ Email</th>
                <th>Dòng xe quan tâm</th>
                <th>Hình thức lái thử</th>
                <th>Địa điểm / Ngày giờ</th>
                <th>Thời gian đăng ký</th>
                <th>Phân công Sale</th>
                <th>Trạng thái xử lý</th>
                <th style="text-align: center;">Thao tác</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $stmtAppointments = $db->query("SELECT l.*, c.model_name FROM leads l LEFT JOIN cars c ON l.car_id = c.id ORDER BY l.id DESC");
                $appointments = $stmtAppointments->fetchAll();
                if (empty($appointments)) {
                    echo '<tr><td colspan="10" style="text-align:center; color:var(--color-text-muted);">Không có dữ liệu lịch hẹn đăng ký lái thử.</td></tr>';
                } else {
                    foreach ($appointments as $ap) {
                        echo '<tr>';
                        echo '<td><strong>' . htmlspecialchars($ap['fullname'] ?? '') . '</strong></td>';
                        echo '<td>' . htmlspecialchars($ap['phone'] ?? '') . '</td>';
                        echo '<td><span style="font-size:12px; color:var(--color-text-muted);">' . htmlspecialchars($ap['email'] ?? '') . '</span></td>';
                        echo '<td>' . htmlspecialchars($ap['model_name'] ?? 'VinFast VF 9') . '</td>';
                        
                        if (($ap['test_drive_type'] ?? '') === 'Thu cũ đổi mới') {
                            echo '<td><span class="status-badge status-badge--success" style="background:rgba(25, 96, 215,0.15); border:1px solid var(--color-primary); color:var(--color-primary);">Thu cũ đổi mới</span></td>';
                            echo '<td><div style="font-size:11px; color:var(--color-text-white); white-space:pre-line; text-align:left; background:rgba(0,0,0,0.2); padding:8px; border-radius:6px; border:1px solid var(--color-border);">' . htmlspecialchars($ap['notes'] ?? '') . '</div></td>';
                        } else {
                            echo '<td>' . htmlspecialchars($ap['test_drive_type'] ?? 'Tại Showroom') . '</td>';
                            echo '<td>' . htmlspecialchars(($ap['test_drive_address'] ?? '') ? $ap['test_drive_address'] : 'Tại Showroom chính') . '<br><span style="font-size:11px; color:var(--color-primary); font-weight:600;">' . htmlspecialchars($ap['preferred_date'] ?? '') . '</span></td>';
                        }
                        
                        // Registration date column
                        echo '<td style="font-size:12px; color:var(--color-text-muted);">' . date('d/m/Y H:i', strtotime($ap['created_at'])) . '</td>';

                        // Edit action in-table form for status and sale assignment
                        echo '<td>';
                        echo '<form method="POST" action="admin.php?p=appointments" id="form-lead-' . $ap['id'] . '">';
                        echo '<input type="hidden" name="action" value="status">';
                        echo '<input type="hidden" name="id" value="' . $ap['id'] . '">';
                        echo '<select class="form-input" name="assigned_sale_id" style="padding:6px; font-size:12px; width:150px;" onchange="document.getElementById(\'form-lead-' . $ap['id'] . '\').submit()">';
                        echo '<option value="">-- Chưa phân công --</option>';
                        foreach ($salesStaff as $sale) {
                            $selected = ($ap['assigned_sale_id'] == $sale['id']) ? 'selected' : '';
                            echo '<option value="' . $sale['id'] . '" ' . $selected . '>' . htmlspecialchars($sale['fullname']) . '</option>';
                        }
                        echo '</select>';
                        echo '</td>';

                        echo '<td>';
                        echo '<select class="form-input" name="status" style="padding:6px; font-size:12px; width:130px;" onchange="document.getElementById(\'form-lead-' . $ap['id'] . '\').submit()">';
                        $statuses = ['Chưa liên hệ', 'Đang liên hệ', 'Đã lái thử', 'Đã chốt', 'Hủy'];
                        foreach ($statuses as $st) {
                            $selected = ($ap['status'] === $st) ? 'selected' : '';
                            echo '<option value="' . $st . '" ' . $selected . '>' . $st . '</option>';
                        }
                        echo '</select>';
                        echo '</form>';
                        echo '</td>';

                        echo '<td style="text-align: center;">';
                        echo '<form method="POST" action="admin.php?p=appointments" onsubmit="return confirm(\'Xóa lịch hẹn này?\')" style="display:inline-block;">';
                        echo '<input type="hidden" name="action" value="delete">';
                        echo '<input type="hidden" name="id" value="' . $ap['id'] . '">';
                        echo '<button type="submit" class="btn-danger" style="font-size:11px;">Xóa</button>';
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

      <!-- JAVASCRIPT EXPORT UTILITY FOR APPOINTMENTS -->
      <script>
        function exportAppointmentsToCsv() {
          const table = document.getElementById('crm_appointments_table');
          if (!table) return;
          
          let csv = [];
          const rows = table.querySelectorAll("tr");
          
          for (let i = 0; i < rows.length; i++) {
            // Check if row is visible (filter-aware export)
            if (rows[i].style.display === 'none') continue;
            
            let row = [];
            const cols = rows[i].querySelectorAll("td, th");
            
            // Export up to the last column (skip action Delete button column)
            for (let j = 0; j < cols.length - 1; j++) {
              let cell = cols[j];
              let text = '';
              const select = cell.querySelector('select');
              if (select) {
                // If it is a select dropdown, fetch the selected text
                text = select.options[select.selectedIndex] ? select.options[select.selectedIndex].text : '';
              } else {
                text = cell.innerText.trim();
              }
              // Escape double quotes
              text = text.replace(/"/g, '""');
              row.push('"' + text + '"');
            }
            csv.push(row.join(","));
          }
          
          // Download CSV file with UTF-8 BOM so Excel displays Vietnamese characters correctly
          const csvContent = "\uFEFF" + csv.join("\n");
          const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
          const url = URL.createObjectURL(blob);
          const link = document.createElement("a");
          link.setAttribute("href", url);
          link.setAttribute("download", "crm_lich_hen_lai_thu_" + new Date().toISOString().slice(0,10) + ".csv");
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
        }
      </script>





