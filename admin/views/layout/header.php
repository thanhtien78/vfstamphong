<?php
/**
 * Admin Panel Layout: Header
 * Contains the document declaration, SEO analyzers, Google fonts, and CSS styles.
 */
global $page, $currentUser, $basePath, $pseo_phone, $pseo_website;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VinFast CMS & CRM Portal - <?php echo htmlspecialchars(ucfirst($page)); ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    // Global CSRF injection for all AJAX fetch requests
    (function() {
      const originalFetch = window.fetch;
      window.fetch = function(input, init) {
        if (init && init.method && init.method.toUpperCase() === 'POST') {
          const token = '<?php echo $_SESSION['csrf_token'] ?? ''; ?>';
          if (init.body instanceof FormData) {
            if (!init.body.has('csrf_token')) {
              init.body.append('csrf_token', token);
            }
          } else if (typeof init.body === 'string') {
            try {
              const data = JSON.parse(init.body);
              if (typeof data === 'object' && data !== null && !data.csrf_token) {
                data.csrf_token = token;
                init.body = JSON.stringify(data);
              }
            } catch (e) {
              if (init.body.indexOf('csrf_token=') === -1) {
                init.body += (init.body ? '&' : '') + 'csrf_token=' + encodeURIComponent(token);
              }
            }
          } else if (!init.body) {
            const data = new FormData();
            data.append('csrf_token', token);
            init.body = data;
          }
        }
        return originalFetch(input, init);
      };
    })();

    document.addEventListener("DOMContentLoaded", () => {
      if (document.getElementById('post_content')) {
        tinymce.init({
          selector: '#post_content',
          height: 400,
          plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
          toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table | removeformat code fullscreen',
          skin: 'oxide-dark',
          content_css: 'dark',
          content_style: 'body { font-family:Montserrat,sans-serif; color:#fff; } a { color: #38bdf8 !important; text-decoration: underline !important; } a:hover { color: #fff !important; }',
          branding: false,
          promotion: false,
          images_upload_url: '<?php echo $basePath; ?>/admin/admin.php?upload_tinymce_image=1',
          automatic_uploads: true,
          setup: function (editor) {
              editor.on('change', function () {
                  editor.save();
                  if (typeof window.updateSeoAnalysis === "function") {
                      window.updateSeoAnalysis();
                  }
              });
              editor.on('keyup', function () {
                  editor.save();
                  if (typeof window.updateSeoAnalysis === "function") {
                      window.updateSeoAnalysis();
                  }
              });
          }
        });
      }
      if (document.getElementById('pricelist_editorial')) {
        tinymce.init({
          selector: '#pricelist_editorial',
          height: 500,
          plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
          toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table | removeformat code fullscreen',
          skin: 'oxide-dark',
          content_css: 'dark',
          content_style: 'body { font-family:Montserrat,sans-serif; color:#fff; } a { color: #38bdf8 !important; text-decoration: underline !important; } a:hover { color: #fff !important; }',
          branding: false,
          promotion: false,
          images_upload_url: '<?php echo $basePath; ?>/admin/admin.php?upload_tinymce_image=1',
          automatic_uploads: true,
          setup: function (editor) {
              editor.on('change', function () {
                  editor.save();
              });
              editor.on('keyup', function () {
                  editor.save();
              });
          }
        });
      }
      if (document.getElementById('pseo_content_price')) {
        tinymce.init({
          selector: '#pseo_content_price, #pseo_content_dealer, #pseo_content_project',
          height: 380,
          plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
          toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table | removeformat code fullscreen',
          skin: 'oxide-dark',
          content_css: 'dark',
          content_style: 'body { font-family:Montserrat,sans-serif; color:#fff; } a { color: #38bdf8 !important; text-decoration: underline !important; } a:hover { color: #fff !important; }',
          branding: false,
          promotion: false,
          images_upload_url: '<?php echo $basePath; ?>/admin/admin.php?upload_tinymce_image=1',
          automatic_uploads: true,
          setup: function (editor) {
              editor.on('change', function () {
                  editor.save();
              });
              editor.on('keyup', function () {
                  editor.save();
              });
          }
        });
      }

      // Real-time On-Page SEO Live Analyzer Logic
      window.updateSeoAnalysis = function () {
        const titleInput = document.getElementById("post_title");
        const summaryInput = document.getElementById("post_summary");
        const keywordInput = document.getElementById("post_focus_keyword");
        const contentArea = document.getElementById("post_content");

        if (!titleInput || !summaryInput || !keywordInput || !contentArea) return;

        const keyword = keywordInput.value.trim().toLowerCase();
        const title = titleInput.value.trim();
        const summary = summaryInput.value.trim();
        
        // Grab TinyMCE content safely, fall back to textarea
        let content = "";
        if (typeof tinymce !== "undefined" && tinymce.get("post_content")) {
          content = tinymce.get("post_content").getContent();
        } else {
          content = contentArea.value;
        }

        // Clean content tags to calculate exact words
        const cleanContent = content.replace(/<\/?[^>]+(>|$)/g, " ");
        const words = cleanContent.trim().split(/\s+/).filter(w => w.length > 0);
        const wordCount = words.length;

        let score = 0;
        let checksPassed = 0;

        // Check helper function
        function updateCheck(elementId, passed, scoreValue) {
          const li = document.getElementById(elementId);
          if (!li) return;
          const icon = li.querySelector(".seo-icon");
          if (passed) {
            icon.innerText = "✅";
            icon.style.color = "#28a745";
            li.style.color = "var(--color-text-white)";
            score += scoreValue;
            checksPassed++;
          } else {
            icon.innerText = "❌";
            icon.style.color = "#dc3545";
            li.style.color = "var(--color-text-muted)";
          }
        }

        // 1. Tiêu đề chứa từ khóa chính
        const titlePassed = keyword !== "" && title.toLowerCase().includes(keyword);
        updateCheck("seo-check-title-keyword", titlePassed, 15);

        // 2. Độ dài tiêu đề chuẩn SEO (40 - 65 ký tự)
        const titleLengthPassed = title.length >= 40 && title.length <= 65;
        updateCheck("seo-check-title-length", titleLengthPassed, 10);

        // 3. Tóm tắt ngắn chứa từ khóa chính
        const summaryPassed = keyword !== "" && summary.toLowerCase().includes(keyword);
        updateCheck("seo-check-summary-keyword", summaryPassed, 15);

        // 4. Độ dài tóm tắt chuẩn SEO (110 - 160 ký tự)
        const summaryLengthPassed = summary.length >= 110 && summary.length <= 160;
        updateCheck("seo-check-summary-length", summaryLengthPassed, 10);

        // 5. Từ khóa chính xuất hiện trong 100 từ đầu tiên
        const sapoText = words.slice(0, 100).join(" ").toLowerCase();
        const first100Passed = keyword !== "" && sapoText.includes(keyword);
        updateCheck("seo-check-first-100", first100Passed, 15);

        // 6. Độ dài bài viết tối thiểu 500 từ
        const wordCountPassed = wordCount >= 500;
        updateCheck("seo-check-word-count", wordCountPassed, 15);

        // 7. Mật độ từ khóa đạt chuẩn (0.5% - 2.5%)
        let densityPassed = false;
        if (keyword !== "" && wordCount > 0) {
          // Count occurrences of keyword in clean content safely
          const escapedKeyword = keyword.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
          const regex = new RegExp(escapedKeyword, "gi");
          const matches = cleanContent.match(regex);
          const count = matches ? matches.length : 0;
          const density = (count / wordCount) * 100;
          densityPassed = density >= 0.5 && density <= 2.5;
        }
        updateCheck("seo-check-density", densityPassed, 10);

        // 8. Chứa ít nhất một tiêu đề con (H2, H3, H4)
        const headingsPassed = /<(h2|h3|h4)\b/i.test(content);
        updateCheck("seo-check-headings", headingsPassed, 10);

        // Render Score Badge & Bar
        const badge = document.getElementById("seo-score-badge");
        const bar = document.getElementById("seo-score-bar");
        if (badge && bar) {
          badge.innerText = score + "/100";
          bar.style.width = score + "%";
          
          if (score < 40) {
            badge.style.background = "#dc3545"; // Red
            bar.style.background = "#dc3545";
          } else if (score < 75) {
            badge.style.background = "#fd7e14"; // Orange
            bar.style.background = "#fd7e14";
          } else {
            badge.style.background = "var(--color-primary)"; // Gold
            bar.style.background = "var(--color-primary)";
          }
        }
      };

      // Register listeners for real-time text input tracking
      const titleInput = document.getElementById("post_title");
      const summaryInput = document.getElementById("post_summary");
      const keywordInput = document.getElementById("post_focus_keyword");

      if (titleInput) titleInput.addEventListener("input", window.updateSeoAnalysis);
      if (summaryInput) summaryInput.addEventListener("input", window.updateSeoAnalysis);
      if (keywordInput) keywordInput.addEventListener("input", window.updateSeoAnalysis);

      // Run initial analysis after short timeout to let TinyMCE load
      setTimeout(() => {
        if (typeof window.updateSeoAnalysis === "function") {
          window.updateSeoAnalysis();
        }
      }, 1500);
    });
  </script>
  <link rel="icon" type="image/x-icon" href="<?php echo $basePath; ?>/assets/favicon/favicon.ico">
  <style>
    /* Google Fonts & Premium Automotive Typography */
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700;800&display=swap");

    @font-face {
      font-family: 'VinFastType';
      src: url('<?php echo $basePath; ?>/assets/fonts/VinFastTypeVF.woff2') format('woff2-variations');
      font-display: swap;
      font-style: normal;
      font-stretch: 100% 130%;
    }

    :root {
      --color-surface-dark: #0f172a;       /* Deep Slate Blue-Gray */
      --color-bg-sidebar: #0b0f19;         /* Dark Navy-Slate */
      --color-bg-card: #1e293b;            /* Softer Slate Card */
      --color-bg-input: #0f172a;           /* Input matches surface */
      --color-text-white: #f8fafc;         /* Off-white (Slate 50) */
      --color-text-muted: #94a3b8;         /* Soft Gray-Blue (Slate 400) */
      --color-border: #334155;             /* Border line (Slate 700) */
      --color-border-active: #475569;      /* Border line active (Slate 600) */
      --color-primary: #38bdf8;            /* Futuristic Sky Blue/Cyan */
      --color-primary-glow: rgba(56, 189, 248, 0.18);
      --transition-speed: 200ms;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    /* Core Unified Typography System */
    body {
      font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, sans-serif;
      background-color: var(--color-surface-dark);
      color: var(--color-text-white);
      min-height: 100vh;
      display: grid;
      grid-template-columns: 260px 1fr;
    }

    h1, h2, h3, h4, h5, h6,
    .sidebar__logo-title, .sidebar__item-link,
    .topbar__title, .card__title, .btn, button, input[type="submit"],
    .dashboard-stat__value, .dashboard-stat__title, .form-group label {
      font-family: 'Montserrat', sans-serif !important;
      letter-spacing: 0.5px;
      font-weight: 700 !important;
    }

    /* LEFT SIDEBAR NAVIGATION */
    .sidebar {
      background: var(--color-bg-sidebar);
      border-right: 1px solid var(--color-border);
      padding: 32px 16px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      height: 100vh;
      position: sticky;
      top: 0;
    }

    .sidebar__top {
      display: flex;
      flex-direction: column;
      gap: 36px;
    }

    .sidebar__logo {
      display: flex;
      align-items: center;
      gap: 12px;
      color: var(--color-text-white);
      text-decoration: none;
      padding: 0 12px;
    }

    .sidebar__logo-title {
      font-size: 18px;
      font-weight: 500;
      letter-spacing: 1px;
      font-stretch: 110%;
      color: var(--color-primary);
    }

    .sidebar__menu {
      display: flex;
      flex-direction: column;
      gap: 6px;
      list-style: none;
    }

    .sidebar__item-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 13px 16px;
      color: var(--color-text-muted);
      text-decoration: none;
      font-size: 13px;
      font-weight: 500;
      border-radius: 8px;
      transition: all var(--transition-speed);
    }

    .sidebar__item-link i {
      width: 20px;
      text-align: center;
      font-size: 15px;
      transition: color var(--transition-speed);
    }

    .sidebar__item-link:hover {
      background: var(--color-bg-card);
      color: var(--color-text-white);
    }

    .sidebar__item-link--active {
      background: var(--color-bg-card);
      color: var(--color-primary);
      border-left: 3px solid var(--color-primary);
      border-radius: 0 8px 8px 0;
      font-weight: 600;
    }

    .sidebar__footer {
      display: flex;
      flex-direction: column;
      gap: 12px;
      padding: 16px 12px;
      border-top: 1px solid var(--color-border);
    }

    .sidebar__user-name {
      font-size: 13px;
      font-weight: 600;
      color: var(--color-text-white);
    }

    .sidebar__user-role {
      font-size: 10px;
      color: var(--color-primary);
      letter-spacing: 0.5px;
      text-transform: uppercase;
      margin-top: 2px;
    }

    .sidebar__logout {
      font-size: 12px;
      color: #ef5350;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 8px;
      margin-top: 6px;
      transition: color 0.2s;
    }

    .sidebar__logout:hover {
      color: #ff8a80;
    }

    /* RIGHT CONTENT PANEL */
    .content-area {
      padding: 40px;
      overflow-y: auto;
      background-image: radial-gradient(circle at top right, rgba(56, 189, 248, 0.03), transparent 600px);
    }

    .header-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid var(--color-border);
      padding-bottom: 20px;
      margin-bottom: 30px;
    }

    .header-bar__title {
      font-size: 26px;
      font-weight: 400;
      font-stretch: 105%;
    }

    /* Premium Alert Banners */
    .alert-banner {
      padding: 14px 20px;
      border-radius: 8px;
      font-size: 13px;
      font-weight: 500;
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .alert-banner--success {
      background: rgba(46, 125, 50, 0.1);
      border: 1px solid rgba(46, 125, 50, 0.3);
      color: #a5d6a7;
    }

    .alert-banner--error {
      background: rgba(239, 83, 80, 0.1);
      border: 1px solid rgba(239, 83, 80, 0.3);
      color: #ff8a80;
    }

    /* Cards */
    .card {
      background: var(--color-bg-card);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid var(--color-border);
      border-radius: 14px;
      padding: 28px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.35);
      display: flex;
      flex-direction: column;
      gap: 20px;
      margin-bottom: 30px;
    }

    .card__title-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .card__title {
      font-size: 15px;
      font-weight: 600;
      color: var(--color-primary);
      letter-spacing: 0.5px;
      text-transform: uppercase;
      border-left: 3px solid var(--color-primary);
      padding-left: 10px;
    }

    /* Forms */
    .form-group {
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .form-label {
      font-size: 10px;
      font-weight: 600;
      color: var(--color-text-muted);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .form-input {
      background: var(--color-bg-input);
      border: 1px solid var(--color-border);
      color: var(--color-text-white);
      padding: 12px 14px;
      border-radius: 6px;
      font-size: 13px;
      font-family: inherit;
      transition: all var(--transition-speed);
      width: 100%;
      box-sizing: border-box;
    }

    input.form-input[style*="height"] {
      padding-top: 0 !important;
      padding-bottom: 0 !important;
    }

    .form-input:focus {
      outline: none;
      border-color: var(--color-primary);
      box-shadow: 0 0 8px rgba(56, 189, 248, 0.15);
    }

    textarea.form-input {
      resize: vertical;
      min-height: 100px;
      line-height: 1.5;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    .form-row--triple {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 15px;
    }

    /* Premium Interactive Image Manager */
    .image-preview-container {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      margin-top: 10px;
      background: rgba(255, 255, 255, 0.02);
      border: 1px dashed var(--color-border);
      border-radius: 8px;
      padding: 12px;
      min-height: 50px;
    }
    .image-preview-item {
      position: relative;
      width: 80px;
      height: 60px;
      border-radius: 6px;
      overflow: hidden;
      border: 1px solid var(--color-border);
      background: #000;
      transition: all 0.2s ease;
    }
    .image-preview-item:hover {
      border-color: var(--color-primary);
      transform: translateY(-2px);
    }
    .image-preview-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .image-preview-item .remove-btn {
      position: absolute;
      top: 2px;
      right: 2px;
      background: rgba(220, 53, 69, 0.85);
      color: #fff;
      border: none;
      width: 18px;
      height: 18px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 10px;
      cursor: pointer;
      line-height: 1;
      padding: 0;
      transition: background var(--transition-speed);
      z-index: 10;
    }
    .image-preview-item .remove-btn:hover {
      background: rgb(220, 53, 69);
    }

    /* Tables */
    .table-container {
      width: 100%;
      overflow-x: auto;
      border-radius: 8px;
      border: 1px solid var(--color-border);
      background: rgba(0, 0, 0, 0.1);
    }

    .cms-table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
    }

    .cms-table th {
      font-size: 10px;
      font-weight: 600;
      text-transform: uppercase;
      color: var(--color-text-muted);
      padding: 14px 16px;
      border-bottom: 1px solid var(--color-border);
      background: rgba(0, 0, 0, 0.2);
      letter-spacing: 0.5px;
    }

    .cms-table td {
      font-size: 13px;
      padding: 16px;
      border-bottom: 1px solid var(--color-border);
      color: var(--color-text-white);
      vertical-align: middle;
    }

    .cms-table tr:hover td {
      background: rgba(255, 255, 255, 0.015);
    }

    /* Buttons */
    .btn-gold {
      background: rgba(18, 24, 38, 0.9);
      border: 1px solid var(--color-primary);
      color: var(--color-primary);
      padding: 11px 20px;
      border-radius: 6px;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: 0.5px;
      cursor: pointer;
      text-transform: uppercase;
      transition: all var(--transition-speed);
      box-shadow: 0 0 8px var(--color-primary-glow);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      font-family: inherit;
      text-decoration: none;
    }

    .btn-gold:hover {
      background: var(--color-primary);
      color: #000;
      box-shadow: 0 0 15px rgba(56, 189, 248, 0.35);
    }

    .btn-danger {
      background: none;
      border: none;
      color: #ef5350;
      cursor: pointer;
      font-size: 12px;
      font-weight: 600;
      transition: color 0.2s;
    }

    .btn-danger:hover {
      color: #ff8a80;
    }

    /* Stats Grid */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .stat-box {
      background: var(--color-bg-card);
      border: 1px solid var(--color-border);
      border-radius: 12px;
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .stat-box__title {
      font-size: 10px;
      font-weight: 600;
      color: var(--color-text-muted);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .stat-box__value {
      font-size: 26px;
      font-weight: 300;
      color: var(--color-primary);
    }

    /* Badges */
    .status-badge {
      display: inline-flex;
      align-items: center;
      padding: 4px 10px;
      border-radius: 12px;
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.3px;
    }

    .status-badge--pending { background: rgba(158, 158, 158, 0.15); border: 1px solid #9e9e9e; color: #bdbdbd; }
    .status-badge--contacting { background: rgba(255, 193, 7, 0.15); border: 1px solid #ffc107; color: #ffe082; }
    .status-badge--completed { background: rgba(76, 175, 80, 0.15); border: 1px solid #4caf50; color: #a5d6a7; }
    .status-badge--success { background: rgba(0, 150, 255, 0.15); border: 1px solid #0096ff; color: #33b3ff; }
    .status-badge--failed { background: rgba(239, 83, 80, 0.15); border: 1px solid #ef5350; color: #ff8a80; }

    /* Submenu Layout Split */
    .layout-split {
      display: grid;
      grid-template-columns: 1fr;
      gap: 30px;
    }

    @media (min-width: 1200px) {
      .layout-split--wide-left {
        grid-template-columns: 1.3fr 0.7fr;
      }
    }

    /* Pulsing Green Circle for active status */
    .pulse-dot {
      display: inline-block;
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: #4caf50;
      box-shadow: 0 0 0 0 rgba(76, 175, 80, 0.7);
      animation: pulse 1.6s infinite;
      margin-right: 6px;
    }

    .pulse-dot--red {
      background: #f44336;
      box-shadow: 0 0 0 0 rgba(244, 67, 54, 0.7);
    }

    @keyframes pulse {
      0% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(76, 175, 80, 0.7);
      }
      70% {
        transform: scale(1);
        box-shadow: 0 0 0 6px rgba(76, 175, 80, 0);
      }
      100% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(76, 175, 80, 0);
      }
    }

    /* Modal Form / Popups simulation inline */
    .inline-action-card {
      border: 1px solid rgba(56, 189, 248, 0.15);
      background-image: linear-gradient(135deg, rgba(56, 189, 248, 0.01), rgba(0,0,0,0));
    }
  </style>
</head>
<body>
