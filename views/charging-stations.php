<style>
/* Dedicated Charging Stations Page Styling */
.charging-hero {
  padding: 80px 0;
  background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%);
  border-bottom: 1px solid rgba(20, 100, 244, 0.1);
  text-align: center;
  position: relative;
  overflow: hidden;
}
.charging-hero::before {
  content: "";
  position: absolute;
  top: 0; left: 0; right: 0; bottom: 0;
  background-image: radial-gradient(rgba(20, 100, 244, 0.05) 1px, transparent 1px);
  background-size: 20px 20px;
  pointer-events: none;
}
.charging-title {
  font-family: 'Montserrat', sans-serif !important;
  font-weight: 800;
  font-size: 40px;
  color: var(--color-text-dark);
  margin-bottom: 16px;
  text-transform: uppercase;
}
.charging-subtitle {
  font-size: 16px;
  color: var(--color-text-slate);
  max-width: 680px;
  margin: 0 auto;
  line-height: 1.6;
}

.station-finder-section {
  padding: 60px 0;
  background: #ffffff;
}
.finder-card {
  background: #ffffff;
  border: 1px solid rgba(20, 100, 244, 0.1);
  box-shadow: 0 10px 30px rgba(20, 100, 244, 0.05);
  border-radius: 16px;
  padding: 32px;
  margin-top: -30px;
  position: relative;
  z-index: 5;
}
.finder-controls {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  margin-bottom: 24px;
}
@media (max-width: 768px) {
  .finder-controls {
    grid-template-columns: 1fr;
    gap: 12px;
  }
}
.finder-select-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.finder-select-label {
  font-size: 13px;
  font-weight: 600;
  color: var(--color-text-slate);
}
.finder-select {
  background: #f8fafc;
  border: 1px solid #cbd5e1;
  color: var(--color-text-dark);
  padding: 12px;
  border-radius: 8px;
  font-size: 14px;
  outline: none;
  cursor: pointer;
  width: 100%;
}
.finder-select:focus {
  border-color: var(--color-primary);
}

.results-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 24px;
  margin-top: 30px;
}
.station-card {
  background: #f8fafc;
  border: 1px solid rgba(20, 100, 244, 0.08);
  border-radius: 12px;
  padding: 20px;
  transition: all 0.3s ease;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  gap: 16px;
}
.station-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 20px rgba(20, 100, 244, 0.06);
  border-color: var(--color-primary);
}
.station-name {
  font-size: 16px;
  font-weight: 700;
  color: var(--color-text-dark);
}
.station-address {
  font-size: 13px;
  color: var(--color-text-slate);
  line-height: 1.5;
}
.station-meta {
  border-top: 1px dashed #e2e8f0;
  padding-top: 12px;
  display: flex;
  flex-direction: column;
  gap: 6px;
}
.meta-row {
  display: flex;
  justify-content: space-between;
  font-size: 12.5px;
}
.meta-lbl {
  color: var(--color-text-slate);
}
.meta-val {
  font-weight: 600;
  color: var(--color-text-dark);
}
.status-badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  background: #e0f2fe;
  color: var(--color-primary);
  padding: 2px 8px;
  border-radius: 12px;
  font-size: 11px;
  font-weight: 700;
}
.btn-directions {
  background: #ffffff;
  color: var(--color-primary);
  border: 1px solid var(--color-primary);
  padding: 10px;
  border-radius: 6px;
  font-size: 13px;
  font-weight: 700;
  text-align: center;
  text-decoration: none;
  display: block;
  transition: all 0.2s ease;
}
.btn-directions:hover {
  background: var(--color-primary);
  color: #fff;
  box-shadow: 0 4px 12px rgba(20, 100, 244, 0.2);
}

.spec-section {
  padding: 80px 0;
  background: #f8fafc;
  border-top: 1px solid rgba(20, 100, 244, 0.05);
}
.charging-spec-table {
  width: 100%;
  border-collapse: collapse;
  background: #ffffff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0,0,0,0.02);
  border: 1px solid #e2e8f0;
  margin-top: 30px;
}
.charging-spec-table th, .charging-spec-table td {
  padding: 16px 24px;
  text-align: left;
}
.charging-spec-table th {
  background: #f1f5f9;
  color: var(--color-text-dark);
  font-weight: 700;
  font-size: 14px;
}
.charging-spec-table td {
  color: var(--color-text-slate);
  border-bottom: 1px solid #f1f5f9;
  font-size: 13.5px;
}
.charging-spec-table tr:last-child td {
  border-bottom: none;
}

.guideline-section {
  padding: 80px 0;
  background: #ffffff;
}
.guideline-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 30px;
  margin-top: 40px;
}
@media (max-width: 992px) {
  .guideline-grid {
    grid-template-columns: 1fr;
  }
}
.guide-card {
  background: #f8fafc;
  border: 1px solid rgba(20, 100, 244, 0.05);
  border-radius: 12px;
  padding: 30px;
  text-align: center;
}
.guide-icon {
  font-size: 32px;
  margin-bottom: 16px;
  display: inline-block;
}
.guide-title {
  font-size: 17px;
  font-weight: 700;
  color: var(--color-text-dark);
  margin-bottom: 10px;
}
.guide-desc {
  font-size: 13px;
  color: var(--color-text-slate);
  line-height: 1.6;
}

.faq-page-section {
  padding: 80px 0;
  background: #f8fafc;
  border-top: 1px solid rgba(20, 100, 244, 0.05);
}
.faq-accordion-container {
  max-width: 800px;
  margin: 40px auto 0 auto;
  display: flex;
  flex-direction: column;
  gap: 16px;
}
.faq-item-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  overflow: hidden;
  transition: all 0.3s ease;
}
.faq-question-btn {
  width: 100%;
  padding: 20px 24px;
  background: none;
  border: none;
  text-align: left;
  font-size: 15px;
  font-weight: 700;
  color: var(--color-text-dark);
  cursor: pointer;
  display: flex;
  justify-content: space-between;
  align-items: center;
  outline: none;
}
.faq-answer-pane {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.3s cubic-bezier(0, 1, 0, 1);
  background: #f8fafc;
}
.faq-answer-content {
  padding: 20px 24px;
  font-size: 14px;
  color: var(--color-text-slate);
  line-height: 1.6;
  border-top: 1px solid #f1f5f9;
}
.faq-item-card.active {
  border-color: var(--color-primary);
  box-shadow: 0 4px 15px rgba(20, 100, 244, 0.05);
}
.faq-item-card.active .faq-question-btn {
  color: var(--color-primary);
}
.faq-chevron {
  transition: transform 0.3s ease;
}
.faq-item-card.active .faq-chevron {
  transform: rotate(180deg);
}
</style>

<main>
  <!-- HERO SECTION -->
  <section class="charging-hero">
    <div class="container">
      <h1 class="charging-title">Bản đồ Trạm sạc VinFast Toàn Quốc</h1>
      <p class="charging-subtitle">Tìm kiếm vị trí trạm sạc gần nhất của hệ thống 150.000 cổng sạc trên 63 tỉnh thành phục vụ xe máy điện và ô tô điện VinFast.</p>
    </div>
  </section>

  <!-- DYNAMIC STATION FINDER -->
  <section class="station-finder-section">
    <div class="container">
      <div class="finder-card">
        <div class="finder-controls">
          <div class="finder-select-group">
            <label class="finder-select-label">Tỉnh / Thành phố</label>
            <select class="finder-select" id="select-province" onchange="onProvinceChange()">
              <option value="all">Tất cả Tỉnh / Thành</option>
              <option value="ha-noi">Hà Nội</option>
              <option value="tp-hcm">TP. Hồ Chí Minh</option>
              <option value="da-nang">Đà Nẵng</option>
            </select>
          </div>
          <div class="finder-select-group">
            <label class="finder-select-label">Quận / Huyện</label>
            <select class="finder-select" id="select-district" onchange="renderStations()">
              <option value="all">Tất cả Quận / Huyện</option>
            </select>
          </div>
          <div class="finder-select-group">
            <label class="finder-select-label">Loại trụ sạc</label>
            <select class="finder-select" id="select-type" onchange="renderStations()">
              <option value="all">Tất cả trụ sạc</option>
              <option value="DC 250kW">Sạc Siêu Tốc DC 250kW</option>
              <option value="DC 60kW">Sạc Nhanh DC 60kW</option>
              <option value="AC 11kW">Sạc AC Thường 11kW</option>
            </select>
          </div>
        </div>

        <div class="results-grid" id="stations-results-container">
          <!-- Rendered dynamically -->
        </div>
      </div>
    </div>
  </section>

  <!-- CHARGING SPECIFICATION TABLE -->
  <section class="spec-section">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Công nghệ trạm sạc</span>
        <h2 class="section-title">Phân loại trụ sạc xe điện VinFast</h2>
      </div>

      <table class="charging-spec-table">
        <thead>
          <tr>
            <th>Loại trụ sạc</th>
            <th>Công suất đầu ra</th>
            <th>Thời gian ước tính (10 - 70%)</th>
            <th>Phân bổ phổ biến</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><strong>Sạc Siêu Tốc DC 250kW</strong></td>
            <td>Tối đa 250 kW</td>
            <td>18 - 25 phút</td>
            <td>Cao tốc, quốc lộ trọng điểm, Showroom lớn</td>
          </tr>
          <tr>
            <td><strong>Sạc Nhanh DC 150kW</strong></td>
            <td>Tối đa 150 kW</td>
            <td>25 - 35 phút</td>
            <td>Trung tâm thương mại Vincom, Bãi đỗ xe trung tâm</td>
          </tr>
          <tr>
            <td><strong>Sạc Nhanh DC 60kW</strong></td>
            <td>Tối đa 60 kW</td>
            <td>40 - 50 phút</td>
            <td>Chung cư Vinhomes, trạm dừng nghỉ, tòa nhà văn phòng</td>
          </tr>
          <tr>
            <td><strong>Sạc AC Thường 11kW / 22kW</strong></td>
            <td>11 - 22 kW</td>
            <td>6 - 8 tiếng (Sạc qua đêm)</td>
            <td>Bãi đỗ xe văn phòng, tại nhà riêng</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  <!-- CHARGING SAFETY GUIDELINES -->
  <section class="guideline-section">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Cẩm nang xe điện</span>
        <h2 class="section-title">Quy chuẩn sạc xe an toàn & tiết kiệm</h2>
      </div>

      <div class="guideline-grid">
        <div class="guide-card">
          <span class="guide-icon">💵</span>
          <h3 class="guide-title">Giá sạc minh bạch</h3>
          <p class="guide-desc">Đơn giá sạc công cộng thống nhất 3.858đ/kWh. Miễn phí đỗ xe 30 phút đầu sau khi pin sạc đầy.</p>
        </div>
        <div class="guide-card">
          <span class="guide-icon">⚡</span>
          <h3 class="guide-title">Tránh sạc quá 90% khi sạc nhanh</h3>
          <p class="guide-desc">Sạc nhanh DC nên dừng ở mức 80% - 90% để bảo vệ pin tốt nhất và tối ưu hóa thời gian chờ đợi tại trạm.</p>
        </div>
        <div class="guide-card">
          <span class="guide-icon">☔</span>
          <h3 class="guide-title">An toàn tuyệt đối dưới trời mưa</h3>
          <p class="guide-desc">Các trụ sạc đạt chuẩn IP65 chịu nước lớn, hệ thống rơ-le cách điện thông minh ngắt ngay khi có tín hiệu rò rỉ.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ SECTION -->
  <section class="faq-page-section">
    <div class="container">
      <div class="section-header" style="text-align: center;">
        <span class="section-tag">Giải đáp thắc mắc</span>
        <h2 class="section-title">Các câu hỏi thường gặp về trạm sạc VinFast</h2>
      </div>

      <div class="faq-accordion-container">
        <?php foreach ($faqSchemaData as $index => $faq): ?>
          <div class="faq-item-card" id="faq-card-<?php echo $index; ?>">
            <button class="faq-question-btn" onclick="toggleFaqAccordion(<?php echo $index; ?>)">
              <span><?php echo htmlspecialchars($faq['question']); ?></span>
              <svg class="faq-chevron" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="6 9 12 15 18 9"></polyline>
              </svg>
            </button>
            <div class="faq-answer-pane" id="faq-pane-<?php echo $index; ?>">
              <div class="faq-answer-content">
                <?php echo htmlspecialchars($faq['answer']); ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
</main>

<script>
const stationsDb = {
  'ha-noi': [
    { name: 'Vincom Mega Mall Royal City', address: '72A Nguyễn Trãi, Thượng Đình, Thanh Xuân, Hà Nội', district: 'Thanh Xuân', types: 'DC 250kW, DC 60kW, AC 11kW', count: '12 cổng sạc (Trống 6)', status: 'ONLINE', map: 'https://www.google.com/maps/search/?api=1&query=Vincom+Mega+Mall+Royal+City+Hanoi' },
    { name: 'Vincom Center Nguyễn Chí Thanh', address: '54A Nguyễn Chí Thanh, Láng Thượng, Đống Đa, Hà Nội', district: 'Đống Đa', types: 'DC 60kW, AC 11kW', count: '8 cổng sạc (Trống 2)', status: 'ONLINE', map: 'https://www.google.com/maps/search/?api=1&query=Vincom+Center+Nguyen+Chi+Thanh+Hanoi' },
    { name: 'Trạm sạc Vinhomes Ocean Park (Bãi đỗ xe tập trung)', address: 'Đa Tốn, Gia Lâm, Hà Nội', district: 'Gia Lâm', types: 'DC 250kW, DC 60kW', count: '24 cổng sạc (Trống 15)', status: 'ONLINE', map: 'https://www.google.com/maps/search/?api=1&query=Vinhomes+Ocean+Park+Gia+Lam+Hanoi' }
  ],
  'tp-hcm': [
    { name: 'Vincom Mega Mall Thảo Điền', address: '161 Xa lộ Hà Nội, Thảo Điền, Quận 2, TP. Hồ Chí Minh', district: 'Quận 2', types: 'DC 250kW, DC 60kW, AC 11kW', count: '16 cổng sạc (Trống 8)', status: 'ONLINE', map: 'https://www.google.com/maps/search/?api=1&query=Vincom+Mega+Mall+Thao+Dien+HCM' },
    { name: 'Trạm sạc Vinhomes Central Park (Hầm B2 Landmark 81)', address: '720A Điện Biên Phủ, Phường 22, Bình Thạnh, TP. Hồ Chí Minh', district: 'Bình Thạnh', types: 'DC 250kW, DC 60kW', count: '20 cổng sạc (Trống 4)', status: 'ONLINE', map: 'https://www.google.com/maps/search/?api=1&query=Vinhomes+Central+Park+Landmark+81+HCM' },
    { name: 'Vincom Plaza Cộng Hòa', address: '15-17 Cộng Hòa, Phường 4, Tân Bình, TP. Hồ Chí Minh', district: 'Tân Bình', types: 'DC 60kW, AC 11kW', count: '8 cổng sạc (Trống 3)', status: 'ONLINE', map: 'https://www.google.com/maps/search/?api=1&query=Vincom+Plaza+Cong+Hoa+HCM' }
  ],
  'da-nang': [
    { name: 'Vincom Plaza Ngô Quyền', address: '910A Ngô Quyền, An Hải Bắc, Sơn Trà, Đà Nẵng', district: 'Sơn Trà', types: 'DC 150kW, DC 60kW', count: '10 cổng sạc (Trống 5)', status: 'ONLINE', map: 'https://www.google.com/maps/search/?api=1&query=Vincom+Plaza+Ngo+Quyen+Da+Nang' },
    { name: 'Trạm sạc Bãi đỗ xe công cộng Đà Nẵng', address: 'Lê Thanh Nghị, Hòa Cường Nam, Hải Châu, Đà Nẵng', district: 'Hải Châu', types: 'DC 60kW, AC 11kW', count: '6 cổng sạc (Trống 1)', status: 'ONLINE', map: 'https://www.google.com/maps/search/?api=1&query=Le+Thanh+Nghi+Hai+Chau+Da+Nang' }
  ]
};

const districtsByProvince = {
  'ha-noi': ['Thanh Xuân', 'Đống Đa', 'Gia Lâm'],
  'tp-hcm': ['Quận 2', 'Bình Thạnh', 'Tân Bình'],
  'da-nang': ['Sơn Trà', 'Hải Châu']
};

function onProvinceChange() {
  const province = document.getElementById('select-province').value;
  const districtSelect = document.getElementById('select-district');
  
  // Clear districts
  districtSelect.innerHTML = '<option value="all">Tất cả Quận / Huyện</option>';
  
  if (province !== 'all' && districtsByProvince[province]) {
    districtsByProvince[province].forEach(d => {
      const option = document.createElement('option');
      option.value = d;
      option.textContent = d;
      districtSelect.appendChild(option);
    });
  }
  
  renderStations();
}

function renderStations() {
  const province = document.getElementById('select-province').value;
  const district = document.getElementById('select-district').value;
  const typeFilter = document.getElementById('select-type').value;
  const container = document.getElementById('stations-results-container');
  
  container.innerHTML = '';
  
  let list = [];
  if (province === 'all') {
    Object.keys(stationsDb).forEach(p => {
      list = list.concat(stationsDb[p]);
    });
  } else {
    list = stationsDb[province] || [];
  }
  
  const filteredList = list.filter(s => {
    const matchDistrict = (district === 'all' || s.district === district);
    const matchType = (typeFilter === 'all' || s.types.includes(typeFilter));
    return matchDistrict && matchType;
  });
  
  if (filteredList.length === 0) {
    container.innerHTML = `<div style="grid-column: 1 / -1; text-align: center; color: var(--color-text-slate); padding: 40px 0;">Không tìm thấy trạm sạc nào phù hợp với bộ lọc đã chọn.</div>`;
    return;
  }
  
  filteredList.forEach(s => {
    const card = document.createElement('div');
    card.className = 'station-card';
    card.innerHTML = `
      <div>
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
          <h3 class="station-name">${s.name}</h3>
          <span class="status-badge">
            <span style="width: 6px; height: 6px; background: #1464f4; border-radius: 50%; display: inline-block;"></span>
            ${s.status}
          </span>
        </div>
        <p class="station-address">${s.address}</p>
      </div>
      <div class="station-meta">
        <div class="meta-row">
          <span class="meta-lbl">Phân loại cổng sạc</span>
          <span class="meta-val">${s.types}</span>
        </div>
        <div class="meta-row" style="margin-bottom: 12px;">
          <span class="meta-lbl">Trạng thái cổng</span>
          <span class="meta-val" style="color: #16a34a;">${s.count}</span>
        </div>
        <a href="${s.map}" target="_blank" rel="noopener" class="btn-directions">Chỉ đường Google Maps</a>
      </div>
    `;
    container.appendChild(card);
  });
}

function toggleFaqAccordion(index) {
  const activeCard = document.getElementById('faq-card-' + index);
  const activePane = document.getElementById('faq-pane-' + index);
  const isActive = activeCard.classList.contains('active');

  // Close all
  document.querySelectorAll('.faq-item-card').forEach(card => card.classList.remove('active'));
  document.querySelectorAll('.faq-answer-pane').forEach(pane => pane.style.maxHeight = null);

  if (!isActive) {
    activeCard.classList.add('active');
    activePane.style.maxHeight = activePane.scrollHeight + "px";
  }
}

// Initial render
document.addEventListener('DOMContentLoaded', () => {
  onProvinceChange();
});
</script>
