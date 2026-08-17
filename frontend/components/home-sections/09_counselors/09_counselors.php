<?php if (!empty($compareCounselors)): ?>
  <style>
  @media (max-width: 768px) {
    .compare-counselors-section {
      padding: 30px 10px !important;
    }
    .compare-counselors-title {
      font-size: 18px !important;
      line-height: 1.3 !important;
      text-align: center !important;
    }
    .compare-counselors-subtitle {
      font-size: 12.5px !important;
      line-height: 1.5 !important;
      text-align: center !important;
    }
    .compare-counselors-grid {
      display: grid !important;
      grid-template-columns: repeat(2, 1fr) !important;
      gap: 10px !important;
    }
    .counselor-compare-card {
      padding: 14px 10px !important;
      border-radius: 12px !important;
      gap: 10px !important;
    }
    .counselor-compare-name {
      font-size: 14px !important;
      font-weight: 800 !important;
    }
    .counselor-compare-title {
      font-size: 11px !important;
    }
    .counselor-compare-actions {
      display: grid !important;
      grid-template-columns: 1fr 1fr !important;
      gap: 4px !important;
      width: 100% !important;
    }
    .btn-counselor-compare {
      padding: 8px 4px !important;
      font-size: 10.5px !important;
      font-weight: 800 !important;
      text-align: center !important;
      border-radius: 18px !important;
    }
  }
</style>
<section class="compare-counselors-section" style="padding: 60px 0; background-color: #ffffff; border-top: 1px dashed #cbd5e1;">
    <div class="container">
      <div class="compare-counselors-block">
        <div class="compare-counselors-header" style="text-align: center; margin-bottom: 30px;">
          <span class="compare-counselors-tag" style="display: inline-block; font-size: 11px; font-weight: 800; color: #1464f4; background-color: rgba(20, 100, 244, 0.06); padding: 5px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1.5px; border: 1px solid rgba(20, 100, 244, 0.12); font-family: 'Montserrat', sans-serif;">Hỗ trợ trực tiếp</span>
          <h3 class="compare-counselors-title" style="font-size: 21px; font-weight: 750; color: #0f172a; margin-top: 12px; margin-bottom: 8px; font-family: 'Montserrat', sans-serif;">Bạn đang băn khoăn chưa biết lựa chọn dòng xe nào phù hợp?</h3>
          <p class="compare-counselors-subtitle" style="font-size: 13.5px; color: #475569; max-width: 650px; margin: 0 auto; line-height: 1.6; font-family: 'Montserrat', sans-serif;">Kết nối ngay với các Chuyên viên tư vấn VIP để nhận so sánh chi tiết, tính toán giá lăn bánh trả góp và đăng ký lịch lái thử tại nhà hoàn toàn miễn phí.</p>
        </div>

        <div class="compare-counselors-grid">
          <?php foreach ($compareCounselors as $counselor): ?>
            <div class="counselor-compare-card">
              <!-- Certified Badge at top left -->
              <span class="counselor-compare-badge">🏆 TƯ VẤN XUẤT SẮC</span>
              
              <div class="counselor-compare-avatar-wrap">
                <?php
                $avatar_path = $counselor['avatar'] ?? '';
                $physical_path = dirname(dirname(__DIR__)) . '/' . ltrim($avatar_path, '/');
                $has_avatar = !empty($avatar_path) && file_exists($physical_path);
                if ($has_avatar):
                  $counselorAvatarUrl = ($basePath !== '' ? rtrim($basePath, '/') : '') . '/' . ltrim($avatar_path, '/');
                ?>
                  <img src="<?php echo htmlspecialchars($counselorAvatarUrl); ?>" alt="<?php echo htmlspecialchars($counselor['fullname']); ?>" class="counselor-compare-avatar" loading="lazy">
                <?php else: ?>
                  <div class="counselor-compare-avatar-initials">
                    <?php
                    $words = explode(' ', trim($counselor['fullname'] ?? ''));
                    $initials = '';
                    if (count($words) >= 2) {
                        $initials = mb_substr($words[count($words)-2], 0, 1, 'UTF-8') . mb_substr($words[count($words)-1], 0, 1, 'UTF-8');
                    } else {
                        $initials = mb_substr($words[0] ?? 'C', 0, 2, 'UTF-8');
                    }
                    echo htmlspecialchars(mb_strtoupper($initials, 'UTF-8'));
                    ?>
                  </div>
                <?php endif; ?>
                <span class="counselor-compare-pulse"></span>
              </div>

              <div class="counselor-compare-info">
                <span class="counselor-compare-status">Đang trực tuyến</span>
                <h4 class="counselor-compare-name"><?php echo htmlspecialchars($counselor['fullname']); ?></h4>
                <p class="counselor-compare-title">Chuyên viên Tư vấn VinFast VIP</p>
                
                <div class="counselor-compare-rating">
                  <div class="stars">★★★★★</div>
                  <span class="score">5.0</span>
                </div>
              </div>

              <div class="counselor-compare-tags">
                <span>Tư vấn tận tâm</span>
                <span>Hỗ trợ 24/7</span>
              </div>

               <div class="counselor-compare-actions">
                <a href="tel:<?php echo htmlspecialchars($counselor['phone']); ?>" class="btn-counselor-compare btn-counselor-compare--phone">
                  Gọi điện
                </a>
                <a href="<?php echo htmlspecialchars($counselor['zalo']); ?>" target="_blank" rel="noopener" class="btn-counselor-compare btn-counselor-compare--zalo">
                  Chat Zalo
                </a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>