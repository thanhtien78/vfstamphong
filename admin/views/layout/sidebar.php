<?php
/**
 * Admin Panel Layout: Sidebar
 * Contains Left Navigation with pages matching system modules and active special roles.
 */
global $page, $currentUser, $basePath;
$basePath = $basePath ?? rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
?>
<!-- LEFT SIDEBAR -->
<aside class="sidebar">
  <div class="sidebar__top">
    <a href="<?php echo $basePath ?: '/'; ?>" class="sidebar__logo">
      <svg viewBox="0 0 100 35" width="60" height="20" fill="none" stroke="currentColor" stroke-width="2.5">
        <circle cx="16" cy="17.5" r="12" />
        <circle cx="37" cy="17.5" r="12" />
        <circle cx="58" cy="17.5" r="12" />
        <circle cx="79" cy="17.5" r="12" />
      </svg>
      <span class="sidebar__logo-title">VinFast CENTRAL</span>
    </a>

    <ul class="sidebar__menu">
      <li>
        <a href="<?php echo $basePath; ?>/admin.php?p=dashboard" class="sidebar__item-link <?php echo $page === 'dashboard' ? 'sidebar__item-link--active' : ''; ?>">
          <i class="fas fa-chart-pie"></i>
          <span>Bảng điều khiển (Dashboard)</span>
        </a>
      </li>
      <li>
        <a href="<?php echo $basePath; ?>/admin.php?p=inventory" class="sidebar__item-link <?php echo $page === 'inventory' ? 'sidebar__item-link--active' : ''; ?>">
          <i class="fas fa-car"></i>
          <span>Quản lý Kho xe</span>
        </a>
      </li>
      <li>
        <a href="<?php echo $basePath; ?>/admin.php?p=appointments" class="sidebar__item-link <?php echo $page === 'appointments' ? 'sidebar__item-link--active' : ''; ?>">
          <i class="fas fa-calendar-check"></i>
          <span>Lịch hẹn & Lái thử</span>
        </a>
      </li>
      <li>
        <a href="<?php echo $basePath; ?>/admin.php?p=crm" class="sidebar__item-link <?php echo $page === 'crm' ? 'sidebar__item-link--active' : ''; ?>">
          <i class="fas fa-users-cog"></i>
          <span>Khách hàng (CRM)</span>
        </a>
      </li>
      <li>
        <a href="<?php echo $basePath; ?>/admin.php?p=service" class="sidebar__item-link <?php echo $page === 'service' ? 'sidebar__item-link--active' : ''; ?>">
          <i class="fas fa-wrench"></i>
          <span>Dịch vụ & Bảo dưỡng</span>
        </a>
      </li>
      <li>
        <a href="<?php echo $basePath; ?>/admin.php?p=cms" class="sidebar__item-link <?php echo $page === 'cms' ? 'sidebar__item-link--active' : ''; ?>">
          <i class="fas fa-file-signature"></i>
          <span>Quản lý Nội dung (CMS)</span>
        </a>
      </li>
      <li>
        <a href="<?php echo $basePath; ?>/admin.php?p=media" class="sidebar__item-link <?php echo $page === 'media' ? 'sidebar__item-link--active' : ''; ?>">
          <i class="fas fa-photo-video"></i>
          <span>Thư viện Media</span>
        </a>
      </li>
      <?php if (($currentUser['role'] ?? '') === 'Quản trị viên'): ?>
      <li>
        <a href="<?php echo $basePath; ?>/admin.php?p=branding" class="sidebar__item-link <?php echo $page === 'branding' ? 'sidebar__item-link--active' : ''; ?>">
          <i class="fas fa-palette"></i>
          <span>Cấu hình Header & Footer</span>
        </a>
      </li>
      <?php endif; ?>
      <li>
        <a href="<?php echo $basePath; ?>/admin.php?p=counselors" class="sidebar__item-link <?php echo $page === 'counselors' ? 'sidebar__item-link--active' : ''; ?>">
          <i class="fas fa-user-shield"></i>
          <span>Quản lý Đội ngũ tư vấn</span>
        </a>
      </li>
      <?php if (($currentUser['role'] ?? '') === 'Quản trị viên'): ?>
      <li>
        <a href="<?php echo $basePath; ?>/admin.php?p=pseo" class="sidebar__item-link <?php echo $page === 'pseo' ? 'sidebar__item-link--active' : ''; ?>">
          <i class="fas fa-search-location"></i>
          <span>Cấu hình pSEO PRO</span>
        </a>
      </li>
      <?php endif; ?>
      <li>
        <a href="<?php echo $basePath; ?>/admin.php?p=settings" class="sidebar__item-link <?php echo $page === 'settings' ? 'sidebar__item-link--active' : ''; ?>">
          <i class="fas fa-sliders-h"></i>
          <span><?php echo (($currentUser['role'] ?? '') === 'Quản trị viên') ? 'Cấu hình & Phân quyền' : 'Cấu hình cá nhân'; ?></span>
        </a>
      </li>
    </ul>
  </div>

  <div class="sidebar__footer">
    <div>
      <div class="sidebar__user-name"><?php echo htmlspecialchars($currentUser['fullname']); ?></div>
      <div class="sidebar__user-role"><?php echo htmlspecialchars($currentUser['role']); ?></div>
    </div>
    <a href="<?php echo $basePath; ?>/logout.php" class="sidebar__logout">
      <span>Đăng xuất</span>
    </a>
  </div>
</aside>
