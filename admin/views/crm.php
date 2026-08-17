<?php
  // Automatically check & initialize database column next_followup_date (GET & POST safe)
  try {
      $db->exec("ALTER TABLE customers ADD COLUMN next_followup_date DATE NULL");
  } catch (Exception $e) {
      // Column already exists, ignore safely
  }

  $customerIdToEdit = isset($_GET['edit_cust_id']) ? (int)$_GET['edit_cust_id'] : 0;
  $editCustomer = null;
  if ($customerIdToEdit > 0) {
      $stmt = $db->prepare("SELECT * FROM customers WHERE id = ?");
      $stmt->execute([$customerIdToEdit]);
      $editCustomer = $stmt->fetch();
  }

  // Pre-fetch all customers
  $stmtC = $db->query("SELECT * FROM customers ORDER BY id DESC");
  $crmCustomers = $stmtC->fetchAll();


  // Pre-fetch sales history
  $stmtPurchaseHistory = $db->query("SELECT cc.*, c.fullname, c.phone FROM customer_cars cc JOIN customers c ON cc.customer_id = c.id ORDER BY cc.id DESC");
  $purchases = $stmtPurchaseHistory->fetchAll();

  // Pre-fetch care logs
  $stmtAllLogs = $db->query("SELECT cl.*, c.fullname, c.phone, u.fullname as staff_name FROM customer_care_logs cl JOIN customers c ON cl.customer_id = c.id LEFT JOIN users u ON cl.sale_id = u.id ORDER BY cl.id DESC");
  $allLogs = $stmtAllLogs->fetchAll();

  // Advanced Feature: Pre-fetch unconverted leads from landing page (leads not yet converted to CRM customers)
  $stmtLeads = $db->query("
      SELECT l.*, c.model_name as car_model_name 
      FROM leads l 
      LEFT JOIN cars c ON l.car_id = c.id 
      WHERE l.phone NOT IN (SELECT phone FROM customers) 
      ORDER BY l.id DESC
  ");
  $unconvertedLeads = $stmtLeads->fetchAll();

  // Group detailed data for client-side interactive modal
  $customersData = [];
  foreach ($crmCustomers as $cust) {
      $stmtCars = $db->prepare("SELECT car_model, purchase_date, license_plate, price FROM customer_cars WHERE customer_id = ? ORDER BY id DESC");
      $stmtCars->execute([$cust['id']]);
      $cars = $stmtCars->fetchAll(PDO::FETCH_ASSOC);
      
      $stmtLogs = $db->prepare("SELECT cl.notes, cl.care_date, u.fullname as staff_name FROM customer_care_logs cl LEFT JOIN users u ON cl.sale_id = u.id WHERE cl.customer_id = ? ORDER BY cl.id DESC");
      $stmtLogs->execute([$cust['id']]);
      $logs = $stmtLogs->fetchAll(PDO::FETCH_ASSOC);
      
      $customersData[$cust['id']] = [
          'id' => $cust['id'],
          'fullname' => $cust['fullname'],
          'phone' => $cust['phone'],
          'email' => $cust['email'] ?: 'Chưa có email',
          'classification' => $cust['classification'],
          'created_at' => date('d/m/Y H:i', strtotime($cust['created_at'])),
          'next_followup_date' => isset($cust['next_followup_date']) ? $cust['next_followup_date'] : null,
          'cars' => $cars,
          'logs' => $logs
      ];
  }
?>

<!-- SCOPED CSS STYLING FOR CRM UPGRADE (CSS Scope to prevent collision) -->
<style>
  .crm-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 25px;
  }
  .crm-kpi-card {
    background: linear-gradient(135deg, rgba(20, 26, 40, 0.95) 0%, rgba(10, 14, 22, 0.95) 100%);
    border: 1px solid rgba(25, 96, 215, 0.15);
    border-radius: 12px;
    padding: 22px;
    display: flex;
    align-items: center;
    gap: 16px;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    position: relative;
    overflow: hidden;
  }
  .crm-kpi-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, transparent, var(--color-primary), transparent);
    opacity: 0;
    transition: opacity 0.3s;
  }
  .crm-kpi-card:hover {
    transform: translateY(-4px);
    border-color: rgba(25, 96, 215, 0.4);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3), 0 0 15px rgba(25, 96, 215, 0.05);
  }
  .crm-kpi-card:hover::before {
    opacity: 1;
  }
  .crm-kpi-icon {
    width: 46px;
    height: 46px;
    border-radius: 10px;
    background: rgba(25, 96, 215, 0.1);
    border: 1px solid rgba(25, 96, 215, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--color-primary);
    font-size: 20px;
    flex-shrink: 0;
  }
  .crm-kpi-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }
  .crm-kpi-title {
    font-size: 11px;
    font-weight: 600 !important;
    text-transform: uppercase;
    color: var(--color-text-muted);
    letter-spacing: 0.5px;
  }
  .crm-kpi-value {
    font-size: 24px;
    font-weight: 700 !important;
    color: #fff;
    line-height: 1.1;
  }
  
  /* Navigation Tabs */
  .crm-nav-tabs {
    display: flex;
    gap: 8px;
    border-bottom: 1px solid var(--color-border);
    margin-bottom: 20px;
    padding-bottom: 2px;
    flex-wrap: wrap;
  }
  .crm-nav-tab-btn {
    background: transparent;
    border: none;
    padding: 10px 18px;
    font-size: 13px;
    font-weight: 700 !important;
    color: var(--color-text-muted);
    cursor: pointer;
    border-bottom: 3px solid transparent;
    transition: all 0.2s;
    font-family: 'Montserrat', sans-serif;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .crm-nav-tab-btn:hover {
    color: #fff;
  }
  .crm-nav-tab-btn.active {
    color: var(--color-primary);
    border-bottom-color: var(--color-primary);
  }
  .crm-main-card {
    padding: 24px !important;
  }
  
  /* Quick Action Drawer Tabs */
  .crm-action-tabs {
    display: flex;
    border: 1px solid var(--color-border);
    border-radius: 8px;
    background: rgba(0, 0, 0, 0.3);
    padding: 4px;
    margin-bottom: 20px;
    gap: 4px;
  }
  .crm-action-tab-btn {
    flex: 1;
    background: transparent;
    border: none;
    padding: 8px 12px;
    font-size: 11px;
    font-weight: 700 !important;
    color: var(--color-text-muted);
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.2s;
    text-transform: uppercase;
    font-family: 'Montserrat', sans-serif;
    text-align: center;
  }
  .crm-action-tab-btn:hover {
    color: #fff;
  }
  .crm-action-tab-btn.active {
    background: var(--color-bg-input);
    color: var(--color-primary);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
  }

  /* Inline action icons styling */
  .crm-actions-cell {
    display: flex;
    gap: 6px;
    align-items: center;
  }
  .crm-action-icon {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    border: 1px solid transparent;
    font-size: 12px;
  }
  .crm-action-icon--view {
    background: rgba(25, 96, 215, 0.08);
    border-color: rgba(25, 96, 215, 0.2);
    color: var(--color-primary);
  }
  .crm-action-icon--view:hover {
    background: var(--color-primary);
    color: #000;
  }
  .crm-action-icon--edit {
    background: rgba(255, 255, 255, 0.04);
    border-color: var(--color-border);
    color: var(--color-text-muted);
  }
  .crm-action-icon--edit:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    border-color: var(--color-border-active);
  }
  .crm-action-icon--zalo {
    background: rgba(33, 150, 243, 0.08);
    border-color: rgba(33, 150, 243, 0.2);
    color: #90caf9;
  }
  .crm-action-icon--zalo:hover {
    background: #2196f3;
    color: #fff;
    box-shadow: 0 0 8px rgba(33, 150, 243, 0.3);
  }
  .crm-action-icon--care {
    background: rgba(255, 193, 7, 0.08);
    border-color: rgba(255, 193, 7, 0.2);
    color: #ffe082;
  }
  .crm-action-icon--care:hover {
    background: #ffc107;
    color: #000;
    box-shadow: 0 0 8px rgba(255, 193, 7, 0.3);
  }
  .crm-action-icon--car {
    background: rgba(76, 175, 80, 0.08);
    border-color: rgba(76, 175, 80, 0.2);
    color: #a5d6a7;
  }
  .crm-action-icon--car:hover {
    background: #4caf50;
    color: #fff;
    box-shadow: 0 0 8px rgba(76, 175, 80, 0.3);
  }
  .crm-action-icon--delete {
    background: rgba(239, 83, 80, 0.08);
    border-color: rgba(239, 83, 80, 0.2);
    color: #ff8a80;
  }
  .crm-action-icon--delete:hover {
    background: #ef5350;
    color: #fff;
    box-shadow: 0 0 8px rgba(239, 83, 80, 0.3);
  }

  /* Interactive timeline component */
  .crm-timeline {
    position: relative;
    padding-left: 24px;
    border-left: 2px solid var(--color-border);
    margin-top: 15px;
    display: flex;
    flex-direction: column;
    gap: 20px;
  }
  .crm-timeline-item {
    position: relative;
  }
  .crm-timeline-item::before {
    content: '';
    position: absolute;
    left: -31px;
    top: 4px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: var(--color-primary);
    border: 3px solid var(--color-bg-card);
    box-shadow: 0 0 8px var(--color-primary-glow);
  }
  .crm-timeline-date {
    font-size: 11px;
    font-weight: 600;
    color: var(--color-text-muted);
    margin-bottom: 6px;
    font-family: 'Montserrat', sans-serif;
  }
  .crm-timeline-title {
    font-weight: 700;
    font-size: 13px;
    color: #fff;
    font-family: 'Montserrat', sans-serif;
  }
  .crm-timeline-body {
    font-size: 12.5px;
    color: var(--color-text-muted);
    margin-top: 5px;
    line-height: 1.5;
  }

  /* WP-Style Details Modal Dialog */
  .crm-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 10000;
    display: none;
    align-items: center;
    justify-content: center;
    box-sizing: border-box;
  }
  .crm-modal-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(4, 6, 10, 0.85);
    backdrop-filter: blur(8px);
  }
  .crm-modal-dialog {
    position: relative;
    width: 90vw;
    max-width: 850px;
    height: 85vh;
    max-height: 90vh;
    background: var(--color-bg-card);
    border: 1px solid var(--color-border);
    border-radius: 14px;
    padding: 28px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.65), 0 0 30px rgba(25, 96, 215, 0.05);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    animation: crm-modal-in 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    box-sizing: border-box;
  }
  @keyframes crm-modal-in {
    from { opacity: 0; transform: scale(0.96) translateY(12px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
  }
  .crm-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid var(--color-border);
    padding-bottom: 16px;
    margin-bottom: 20px;
  }
  .crm-modal-title {
    font-size: 16px;
    font-weight: 700 !important;
    color: var(--color-primary);
    font-family: 'Montserrat', sans-serif;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-left: 3px solid var(--color-primary);
    padding-left: 10px;
  }
  .crm-modal-close {
    background: transparent;
    border: none;
    color: var(--color-text-muted);
    font-size: 24px;
    cursor: pointer;
    transition: color 0.2s;
  }
  .crm-modal-close:hover {
    color: #fff;
  }
  .crm-modal-body {
    overflow-y: auto;
    flex-grow: 1;
    padding-right: 8px;
    min-height: 0;
  }
  .crm-modal-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 24px;
    height: 100%;
  }
  @media (min-width: 768px) {
    .crm-modal-grid {
      grid-template-columns: 300px 1fr;
    }
  }
  .crm-modal-sidebar {
    background: rgba(0, 0, 0, 0.2);
    border: 1px solid var(--color-border);
    border-radius: 10px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 15px;
  }
  .crm-modal-main {
    display: flex;
    flex-direction: column;
    gap: 20px;
    min-width: 0;
  }
  .crm-meta-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }
  .crm-meta-label {
    font-size: 10px;
    font-weight: 600;
    color: var(--color-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .crm-meta-value {
    font-size: 13.5px;
    color: #fff;
    font-weight: 500;
  }
  
  /* Contact desk button actions */
  .crm-contact-desk {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-top: 10px;
    border-top: 1px solid var(--color-border);
    padding-top: 15px;
  }
  .crm-contact-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 14px;
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    text-decoration: none;
    border-radius: 6px;
    border: 1px solid transparent;
    transition: all 0.2s;
    cursor: pointer;
  }
  .crm-contact-link--call {
    background: rgba(76, 175, 80, 0.08);
    border-color: rgba(76, 175, 80, 0.2);
    color: #a5d6a7;
  }
  .crm-contact-link--call:hover {
    background: #4caf50;
    color: #fff;
    box-shadow: 0 0 10px rgba(76, 175, 80, 0.25);
  }
  .crm-contact-link--zalo {
    background: rgba(33, 150, 243, 0.08);
    border-color: rgba(33, 150, 243, 0.2);
    color: #90caf9;
  }
  .crm-contact-link--zalo:hover {
    background: #2196f3;
    color: #fff;
    box-shadow: 0 0 10px rgba(33, 150, 243, 0.25);
  }
  .crm-contact-link--email {
    background: rgba(255, 193, 7, 0.08);
    border-color: rgba(255, 193, 7, 0.2);
    color: #ffe082;
  }
  .crm-contact-link--email:hover {
    background: #ffc107;
    color: #000;
    box-shadow: 0 0 10px rgba(255, 193, 7, 0.25);
  }
</style>

<div class="crm-container">

  <!-- ADVANCED REMINDER ALERTS BAR (Reminders of followup due today or overdue) -->
  <?php
    $today = date('Y-m-d');
    $stmtReminders = $db->prepare("SELECT * FROM customers WHERE next_followup_date IS NOT NULL AND next_followup_date <= ? ORDER BY next_followup_date ASC");
    $stmtReminders->execute([$today]);
    $reminders = $stmtReminders->fetchAll();
  ?>
  <?php if (!empty($reminders)): ?>
    <div class="card" style="border-color: #ff9800; background: rgba(255, 152, 0, 0.04); box-shadow: 0 0 15px rgba(255, 152, 0, 0.08); margin-bottom: 25px; padding: 20px;">
      <div style="font-size: 13px; font-weight: 700; color: #ffb74d; text-transform: uppercase; margin-bottom: 12px; display:flex; align-items:center; gap:8px; font-family:'Montserrat',sans-serif;">
        <i class="fas fa-bell" style="animation: crm-bell-ring 1s infinite alternate; color: #ff9800;"></i> NHẮC NHỞ LIÊN HỆ CHĂM SÓC KHÁCH HÀNG HÔM NAY (<?= count($reminders) ?>)
      </div>
      <div style="display: flex; flex-direction: column; gap: 10px;">
        <?php foreach ($reminders as $rem): ?>
          <div class="crm-reminder-row" id="reminder-row-<?= $rem['id'] ?>" style="display: flex; justify-content: space-between; align-items: center; background: rgba(10, 14, 22, 0.4); padding: 10px 18px; border-radius: 6px; border: 1px solid rgba(255, 152, 0, 0.15); transition: all 0.3s ease; flex-wrap: wrap; gap: 10px;">
            <div>
              <strong style="color: #fff; font-size: 13.5px;"><?= htmlspecialchars($rem['fullname']) ?></strong> (<?= htmlspecialchars($rem['phone']) ?>) 
              <span style="font-size: 11px; margin-left: 10px; padding: 3px 8px; border-radius: 4px; background: rgba(255, 152, 0, 0.15); color: #ffb74d; font-family: monospace; font-weight: bold;">Hạn: <?= date('d/m/Y', strtotime($rem['next_followup_date'])) ?></span>
            </div>
            <div style="display:flex; gap: 8px;">
              <a href="tel:<?= $rem['phone'] ?>" class="btn-gold" style="padding: 5px 12px; font-size: 10.5px; border-color: #4caf50; color: #81c784; box-shadow: none; min-height: auto; text-transform: none;"><i class="fas fa-phone-alt"></i> Gọi điện</a>
              <a href="https://zalo.me/<?= preg_replace('/\D/', '', $rem['phone']) ?>" target="_blank" class="btn-gold" style="padding: 5px 12px; font-size: 10.5px; border-color: #2196f3; color: #64b5f6; box-shadow: none; min-height: auto; text-transform: none;"><i class="fas fa-comment-dots"></i> Zalo</a>
              <button onclick="clearReminder(<?= $rem['id'] ?>)" class="btn-gold" style="padding: 5px 12px; font-size: 10.5px; border-color: #ff9800; color: #ffb74d; box-shadow: none; min-height: auto; text-transform: none;"><i class="fas fa-check"></i> Đã hoàn thành</button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <style>
      @keyframes crm-bell-ring {
        from { transform: rotate(-10deg); }
        to { transform: rotate(10deg); }
      }
    </style>
  <?php endif; ?>

  <!-- TOP-LEVEL STATS ROW -->
  <div class="crm-kpi-grid">
    <div class="crm-kpi-card">
      <div class="crm-kpi-icon">
        <i class="fas fa-users"></i>
      </div>
      <div class="crm-kpi-info">
        <div class="crm-kpi-title">Tổng số khách hàng</div>
        <div class="crm-kpi-value"><?= count($crmCustomers) ?></div>
      </div>
    </div>
    
    <div class="crm-kpi-card">
      <div class="crm-kpi-icon" style="background: rgba(76,175,80,0.1); border-color: rgba(76,175,80,0.2); color: #81c784;">
        <i class="fas fa-crown"></i>
      </div>
      <div class="crm-kpi-info">
        <div class="crm-kpi-title">Khách hàng VIP</div>
        <div class="crm-kpi-value">
          <?php
            $vipCount = 0;
            foreach ($crmCustomers as $c) {
                if ($c['classification'] === 'VIP') $vipCount++;
            }
            echo $vipCount;
          ?>
        </div>
      </div>
    </div>
    
    <div class="crm-kpi-card">
      <div class="crm-kpi-icon" style="background: rgba(33,150,243,0.1); border-color: rgba(33,150,243,0.2); color: #64b5f6;">
        <i class="fas fa-car"></i>
      </div>
      <div class="crm-kpi-info">
        <div class="crm-kpi-title">Đã bàn giao xe</div>
        <div class="crm-kpi-value"><?= count($purchases) ?></div>
      </div>
    </div>
    
    <div class="crm-kpi-card">
      <div class="crm-kpi-icon" style="background: rgba(255,193,7,0.1); border-color: rgba(255,193,7,0.2); color: #ffd54f;">
        <i class="fas fa-history"></i>
      </div>
      <div class="crm-kpi-info">
        <div class="crm-kpi-title">Lượt chăm sóc khách</div>
        <div class="crm-kpi-value"><?= count($allLogs) ?></div>
      </div>
    </div>
  </div>

  <!-- SPLIT CONTENT LAYOUT -->
  <div class="layout-split layout-split--wide-left">
    
    <!-- LEFT SIDE: CRM TABS & DATABASES -->
    <div>
      <div class="card crm-main-card">
        
        <div class="card__title-row" style="border-bottom: 1px solid var(--color-border); padding-bottom: 15px; margin-bottom: 15px;">
          <div class="card__title">CƠ SỞ DỮ LIỆU CRM CHUYÊN NGHIỆP</div>
          <div style="display:flex; gap:10px;">
            <!-- ADVANCED EXCEL DATA EXPORTER BUTTON -->
            <button onclick="exportFilteredDataToCsv()" class="btn-gold" style="font-size: 11px; padding: 6px 12px; border-color: #4caf50; color: #a5d6a7; border-radius: 6px;"><i class="fas fa-file-excel"></i> Xuất Excel</button>
            <a href="admin.php?p=crm&new=1" class="btn-gold" style="font-size: 11px; padding: 6px 12px; border-radius: 6px;"><i class="fas fa-plus"></i> Tạo hồ sơ khách mới</a>
          </div>
        </div>

        <!-- Inner Navigation Switcher -->
        <div class="crm-nav-tabs">
          <button class="crm-nav-tab-btn active" data-tab="list" onclick="switchMainTab('list')">
            <i class="fas fa-address-book"></i> Danh sách khách hàng
          </button>
          <button class="crm-nav-tab-btn" data-tab="deliveries" onclick="switchMainTab('deliveries')">
            <i class="fas fa-file-invoice-dollar"></i> Lịch sử bàn giao xe
          </button>
          <button class="crm-nav-tab-btn" data-tab="care" onclick="switchMainTab('care')">
            <i class="fas fa-clipboard-list"></i> Nhật ký chăm sóc chung
          </button>
          <!-- ADVANCED HOMEPAGE LEADS SYNC PANELS TAB -->
          <button class="crm-nav-tab-btn" data-tab="leads-sync" onclick="switchMainTab('leads-sync')">
            <i class="fas fa-sync"></i> Đồng bộ Lead lái thử (<?= count($unconvertedLeads) ?>)
          </button>
        </div>

        <!-- TAB CONTENT 1: CUSTOMERS DIRECTORY -->
        <div class="crm-tab-content active" id="crm-tab-list">
          
          <!-- Filters Toolbelt -->
          <div style="margin-bottom: 18px; display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 15px; background: rgba(0,0,0,0.15); padding: 12px; border-radius: 8px; border: 1px solid var(--color-border);">
            <div>
              <input class="form-input" type="text" id="search_cust" placeholder="🔍 Nhập họ tên khách hàng, số điện thoại để lọc..." onkeyup="filterCrmTable()">
            </div>
            <div>
              <select class="form-input" id="filter_cust_class" onchange="filterCrmTable()">
                <option value="">-- Phân nhóm khách hàng --</option>
                <option value="Tiềm năng">Tiềm năng</option>
                <option value="VIP">VIP</option>
                <option value="Đã mua xe">Đã mua xe</option>
                <option value="Thành viên">Thành viên</option>
              </select>
            </div>
          </div>

          <div class="table-container">
            <table class="cms-table" id="crm_customers_table">
              <thead>
                <tr>
                  <th style="width: 50px;">ID</th>
                  <th>Họ & Tên khách</th>
                  <th>Số điện thoại</th>
                  <th>Địa chỉ Email</th>
                  <th>Phân loại</th>
                  <th>Ngày đăng ký</th>
                  <th>Hẹn lịch nhắc</th>
                  <th>Nhật ký cuối cùng</th>
                  <th style="width: 150px; text-align: center;">Thao tác nhanh</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($crmCustomers)): ?>
                  <tr><td colspan="9" style="text-align:center; color:var(--color-text-muted); padding:30px;">Hệ thống CRM đang trống. Vui lòng thêm khách hàng mới!</td></tr>
                <?php else: ?>
                  <?php foreach ($crmCustomers as $cust): ?>
                    <?php
                      $classBadge = 'status-badge--pending'; // Tiềm năng
                      if ($cust['classification'] === 'VIP') $classBadge = 'status-badge--completed';
                      elseif ($cust['classification'] === 'Đã mua xe') $classBadge = 'status-badge--success';
                      elseif ($cust['classification'] === 'Thành viên') $classBadge = 'status-badge--contacting';

                      // Last Care log
                      $stmtLastLog = $db->prepare("SELECT notes, care_date FROM customer_care_logs WHERE customer_id = ? ORDER BY id DESC LIMIT 1");
                      $stmtLastLog->execute([$cust['id']]);
                      $lastLog = $stmtLastLog->fetch();
                    ?>
                    <tr class="customer-row" data-class="<?= htmlspecialchars($cust['classification']) ?>">
                      <td>#<?= $cust['id'] ?></td>
                      <td>
                        <strong class="cust-name"><?= htmlspecialchars($cust['fullname']) ?></strong>
                      </td>
                      <td>
                        <span class="cust-phone"><?= htmlspecialchars($cust['phone']) ?></span>
                      </td>
                      <td>
                        <span class="cust-email" style="font-size:12px; color:var(--color-text-muted);"><?= htmlspecialchars($cust['email'] ?: 'Chưa nhập email') ?></span>
                      </td>
                      <td>
                        <span class="status-badge <?= $classBadge ?>"><?= htmlspecialchars($cust['classification']) ?></span>
                      </td>
                      <td style="font-size:12px; color:var(--color-text-muted);">
                        <?= date('d/m/Y H:i', strtotime($cust['created_at'])) ?>
                      </td>
                      <td>
                        <?php if ($cust['next_followup_date']): ?>
                          <span style="font-size: 11px; color: #ffb74d; background: rgba(255, 152, 0, 0.08); padding: 3px 6px; border-radius: 4px; border: 1px solid rgba(255, 152, 0, 0.2);">
                            <i class="far fa-clock"></i> <?= date('d/m/Y', strtotime($cust['next_followup_date'])) ?>
                          </span>
                        <?php else: ?>
                          <span style="color:var(--color-text-muted); font-size: 11.5px;">Chưa hẹn</span>
                        <?php endif; ?>
                      </td>
                      <td style="font-size:12px; max-width:180px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="<?= $lastLog ? htmlspecialchars($lastLog['notes']) : 'Chưa có nhật ký' ?>">
                        <?= $lastLog ? htmlspecialchars($lastLog['notes']) : '<span style="color:var(--color-text-muted);">Không có ghi chép</span>' ?>
                      </td>
                      <td>
                        <div class="crm-actions-cell">
                          <button type="button" class="crm-action-icon crm-action-icon--view" onclick="openCrmDetailsModal(<?= $cust['id'] ?>)" title="Xem chi tiết & Dòng lịch sử">
                            <i class="fas fa-eye"></i>
                          </button>
                          
                          <button type="button" class="crm-action-icon crm-action-icon--care" onclick="quickLogCare(<?= $cust['id'] ?>)" title="Thêm nhật ký nhanh">
                            <i class="fas fa-comment-alt"></i>
                          </button>

                          <button type="button" class="crm-action-icon crm-action-icon--car" onclick="quickLogPurchase(<?= $cust['id'] ?>)" title="Ghi nhận giao dịch mua xe">
                            <i class="fas fa-car-side"></i>
                          </button>

                          <a href="admin.php?p=crm&edit_cust_id=<?= $cust['id'] ?>" class="crm-action-icon crm-action-icon--edit" title="Sửa hồ sơ">
                            <i class="fas fa-pencil-alt"></i>
                          </a>

                          <form method="POST" action="admin.php?p=crm" style="display:inline-block;" onsubmit="return confirm('Xóa hồ sơ khách hàng sẽ xóa sạch lịch sử mua xe và toàn bộ nhật ký chăm sóc liên quan? Thao tác không thể khôi phục!')">
                            <input type="hidden" name="action" value="delete_customer">
                            <input type="hidden" name="id" value="<?= $cust['id'] ?>">
                            <button type="submit" class="crm-action-icon crm-action-icon--delete" style="padding:0;">
                              <i class="fas fa-trash-alt"></i>
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- TAB CONTENT 2: DELIVERED CARS -->
        <div class="crm-tab-content" id="crm-tab-deliveries">
          <div class="table-container">
            <table class="cms-table" id="crm_deliveries_table">
              <thead>
                <tr>
                  <th>Khách hàng mua xe</th>
                  <th>Số điện thoại</th>
                  <th>Dòng xe bàn giao</th>
                  <th>Biển kiểm soát</th>
                  <th>Ngày giao nhận</th>
                  <th>Trị giá hợp đồng</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($purchases)): ?>
                  <tr><td colspan="6" style="text-align:center; color:var(--color-text-muted); padding:30px;">Chưa ghi nhận giao dịch mua xe nào trên hệ thống.</td></tr>
                <?php else: ?>
                  <?php foreach ($purchases as $p): ?>
                    <tr>
                      <td><strong><?= htmlspecialchars($p['fullname']) ?></strong></td>
                      <td><?= htmlspecialchars($p['phone']) ?></td>
                      <td><strong style="color:#fff;"><?= htmlspecialchars($p['car_model']) ?></strong></td>
                      <td><span style="font-family:monospace; background:rgba(0,0,0,0.3); padding:4px 8px; border-radius:4px; border:1px solid var(--color-border);"><?= htmlspecialchars($p['license_plate'] ?: 'N/A') ?></span></td>
                      <td><?= date('d/m/Y', strtotime($p['purchase_date'])) ?></td>
                      <td style="color:var(--color-primary); font-weight:600;"><?= htmlspecialchars($p['price']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- TAB CONTENT 3: TIMELINE HISTORY LIST -->
        <div class="crm-tab-content" id="crm-tab-care">
          <div class="crm-timeline" id="crm_care_logs_timeline" style="max-height: 620px; overflow-y: auto; padding-right:12px; margin-top:10px;">
            <?php if (empty($allLogs)): ?>
              <div style="color:var(--color-text-muted); font-size:13px; text-align:center; padding:30px;">Chưa có nhật ký chăm sóc khách hàng nào trên hệ thống.</div>
            <?php else: ?>
              <?php foreach ($allLogs as $log): ?>
                <div class="crm-timeline-item">
                  <div class="crm-timeline-date" style="display:flex; justify-content:space-between; align-items:center;">
                    <span><?= date('d/m/Y H:i', strtotime($log['care_date'])) ?></span>
                    <span style="background: rgba(25, 96, 215,0.08); border: 1px solid rgba(25, 96, 215,0.2); padding: 2px 8px; border-radius: 4px; color:var(--color-primary); font-size: 10px;">phụ trách: <?= htmlspecialchars($log['staff_name'] ?: 'Hệ thống') ?></span>
                  </div>
                  <div class="crm-timeline-title">
                    Khách hàng: <strong style="color:#fff;"><?= htmlspecialchars($log['fullname']) ?></strong> (<?= htmlspecialchars($log['phone']) ?>)
                  </div>
                  <div class="crm-timeline-body" style="background: rgba(0,0,0,0.25); padding: 12px; border-radius: 8px; border: 1px solid var(--color-border); margin-top: 6px;">
                    <?= nl2br(htmlspecialchars($log['notes'])) ?>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>

        <!-- TAB CONTENT 4: LEADS SYNCHRONIZATION FROM HOMEPAGE -->
        <div class="crm-tab-content" id="crm-tab-leads-sync">
          <div class="table-container">
            <table class="cms-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Họ & Tên đăng ký</th>
                  <th>Liên hệ (SĐT / Email)</th>
                  <th>Dòng xe đăng ký lái thử</th>
                  <th>Ngày hẹn đề xuất</th>
                  <th>Đồng bộ</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($unconvertedLeads)): ?>
                  <tr><td colspan="6" style="text-align:center; color:var(--color-text-muted); padding:40px;">Tất cả Lead đăng ký lái thử đã được đồng bộ hoàn toàn vào CRM!</td></tr>
                <?php else: ?>
                  <?php foreach ($unconvertedLeads as $lead): ?>
                    <tr>
                      <td>#<?= $lead['id'] ?></td>
                      <td><strong><?= htmlspecialchars($lead['fullname']) ?></strong></td>
                      <td>
                        <?= htmlspecialchars($lead['phone']) ?>
                        <br>
                        <span style="font-size:11px; color:var(--color-text-muted);"><?= htmlspecialchars($lead['email'] ?: 'Chưa nhập email') ?></span>
                      </td>
                      <td>
                        <strong style="color:#fff;"><i class="fas fa-car"></i> <?= htmlspecialchars($lead['car_model_name'] ?: 'Dòng xe VinFast') ?></strong>
                      </td>
                      <td style="font-size:12px;"><?= htmlspecialchars($lead['preferred_date'] ?: 'N/A') ?></td>
                      <td>
                        <div style="display:flex; flex-direction:column; gap:6px;">
                          <form method="POST" action="admin.php?p=crm" style="display:block; width:100%;">
                            <input type="hidden" name="action" value="import_lead">
                            <input type="hidden" name="lead_id" value="<?= $lead['id'] ?>">
                            <button type="submit" class="btn-gold" style="padding:5px 10px; font-size:10.5px; min-height:auto; text-transform:none; width:100%; text-align:center; display:block;">
                              <i class="fas fa-download"></i> Đồng bộ tiềm năng
                            </button>
                          </form>
                          <form method="POST" action="admin.php?p=crm" style="display:block; width:100%;" onsubmit="return confirm('Bạn có chắc chắn muốn chuyển đổi lead này thành khách hàng đã mua xe? Xe: <?= htmlspecialchars($lead['car_model_name'] ?: 'Dòng xe VinFast') ?>')">
                            <input type="hidden" name="action" value="convert_lead_to_buyer">
                            <input type="hidden" name="lead_id" value="<?= $lead['id'] ?>">
                            <button type="submit" class="btn-gold" style="padding:5px 10px; font-size:10.5px; min-height:auto; text-transform:none; width:100%; text-align:center; display:block; border-color:#2ec4b6; color:#2ec4b6; background:rgba(46, 196, 182, 0.05);">
                              <i class="fas fa-check-circle"></i> Chuyển khách mua xe
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>

    <!-- RIGHT SIDE: QUICK ACTIONS DESK -->
    <div>
      <div class="card inline-action-card" style="position: sticky; top: 20px;">
        
        <div class="card__title" style="border-bottom: 1px solid var(--color-border); padding-bottom: 12px; margin-bottom: 15px;">
          BÀN LÀM VIỆC TÁC VỤ NHANH
        </div>

        <!-- Form Navigation Switcher -->
        <div class="crm-action-tabs">
          <button type="button" class="crm-action-tab-btn active" data-tab="customer" onclick="switchActionTab('customer')">Hồ sơ</button>
          <button type="button" class="crm-action-tab-btn" data-tab="purchase" onclick="switchActionTab('purchase')">Giao xe</button>
          <button type="button" class="crm-action-tab-btn" data-tab="care" onclick="switchActionTab('care')">Nhật ký</button>
        </div>

        <!-- FORM CONTAINER 1: CUSTOMER ADD/EDIT -->
        <div class="action-form-content" id="action-form-customer">
          <form method="POST" action="admin.php?p=crm">
            <input type="hidden" name="action" value="<?= $editCustomer ? 'edit_customer' : 'create_customer' ?>">
            <?php if ($editCustomer): ?>
              <input type="hidden" name="id" value="<?= $editCustomer['id'] ?>">
              <div style="font-size: 11px; color: var(--color-primary); font-weight: 600; margin-bottom: 10px; display:flex; justify-content:space-between; align-items:center;">
                <span>✏️ CẬP NHẬT TƯ VẤN VIÊN</span>
                <a href="admin.php?p=crm" style="color:#ef5350; text-decoration:none;">Huỷ sửa ✕</a>
              </div>
            <?php else: ?>
              <div style="font-size: 11px; color: var(--color-text-muted); font-weight: 600; margin-bottom: 10px;">
                🆕 TẠO MỚI HỒ SƠ KHÁCH HÀNG CRM
              </div>
            <?php endif; ?>

            <div class="form-group">
              <label class="form-label" for="fullname">Họ & Tên khách hàng *</label>
              <input class="form-input" type="text" name="fullname" id="fullname" required value="<?= $editCustomer ? htmlspecialchars($editCustomer['fullname']) : '' ?>" placeholder="Nguyễn Văn A">
            </div>

            <div class="form-group" style="margin-top:12px;">
              <label class="form-label" for="phone">Số điện thoại liên hệ *</label>
              <input class="form-input" type="text" name="phone" id="phone" required value="<?= $editCustomer ? htmlspecialchars($editCustomer['phone']) : '' ?>" placeholder="Ví dụ: 0912345678">
            </div>

            <div class="form-group" style="margin-top:12px;">
              <label class="form-label" for="email">Địa chỉ Email</label>
              <input class="form-input" type="email" name="email" id="email" value="<?= $editCustomer ? htmlspecialchars($editCustomer['email']) : '' ?>" placeholder="name@domain.com">
            </div>

            <div class="form-group" style="margin-top:12px;">
              <label class="form-label" for="classification">Phân nhóm / Đánh giá phân loại</label>
              <select class="form-input" name="classification" id="classification">
                <option value="Tiềm năng" <?= ($editCustomer && $editCustomer['classification'] === 'Tiềm năng') ? 'selected' : '' ?>>Khách Tiềm năng</option>
                <option value="VIP" <?= ($editCustomer && $editCustomer['classification'] === 'VIP') ? 'selected' : '' ?>>Khách hàng VIP</option>
                <option value="Đã mua xe" <?= ($editCustomer && $editCustomer['classification'] === 'Đã mua xe') ? 'selected' : '' ?>>Đã mua xe</option>
                <option value="Thành viên" <?= ($editCustomer && $editCustomer['classification'] === 'Thành viên') ? 'selected' : '' ?>>Thành viên thường</option>
              </select>
            </div>

            <!-- Follow-up input for Client profiling card -->
            <div class="form-group" style="margin-top:12px;">
              <label class="form-label" for="cust_next_followup">Hẹn lịch liên hệ tiếp theo (Nhắc hẹn)</label>
              <input class="form-input" type="date" name="next_followup_date" id="cust_next_followup" value="<?= $editCustomer ? htmlspecialchars($editCustomer['next_followup_date']) : '' ?>">
            </div>

            <button class="btn-gold" type="submit" style="margin-top:18px; width:100%;">
              <?= $editCustomer ? 'Cập nhật thông tin' : 'Lưu hồ sơ CRM' ?>
            </button>
          </form>
        </div>

        <!-- FORM CONTAINER 2: LOG CAR DELIVERY -->
        <div class="action-form-content" id="action-form-purchase" style="display:none;">
          <form method="POST" action="admin.php?p=crm">
            <input type="hidden" name="action" value="add_purchase">
            
            <div style="font-size: 11px; color: var(--color-text-muted); font-weight: 600; margin-bottom: 10px;">
              🚘 GHI NHẬN BÀN GIAO XE MỚI
            </div>

            <div class="form-group">
              <label class="form-label" for="pur_cust_id">Chọn khách hàng nhận xe</label>
              <div style="margin-bottom:6px;">
                <input type="text" id="pur_cust_search" class="form-input" placeholder="🔍 Gõ để tìm nhanh tên hoặc SĐT..." style="font-size:11px; padding:6px 10px; height:auto; background: rgba(0,0,0,0.2);" onkeyup="filterSelectOptions('pur_cust_search', 'pur_cust_id')">
              </div>
              <select class="form-input" name="customer_id" id="pur_cust_id" required>
                <option value="">-- Chọn khách hàng --</option>
                <?php foreach ($crmCustomers as $cust): ?>
                  <option value="<?= $cust['id'] ?>"><?= htmlspecialchars($cust['fullname']) ?> (<?= htmlspecialchars($cust['phone']) ?>)</option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group" style="margin-top:12px;">
              <label class="form-label" for="pur_car">Dòng xe bàn giao *</label>
              <input class="form-input" type="text" name="car_model" id="pur_car" required placeholder="Ví dụ: VinFast VF 9 RS">
            </div>

            <div class="form-row" style="margin-top:12px;">
              <div class="form-group">
                <label class="form-label" for="pur_plate">Biển kiểm soát</label>
                <input class="form-input" type="text" name="license_plate" id="pur_plate" placeholder="Ví dụ: 30K-999.99">
              </div>
              <div class="form-group">
                <label class="form-label" for="pur_date">Ngày bàn giao</label>
                <input class="form-input" type="date" name="purchase_date" id="pur_date" value="<?= date('Y-m-d') ?>">
              </div>
            </div>

            <div class="form-group" style="margin-top:12px;">
              <label class="form-label" for="pur_price">Giá trị hợp đồng (VNĐ)</label>
              <input class="form-input" type="text" name="price" id="pur_price" placeholder="Ví dụ: 5.900.000.000 VNĐ">
            </div>

            <button class="btn-gold" type="submit" style="margin-top:18px; width:100%;">
              Ghi nhận giao dịch mua xe
            </button>
          </form>
        </div>

        <!-- FORM CONTAINER 3: LOG CARE ACTIVITY -->
        <div class="action-form-content" id="action-form-care" style="display:none;">
          <form method="POST" action="admin.php?p=crm">
            <input type="hidden" name="action" value="add_care_log">
            
            <div style="font-size: 11px; color: var(--color-text-muted); font-weight: 600; margin-bottom: 10px;">
              📝 THÊM NHẬT KÝ CHĂM SÓC KHÁCH
            </div>

            <div class="form-group">
              <label class="form-label" for="care_cust_id">Chọn khách hàng</label>
              <div style="margin-bottom:6px;">
                <input type="text" id="care_cust_search" class="form-input" placeholder="🔍 Gõ để tìm nhanh tên hoặc SĐT..." style="font-size:11px; padding:6px 10px; height:auto; background: rgba(0,0,0,0.2);" onkeyup="filterSelectOptions('care_cust_search', 'care_cust_id')">
              </div>
              <select class="form-input" name="customer_id" id="care_cust_id" required>
                <option value="">-- Chọn khách hàng --</option>
                <?php foreach ($crmCustomers as $cust): ?>
                  <option value="<?= $cust['id'] ?>"><?= htmlspecialchars($cust['fullname']) ?> (<?= htmlspecialchars($cust['phone']) ?>)</option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group" style="margin-top:12px;">
              <label class="form-label" for="care_notes">Nội dung trao đổi / Nhật ký chăm sóc *</label>
              <textarea class="form-input" name="notes" id="care_notes" required placeholder="Ghi chép chi tiết trao đổi..." style="min-height: 120px;"></textarea>
            </div>

            <!-- Follow-up input for Log Care card -->
            <div class="form-group" style="margin-top:12px;">
              <label class="form-label" for="care_next_followup">Hẹn lịch liên hệ tiếp theo (Nhắc hẹn)</label>
              <input class="form-input" type="date" name="next_followup_date" id="care_next_followup" value="">
            </div>

            <button class="btn-gold" type="submit" style="margin-top:18px; width:100%;">
              Lưu nhật ký chăm sóc
            </button>
          </form>
        </div>

      </div>
    </div>

  </div>

</div>

<!-- INTERACTIVE DETAILS MODAL DIALOG -->
<div class="crm-modal" id="crm_details_modal">
  <div class="crm-modal-backdrop" onclick="closeCrmDetailsModal()"></div>
  <div class="crm-modal-dialog">
    <div class="crm-modal-header">
      <div class="crm-modal-title">CHI TIẾT LỊCH SỬ KHÁCH HÀNG</div>
      <button type="button" class="crm-modal-close" onclick="closeCrmDetailsModal()">&times;</button>
    </div>
    
    <div class="crm-modal-body">
      <div class="crm-modal-grid">
        
        <!-- Sidebar: Contact Summary -->
        <div class="crm-modal-sidebar">
          <div style="text-align: center; padding-bottom: 15px; border-bottom: 1px solid var(--color-border); margin-bottom: 15px;">
            <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(25, 96, 215,0.1); border: 2px solid var(--color-primary); display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; color: var(--color-primary); font-size: 26px;">
              <i class="fas fa-user-tie"></i>
            </div>
            <h3 id="modal_fullname" style="font-size: 15px; color: #fff; font-weight: 700; margin-bottom: 5px;">Họ tên khách</h3>
            <span id="modal_badge" class="status-badge">Phân loại</span>
          </div>

          <div class="crm-meta-item">
            <span class="crm-meta-label">Số điện thoại:</span>
            <span class="crm-meta-value" id="modal_phone">Chưa có</span>
          </div>

          <div class="crm-meta-item">
            <span class="crm-meta-label">Email:</span>
            <span class="crm-meta-value" id="modal_email" style="word-break: break-all;">Chưa có</span>
          </div>

          <div class="crm-meta-item">
            <span class="crm-meta-label">Lịch nhắc tiếp theo:</span>
            <span class="crm-meta-value" id="modal_followup_label" style="color:#ffb74d;">Không có</span>
          </div>

          <div class="crm-meta-item">
            <span class="crm-meta-label">Đăng ký hệ thống:</span>
            <span class="crm-meta-value" id="modal_created_at">Chưa có</span>
          </div>

          <!-- Quick Communications -->
          <div class="crm-contact-desk">
            <a href="#" id="modal_call_btn" class="crm-contact-link crm-contact-link--call">
              <i class="fas fa-phone-alt"></i> Gọi điện thoại
            </a>
            <a href="#" id="modal_zalo_btn" target="_blank" class="crm-contact-link crm-contact-link--zalo">
              <i class="fas fa-comment-dots"></i> Chat Zalo
            </a>
            <a href="#" id="modal_email_btn" class="crm-contact-link crm-contact-link--email">
              <i class="fas fa-envelope"></i> Gửi Thư Điện Tử
            </a>
          </div>
        </div>

        <!-- Main section: Tabs of History -->
        <div class="crm-modal-main">
          
          <!-- Section 1: Owned Cars -->
          <div style="background: rgba(0, 0, 0, 0.15); border: 1px solid var(--color-border); border-radius: 10px; padding: 20px;">
            <div style="font-size: 11px; font-weight: 700; color: var(--color-primary); text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.5px; display:flex; align-items:center; gap:6px;">
              <i class="fas fa-car"></i> SỞ HỮU XE & GIAO DỊCH ĐÃ KÝ
            </div>
            <div id="modal_cars_list" style="max-height: 180px; overflow-y: auto;">
              <!-- Populated dynamically -->
            </div>
          </div>

          <!-- Section 2: Care Logs Timeline -->
          <div style="background: rgba(0, 0, 0, 0.15); border: 1px solid var(--color-border); border-radius: 10px; padding: 20px; flex-grow: 1; display: flex; flex-direction: column; min-height: 0;">
            <div style="font-size: 11px; font-weight: 700; color: var(--color-primary); text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.5px; display:flex; align-items:center; gap:6px;">
              <i class="fas fa-clipboard-list"></i> DÒNG LỊCH SỬ CHĂM SÓC
            </div>
            <div id="modal_logs_timeline" style="overflow-y: auto; flex-grow: 1; max-height: 220px; padding-right: 5px;">
              <!-- Populated dynamically -->
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
</div>

<!-- CLIENT-DATASTORE INJECTION -->
<script>
  const crmCustomersData = <?= json_encode($customersData, JSON_UNESCAPED_UNICODE) ?>;
  let activeMainTab = 'list';
</script>

<!-- JAVASCRIPT CRM INTERACTION MANAGER -->
<script>
  // 1. Tab Swapping on Main Board
  function switchMainTab(tabName) {
    activeMainTab = tabName;
    document.querySelectorAll('.crm-nav-tab-btn').forEach(btn => {
      btn.classList.remove('active');
    });
    document.querySelectorAll('.crm-tab-content').forEach(content => {
      content.classList.remove('active');
    });
    
    const activeBtn = document.querySelector(`.crm-nav-tab-btn[data-tab="${tabName}"]`);
    const activeContent = document.getElementById(`crm-tab-${tabName}`);
    
    if (activeBtn && activeContent) {
      activeBtn.classList.add('active');
      activeContent.classList.add('active');
    }
  }

  // 2. Tab Swapping on Action Panel
  function switchActionTab(tabName) {
    document.querySelectorAll('.crm-action-tab-btn').forEach(btn => {
      btn.classList.remove('active');
    });
    document.querySelectorAll('.action-form-content').forEach(form => {
      form.style.display = 'none';
    });
    
    const activeBtn = document.querySelector(`.crm-action-tab-btn[data-tab="${tabName}"]`);
    const activeForm = document.getElementById(`action-form-${tabName}`);
    
    if (activeBtn && activeForm) {
      activeBtn.classList.add('active');
      activeForm.style.display = 'block';
    }
  }

  // 3. Quick select customer & switch form actions
  function quickLogCare(customerId) {
    switchActionTab('care');
    const select = document.getElementById('care_cust_id');
    if (select) {
      select.value = customerId;
      // Scroll to workspace card
      const actionCard = document.querySelector('.inline-action-card');
      if (actionCard) {
        actionCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
        actionCard.style.borderColor = 'var(--color-primary)';
        actionCard.style.boxShadow = '0 0 20px rgba(25, 96, 215, 0.2)';
        setTimeout(() => {
          actionCard.style.borderColor = '';
          actionCard.style.boxShadow = '';
        }, 1500);
      }
    }
  }

  function quickLogPurchase(customerId) {
    switchActionTab('purchase');
    const select = document.getElementById('pur_cust_id');
    if (select) {
      select.value = customerId;
      const actionCard = document.querySelector('.inline-action-card');
      if (actionCard) {
        actionCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
        actionCard.style.borderColor = 'var(--color-primary)';
        actionCard.style.boxShadow = '0 0 20px rgba(25, 96, 215, 0.2)';
        setTimeout(() => {
          actionCard.style.borderColor = '';
          actionCard.style.boxShadow = '';
        }, 1500);
      }
    }
  }

  // 4. Dropdown Select Search Filter Helper
  function filterSelectOptions(searchInputId, selectId) {
    const query = document.getElementById(searchInputId).value.toLowerCase().trim();
    const select = document.getElementById(selectId);
    const options = select.options;
    
    for (let i = 1; i < options.length; i++) {
      const text = options[i].text.toLowerCase();
      if (text.includes(query)) {
        options[i].style.display = '';
      } else {
        options[i].style.display = 'none';
      }
    }
  }

  // 5. Customer Grid live search and classification filters
  function filterCrmTable() {
    const query = document.getElementById('search_cust').value.toLowerCase().trim();
    const classFilter = document.getElementById('filter_cust_class').value;
    const rows = document.querySelectorAll('.customer-row');
    
    rows.forEach(row => {
      const name = row.querySelector('.cust-name') ? row.querySelector('.cust-name').textContent.toLowerCase() : '';
      const phone = row.querySelector('.cust-phone') ? row.querySelector('.cust-phone').textContent.toLowerCase() : '';
      const email = row.querySelector('.cust-email') ? row.querySelector('.cust-email').textContent.toLowerCase() : '';
      const classification = row.getAttribute('data-class') || '';
      
      const matchesSearch = name.includes(query) || phone.includes(query) || email.includes(query);
      const matchesClass = !classFilter || classification === classFilter;
      
      if (matchesSearch && matchesClass) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  }

  // 6. Modal Open & Close Lifecycle
  function openCrmDetailsModal(id) {
    const cust = crmCustomersData[id];
    if (!cust) return;
    
    // Header & profile block setup
    document.getElementById('modal_fullname').innerText = cust.fullname;
    document.getElementById('modal_phone').innerText = cust.phone;
    document.getElementById('modal_email').innerText = cust.email;
    document.getElementById('modal_created_at').innerText = cust.created_at;
    
    const followupLabel = document.getElementById('modal_followup_label');
    if (cust.next_followup_date) {
      const parts = cust.next_followup_date.split('-');
      followupLabel.innerText = `${parts[2]}/${parts[1]}/${parts[0]}`;
      followupLabel.style.color = '#ffb74d';
    } else {
      followupLabel.innerText = 'Chưa lên lịch hẹn';
      followupLabel.style.color = 'var(--color-text-muted)';
    }

    const badge = document.getElementById('modal_badge');
    badge.className = 'status-badge';
    badge.innerText = cust.classification;
    if (cust.classification === 'VIP') {
      badge.classList.add('status-badge--completed');
    } else if (cust.classification === 'Đã mua xe') {
      badge.classList.add('status-badge--success');
    } else if (cust.classification === 'Thành viên') {
      badge.classList.add('status-badge--contacting');
    } else {
      badge.classList.add('status-badge--pending');
    }
    
    // Communication links setup
    document.getElementById('modal_call_btn').href = 'tel:' + cust.phone;
    const cleanPhone = cust.phone.replace(/\D/g, '');
    document.getElementById('modal_zalo_btn').href = 'https://zalo.me/' + cleanPhone;
    
    const emailBtn = document.getElementById('modal_email_btn');
    if (cust.email && cust.email !== 'Chưa có email') {
      emailBtn.href = 'mailto:' + cust.email;
      emailBtn.style.opacity = '1';
      emailBtn.style.pointerEvents = 'auto';
    } else {
      emailBtn.href = '#';
      emailBtn.style.opacity = '0.4';
      emailBtn.style.pointerEvents = 'none';
    }
    
    // Car ownership dataset assembly
    const carsList = document.getElementById('modal_cars_list');
    if (!cust.cars || cust.cars.length === 0) {
      carsList.innerHTML = '<div style="color:var(--color-text-muted); font-size:12px; padding: 12px 0; text-align:center;">Chưa sở hữu dòng xe nào.</div>';
    } else {
      let html = '<table class="cms-table" style="font-size:12px;"><thead><tr><th>Dòng xe</th><th>Biển kiểm soát</th><th>Ngày bàn giao</th><th>Trị giá</th></tr></thead><tbody>';
      cust.cars.forEach(car => {
        const dateStr = car.purchase_date ? new Date(car.purchase_date).toLocaleDateString('vi-VN') : 'N/A';
        html += `<tr>
          <td><strong>${car.car_model}</strong></td>
          <td><span style="font-family:monospace; background:rgba(0,0,0,0.3); padding:2px 6px; border-radius:4px; border:1px solid var(--color-border); font-size:11px;">${car.license_plate || 'N/A'}</span></td>
          <td>${dateStr}</td>
          <td style="color:var(--color-primary); font-weight:600;">${car.price || 'N/A'}</td>
        </tr>`;
      });
      html += '</tbody></table>';
      carsList.innerHTML = html;
    }
    
    // Chronological Care Log layout timeline
    const logsTimeline = document.getElementById('modal_logs_timeline');
    if (!cust.logs || cust.logs.length === 0) {
      logsTimeline.innerHTML = '<div style="color:var(--color-text-muted); font-size:12px; padding: 12px 0; text-align:center;">Chưa ghi nhận hoạt động chăm sóc.</div>';
    } else {
      let html = '<div class="crm-timeline" style="margin-left: 10px;">';
      cust.logs.forEach(log => {
        const timeStr = log.care_date ? new Date(log.care_date).toLocaleString('vi-VN') : 'N/A';
        html += `<div class="crm-timeline-item">
          <div class="crm-timeline-date">${timeStr} - bởi <strong>${log.staff_name || 'Hệ thống'}</strong></div>
          <div class="crm-timeline-body">${log.notes.replace(/\n/g, '<br>')}</div>
        </div>`;
      });
      html += '</div>';
      logsTimeline.innerHTML = html;
    }
    
    // Show modal dialog
    const modal = document.getElementById('crm_details_modal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
  }

  function closeCrmDetailsModal() {
    document.getElementById('crm_details_modal').style.display = 'none';
    document.body.style.overflow = '';
  }

  // 7. Clear Follow-up date reminder via AJAX
  function clearReminder(id) {
    const row = document.getElementById('reminder-row-' + id);
    if (!row) return;
    
    const formData = new FormData();
    formData.append('action', 'clear_followup_ajax');
    formData.append('id', id);
    
    fetch('admin.php?p=crm', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        // Smooth slide & fade transition
        row.style.opacity = '0';
        row.style.transform = 'translateX(20px)';
        setTimeout(() => {
          row.remove();
          // Update data source locally
          if (crmCustomersData[id]) {
            crmCustomersData[id].next_followup_date = null;
          }
          // Reload window reminders section if empty
          const container = row.closest('.card');
          if (container && container.querySelectorAll('.crm-reminder-row').length === 0) {
            container.style.opacity = '0';
            setTimeout(() => container.remove(), 300);
          }
        }, 300);
      } else {
        alert('Lỗi: ' + (data.error || 'Không thể xử lý yêu cầu.'));
      }
    })
    .catch(err => {
      alert('Không thể kết nối đến máy chủ: ' + err.message);
    });
  }

  // 8. Advanced Client-side Excel Exporter (Downloads UTF-8 BOM CSV)
  function exportFilteredDataToCsv() {
    let tableId = '';
    let filename = '';
    
    if (activeMainTab === 'list') {
      tableId = 'crm_customers_table';
      filename = 'crm_danh_sach_khach_hang';
    } else if (activeMainTab === 'deliveries') {
      tableId = 'crm_deliveries_table';
      filename = 'crm_lich_su_ban_giao_xe';
    } else {
      alert('Chức năng xuất Excel chỉ hỗ trợ trên tab Danh sách khách hàng và Lịch sử bàn giao xe!');
      return;
    }
    
    const table = document.getElementById(tableId);
    if (!table) return;
    
    let csv = [];
    const rows = table.querySelectorAll("tr");
    
    for (let i = 0; i < rows.length; i++) {
      // Don't export filtered rows (hidden by search/category queries)
      if (rows[i].style.display === 'none') continue;
      
      let row = [];
      const cols = rows[i].querySelectorAll("td, th");
      
      // We skip the last column (which is the Action buttons column)
      const maxCol = activeMainTab === 'list' ? cols.length - 1 : cols.length;
      
      for (let j = 0; j < maxCol; j++) {
        let text = cols[j].innerText.trim();
        // Escape quotes
        text = text.replace(/"/g, '""');
        row.push('"' + text + '"');
      }
      csv.push(row.join(","));
    }
    
    // Add UTF-8 BOM prefix (\uFEFF) to make Excel display Vietnamese text correctly
    const csvContent = "\uFEFF" + csv.join("\n");
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement("a");
    link.setAttribute("href", url);
    link.setAttribute("download", filename + "_" + new Date().toISOString().slice(0, 10) + ".csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  }

  // Pre-load redirects & config
  document.addEventListener('DOMContentLoaded', () => {
    switchActionTab('customer');
  });
</script>





