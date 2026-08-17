<!-- SECTION 4: PREMIUM COMPARISON (Da đẩy lên vị trí 4) -->
  <section class="compare-section">
    <div class="container">
      <div class="compare-header-block">
        <span class="section-tag">Đối chiếu kỹ thuật</span>
        <h2 class="compare-title">So Sánh Thông Số Các Dòng Xe Tại Showroom VinFast Tam Phong</h2>
        <p class="compare-subtitle">Giúp bạn có cái nhìn chi tiết và đối chiếu trực quan nhất các chỉ số kỹ thuật, phân khúc và giá trị của các dòng xe điện VinFast.</p>
      </div>

      <!-- Centered VUỐT ĐỂ SO SÁNH Pill-shaped badge (Rule requirement - Light mode gold accent) -->
      <div class="compare-pulse-btn-container" style="display: flex; justify-content: center; margin-bottom: 25px;">
        <button class="btn-compare-pulse" onclick="scrollTableToRight()">
          <span class="swipe-icon">👉</span> VUỐT ĐỂ SO SÁNH
          <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" width="14" height="14" style="margin-left: 4px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
          </svg>
        </button>
      </div>

      <!-- Sticky horizontal scrollable comparison table -->
      <div class="table-scroll-container" id="VinFast-compare-scrollable-table">
        <table class="compare-spec-table">
          <thead>
            <tr>
              <th>Thông số / Model</th>
              <?php if (count($compareCars) === 0): ?>
                <th>Chưa có dòng xe</th>
              <?php else: ?>
                <?php foreach ($compareCars as $car): ?>
                  <th><?php echo htmlspecialchars($car['model_name']); ?></th>
                <?php endforeach; ?>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php if (count($compareCars) === 0): ?>
              <tr>
                <td colspan="2" style="text-align: center; color: var(--color-text-slate); padding: 40px 0;">Chưa có dòng xe so sánh nào được đăng tải trên hệ thống CMS.</td>
              </tr>
            <?php else: ?>
              <?php
                $specs = [
                    'segment' => 'Phân khúc xe',
                    'engine' => 'Động cơ / Truyền động',
                    'power' => 'Công suất tối đa',
                    'torque' => 'Mô-men xoắn cực đại',
                    'acceleration' => 'Tăng tốc (0 - 100 km/h)',
                    'top_speed' => 'Tốc độ tối đa',
                    'range_wltp' => 'Tầm hoạt động (WLTP)',
                    'price' => 'Giá khởi điểm ước tính'
                ];
                foreach ($specs as $col => $label):
              ?>
                <tr class="compare-row-<?php echo $col; ?>">
                  <td><?php echo $label; ?></td>
                  <?php foreach ($compareCars as $car): 
                    $val = $car[$col] ?? '-';
                    if ($col === 'price' && !empty($val) && $val !== '-') {
                      if (strpos($val, '/') !== false) {
                        $parts = explode('/', $val);
                        $val = trim($parts[0]);
                      }
                      $val = preg_replace('/\s*\(Thuê pin\)/iu', '', $val);
                      $val = preg_replace('/\s*\(Đã gồm pin\)/iu', '', $val);
                      $val = trim($val);
                    }
                  ?>
                    <td><?php echo htmlspecialchars($val); ?></td>
                  <?php endforeach; ?>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Swipe hint pill -->
      <div class="swipe-hint-container">
        <div class="swipe-hint-pill">
          <span class="swipe-hint-icon">👉</span>
          <span>VUỐT SANG PHẢI ĐỂ XEM THÊM CÁC DÒNG XE KHÁC</span>
        </div>
      </div>

    </div>
  </section>