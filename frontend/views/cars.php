<!-- DYNAMIC JSON-LD ITEMLIST SCHEMA FOR 2026 SEO ADVANTAGES -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "name": "Danh mục các dòng xe VinFast chính hãng",
  "description": "Khám phá danh sách các mẫu xe sang VinFast chính hãng: EV thuần điện, SUV VF 3, VF 5, VF 6, VF 7, VF 8, VF 9 và Green đẳng cấp.",
  "url": "<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>",
  "numberOfItems": <?php echo count($cars); ?>,
  "itemListElement": [
    <?php foreach ($cars as $index => $c): ?>
    {
      "@type": "ListItem",
      "position": <?php echo $index + 1; ?>,
      "url": "<?php echo $baseUrl; ?>/xe-vinfast/<?php echo $c['slug']; ?>",
      "name": "<?php echo htmlspecialchars($c['model_name']); ?>"
    }<?php echo ($index < count($cars) - 1) ? ',' : ''; ?>
    <?php endforeach; ?>
  ]
}
</script>

<style>
/* Immersive Scroll Snapping Design for Cars Page */
html, body {
  margin: 0;
  padding: 0;
  height: 100vh !important;
  overflow: hidden !important;
}

/* Snap Scroll Wrapper */
.snap-scroll-wrapper {
  height: 100vh;
  overflow-y: scroll;
  scroll-snap-type: y mandatory;
  scroll-behavior: smooth;
  position: relative;
}

/* Snap Section */
.snap-section {
  height: 100vh;
  width: 100%;
  scroll-snap-align: start;
  position: relative;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 20px;
  padding: 60px 24px 80px 24px;
  background: radial-gradient(circle at center, #ffffff 40%, #f1f5f9 100%);
  box-sizing: border-box;
}

/* Giant background watermark */
.slide-watermark {
  position: absolute;
  top: 45%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-family: 'Outfit', sans-serif !important;
  font-size: 15vw;
  font-weight: 900;
  color: rgba(20, 100, 244, 0.035);
  white-space: nowrap;
  pointer-events: none;
  z-index: 1;
  text-transform: uppercase;
  letter-spacing: 5px;
}

/* Section Header content */
.slide-header {
  text-align: center;
  z-index: 2;
  margin-top: 10px;
}

.slide-tag {
  font-size: 11px;
  font-weight: 800;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: #1464f4;
  margin-bottom: 6px;
  display: block;
}

.slide-title {
  font-size: 40px !important;
  font-weight: 900 !important;
  color: #0f172a;
  margin: 0;
  letter-spacing: 1px;
  text-transform: uppercase;
}

.slide-desc {
  font-size: 14px;
  color: #64748b;
  margin: 8px auto 0;
  max-width: 600px;
  line-height: 1.6;
}

/* Centered Car Media */
.slide-media {
  position: relative;
  width: 100%;
  max-width: 750px;
  height: 38vh;
  flex: 1;
  min-height: 150px;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 2;
  margin: 5px 0;
}

.slide-car-img {
  max-height: 100%;
  max-width: 100%;
  object-fit: contain;
  filter: drop-shadow(0 20px 30px rgba(15, 23, 42, 0.12));
  transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
  animation: carFloat 6s ease-in-out infinite alternate;
}

@keyframes carFloat {
  0% { transform: translateY(0px) rotate(0deg); }
  100% { transform: translateY(-10px) rotate(0.5deg); }
}

/* Active Color Swatches on Slide */
.slide-colors {
  display: flex;
  gap: 12px;
  justify-content: center;
  margin-bottom: 12px;
  z-index: 2;
}

.slide-color-dot {
  width: 16px;
  height: 16px;
  border-radius: 50%;
  border: 2px solid #ffffff;
  box-shadow: 0 0 0 1px #cbd5e1;
  cursor: pointer;
  transition: all 0.3s;
}

.slide-color-dot.active {
  box-shadow: 0 0 0 2px #1464f4;
  transform: scale(1.2);
}

/* Footer specifications */
.slide-footer {
  width: 100%;
  max-width: 900px;
  z-index: 2;
  text-align: center;
}

.slide-specs-row {
  display: flex;
  justify-content: center;
  gap: 40px;
  margin-bottom: 12px;
}

.slide-spec-item {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.slide-spec-val {
  font-size: 20px;
  font-weight: 800;
  color: #0f172a;
}

.slide-spec-lbl {
  font-size: 11px;
  color: #64748b;
  text-transform: uppercase;
  margin-top: 4px;
  letter-spacing: 1px;
}

/* Slide Action Buttons */
.slide-actions {
  display: flex;
  justify-content: center;
  gap: 15px;
}

.btn-slide-primary {
  background: #1464f4;
  color: #ffffff;
  font-size: 13px;
  font-weight: 700;
  text-transform: uppercase;
  padding: 12px 28px;
  border-radius: 30px;
  border: none;
  cursor: pointer;
  text-decoration: none;
  box-shadow: 0 4px 15px rgba(20, 100, 244, 0.3);
  transition: all 0.3s;
}

.btn-slide-primary:hover {
  background: #004ecc;
  box-shadow: 0 6px 20px rgba(20, 100, 244, 0.45);
  transform: translateY(-2px);
}

.btn-slide-outline {
  background: rgba(255, 255, 255, 0.8);
  border: 1px solid #cbd5e1;
  color: #1e293b;
  font-size: 13px;
  font-weight: 700;
  text-transform: uppercase;
  padding: 12px 24px;
  border-radius: 30px;
  cursor: pointer;
  text-decoration: none;
  transition: all 0.3s;
}

.btn-slide-outline:hover {
  background: #ffffff;
  border-color: #1464f4;
  color: #1464f4;
  transform: translateY(-2px);
}

.btn-slide-zalo {
  background: #0084ff;
  color: #ffffff;
  font-size: 13px;
  font-weight: 700;
  text-transform: uppercase;
  padding: 12px 24px;
  border-radius: 30px;
  border: none;
  cursor: pointer;
  text-decoration: none;
  transition: all 0.3s;
}

.btn-slide-zalo:hover {
  background: #0066cc;
  transform: translateY(-2px);
}

/* Floating Bottom Control Dock */
.floating-bottom-dock {
  position: fixed;
  bottom: 24px;
  left: 50%;
  transform: translateX(-50%);
  background: rgba(255, 255, 255, 0.9);
  border: 1px solid rgba(20, 100, 244, 0.12);
  padding: 6px 12px;
  border-radius: 40px;
  display: flex;
  gap: 4px;
  align-items: center;
  z-index: 999;
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
}

.dock-item {
  color: #475569;
  text-decoration: none;
  font-size: 11px;
  font-weight: 800;
  padding: 8px 14px;
  border-radius: 20px;
  transition: all 0.3s;
  white-space: nowrap;
  text-transform: uppercase;
}

.dock-item:hover {
  color: #1464f4;
  background: rgba(20, 100, 244, 0.04);
}

.dock-item.active {
  color: #ffffff !important;
  background: #1464f4 !important;
  box-shadow: 0 4px 12px rgba(20, 100, 244, 0.3);
}

/* Hide navigation buttons default styles or adjust them inside slides */
.snap-section .ev-calculator-section,
.snap-section .VinFast-legacy-section,
.snap-section .vip-booking-section,
.snap-section .faq-section-official,
.snap-section .seo-cars-article {
  width: 100%;
  height: auto;
  max-height: 75vh;
  overflow-y: auto;
  padding: 10px !important;
  margin: auto !important;
  background: transparent !important;
  border: none !important;
}

/* Custom Scrollbar for snapping wrapper */
.snap-scroll-wrapper::-webkit-scrollbar {
  width: 6px;
}
.snap-scroll-wrapper::-webkit-scrollbar-track {
  background: transparent;
}
.snap-scroll-wrapper::-webkit-scrollbar-thumb {
  background: rgba(0, 0, 0, 0.1);
  border-radius: 10px;
}

/* Cockpit styling */
.cockpit-tab-btn {
  border: 1.5px solid #e2e8f0;
  background: #ffffff;
  border-radius: 14px;
  transition: all 0.3s;
}
.cockpit-tab-btn.active {
  border-color: #1464f4 !important;
  box-shadow: 0 8px 24px rgba(20, 100, 244, 0.06) !important;
  background: rgba(20, 100, 244, 0.01) !important;
}
.cockpit-tab-btn.active .cockpit-tab-num {
  color: #1464f4 !important;
}
.cockpit-tab-btn:hover {
  border-color: #cbd5e1;
}

/* Visual Car Picker (Booking form) */
.visual-car-picker::-webkit-scrollbar {
  height: 4px;
}
.visual-car-picker::-webkit-scrollbar-track {
  background: #f1f5f9;
}
.visual-car-picker::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 10px;
}

.car-picker-item {
  transition: all 0.3s;
}
.car-picker-item.active {
  border-color: #1464f4 !important;
  background: rgba(20, 100, 244, 0.02) !important;
  box-shadow: 0 4px 12px rgba(20, 100, 244, 0.15) !important;
}

/* Dynamic Color Selector Info style */
.selected-color-label {
  font-family: 'Outfit', sans-serif !important;
  font-size: 11px;
  font-weight: 800;
  color: #64748b;
  text-transform: uppercase;
  margin-top: -6px;
  margin-bottom: 8px;
  letter-spacing: 0.5px;
  z-index: 2;
  transition: color 0.3s;
}

/* Quick Comparison Tool floating bar */
.floating-compare-bar {
  position: fixed;
  bottom: 90px;
  right: 24px;
  background: rgba(15, 23, 42, 0.92);
  border: 1px solid rgba(255, 255, 255, 0.12);
  border-radius: 40px;
  padding: 8px 18px;
  display: none;
  align-items: center;
  gap: 15px;
  z-index: 999;
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  color: #ffffff;
  transition: all 0.3s;
}
.floating-compare-bar span {
  font-family: 'Outfit', sans-serif !important;
}

/* Comparison side-by-side modal overlay */
.compare-modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(15, 23, 42, 0.5);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  display: none;
  justify-content: center;
  align-items: center;
  z-index: 9999;
  padding: 16px;
  box-sizing: border-box;
}
.compare-modal-overlay.active {
  display: flex;
}
.compare-modal-box {
  background: #ffffff;
  width: 100%;
  max-width: 950px;
  max-height: 85vh;
  border-radius: 20px;
  padding: 24px;
  box-shadow: 0 20px 50px rgba(15, 23, 42, 0.3);
  position: relative;
  display: flex;
  flex-direction: column;
  box-sizing: border-box;
  animation: modalSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes modalSlideUp {
  from { transform: translateY(30px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}
.compare-modal-close {
  position: absolute;
  top: 15px;
  right: 20px;
  font-size: 28px;
  font-weight: bold;
  color: #64748b;
  cursor: pointer;
  transition: color 0.2s;
  z-index: 10;
}
.compare-modal-close:hover {
  color: #1e293b;
}

/* Table comparison formatting */
.compare-table-wrapper {
  overflow-x: auto;
  margin-top: 15px;
  flex: 1;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  background: #ffffff;
}
.compare-table {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
}
.compare-table th, .compare-table td {
  padding: 12px 16px;
  border-bottom: 1px solid #e2e8f0;
  border-right: 1px solid #e2e8f0;
  min-width: 180px;
  font-size: 13.5px;
  vertical-align: middle;
}
.compare-table tr:last-child td {
  border-bottom: none;
}
.compare-table td:first-child, .compare-table th:first-child {
  position: sticky;
  left: 0;
  background: #f8fafc;
  font-weight: 800;
  color: #1e293b;
  min-width: 130px;
  max-width: 140px;
  z-index: 10;
  border-right: 2px solid #cbd5e1;
}

/* Pulsing Gold swipe badge */
.compare-swipe-badge {
  display: inline-block;
  padding: 6px 16px;
  font-size: 11px;
  font-weight: 800;
  color: #ffd700 !important;
  background: rgba(15, 23, 42, 0.85);
  border: 1.5px solid #ffd700;
  border-radius: 20px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  animation: goldPulse 1.8s infinite ease-in-out;
  box-shadow: 0 4px 10px rgba(255, 215, 0, 0.25);
  font-family: 'Outfit', sans-serif !important;
}
@keyframes goldPulse {
  0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 215, 0, 0.4); }
  70% { transform: scale(1.04); box-shadow: 0 0 0 8px rgba(255, 215, 0, 0); }
  100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 215, 0, 0); }
}

/* Responsive fixes */
@media (max-width: 991px) {
  .slide-specs-row { gap: 20px; flex-wrap: wrap; justify-content: center; }
  .slide-media { height: 30vh; }
  .snap-section { padding: 90px 16px 70px 16px; }
  .floating-bottom-dock {
    width: 92%;
    overflow-x: auto;
    bottom: 12px;
    padding: 6px;
    justify-content: flex-start;
  }
}
@media (max-width: 767px) {
  .floating-bottom-dock {
    display: none !important; /* Hide to avoid overlapping with native theme sticky footer */
  }
  .floating-compare-bar {
    bottom: 80px !important;
    left: 12px !important;
    right: 12px !important;
    width: auto !important;
    justify-content: space-between !important;
  }
  .snap-section {
    padding: 70px 12px 125px 12px !important;
  }
  .slide-media {
    height: auto !important;
    max-height: 25vh !important;
    min-height: 100px !important;
    margin: 5px 0 !important;
  }
  .slide-title {
    font-size: 24px !important;
  }
  .slide-desc {
    font-size: 12px !important;
    margin-top: 4px !important;
    line-height: 1.4 !important;
    max-width: 90% !important;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  .slide-colors {
    margin-bottom: 12px !important;
    gap: 8px !important;
  }
  .slide-color-dot {
    width: 14px !important;
    height: 14px !important;
  }
  .slide-specs-row {
    gap: 12px !important;
    margin-bottom: 12px !important;
  }
  .slide-spec-val {
    font-size: 14px !important;
  }
  .slide-spec-lbl {
    font-size: 9px !important;
    margin-top: 2px !important;
  }
  .slide-actions {
    flex-direction: row !important;
    flex-wrap: wrap;
    justify-content: center;
    gap: 8px !important;
    max-width: 320px;
    margin: 0 auto;
  }
  .btn-slide-primary, .btn-slide-outline, .btn-slide-zalo {
    padding: 8px 14px !important;
    font-size: 11px !important;
    flex: 1 1 45%; /* 2x2 grid */
    text-align: center;
    box-sizing: border-box;
  }
}
@media (max-width: 480px) {
  .floating-compare-bar {
    bottom: 72px !important;
    padding: 6px 12px !important;
  }
  .snap-section {
    padding: 60px 10px 115px 10px !important;
  }
  .slide-media {
    max-height: 20vh !important;
    min-height: 80px !important;
  }
  .slide-title {
    font-size: 22px !important;
  }
  .slide-desc {
    display: none !important; /* Hide description on tiny viewports to avoid cutoff */
  }
}

body.page-cars footer,
body.page-cars .premium-footer {
  scroll-snap-align: end !important;
  background: #0f172a !important;
  border-top: 1px solid rgba(255, 255, 255, 0.05) !important;
  padding: 60px 24px !important;
  color: #94a3b8 !important;
}

body.page-cars .vf-infotainment-mock {
  background: #ffffff !important;
  border-color: #f1f5f9 !important;
}
body.page-cars .cockpit-screen-wrap {
  background: #ffffff !important;
}
body.page-cars .cockpit-slide {
  background: #ffffff !important;
  color: #1e293b !important;
}
body.page-cars .cockpit-display {
  background: #ffffff !important;
  border-color: #cbd5e1 !important;
}
</style>

<div class="snap-scroll-wrapper">
  
  <!-- CAR LINEUP IMMERSIVE SLIDES -->
  <?php foreach ($cars as $index => $car): ?>
    <?php
      $segmentLower = mb_strtolower($car['segment'] ?? '');
      $nameLower = mb_strtolower($car['model_name'] ?? '');
      
      $seats = '5 chỗ';
      $bodyType = 'SUV';

      if (str_contains($segmentLower, 'dịch vụ') || str_contains($nameLower, 'green') || str_contains($nameLower, 'van')) {
          if (str_contains($nameLower, 'van')) { $bodyType = 'VAN'; $seats = '2 chỗ'; }
          elseif (str_contains($nameLower, 'limo')) { $bodyType = 'MPV'; $seats = '7 chỗ'; }
          elseif (str_contains($nameLower, 'minio')) { $bodyType = 'MINI'; $seats = '4 chỗ'; }
      } elseif (str_contains($segmentLower, 'cỡ e') || str_contains($segmentLower, 'cao cấp') || str_contains($nameLower, 'vf 9') || str_contains($nameLower, 'vf 8 the all new')) {
          if (str_contains($nameLower, 'vf 9')) { $seats = '7 chỗ'; }
      } elseif (str_contains($segmentLower, 'cỡ b') || str_contains($segmentLower, 'cỡ c') || str_contains($segmentLower, 'cỡ d') || str_contains($segmentLower, 'mpv') || str_contains($nameLower, 'vf 6') || str_contains($nameLower, 'vf 7') || str_contains($nameLower, 'vf 8')) {
          if (str_contains($nameLower, 'mpv')) { $bodyType = 'MPV'; $seats = '7 chỗ'; }
      } elseif (str_contains($segmentLower, 'cỡ a') || str_contains($segmentLower, 'mini') || str_contains($nameLower, 'vf 2') || str_contains($nameLower, 'vf 3') || str_contains($nameLower, 'vf 5')) {
          if (str_contains($nameLower, 'vf 2') || str_contains($nameLower, 'vf 3')) { $bodyType = 'MINI'; $seats = '4 chỗ'; }
      }

      $watermarkText = preg_replace('/^VinFast\s+/i', '', $car['model_name']);
      $rawPrice = $car['price'] ?? '';
      $priceParts = explode('/', $rawPrice);
      $displayPrice = trim($priceParts[0]);
    ?>
    <section class="snap-section car-slide" id="model-<?php echo $car['id']; ?>" data-name="<?php echo htmlspecialchars($car['model_name']); ?>">
      <!-- Giant background watermark -->
      <div class="slide-watermark"><?php echo htmlspecialchars($watermarkText); ?></div>
      
      <!-- Slide Header -->
      <div class="slide-header">
        <span class="slide-tag"><?php echo htmlspecialchars($car['segment']); ?></span>
        <h2 class="slide-title"><?php echo htmlspecialchars($car['model_name']); ?></h2>
        <p class="slide-desc"><?php echo htmlspecialchars($car['description'] ?? 'Mẫu xe điện thông minh sở hữu DNA công nghệ và phong cách đột phá của VinFast.'); ?></p>
      </div>

      <!-- Slide Media (LCP Optimization) -->
      <div class="slide-media">
        <?php
          $isFirst = ($index === 0);
          $loadingAttr = $isFirst ? 'loading="eager" fetchpriority="high"' : 'loading="lazy"';
        ?>
        <img class="slide-car-img" id="slide-img-<?php echo $car['id']; ?>" src="<?php echo htmlspecialchars(get_thumb_url($car['image'], 800)); ?>" alt="Hình ảnh thực tế xe ô tô điện <?php echo htmlspecialchars($car['model_name']); ?> chính hãng VinFast" <?php echo $loadingAttr; ?> width="640" height="400">
      </div>

      <!-- Active Color Swatches on Slide (Dynamic Color Swapper) -->
      <?php
        $colorDots = [];
        $colorsRaw = $car['exterior_colors'] ?? '';
        if (!empty($colorsRaw)) {
            $colorParts = explode(',', $colorsRaw);
            foreach ($colorParts as $part) {
                $subParts = explode('|', $part);
                if (count($subParts) === 2) {
                    $colorDots[] = [
                        'name' => trim($subParts[0]),
                        'hex' => trim($subParts[1])
                    ];
                }
            }
        }
        if (empty($colorDots)) {
            $colorDots = [
                ['name' => 'Trắng Glacier', 'hex' => '#ffffff'],
                ['name' => 'Đỏ Crimson', 'hex' => '#dc2626'],
                ['name' => 'Xanh Neptune', 'hex' => '#0284c7'],
                ['name' => 'Vàng Brahmini', 'hex' => '#eab308'],
                ['name' => 'Xám Desat', 'hex' => '#64748b'],
                ['name' => 'Đen Jet Black', 'hex' => '#0f172a']
            ];
        }
        $firstColor = $colorDots[0] ?? ['name' => 'Trắng Glacier', 'hex' => '#ffffff'];
      ?>
      <div class="selected-color-label" id="color-label-<?php echo $car['id']; ?>">
        Màu sơn: <?php echo htmlspecialchars($firstColor['name']); ?>
      </div>
      <div class="slide-colors">
        <?php foreach ($colorDots as $cIdx => $dot): ?>
          <div class="slide-color-dot<?php echo $cIdx === 0 ? ' active' : ''; ?>" 
               style="background: <?php echo htmlspecialchars($dot['hex']); ?>;" 
               title="<?php echo htmlspecialchars($dot['name']); ?>" 
               onclick="window.switchSlideColor('<?php echo $car['id']; ?>', '<?php echo htmlspecialchars($dot['hex']); ?>', '<?php echo htmlspecialchars($dot['name']); ?>', event)"></div>
        <?php endforeach; ?>
      </div>

      <!-- Slide Footer Specs & Actions -->
      <div class="slide-footer">
        <div class="slide-specs-row">
          <div class="slide-spec-item">
            <span class="slide-spec-val"><?php echo htmlspecialchars($bodyType); ?></span>
            <span class="slide-spec-lbl">Dáng xe</span>
          </div>
          <div class="slide-spec-item">
            <span class="slide-spec-val"><?php echo htmlspecialchars($seats); ?></span>
            <span class="slide-spec-lbl">Số chỗ</span>
          </div>
          <div class="slide-spec-item">
            <span class="slide-spec-val"><?php echo htmlspecialchars($car['power']); ?></span>
            <span class="slide-spec-lbl">Công suất</span>
          </div>
          <div class="slide-spec-item">
            <span class="slide-spec-val"><?php echo htmlspecialchars($car['acceleration']); ?></span>
            <span class="slide-spec-lbl">Gia tốc</span>
          </div>
          <div class="slide-spec-item">
            <span class="slide-spec-val" style="color: #1464f4;"><?php echo htmlspecialchars($displayPrice); ?></span>
            <span class="slide-spec-lbl">Giá xe từ</span>
          </div>
        </div>

        <div class="slide-actions">
          <button type="button" class="btn-slide-primary" onclick="window.openPriceEstimator('<?php echo addslashes($car['model_name']); ?>', '<?php echo addslashes($displayPrice); ?>', '<?php echo $car['id']; ?>')">
            Tính giá lăn bánh
          </button>
          <button type="button" class="btn-slide-outline btn-compare-trigger" data-id="<?php echo $car['id']; ?>" onclick="window.toggleCompareCar('<?php echo $car['id']; ?>', '<?php echo addslashes($car['model_name']); ?>', event)">
            + So sánh
          </button>
          <a href="<?php echo seo_url('xe-vinfast/' . $car['slug']); ?>" class="btn-slide-outline">Xem chi tiết</a>
          <a href="https://zalo.me/<?php echo preg_replace('/[^0-9]/', '', $agencyPhone); ?>?text=Tôi%20muốn%20nhận%20báo%20giá%20và%20tư%20vấn%20mẫu%20xe%20<?php echo urlencode($car['model_name']); ?>" target="_blank" class="btn-slide-zalo" rel="noopener">Zalo</a>
        </div>
      </div>
    </section>
  <?php endforeach; ?>

</div>

<!-- FLOATING BOTTOM CONTROL DOCK -->
<div class="floating-bottom-dock">
  <?php foreach ($cars as $car): ?>
    <?php
      $shortName = preg_replace('/^VinFast\s+/i', '', $car['model_name']);
    ?>
    <a href="#model-<?php echo $car['id']; ?>" class="dock-item" onclick="event.preventDefault(); window.scrollToSection('model-<?php echo $car['id']; ?>');"><?php echo htmlspecialchars($shortName); ?></a>
  <?php endforeach; ?>
</div>

<!-- FLOATING COMPARE BAR -->
<div class="floating-compare-bar" id="compare-bar" style="display: none;">
  <div style="display: flex; align-items: center; gap: 8px;">
    <span style="font-size: 16px;">⚖️</span>
    <span style="font-size: 12px; font-weight: 700; color: #ffffff;" id="compare-count">Đã chọn 0 xe</span>
  </div>
  <div style="display: flex; gap: 8px; align-items: center;">
    <button onclick="window.showCompareModal()" class="btn-slide-primary" style="padding: 6px 14px; font-size: 11px; border-radius: 20px; text-transform: uppercase; box-shadow: none; background: #ffd700; color: #0f172a; font-weight: 800;">So sánh ngay</button>
    <button onclick="window.clearCompare()" style="background: transparent; border: none; color: #cbd5e1; font-size: 11px; cursor: pointer; text-decoration: underline;">Xóa hết</button>
  </div>
</div>

<!-- COMPARE MODAL -->
<div class="compare-modal-overlay" id="compare-modal" onclick="if(event.target === this) window.closeCompareModal()">
  <div class="compare-modal-box">
    <span class="compare-modal-close" onclick="window.closeCompareModal()">&times;</span>
    
    <div style="margin-bottom: 5px;">
      <h3 style="font-size: 20px; font-weight: 900; color: #0f172a; margin: 0; text-transform: uppercase; font-family: 'Outfit', sans-serif !important;">So Sánh Các Dòng Xe Điện VinFast</h3>
      <p style="font-size: 12px; color: #64748b; margin: 4px 0 0;">Bảng đối chiếu thông số kĩ thuật, kích thước và giá bán lăn bánh chi tiết.</p>
    </div>

    <!-- Swipe hint for Mobile -->
    <div class="swipe-hint-container" id="compare-swipe-hint" style="text-align: center; margin-top: 10px; margin-bottom: 5px;">
      <span class="compare-swipe-badge">VUỐT ĐỂ SO SÁNH</span>
    </div>

    <!-- Table Container -->
    <div class="compare-table-wrapper">
      <table class="compare-table" id="compare-table-content">
        <!-- Content injected dynamically by JS -->
      </table>
    </div>
  </div>
</div>

<!-- 1-CLICK ON-ROAD PRICE ESTIMATOR MODAL -->
<div class="estimator-modal-overlay" id="price-estimator-modal" onclick="if(event.target === this) window.closePriceEstimator()">
  <div class="estimator-modal-box">
    <span class="estimator-modal-close" onclick="window.closePriceEstimator()">&times;</span>
    
    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
      <span style="font-size: 26px;">🧮</span>
      <div>
        <h3 style="font-size: 19px; font-weight: 850; color: #0f172a; margin: 0;" id="estimator-car-title">Bảng Dự Toán Chi Phí Lăn Bánh</h3>
        <span style="font-size: 12px; font-weight: 700; color: #1464f4;" id="estimator-car-price-display">Giá niêm yết: -- VNĐ</span>
      </div>
    </div>

    <div class="estimator-grid-controls" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
      <div class="estimator-control-group">
        <label class="estimator-control-label" style="font-size: 11px; color: #64748b; display: block; margin-bottom: 4px;">Khu vực đăng ký:</label>
        <select class="estimator-select-input" id="est-location" onchange="window.recalculateEstimator()" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff;">
          <option value="hcm" selected>TP. Hồ Chí Minh</option>
          <option value="hanoi">TP. Hà Nội</option>
          <option value="province">Tỉnh / Thành khác</option>
        </select>
      </div>

      <div class="estimator-control-group">
        <label class="estimator-control-label" style="font-size: 11px; color: #64748b; display: block; margin-bottom: 4px;">Hình thức mua xe:</label>
        <select class="estimator-select-input" id="est-buy-type" onchange="window.recalculateEstimator()" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff;">
          <option value="installment" selected>Trả Góp 85%</option>
          <option value="full">Trả Thẳng 100%</option>
        </select>
      </div>

      <div class="estimator-control-group" id="est-loan-term-group">
        <label class="estimator-control-label" style="font-size: 11px; color: #64748b; display: block; margin-bottom: 4px;">Thời hạn vay vốn:</label>
        <select class="estimator-select-input" id="est-loan-term" onchange="window.recalculateEstimator()" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff;">
          <option value="96" selected>8 Năm (96 Tháng)</option>
          <option value="60">5 Năm (60 Tháng)</option>
          <option value="36">3 Năm (36 Tháng)</option>
        </select>
      </div>

      <div class="estimator-control-group">
        <label class="estimator-control-label" style="font-size: 11px; color: #64748b; display: block; margin-bottom: 4px;">Gói Pin lựa chọn:</label>
        <select class="estimator-select-input" id="est-battery-type" onchange="window.recalculateEstimator()" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff;">
          <option value="rent" selected>Thuê Pin</option>
          <option value="buy">Mua Đứt Pin</option>
        </select>
      </div>
    </div>

    <!-- Financial Breakdown Readout -->
    <div class="estimator-summary-card" style="padding: 15px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 20px;">
      
      <!-- Progress Bar Chart proportions -->
      <div class="estimator-progress-wrap" style="margin-bottom: 15px; display: none;" id="est-progress-container">
        <div style="display: flex; height: 10px; border-radius: 5px; overflow: hidden; background: #cbd5e1; margin-bottom: 6px;">
          <div id="est-bar-downpayment" style="background: #1464f4; width: 15%; transition: width 0.4s ease;"></div>
          <div id="est-bar-fees" style="background: #10b981; width: 5%; transition: width 0.4s ease;"></div>
          <div id="est-bar-loan" style="background: #94a3b8; width: 80%; transition: width 0.4s ease;"></div>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 10px; font-weight: 700; color: #64748b;">
          <span style="color: #1464f4;">● Trả trước</span>
          <span style="color: #10b981;">● Thuế phí</span>
          <span id="est-lbl-loan-pct" style="color: #475569;">● Vay 85%</span>
        </div>
      </div>

      <div class="estimator-row" style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13px;">
        <span class="estimator-row-lbl" style="color: #64748b;">Giá niêm yết xe:</span>
        <span class="estimator-row-val" id="est-val-base" style="font-weight: 700; color: #1e293b;">-- VNĐ</span>
      </div>
      <div class="estimator-row" style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13px;">
        <span class="estimator-row-lbl" style="color: #64748b;">Lệ phí trước bạ:</span>
        <span class="estimator-row-val" style="color: #059669; font-weight: 700;">0 VNĐ (Ưu đãi 0%)</span>
      </div>
      <div class="estimator-row" style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13px;">
        <span class="estimator-row-lbl" style="color: #64748b;">Tổng chi phí đăng kiểm & biển:</span>
        <span class="estimator-row-val" id="est-val-fees" style="font-weight: 700; color: #1e293b;">-- VNĐ</span>
      </div>
      <div class="estimator-row" style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13px; border-top: 1px dashed #cbd5e1; padding-top: 8px;">
        <span class="estimator-row-lbl" style="color: #1e293b; font-weight: 700;">CẦN TRẢ TRƯỚC NHẬN XE:</span>
        <span class="estimator-row-val estimator-row-val--highlight" id="est-val-upfront" style="font-weight: 900; color: #1464f4; font-size: 15px;">-- VNĐ</span>
      </div>
      <div class="estimator-row" id="est-row-monthly" style="display: flex; justify-content: space-between; font-size: 13px;">
        <span class="estimator-row-lbl" style="color: #1e293b; font-weight: 700;">GỐC + LÃI TRẢ GÓP THÁNG:</span>
        <span class="estimator-row-val estimator-row-val--monthly" id="est-val-monthly" style="font-weight: 900; color: #059669; font-size: 15px;">-- VNĐ / tháng</span>
      </div>
    </div>

    <div class="estimator-actions" style="display: flex; gap: 10px;">
      <a href="#" id="est-btn-zalo" target="_blank" class="btn-slide-zalo" style="flex: 1; text-align: center; font-size: 12.5px; padding: 10px; text-transform: none; border-radius: 20px;">
        💬 Gửi qua Zalo
      </a>
      <a href="#" id="est-btn-drive" target="_blank" class="btn-slide-primary" style="flex: 1; text-align: center; font-size: 12.5px; padding: 10px; border-radius: 20px; text-transform: uppercase; text-decoration: none;">
        📅 Đăng Ký Lái Thử
      </a>
    </div>
  </div>
</div>

<!-- Scripting for All Interactive Features -->
<script>
(function() {
  // Move footer inside the snap-scroll wrapper to snap correctly on scroll
  document.addEventListener('DOMContentLoaded', () => {
    try {
      const footer = document.querySelector('footer') || document.querySelector('.premium-footer');
      const wrapper = document.querySelector('.snap-scroll-wrapper');
      if (footer && wrapper) {
        wrapper.appendChild(footer);
      }
    } catch(err) { console.error(err); }
  });

  // Smooth Scroll Snap Section Link Navigation
  window.scrollToSection = function(id) {
    const el = document.getElementById(id);
    if (el) {
      el.scrollIntoView({ behavior: 'smooth' });
    }
  };

  // IntersectionObserver to update active bottom dock dots on scroll
  document.addEventListener('DOMContentLoaded', () => {
    try {
      const sections = document.querySelectorAll('.snap-section');
      const dockItems = document.querySelectorAll('.dock-item');

      const observerOptions = {
        root: document.querySelector('.snap-scroll-wrapper'),
        threshold: 0.5
      };

      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const id = entry.target.id;
            dockItems.forEach(item => {
              if (item.getAttribute('href') === '#' + id) {
                item.classList.add('active');
              } else {
                item.classList.remove('active');
              }
            });
          }
        });
      }, observerOptions);

      sections.forEach(sec => observer.observe(sec));
    } catch(err) { console.error(err); }
  });

  // Color Swatch Switcher for Snapping Slides (Visual Color Swapper)
  window.switchSlideColor = function(carId, hexColor, colorName, e) {
    if (e) e.stopPropagation();
    try {
      const slide = document.getElementById(`model-${carId}`);
      if (!slide) return;

      const dots = slide.querySelectorAll('.slide-color-dot');
      dots.forEach(d => d.classList.remove('active'));
      if (e && e.currentTarget) {
        e.currentTarget.classList.add('active');
      }

      // Update text label on slide
      const lbl = document.getElementById(`color-label-${carId}`);
      if (lbl) {
        lbl.innerText = 'Màu sơn: ' + colorName;
      }

      const img = slide.querySelector('.slide-car-img');
      if (img) {
        img.style.filter = `drop-shadow(0 20px 25px ${hexColor}55)`;
      }
    } catch(err) { console.error(err); }
  };

  // Inject raw cars data for Comparison Tool
  window.allCarsData = <?php echo json_encode($cars); ?>;
  window.compareCars = [];

  // Toggle Car in Comparison List
  window.toggleCompareCar = function(carId, modelName, e) {
    if (e) e.stopPropagation();
    carId = parseInt(carId, 10);
    const idx = window.compareCars.indexOf(carId);
    
    if (idx > -1) {
      window.compareCars.splice(idx, 1);
    } else {
      if (window.compareCars.length >= 3) {
        alert("Bạn chỉ có thể so sánh tối đa 3 mẫu xe cùng lúc!");
        return;
      }
      window.compareCars.push(carId);
    }
    
    window.updateCompareUI();
  };

  // Update Compare UI Floating Bar & Button States
  window.updateCompareUI = function() {
    const bar = document.getElementById('compare-bar');
    const countEl = document.getElementById('compare-count');
    const triggers = document.querySelectorAll('.btn-compare-trigger');
    
    triggers.forEach(btn => {
      const cId = parseInt(btn.getAttribute('data-id'), 10);
      if (window.compareCars.includes(cId)) {
        btn.innerText = '✓ Đã chọn';
        btn.style.background = '#e2e8f0';
        btn.style.color = '#1e293b';
        btn.style.borderColor = '#cbd5e1';
      } else {
        btn.innerText = '+ So sánh';
        btn.style.background = '';
        btn.style.color = '';
        btn.style.borderColor = '';
      }
    });

    if (window.compareCars.length > 0) {
      if (bar) {
        bar.style.display = 'flex';
        countEl.innerText = `Đã chọn ${window.compareCars.length} xe`;
      }
    } else {
      if (bar) bar.style.display = 'none';
    }
  };

  // Show Comparison Modal Side-by-Side Table
  window.showCompareModal = function() {
    if (window.compareCars.length === 0) return;
    
    const modal = document.getElementById('compare-modal');
    const table = document.getElementById('compare-table-content');
    const swipeHint = document.getElementById('compare-swipe-hint');
    
    if (window.innerWidth < 768) {
      swipeHint.style.display = 'block';
    } else {
      swipeHint.style.display = 'none';
    }

    const selectedCars = window.allCarsData.filter(c => window.compareCars.includes(parseInt(c.id, 10)));
    
    let html = '';
    
    // Header Row
    html += '<tr><td>Mẫu Xe</td>';
    selectedCars.forEach(c => {
      html += `
        <th style="text-align: center;">
          <img src="/${c.image}" style="max-height: 80px; max-width: 120px; object-fit: contain; display: block; margin: 0 auto 8px;" alt="${c.model_name}">
          <span style="font-weight: 800; text-transform: uppercase; display: block; font-size: 13px; color: #0f172a;">${c.model_name}</span>
        </th>
      `;
    });
    html += '</tr>';

    const addRow = (label, key, isPrice = false) => {
      let rHtml = `<tr><td>${label}</td>`;
      selectedCars.forEach(c => {
        let val = c[key] || '--';
        if (isPrice) {
          const parts = val.split('/');
          val = parts[0];
        }
        rHtml += `<td style="font-weight: 600; color: #334155;">${val}</td>`;
      });
      rHtml += '</tr>';
      return rHtml;
    };

    html += addRow('Giá bán từ', 'price', true);
    html += addRow('Phân khúc', 'segment');
    html += addRow('Số chỗ ngồi', 'seats');
    html += addRow('Động cơ', 'engine');
    html += addRow('Công suất', 'power');
    html += addRow('Mô-men xoắn', 'torque');
    html += addRow('Tăng tốc 0-100', 'acceleration');
    html += addRow('Tốc độ tối đa', 'top_speed');
    html += addRow('Quãng đường', 'range_wltp');
    html += addRow('Trạng thái cọc', 'stock_status');

    table.innerHTML = html;
    
    const rows = table.querySelectorAll('tr');
    rows.forEach(tr => {
      const labelTd = tr.querySelector('td');
      if (labelTd && labelTd.innerText === 'Số chỗ ngồi') {
        const tds = tr.querySelectorAll('td:not(:first-child)');
        selectedCars.forEach((c, cIdx) => {
          let seats = '5 chỗ';
          const nameLower = c.model_name.toLowerCase();
          if (nameLower.includes('vf 9') || nameLower.includes('limo') || nameLower.includes('mpv')) {
            seats = '7 chỗ';
          } else if (nameLower.includes('vf 2') || nameLower.includes('vf 3') || nameLower.includes('minio')) {
            seats = '4 chỗ';
          } else if (nameLower.includes('van')) {
            seats = '2 chỗ';
          }
          if (tds[cIdx]) tds[cIdx].innerText = seats;
        });
      }
    });

    if (modal) modal.classList.add('active');
  };

  // Close Comparison Modal
  window.closeCompareModal = function() {
    const modal = document.getElementById('compare-modal');
    if (modal) modal.classList.remove('active');
  };

  // Clear Comparison List
  window.clearCompare = function() {
    window.compareCars = [];
    window.updateCompareUI();
    window.closeCompareModal();
  };
})();
</script>

<!-- 1-CLICK ON-ROAD PRICE ESTIMATOR SCRIPT -->
<script>
(function() {
  let currentCar = { name: '', priceRaw: 0 };

  window.openPriceEstimator = function(name, priceStr, id) {
    currentCar.name = name;
    let numericPrice = parseInt(priceStr.replace(/[^0-9]/g, ''), 10);
    if (isNaN(numericPrice) || numericPrice === 0) {
      numericPrice = 500000000;
    }
    currentCar.priceRaw = numericPrice;

    document.getElementById('estimator-car-title').innerText = 'Dự Toán Lăn Bánh - ' + name;
    document.getElementById('estimator-car-price-display').innerText = 'Giá niêm yết: ' + numericPrice.toLocaleString('vi-VN') + ' VNĐ';

    window.recalculateEstimator();
    document.getElementById('price-estimator-modal').classList.add('active');
  };

  window.closePriceEstimator = function() {
    document.getElementById('price-estimator-modal').classList.remove('active');
  };

  window.recalculateEstimator = function() {
    if (!currentCar.priceRaw) return;

    const location = document.getElementById('est-location').value;
    const buyType = document.getElementById('est-buy-type').value;
    const loanTerm = parseInt(document.getElementById('est-loan-term').value, 10);
    const batteryType = document.getElementById('est-battery-type').value;

    const loanTermGroup = document.getElementById('est-loan-term-group');
    const rowMonthly = document.getElementById('est-row-monthly');
    if (buyType === 'full') {
      if (loanTermGroup) loanTermGroup.style.display = 'none';
      if (rowMonthly) rowMonthly.style.display = 'none';
    } else {
      if (loanTermGroup) loanTermGroup.style.display = 'block';
      if (rowMonthly) rowMonthly.style.display = 'flex';
    }

    let carPrice = currentCar.priceRaw;
    if (batteryType === 'buy') {
      carPrice += 120000000; 
    }

    let plateFee = (location === 'hcm' || location === 'hanoi') ? 20000000 : 1000000;
    let otherFees = 1560000 + 340000 + 480000;
    let totalFees = plateFee + otherFees;

    let upfrontAmount = 0;
    let monthlyPayment = 0;

    if (buyType === 'full') {
      upfrontAmount = carPrice + totalFees;
    } else {
      let downPayment = carPrice * 0.15; 
      upfrontAmount = downPayment + totalFees;

      let loanAmount = carPrice * 0.85;
      let monthlyPrincipal = loanAmount / loanTerm;
      let monthlyInterest = (loanAmount * 0.075) / 12; 
      monthlyPayment = Math.round(monthlyPrincipal + monthlyInterest);
    }

    document.getElementById('est-val-base').innerText = carPrice.toLocaleString('vi-VN') + ' VNĐ';
    document.getElementById('est-val-fees').innerText = totalFees.toLocaleString('vi-VN') + ' VNĐ';
    document.getElementById('est-val-upfront').innerText = 'CHỈ TỪ ' + Math.round(upfrontAmount).toLocaleString('vi-VN') + ' VNĐ';

    if (buyType === 'installment') {
      const monthlyEl = document.getElementById('est-val-monthly');
      if (monthlyEl) monthlyEl.innerText = 'CHỈ TỪ ' + monthlyPayment.toLocaleString('vi-VN') + ' VNĐ / tháng';
    }

    // Recalculate Progress Bar
    const progressContainer = document.getElementById('est-progress-container');
    if (buyType === 'installment') {
      if (progressContainer) {
        progressContainer.style.display = 'block';
        
        let downPayment = carPrice * 0.15;
        let totalCost = upfrontAmount + (carPrice * 0.85); 
        
        let downPct = Math.round((downPayment / totalCost) * 100);
        let feesPct = Math.round((totalFees / totalCost) * 100);
        let loanPct = 100 - downPct - feesPct;
        
        const barDown = document.getElementById('est-bar-downpayment');
        const barFees = document.getElementById('est-bar-fees');
        const barLoan = document.getElementById('est-bar-loan');
        const lblLoan = document.getElementById('est-lbl-loan-pct');
        
        if (barDown) barDown.style.width = downPct + '%';
        if (barFees) barFees.style.width = feesPct + '%';
        if (barLoan) barLoan.style.width = loanPct + '%';
        if (lblLoan) lblLoan.innerText = `● Vay ${loanPct}%`;
      }
    } else {
      if (progressContainer) progressContainer.style.display = 'none';
    }

    let zaloText = encodeURIComponent(
      'Chào VinFast Tam Phong, tôi muốn nhận bảng tính chi phí lăn bánh chi tiết cho mẫu xe ' + currentCar.name + 
      ' (Trả trước khoảng ' + Math.round(upfrontAmount).toLocaleString('vi-VN') + ' VNĐ).'
    );
    const estBtnZalo = document.getElementById('est-btn-zalo');
    if (estBtnZalo) estBtnZalo.href = 'https://zalo.me/<?php echo preg_replace('/[^0-9]/', '', $agencyPhone); ?>?text=' + zaloText;

    let driveText = encodeURIComponent(
      'Chào VinFast Tam Phong, tôi muốn đăng ký lái thử mẫu xe ' + currentCar.name
    );
    const estBtnDrive = document.getElementById('est-btn-drive');
    if (estBtnDrive) estBtnDrive.href = 'https://zalo.me/<?php echo preg_replace('/[^0-9]/', '', $agencyPhone); ?>?text=' + driveText;
  };
})();
</script>

<!-- Schema Markup JSON-LD for VinFast Cars -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "name": "Bảng Giá Các Dòng Xe Ô Tô Điện VinFast 2026",
  "description": "Danh sách các mẫu xe ô tô điện VinFast chính hãng kèm thông số, giá bán và ưu đãi mới nhất tại showroom.",
  "itemListElement": [
    <?php foreach ($cars as $index => $car): ?>
    <?php
      $priceParts = explode('/', $car['price'] ?? '');
      $displayPrice = trim($priceParts[0]);
      $numericPrice = preg_replace('/[^0-9]/', '', $displayPrice);
    ?>
    {
      "@type": "ListItem",
      "position": <?php echo $index + 1; ?>,
      "item": {
        "@type": "Product",
        "name": "<?php echo htmlspecialchars($car['model_name']); ?>",
        "image": "<?php echo htmlspecialchars(get_thumb_url($car['image'], 800)); ?>",
        "description": "<?php echo htmlspecialchars($car['description'] ?? 'Mẫu xe điện thông minh sở hữu DNA công nghệ và phong cách đột phá của VinFast.'); ?>",
        "brand": {
          "@type": "Brand",
          "name": "VinFast"
        },
        "offers": {
          "@type": "Offer",
          "priceCurrency": "VND",
          "price": "<?php echo $numericPrice; ?>",
          "valueAddedTaxIncluded": true
        }
      }
    }<?php echo ($index < count($cars) - 1) ? ',' : ''; ?>
    <?php endforeach; ?>
  ]
}
</script>