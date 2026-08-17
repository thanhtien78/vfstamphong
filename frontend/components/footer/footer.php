<?php
/**
 * VinFast Premium Footer Module
 * Hand-coded dynamic footer and responsive navigation script engine.
 */

// Globalize and safely resolve settings
global $db, $settings;

if (!isset($db)) {
    require_once dirname(dirname(dirname(__DIR__))) . '/db.php';
}

if (!isset($settings) || !is_array($settings)) {
    try {
        $stmt = $db->query("SELECT * FROM settings");
        $settings = [];
        while ($row = $stmt->fetch()) {
            $settings[$row['key']] = $row['value'];
        }
    } catch (Exception $e) {
        $settings = [];
    }
}

// Ensure settings variables are defined (robust fallback)
$agencyName = isset($agencyName) ? $agencyName : ($settings['agency_name'] ?? "VinFast Việt Nam - Chi nhánh Tp. Hồ Chí Minh");
$agencyPhone = isset($agencyPhone) ? $agencyPhone : ($settings['agency_phone'] ?? "081.7777.855");
$agencyAddress = isset($agencyAddress) ? $agencyAddress : ($settings['agency_address'] ?? "6B Tôn Đức Thắng, Phường Bến Nghé, Quận 1, Tp. Hồ Chí Minh");
$agencyHours = isset($agencyHours) ? $agencyHours : ($settings['agency_hours'] ?? "Thứ 2 - Thứ 7: 8:00 - 18:00 | Chủ Nhật: 9:00 - 17:00");

// Fetch all active cars dynamically for the VIP Pop-up select menu
try {
    $stmtCars = $db->query("SELECT id, model_name, slug, segment FROM cars ORDER BY id ASC");
    $allCars = $stmtCars->fetchAll();
    
    $passengerCars = [];
    $serviceCars = [];
    
    foreach ($allCars as $car) {
        $modelLower = mb_strtolower($car['model_name']);
        $segmentLower = mb_strtolower($car['segment']);
        
        if (str_contains($segmentLower, 'xe dịch vụ') || str_contains($segmentLower, 'dịch vụ') || str_contains($modelLower, 'green') || str_contains($modelLower, 'van')) {
            $serviceCars[] = $car;
        } else {
            $passengerCars[] = $car;
        }
    }
} catch (Exception $e) {
    $allCars = [];
    $passengerCars = [];
    $serviceCars = [];
}
?>



  <style>
    /* PREMIUM FOOTER DARK MODERNIZE UPGRADES (Cohesive Brand Identity) */
    .premium-footer {
      background: #090e1a !important; /* Premium deep dark slate-black matching header */
      border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
      padding: 60px 0 40px 0 !important;
    }
    .footer-grid {
      display: grid !important;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)) !important;
      gap: 30px !important;
      margin-bottom: 50px !important;
    }
    @media (min-width: 992px) {
      .footer-grid {
        grid-template-columns: 1.4fr 1fr 1fr 1.1fr 1.2fr !important; /* Specific balanced track widths */
        gap: 25px !important;
      }
    }
    .premium-footer .logo-link {
      color: #ffffff !important; /* High contrast white on dark background */
      font-weight: 900 !important;
      font-size: 17px !important; /* Slightly smaller to fit grid columns */
      letter-spacing: 1.5px !important;
      text-transform: uppercase !important;
      text-decoration: none !important;
      transition: all 0.3s ease !important;
      text-shadow: 0 0 10px rgba(56, 189, 248, 0.15) !important;
    }
    .premium-footer .logo-link:hover {
      color: #38bdf8 !important; /* Brand Blue glow on hover */
    }
    .footer-tagline {
      color: #94a3b8 !important; /* Muted tech gray */
      font-size: 13px !important;
      line-height: 1.65 !important;
      margin-top: 12px !important;
    }
    .footer-socials {
      margin-top: 20px !important;
      display: flex !important;
      gap: 12px !important;
    }
    .social-icon-link {
      background: rgba(255, 255, 255, 0.04) !important;
      color: #cbd5e1 !important;
      border: 1px solid rgba(255, 255, 255, 0.08) !important;
      width: 36px !important;
      height: 36px !important;
      border-radius: 50% !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
    }
    .social-icon-link:hover {
      background: #38bdf8 !important;
      color: #ffffff !important;
      border-color: #38bdf8 !important;
      transform: translateY(-3px) !important;
      box-shadow: 0 5px 15px rgba(56, 189, 248, 0.3) !important;
    }
    .footer-heading {
      color: #ffffff !important;
      font-family: 'Montserrat', sans-serif !important;
      font-weight: 700 !important;
      font-size: 14px !important;
      text-transform: uppercase !important;
      letter-spacing: 1.5px !important;
      margin-bottom: 20px !important;
      position: relative !important;
      padding-bottom: 10px !important;
    }
    .footer-heading::after {
      content: '' !important;
      position: absolute !important;
      left: 0 !important;
      bottom: 0 !important;
      width: 35px !important;
      height: 2px !important;
      background: #38bdf8 !important; /* Brand Blue bottom accent line */
    }
    .footer-links-list {
      list-style: none !important;
      padding: 0 !important;
      margin: 0 !important;
      display: flex !important;
      flex-direction: column !important;
      gap: 12px !important;
    }
    .footer-link-item a {
      color: #94a3b8 !important;
      font-size: 13.5px !important;
      text-decoration: none !important;
      transition: all 0.25s ease !important;
      display: inline-block !important;
    }
    .footer-link-item a:hover {
      color: #38bdf8 !important;
      transform: translateX(4px) !important;
    }
    .footer-contact-info {
      display: flex !important;
      flex-direction: column !important;
      gap: 16px !important;
    }
    .contact-info-item {
      display: flex !important;
      gap: 12px !important;
      align-items: flex-start !important;
      color: #cbd5e1 !important;
      font-size: 13px !important;
      line-height: 1.55 !important;
    }
    .contact-info-item svg {
      color: #38bdf8 !important; /* Brand Blue icons */
      flex-shrink: 0 !important;
      margin-top: 3px !important;
    }
    .footer-divider {
      border: 0 !important;
      border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
      margin: 40px 0 30px 0 !important;
    }
    .footer-bottom-wrap {
      display: flex !important;
      justify-content: space-between !important;
      align-items: center !important;
      flex-wrap: wrap !important;
      gap: 20px !important;
    }
    .footer-copyright {
      color: #64748b !important;
      font-size: 12px !important;
      line-height: 1.65 !important;
    }
    .footer-legal-links {
      list-style: none !important;
      padding: 0 !important;
      margin: 0 !important;
      display: flex !important;
      gap: 20px !important;
    }
    .footer-legal-links a {
      color: #64748b !important;
      font-size: 12px !important;
      text-decoration: none !important;
      transition: all 0.25s ease !important;
    }
    .footer-legal-links a:hover {
      color: #38bdf8 !important;
    }
    @media (max-width: 768px) {
      .footer-bottom-wrap {
        flex-direction: column !important;
        text-align: center !important;
      }
      .footer-legal-links {
        justify-content: center !important;
      }
    }
  </style>

  <!-- PREMIUM FOOTER -->
  <footer class="premium-footer">
    <div class="container">
      <div class="footer-grid">
        <!-- Cột 1: Về thương hiệu -->
        <div class="footer-col">
            <a href="<?php echo seo_url('index.php'); ?>" class="logo-link" style="display: inline-flex; align-items: center; font-weight: 900; font-size: 20px; letter-spacing: 2px; font-family: 'Montserrat', sans-serif !important; color: var(--color-text-main); text-decoration: none; margin-bottom: 12px; text-transform: uppercase; transition: all 0.3s ease; white-space: nowrap !important;">
              <span>VINFAST TAM PHONG</span>
            </a>
            <div class="footer-tagline">
              <?php echo $settings['footer_tagline'] ?? '<strong>Mãnh liệt tinh thần Việt Nam</strong><br>Tiên phong trong công nghệ xe điện thông minh toàn cầu, mở khóa kỷ nguyên di chuyển xanh bền vững.'; ?>
            </div>
            <div class="footer-socials">
              <a href="<?php echo htmlspecialchars($settings['footer_facebook'] ?? '#'); ?>" class="social-icon-link" aria-label="Facebook">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
              </a>
              <a href="<?php echo htmlspecialchars($settings['footer_instagram'] ?? '#'); ?>" class="social-icon-link" aria-label="Instagram">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
              </a>
              <a href="<?php echo htmlspecialchars($settings['footer_youtube'] ?? '#'); ?>" class="social-icon-link" aria-label="YouTube">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>
              </a>
            </div>
          </div>

        <!-- Cột 2: Xe Du Lịch -->
        <div class="footer-col">
          <h4 class="footer-heading">
            Xe Du Lịch
          </h4>
          <ul class="footer-links-list">
            <?php if (!empty($passengerCars)): ?>
              <?php foreach ($passengerCars as $car): ?>
                <li class="footer-link-item">
                  <a href="<?php echo seo_url('xe-vinfast/' . $car['slug']); ?>">
                    <?php echo htmlspecialchars($car['model_name']); ?>
                  </a>
                </li>
              <?php endforeach; ?>
            <?php else: ?>
              <li class="footer-link-item">
                <a href="<?php echo seo_url('cars.php'); ?>">Tất cả dòng xe</a>
              </li>
            <?php endif; ?>
          </ul>
        </div>

        <!-- Cột 3: Xe Dịch Vụ -->
        <div class="footer-col">
          <h4 class="footer-heading">
            Xe Dịch Vụ
          </h4>
          <ul class="footer-links-list">
            <?php if (!empty($serviceCars)): ?>
              <?php foreach ($serviceCars as $car): ?>
                <li class="footer-link-item">
                  <a href="<?php echo seo_url('xe-vinfast/' . $car['slug']); ?>">
                    <?php echo htmlspecialchars($car['model_name']); ?>
                  </a>
                </li>
              <?php endforeach; ?>
            <?php else: ?>
              <li class="footer-link-item">
                <a href="<?php echo seo_url('cars.php'); ?>">Đang cập nhật</a>
              </li>
            <?php endif; ?>
          </ul>
        </div>

        <!-- Cột 3: Tiện ích & Đặc quyền -->
        <div class="footer-col">
          <h4 class="footer-heading">
            <?php echo htmlspecialchars($settings['footer_col3_title'] ?? 'Liên kết dịch vụ'); ?>
          </h4>
          <ul class="footer-links-list">
            <li class="footer-link-item">
              <a href="<?php echo seo_url($settings['footer_col3_link1_url'] ?? 'index.php#privileges-block'); ?>">
                <?php echo htmlspecialchars($settings['footer_col3_link1_text'] ?? 'Đặc quyền chính hãng'); ?>
              </a>
            </li>
            <li class="footer-link-item">
              <a href="<?php echo seo_url($settings['footer_col3_link2_url'] ?? 'index.php#offers-block'); ?>">
                <?php echo htmlspecialchars($settings['footer_col3_link2_text'] ?? 'Gói ưu đãi chào hè'); ?>
              </a>
            </li>
            <li class="footer-link-item">
              <a href="<?php echo seo_url($settings['footer_col3_link4_url'] ?? 'cars.php#booking-block'); ?>">
                <?php echo htmlspecialchars($settings['footer_col3_link4_text'] ?? 'Đặt lịch hẹn lái thử'); ?>
              </a>
            </li>
          </ul>
        </div>

        <!-- Cột 4: Thông tin hỗ trợ -->
        <div class="footer-col">
          <h4 class="footer-heading">Thông tin liên hệ</h4>
          <div class="footer-contact-info">
            <div class="contact-info-item">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
              <span>Hotline 24/7:<br><strong><?php echo htmlspecialchars($agencyPhone); ?></strong></span>
            </div>
            <div class="contact-info-item">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
              <span>Email:<br><strong><?php echo htmlspecialchars($settings['agency_email'] ?? 'info@VinFastvn.com'); ?></strong></span>
            </div>
            <div class="contact-info-item">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="10" r="3"></circle><path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 7 8 11.7z"></path></svg>
              <span><?php echo htmlspecialchars($agencyAddress); ?></span>
            </div>
          </div>
        </div>

      </div>

      <hr class="footer-divider">

      <div class="footer-bottom-wrap">
        <div class="footer-copyright">
          <?php echo $settings['footer_copyright'] ?? 'Bản quyền © 2026 VinFast Việt Nam. Tất cả quyền được bảo lưu. <br>Các thông số kỹ thuật, hình ảnh và trang bị thực tế có thể thay đổi bởi nhà sản xuất mà không báo trước.'; ?>
        </div>
        <ul class="footer-legal-links">
          <li><a href="<?php echo seo_url($settings['policy_privacy_link'] ?? '#'); ?>">Chính sách bảo mật</a></li>
          <li><a href="<?php echo seo_url($settings['policy_terms_link'] ?? '#'); ?>">Điều khoản sử dụng</a></li>
        </ul>
      </div>
    </div>
  </footer>

  <!-- PREMIUM FLOATING CONTACT CALL-TO-ACTION (CTA) CORPORATE PANEL -->
  <?php
  // Safely extract numeric digits from phone number for tel: and zalo.me links
  $cleanPhoneVal = preg_replace('/[^0-9]/', '', $agencyPhone ?? '0817777855');
  if (empty($cleanPhoneVal)) {
      $cleanPhoneVal = '0817777855';
  }
  ?>
  <!-- Floating Contact Sidebar (Replicated exactly from daily-lexus.com) -->
  <div class="floating-contact-sidebar">
      <div class="sidebar-item">
          <a href="<?php echo seo_url('pricelist.php'); ?>" aria-label="Nhận báo giá xe VinFast">
              <div class="icon-circle bg-gradient-blue"><?php echo get_svg_icon('fa-file-alt', 20, 20); ?></div>
              <span>Nhận báo giá</span>
          </a>
      </div>
      <div class="sidebar-item">
          <a href="tel:<?php echo htmlspecialchars($cleanPhoneVal); ?>" aria-label="Gọi hotline cố vấn VinFast">
              <div class="icon-circle bg-gradient-orange"><?php echo get_svg_icon('fa-phone-alt', 20, 20); ?></div>
              <span>Gọi điện</span>
          </a>
      </div>
      <div class="sidebar-item">
          <a href="https://zalo.me/<?php echo htmlspecialchars($cleanPhoneVal); ?>" target="_blank" rel="noopener noreferrer" aria-label="Chat Zalo hỗ trợ nhanh">
              <div class="icon-circle bg-zalo">
                  <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 25px; height: 25px; display: block;">
                      <path d="M24 4C13.5 4 5 11.6 5 21c0 5.4 2.8 10.2 7.2 13.2l-2 6.8c-.2.7.5 1.3 1.1 1l7.8-4.6c1.6.4 3.2.6 4.9.6 10.5 0 19-7.6 19-17S34.5 4 24 4z" fill="#ffffff"/>
                      <path d="M28.5 16.5H19.5V19.5L25 25.5H19.5V28.5H28.5V25.5L23 19.5H28.5V16.5Z" fill="#0084ff"/>
                  </svg>
              </div>
              <span>Chat Zalo</span>
          </a>
      </div>
      <div class="sidebar-item">
          <a href="<?php echo seo_url('cars.php#booking-stage'); ?>" aria-label="Đăng ký lái thử xe VIP">
              <div class="icon-circle bg-gradient-yellow"><?php echo get_svg_icon('fa-car', 20, 20); ?></div>
              <span>Đăng ký lái thử</span>
          </a>
      </div>
  </div>

  <!-- Back to Top Button (Replicated exactly from daily-lexus.com) -->
  <a href="#" id="back-to-top" title="Lên đầu trang" aria-label="Cuộn lên đầu trang"><?php echo get_svg_icon('fa-arrow-up', 18, 18); ?></a>

  <!-- DYNAMIC CORE RESPONSIVE JS ENGINE -->
  <script>
    // Hamburger menu toggle logic for responsive layout
    function toggleMobileMenu() {
      const toggleBtn = document.querySelector('.mobile-menu-toggle');
      const navMenu = document.querySelector('.nav-menu');
      if (toggleBtn && navMenu) {
        toggleBtn.classList.toggle('active');
        navMenu.classList.toggle('nav-menu--open');
      }
    }

    // Auto-close menu when clicking outside or clicking any nav link
    document.addEventListener('click', (e) => {
      const toggleBtn = document.querySelector('.mobile-menu-toggle');
      const navMenu = document.querySelector('.nav-menu');
      if (toggleBtn && navMenu && navMenu.classList.contains('nav-menu--open')) {
        if (!navMenu.contains(e.target) && !toggleBtn.contains(e.target)) {
          toggleBtn.classList.remove('active');
          navMenu.classList.remove('nav-menu--open');
        }
      }
    });

    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', () => {
        const toggleBtn = document.querySelector('.mobile-menu-toggle');
        const navMenu = document.querySelector('.nav-menu');
        if (toggleBtn && navMenu && navMenu.classList.contains('nav-menu--open')) {
          toggleBtn.classList.remove('active');
          navMenu.classList.remove('nav-menu--open');
        }
      });
    });

    // Vanilla JS controller for Back-to-Top fade and smooth scrolling (Lexus behavior)
    document.addEventListener('DOMContentLoaded', function() {
      const backToTop = document.getElementById('back-to-top');
      if (backToTop) {
        window.addEventListener('scroll', function() {
          if (window.pageYOffset > 300) {
            backToTop.classList.add('show');
          } else {
            backToTop.classList.remove('show');
          }
        });
        backToTop.addEventListener('click', function(e) {
          e.preventDefault();
          window.scrollTo({
            top: 0,
            behavior: 'smooth'
          });
        });
      }

      // Resolve content-visibility before scrolling to anchors
      function revealAnchorTarget(hash) {
        if (!hash) return;
        const cleanHash = hash.split('?')[0];
        try {
          const target = document.querySelector(cleanHash);
          if (target) {
            target.classList.add('cv-visible');
            target.getBoundingClientRect(); // Force layout recalculation
          }
        } catch(err) {}
      }

      // Handle direct page loads with hash
      if (window.location.hash) {
        revealAnchorTarget(window.location.hash);
      }

      // Intercept anchor clicks
      document.querySelectorAll('a[href*="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
          const hashIndex = this.href.indexOf('#');
          if (hashIndex !== -1) {
            const hash = this.href.substring(hashIndex);
            revealAnchorTarget(hash);
          }
        });
      });
    });
  </script>

  <!-- GEOLOCATION LOCALIZATION TOAST WIDGET -->
  <div id="geo-local-toast" class="geo-toast" style="display: none;">
    <div class="geo-toast-content">
      <div class="geo-toast-icon">
        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
          <circle cx="12" cy="10" r="3"></circle>
        </svg>
      </div>
      <div class="geo-toast-text">
        <span class="geo-toast-title">Ưu đãi tại <span id="geo-local-name">Khu vực của bạn</span></span>
        <span class="geo-toast-desc">Xem bảng giá và xe VinFast chính hãng hỗ trợ giao tận nơi tại <span id="geo-local-name-bold">khu vực của bạn</span>.</span>
      </div>
      <a href="#" id="geo-local-link" class="geo-toast-btn">Xem chi tiết</a>
      <button class="geo-toast-close" onclick="dismissGeoToast()">&times;</button>
    </div>
  </div>


  <script>
    // Geolocation-based routing & personalization
    (function() {
      // Don't run inside admin backend or on local-seo pages
      const currentUrl = window.location.href;
      if (currentUrl.includes('admin.php') || currentUrl.includes('local-seo.php') || currentUrl.includes('login.php') || currentUrl.includes('-tai-') || currentUrl.includes('-gan-')) {
        return;
      }

      function getCookie(name) {
        let nameEQ = name + "=";
        let ca = document.cookie.split(';');
        for(let i=0; i < ca.length; i++) {
          let c = ca[i];
          while (c.charAt(0)==' ') c = c.substring(1,c.length);
          if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
      }

      function setCookie(name, value, days) {
        let expires = "";
        if (days) {
          let date = new Date();
          date.setTime(date.getTime() + (days*24*60*60*1000));
          expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
      }

      function slugify(str) {
        str = str.toLowerCase();
        str = str.replace(/[àáạảãâầấậẩẫăằắặẳẵ]/g, "a");
        str = str.replace(/[èéẹẻẽêềếệểễ]/g, "e");
        str = str.replace(/[ìíịỉĩ]/g, "i");
        str = str.replace(/[òóọỏõôồốộổỗơờớợởỡ]/g, "o");
        str = str.replace(/[ùúụủũưừứựửữ]/g, "u");
        str = str.replace(/[ỳýỵỷỹ]/g, "y");
        str = str.replace(/đ/g, "d");
        str = str.replace(/[^a-z0-9\s-]/g, "");
        str = str.replace(/[\s-]+/g, "-");
        return str.trim("-");
      }

      // Check if closed in this session to prevent nagging users
      if (sessionStorage.getItem('geoToastDismissed')) {
        return;
      }

      // Check cache cookies first
      let cachedName = getCookie('VinFast_geo_loc_name');
      let cachedSlug = getCookie('VinFast_geo_loc_slug');

      if (cachedName && cachedSlug) {
        showGeoToast(cachedName, cachedSlug);
      } else {
        // Defer Geolocation fetch to first user interaction (scroll, mousemove, touchstart)
        const initGeoFetch = () => {
          window.removeEventListener('scroll', initGeoFetch);
          window.removeEventListener('mousemove', initGeoFetch);
          window.removeEventListener('touchstart', initGeoFetch);

          setTimeout(function() {
            // Query HTTPS Geolocation API with a 3-second timeout failsafe
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 3000);

            fetch('https://ipapi.co/json/', { signal: controller.signal })
              .then(res => res.json())
              .then(data => {
                clearTimeout(timeoutId);
                if (data && data.country_code === 'VN') {
                  let enRegion = data.region || '';
                  let enCity = data.city || '';
                  
                  // Standard normalization map
                  const regionMap = {
                    "ho chi minh": "thanh-pho-ho-chi-minh",
                    "hanoi": "thanh-pho-ha-noi",
                    "ha noi": "thanh-pho-ha-noi",
                    "da nang": "thanh-pho-da-nang",
                    "hai phong": "thanh-pho-hai-phong",
                    "can tho": "thanh-pho-can-tho",
                    "binh duong": "tinh-binh-duong",
                    "dong nai": "tinh-dong-nai",
                    "quang ninh": "tinh-quang-ninh",
                    "khanh hoa": "tinh-khanh-hoa"
                  };
                  const regionNameMap = {
                    "ho chi minh": "TP. Hồ Chí Minh",
                    "hanoi": "Hà Nội",
                    "ha noi": "Hà Nội",
                    "da nang": "Đà Nẵng",
                    "hai phong": "Hải Phòng",
                    "can tho": "Cần Thơ",
                    "binh duong": "Bình Dương",
                    "dong nai": "Đồng Nai",
                    "quang ninh": "Quảng Ninh",
                    "khanh hoa": "Khánh Hòa"
                  };

                  let lookupKey = (enRegion || enCity).toLowerCase().trim();
                  let targetSlug = '';
                  let targetName = '';

                  if (regionMap[lookupKey]) {
                    targetSlug = regionMap[lookupKey];
                    targetName = regionNameMap[lookupKey];
                  } else if (lookupKey) {
                    // Fallback automatic guess slugification
                    targetSlug = 'tinh-' + slugify(lookupKey);
                    targetName = enRegion || enCity;
                  }

                  if (targetSlug && targetName) {
                    // Cache location in cookie for 7 days
                    setCookie('VinFast_geo_loc_name', targetName, 7);
                    setCookie('VinFast_geo_loc_slug', targetSlug, 7);
                    showGeoToast(targetName, targetSlug);
                  }
                }
              })
              .catch(err => {
                clearTimeout(timeoutId);
                // Fail silently
              });
          }, 2000); // 2 seconds delay after first interaction
        };

        window.addEventListener('scroll', initGeoFetch, { passive: true });
        window.addEventListener('mousemove', initGeoFetch, { passive: true });
        window.addEventListener('touchstart', initGeoFetch, { passive: true });
      }

      function showGeoToast(name, slug) {
        // Resolve dynamic base URL path automatically
        const pathSegments = window.location.pathname.split('/');
        const isSubfolder = pathSegments.includes('vfstamphong');
        const rootPath = isSubfolder ? '/vfstamphong/' : '/';

        const toast = document.getElementById('geo-local-toast');
        const nameEl = document.getElementById('geo-local-name');
        const nameBoldEl = document.getElementById('geo-local-name-bold');
        const linkEl = document.getElementById('geo-local-link');

        if (toast && nameEl && nameBoldEl && linkEl) {
          nameEl.textContent = name;
          nameBoldEl.textContent = name;
          linkEl.href = rootPath + 'gia-xe-VinFast-tai-' + slug + '.html';

          // Show Toast after short initial page load delay
          setTimeout(() => {
            toast.style.display = 'block';
          }, 3500);
        }
      }
    })();

    function dismissGeoToast() {
      const toast = document.getElementById('geo-local-toast');
      if (toast) {
        toast.style.animation = 'geo-slide-out 0.4s cubic-bezier(0.25, 0.8, 0.25, 1) forwards';
        setTimeout(() => {
          toast.style.display = 'none';
        }, 400);
        sessionStorage.setItem('geoToastDismissed', 'true');
      }
    }
  </script>

  <!-- VIP CONVERSION PROMOTIONAL MODAL POPUP -->
  <div class="vip-popup-overlay" id="vipPromoPopup" style="pointer-events: none;">
    <div class="vip-popup-card">
      <button class="vip-popup-close" onclick="closeVipPopup()" aria-label="Đóng hộp thoại">&times;</button>
      
      <div class="vip-popup-grid">
        <!-- Left Side: Visual Luxury Cover (Hidden on Mobile) -->
        <div class="vip-popup-cover" style="background-image: url('<?php echo htmlspecialchars(seo_url($settings['vip_popup_cover_image'] ?? 'assets/uploads/vinfast-vf9.webp')); ?>');">
          <div class="vip-popup-cover__badge"><?php echo htmlspecialchars($settings['vip_popup_cover_badge'] ?? 'Đặc quyền VIP'); ?></div>
          <div class="vip-popup-cover__content">
            <h3><?php echo htmlspecialchars($settings['vip_popup_cover_title'] ?? 'VinFast VF 9'); ?></h3>
            <p><?php echo htmlspecialchars($settings['vip_popup_cover_desc'] ?? 'Kiệt tác thiết kế thuần điện EV. Nhận gói đặc quyền ưu đãi chào hè trị giá tới 300 triệu đồng chính hãng.'); ?></p>
          </div>
        </div>
        
        <!-- Right Side: Conversion Lead Form -->
        <div class="vip-popup-form-box">
          <span class="vip-popup-tag"><?php echo htmlspecialchars($settings['vip_popup_form_tag'] ?? 'Ưu đãi độc quyền 2026'); ?></span>
          <h2 class="vip-popup-title"><?php echo htmlspecialchars($settings['vip_popup_form_title'] ?? 'Nhận Báo Giá & Ưu Đãi Đặc Biệt'); ?></h2>
          <p class="vip-popup-subtitle"><?php echo htmlspecialchars($settings['vip_popup_form_subtitle'] ?? 'Để lại thông tin để chuyên viên VinFast liên hệ tư vấn dòng xe yêu thích cùng đặc quyền đăng ký lái thử VIP tại nhà riêng.'); ?></p>
          
          <form id="vipPopupLeadForm" onsubmit="submitVipPopupForm(event)">
            <!-- HoneyPot anti-spam field -->
            <input type="text" id="vip_website_url" name="website_url" style="display:none;" tabindex="-1" autocomplete="off">
            
            <div class="vip-form-group">
              <input type="text" id="vip_fullname" required placeholder="Họ và tên của bạn *" class="vip-form-input">
            </div>
            
            <div class="vip-form-group">
              <input type="tel" id="vip_phone" required placeholder="Số điện thoại liên hệ *" class="vip-form-input">
            </div>
            
            <div class="vip-form-group">
              <select id="vip_car_id" required class="vip-form-input select-custom">
                <option value="" disabled selected>Chọn dòng xe bạn quan tâm *</option>
                <?php foreach ($allCars as $c): ?>
                  <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['model_name']); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            
            <button type="submit" class="vip-btn-submit">
              <span>ĐĂNG KÝ NHẬN ƯU ĐÃI VIP</span>
              <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
              </svg>
            </button>
          </form>
          
          <div id="vipPopupAlert" class="vip-popup-alert" style="display: none; margin-top: 16px;"></div>
          <span class="vip-popup-privacy">🔒 Cam kết bảo mật thông tin khách hàng tuyệt đối 100%</span>
        </div>
      </div>
    </div>
  </div>

  <script>
    // VIP Conversion Popup Logic (Resilient, session-remembered)
    document.addEventListener('DOMContentLoaded', function() {
      const popup = document.getElementById('vipPromoPopup');
      if (popup) {
        // Show after 4 seconds only if not closed in the current session
        if (!sessionStorage.getItem('vipPopupDismissed')) {
          setTimeout(() => {
            popup.classList.add('vip-popup-show');
            popup.style.pointerEvents = 'auto'; // Enable pointer-events dynamically on show
          }, 4000);
        }
      }
    });

    function triggerVipPopup() {
      const popup = document.getElementById('vipPromoPopup');
      if (popup) {
        popup.classList.add('vip-popup-show');
        popup.style.pointerEvents = 'auto';
      }
    }

    function closeVipPopup() {
      const popup = document.getElementById('vipPromoPopup');
      if (popup) {
        popup.classList.remove('vip-popup-show');
        popup.style.pointerEvents = 'none'; // Disable pointer-events dynamically on hide
        sessionStorage.setItem('vipPopupDismissed', 'true');
      }
    }

    // Close on clicking overlay background
    document.addEventListener('click', function(e) {
      const popup = document.getElementById('vipPromoPopup');
      if (popup && popup.classList.contains('vip-popup-show')) {
        if (e.target === popup) {
          closeVipPopup();
        }
      }
    });

    // Close on pressing Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeVipPopup();
      }
    });

    // AJAX form submission handler for VIP Popup
    function submitVipPopupForm(e) {
      e.preventDefault();
      
      const alertBox = document.getElementById('vipPopupAlert');
      const submitBtn = document.querySelector('.vip-btn-submit');
      const fullname = document.getElementById('vip_fullname').value;
      const phone = document.getElementById('vip_phone').value;
      const carId = document.getElementById('vip_car_id').value;
      const websiteUrl = document.getElementById('vip_website_url').value;
      
      if (!fullname || !phone || !carId) {
        if (alertBox) {
          alertBox.className = "vip-popup-alert vip-popup-alert--error";
          alertBox.innerText = "Vui lòng điền đầy đủ các thông tin bắt buộc!";
          alertBox.style.display = "block";
        }
        return;
      }
      
      if (submitBtn) submitBtn.disabled = true;
      
      const formData = new FormData();
      formData.append('fullname', fullname);
      formData.append('phone', phone);
      formData.append('car_id', carId);
      formData.append('website_url', websiteUrl);
      
      fetch('<?php echo seo_url("ajax-vip-lead.php"); ?>', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (alertBox) {
          alertBox.style.display = "block";
          if (data.success) {
            alertBox.className = "vip-popup-alert vip-popup-alert--success";
            alertBox.innerText = data.message;
            document.getElementById('vipPopupLeadForm').reset();
            // Automatically close the popup after 3 seconds on success
            setTimeout(() => {
              closeVipPopup();
            }, 3000);
          } else {
            alertBox.className = "vip-popup-alert vip-popup-alert--error";
            alertBox.innerText = data.message;
            if (submitBtn) submitBtn.disabled = false;
          }
        }
      })
      .catch(error => {
        if (alertBox) {
          alertBox.className = "vip-popup-alert vip-popup-alert--error";
          alertBox.innerText = "Kết nối máy chủ bị lỗi. Vui lòng thử lại!";
          alertBox.style.display = "block";
        }
        if (submitBtn) submitBtn.disabled = false;
      });
    }
  </script>

  <!-- Luxury Scroll Reveal Intersection Observer -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Find all sections on the page
      const revealSections = document.querySelectorAll("section");
      
      // Add the reveal utility class
      revealSections.forEach(el => {
        el.classList.add("reveal-section");
      });
      
      const revealOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -40px 0px"
      };
      
      const observer = new IntersectionObserver(function(entries, observer) {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add("reveal-section--active");
            observer.unobserve(entry.target);
          }
        });
      }, revealOptions);
      
      revealSections.forEach(section => {
        observer.observe(section);
      });
    });
  </script>


  <?php if (!empty($settings['custom_footer_code'])): ?>
    <?php echo $settings['custom_footer_code']; ?>
  <?php endif; ?>
<?php
if (!empty($GLOBALS['footer_js_files'])) {
    foreach ($GLOBALS['footer_js_files'] as $jsFile) {
        $absolutePath = dirname(__DIR__) . '/' . $jsFile;
        if (file_exists($absolutePath)) {
            echo "<script>\n";
            include $absolutePath;
            echo "\n</script>\n";
        } else {
            echo '<script src="' . htmlspecialchars($jsFile) . '"></script>' . "\n";
        }
    }
}
?>
</body>
</html>






