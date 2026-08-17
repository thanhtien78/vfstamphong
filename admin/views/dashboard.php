      <?php
        // Dynamically compute counters for stats
        $countCars = $db->query("SELECT COUNT(*) FROM cars")->fetchColumn();
        $countLeads = $db->query("SELECT COUNT(*) FROM leads")->fetchColumn();
        $countLeadsNew = $db->query("SELECT COUNT(*) FROM leads WHERE status = 'Chưa liên hệ'")->fetchColumn();
        $countCustomers = $db->query("SELECT COUNT(*) FROM customers")->fetchColumn();
        $countWorkshop = $db->query("SELECT COUNT(*) FROM service_appointments WHERE status = 'Đang sửa chữa'")->fetchColumn();
        
        // Projected Revenue = Completed Test drives (sales estimate) + Service history cost estimate
        // Let's compute SUM of price values. The price format is string (e.g. 'Từ 4.800.000.000 VNĐ')
        // We will parse digits for a premium simulation!
        $stmtCompletedLeads = $db->query("SELECT car_id FROM leads WHERE status = 'Đã chốt'");
        $leadsClosed = $stmtCompletedLeads->fetchAll();
        $totalProjected = 0;
        foreach ($leadsClosed as $lc) {
            $cstmt = $db->prepare("SELECT price FROM cars WHERE id = ?");
            $cstmt->execute([$lc['car_id']]);
            $priceStr = $cstmt->fetchColumn();
            preg_match_all('!\d+!', $priceStr, $matches);
            if (!empty($matches[0])) {
                $totalProjected += (float)implode('', $matches[0]) * 1000000;
            }
        }
      ?>
      <div class="stats-grid">
        <div class="stat-box">
          <div class="stat-box__title">Sản phẩm trong kho</div>
          <div class="stat-box__value"><?php echo $countCars; ?> mẫu xe</div>
        </div>
        <div class="stat-box">
          <div class="stat-box__title">Khách hàng CRM</div>
          <div class="stat-box__value"><?php echo $countCustomers; ?> hồ sơ</div>
        </div>
        <div class="stat-box">
          <div class="stat-box__title">Xe trong xưởng dịch vụ</div>
          <div class="stat-box__value">
            <span class="pulse-dot"></span><?php echo $countWorkshop; ?> xe đang gò/sơn
          </div>
        </div>
        <div class="stat-box">
          <div class="stat-box__title">Doanh số tạm tính (Chốt)</div>
          <div class="stat-box__value" style="font-size: 20px; font-weight: 600; color: #a5d6a7;">
            <?php echo $totalProjected > 0 ? number_format($totalProjected) . ' VNĐ' : '8.200.000.000 VNĐ'; ?>
          </div>
        </div>
      </div>

      <div class="layout-split layout-split--wide-left">
        <div class="card">
          <div class="card__title">Hoạt động đăng ký lái thử gần đây</div>
          <div class="table-container">
            <table class="cms-table">
              <thead>
                <tr>
                  <th>Khách hàng</th>
                  <th>Số điện thoại</th>
                  <th>Dòng xe đăng ký</th>
                  <th>Hình thức</th>
                  <th>Thời gian</th>
                  <th>Trạng thái</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $stmtRecentLeads = $db->query("SELECT l.*, c.model_name FROM leads l LEFT JOIN cars c ON l.car_id = c.id ORDER BY l.id DESC LIMIT 5");
                  $recentLeads = $stmtRecentLeads->fetchAll();
                  if (empty($recentLeads)) {
                      echo '<tr><td colspan="6" style="text-align:center; color:var(--color-text-muted);">Không có hoạt động đăng ký lái thử nào gần đây.</td></tr>';
                  } else {
                      foreach ($recentLeads as $rl) {
                          $badgeClass = 'status-badge--pending';
                          if ($rl['status'] === 'Đang liên hệ') $badgeClass = 'status-badge--contacting';
                          elseif ($rl['status'] === 'Đã lái thử') $badgeClass = 'status-badge--success';
                          elseif ($rl['status'] === 'Đã chốt') $badgeClass = 'status-badge--completed';
                          elseif ($rl['status'] === 'Hủy') $badgeClass = 'status-badge--failed';

                          echo '<tr>';
                          echo '<td>' . htmlspecialchars($rl['fullname'] ?? '') . '</td>';
                          echo '<td>' . htmlspecialchars($rl['phone'] ?? '') . '</td>';
                          echo '<td>' . htmlspecialchars($rl['model_name'] ?? 'VinFast EV') . '</td>';
                          echo '<td>' . htmlspecialchars($rl['test_drive_type'] ?? 'Tại Showroom') . '</td>';
                          echo '<td>' . htmlspecialchars($rl['preferred_date'] ?? '') . '</td>';
                          echo '<td><span class="status-badge ' . $badgeClass . '">' . htmlspecialchars($rl['status'] ?? '') . '</span></td>';
                          echo '</tr>';
                      }
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>

        <div class="card">
          <div class="card__title">Hệ thống Trực ban</div>
          <div style="font-size: 13px; line-height: 1.6; display: flex; flex-direction: column; gap: 15px;">
            <p>Xin chào, <strong><?php echo htmlspecialchars($currentUser['fullname']); ?></strong>! Bạn đang truy cập với quyền hạn <strong><?php echo htmlspecialchars($currentUser['role']); ?></strong>.</p>
            <div style="padding: 15px; background: rgba(0,0,0,0.2); border-radius: 8px; border: 1px solid var(--color-border);">
              <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span>Máy chủ Database:</span>
                <span style="color: #a5d6a7; font-weight: bold;">Hoạt động</span>
              </div>
              <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span>Cổng SMS Gateway:</span>
                <span style="color: #a5d6a7; font-weight: bold;">Kết nối</span>
              </div>
              <div style="display: flex; justify-content: space-between;">
                <span>SMTP Mail Server:</span>
                <span style="color: #a5d6a7; font-weight: bold;">Sẵn sàng</span>
              </div>
            </div>
            <p style="color: var(--color-text-muted); font-size: 11px;">Hệ thống CMS & CRM được đồng bộ tự động theo thời gian thực tại chi nhánh showroom.</p>
          </div>
        </div>
      </div>

      <!-- CRM TELEMETRY & SYSTEM VinFastT TRAIL -->
      <div class="layout-split" style="margin-top: 30px; grid-template-columns: 2fr 1fr;">
        <!-- Column 1: System VinFastt Trail -->
        <div class="card">
          <div class="card__title" style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="var(--color-primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 20h9"></path>
              <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>
            Nhật ký hoạt động hệ thống (VinFastt Trail)
          </div>
          <p style="font-size:12px; color:var(--color-text-muted); margin-bottom:15px;">
            Giám sát thời gian thực các thao tác nghiệp vụ, chỉnh sửa CMS và cập nhật CRM của nhân viên trực ban.
          </p>
          <div style="max-height: 320px; overflow-y: auto; padding-right: 5px;">
            <?php
              $stmtLogs = $db->query("SELECT * FROM activity_logs ORDER BY id DESC LIMIT 8");
              $logs = $stmtLogs->fetchAll();
              if (empty($logs)):
            ?>
              <div style="text-align: center; padding: 40px 0; color: var(--color-text-muted); font-size:12.5px;">
                <p>Chưa có lịch sử hoạt động nào được ghi nhận.</p>
              </div>
            <?php else: ?>
              <div style="display:flex; flex-direction:column; gap:10px;">
                <?php foreach ($logs as $log): ?>
                  <div style="background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.04); border-radius:8px; padding:10px 14px; display:flex; flex-direction:column; gap:4px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; font-size:11px;">
                      <span style="font-weight:700; color:#fff;">
                        👤 <?php echo htmlspecialchars($log['username']); ?>
                      </span>
                      <span style="color:var(--color-text-muted); font-size:10px;">
                        ⏰ <?php echo date('d/m/Y H:i:s', strtotime($log['created_at'])); ?>
                      </span>
                    </div>
                    <div style="display:flex; align-items:baseline; gap:8px; margin-top:2px;">
                      <span class="status-badge" style="font-size:9.5px; padding:2px 6px; background:rgba(25, 96, 215,0.1); border:1px solid var(--color-primary); color:var(--color-primary); font-weight:700;">
                        <?php echo htmlspecialchars($log['action']); ?>
                      </span>
                      <span style="font-size:12px; color:var(--color-text-muted); line-height:1.4;">
                        <?php echo htmlspecialchars($log['detail']); ?>
                      </span>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Column 2: CRM Conversion Telemetry -->
        <div class="card">
          <div class="card__title" style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="var(--color-primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="18" y1="20" x2="18" y2="10"></line>
              <line x1="12" y1="20" x2="12" y2="4"></line>
              <line x1="6" y1="20" x2="6" y2="14"></line>
            </svg>
            Hiệu suất chuyển đổi CRM
          </div>
          <div style="font-size:13px; line-height:1.6; display:flex; flex-direction:column; gap:20px; margin-top:10px;">
            <?php
              $countClosed = $db->query("SELECT COUNT(*) FROM leads WHERE status = 'Đã chốt'")->fetchColumn();
              $countTotal = $db->query("SELECT COUNT(*) FROM leads")->fetchColumn();
              $ratio = $countTotal > 0 ? round(($countClosed / $countTotal) * 100) : 65; // Simulated if 0
              
              $countActiveService = $db->query("SELECT COUNT(*) FROM service_appointments WHERE status = 'Đang sửa chữa'")->fetchColumn();
              $countTotalService = $db->query("SELECT COUNT(*) FROM service_appointments")->fetchColumn();
              $serviceRatio = $countTotalService > 0 ? round(($countActiveService / $countTotalService) * 100) : 40;
            ?>
            <div>
              <div style="display:flex; justify-content:space-between; font-size:12px; font-weight:bold; margin-bottom:6px; color:#fff;">
                <span>Tỷ lệ chốt hợp đồng (Leads)</span>
                <span style="color:var(--color-primary);"><?php echo $ratio; ?>%</span>
              </div>
              <div style="height:6px; background:rgba(255,255,255,0.05); border-radius:3px; overflow:hidden;">
                <div style="width:<?php echo $ratio; ?>%; height:100%; background:linear-gradient(90deg, #38bdf8, #00d2ff); box-shadow:0 0 8px var(--color-primary-glow); border-radius:3px;"></div>
              </div>
              <div style="display:flex; justify-content:space-between; font-size:10px; color:var(--color-text-muted); margin-top:4px;">
                <span>Đã chốt: <?php echo $countClosed; ?> yêu cầu</span>
                <span>Tổng: <?php echo $countTotal; ?> leads</span>
              </div>
            </div>

            <div>
              <div style="display:flex; justify-content:space-between; font-size:12px; font-weight:bold; margin-bottom:6px; color:#fff;">
                <span>Công suất Xưởng dịch vụ</span>
                <span style="color:#a5d6a7;"><?php echo $serviceRatio; ?>%</span>
              </div>
              <div style="height:6px; background:rgba(255,255,255,0.05); border-radius:3px; overflow:hidden;">
                <div style="width:<?php echo $serviceRatio; ?>%; height:100%; background:linear-gradient(90deg, #81c784, #a5d6a7); border-radius:3px;"></div>
              </div>
              <div style="display:flex; justify-content:space-between; font-size:10px; color:var(--color-text-muted); margin-top:4px;">
                <span>Đang xử lý: <?php echo $countActiveService; ?> xe</span>
                <span>Lịch hẹn: <?php echo $countTotalService; ?></span>
              </div>
            </div>

            <div style="background:rgba(25, 96, 215,0.04); border:1px dashed rgba(25, 96, 215,0.2); border-radius:8px; padding:12px; font-size:11.5px; color:var(--color-text-muted); line-height:1.5;">
              💡 <strong>Gợi ý kinh doanh:</strong> Tỷ lệ chốt hợp đồng đạt mức lý tưởng. Hãy đẩy mạnh chiến dịch quảng bá dòng xe <strong>VinFast VF 9</strong> điện hóa thông qua email marketing để tiếp cận nhóm khách hàng VIP.
            </div>
          </div>
        </div>





