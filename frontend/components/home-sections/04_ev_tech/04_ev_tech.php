<!-- SECTION 3.5: DYNAMIC EV TECHNOLOGY CENTER (Range & Green ROI Calculators) -->
  <section class="ev-tech-section" id="ev-tech-block">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Công nghệ dẫn lối</span>
        <h2 class="section-title">Trung Tâm Tương Tác Công Nghệ EV</h2>
        <p class="compare-subtitle" style="max-width: 700px; margin: 10px auto 0 auto; color: var(--color-text-slate);">
          Trải nghiệm và ước tính các thông số hoạt động thực tế, mức tiết kiệm chi phí nhiên liệu & bảo vệ môi trường khi sử dụng xe điện VinFast.
        </p>
      </div>

      <!-- Tab Selectors -->
      <div class="ev-tech-tabs-wrapper">
        <div class="ev-tech-tabs">
          <button class="ev-tech-tab-btn active" onclick="switchEvTechTab('range-calc')">
            <svg class="ev-tab-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z"/></svg>
            <span>Tính Quãng Đường</span>
          </button>
          <button class="ev-tech-tab-btn" onclick="switchEvTechTab('roi-calc')">
            <svg class="ev-tab-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-6h6M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            <span>Bộ Tính Tiết Kiệm</span>
          </button>
          <button class="ev-tech-tab-btn" onclick="switchEvTechTab('charging-map')">
            <svg class="ev-tab-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
            <span>Bản Đồ Trạm Sạc</span>
          </button>
        </div>
      </div>

      <!-- PANE 1: RANGE CALCULATOR -->
      <div id="pane-range-calc" class="ev-tech-pane active">
        <div class="range-calc-grid">
          <!-- Left: List of Models -->
          <div class="range-calc-models-panel" id="range-models-list">
            <div class="range-calc-model-card active" data-model="vf3" onclick="selectRangeModel('vf3')">
              <img src="<?php echo $basePath; ?>/assets/uploads/vinfast-vf3.webp" class="range-calc-model-thumb" alt="VF 3" onerror="this.src='<?php echo $basePath; ?>/assets/uploads/vinfast-vf3.webp'">
              <div class="range-calc-model-info">
                <div class="range-calc-model-name">VinFast VF 3</div>
                <div class="range-calc-model-meta">SUV Mini | 18.64 kWh</div>
              </div>
            </div>
            
            <div class="range-calc-model-card" data-model="vf5" onclick="selectRangeModel('vf5')">
              <img src="<?php echo $basePath; ?>/assets/uploads/vinfast-vf5.webp" class="range-calc-model-thumb" alt="VF 5" onerror="this.src='<?php echo $basePath; ?>/assets/uploads/vinfast-vf5.webp'">
              <div class="range-calc-model-info">
                <div class="range-calc-model-name">VinFast VF 5 Plus</div>
                <div class="range-calc-model-meta">SUV Cỡ A | 37.23 kWh</div>
              </div>
            </div>

            <div class="range-calc-model-card" data-model="vf6" onclick="selectRangeModel('vf6')">
              <img src="<?php echo $basePath; ?>/assets/uploads/vinfast-vf6.webp" class="range-calc-model-thumb" alt="VF 6" onerror="this.src='<?php echo $basePath; ?>/assets/uploads/vinfast-vf6.webp'">
              <div class="range-calc-model-info">
                <div class="range-calc-model-name">VinFast VF 6</div>
                <div class="range-calc-model-meta">SUV Cỡ B | 59.6 kWh</div>
              </div>
            </div>

            <div class="range-calc-model-card" data-model="vf7" onclick="selectRangeModel('vf7')">
              <img src="<?php echo $basePath; ?>/assets/uploads/vinfast-vf7.webp" class="range-calc-model-thumb" alt="VF 7" onerror="this.src='<?php echo $basePath; ?>/assets/uploads/vinfast-vf7.webp'">
              <div class="range-calc-model-info">
                <div class="range-calc-model-name">VinFast VF 7</div>
                <div class="range-calc-model-meta">SUV Cỡ C | 75.3 kWh</div>
              </div>
            </div>

            <div class="range-calc-model-card" data-model="vf8" onclick="selectRangeModel('vf8')">
              <img src="<?php echo $basePath; ?>/assets/uploads/vinfast-vf8.webp" class="range-calc-model-thumb" alt="VF 8" onerror="this.src='<?php echo $basePath; ?>/assets/uploads/vinfast-vf8.webp'">
              <div class="range-calc-model-info">
                <div class="range-calc-model-name">VinFast VF 8</div>
                <div class="range-calc-model-meta">SUV Cỡ D | 82.0 kWh</div>
              </div>
            </div>

            <div class="range-calc-model-card" data-model="vf9" onclick="selectRangeModel('vf9')">
              <img src="<?php echo $basePath; ?>/assets/uploads/vinfast-vf9.webp" class="range-calc-model-thumb" alt="VF 9" onerror="this.src='<?php echo $basePath; ?>/assets/uploads/vinfast-vf9.webp'">
              <div class="range-calc-model-info">
                <div class="range-calc-model-name">VinFast VF 9</div>
                <div class="range-calc-model-meta">SUV Cỡ E | 92.0 kWh</div>
              </div>
            </div>
          </div>

          <!-- Right: Interactive Controls & Ring Visualizer -->
          <div class="range-calc-interactive-panel">
            <div class="range-calc-upper-row" style="display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 32px; width: 100%; align-items: center;">
              <div class="range-calc-controls">
                <!-- Slider 1: Speed -->
                <div class="range-slider-group-premium">
                  <div class="slider-icon-box">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #1464f4;">
                      <circle cx="12" cy="12" r="9"></circle>
                      <polyline points="12 7 12 12 15 15"></polyline>
                    </svg>
                  </div>
                  <div class="slider-content">
                    <div class="range-slider-header">
                      <span class="range-slider-label">Vận tốc trung bình</span>
                      <span class="range-slider-value" id="range-speed-val">60 km/h</span>
                    </div>
                    <input type="range" class="range-slider-input" id="range-speed-slider" min="30" max="120" value="60" oninput="updateRangeEstimation()">
                    <div class="slider-ticks">
                      <span>30 km/h</span>
                      <span>75 km/h</span>
                      <span>120 km/h</span>
                    </div>
                  </div>
                </div>

                <!-- Slider 2: Temp -->
                <div class="range-slider-group-premium">
                  <div class="slider-icon-box">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #00a3ff;">
                      <path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z"></path>
                    </svg>
                  </div>
                  <div class="slider-content">
                    <div class="range-slider-header">
                      <span class="range-slider-label">Nhiệt độ ngoài trời (Điều hòa)</span>
                      <span class="range-slider-value" id="range-temp-val">25 °C</span>
                    </div>
                    <input type="range" class="range-slider-input" id="range-temp-slider" min="15" max="45" value="25" oninput="updateRangeEstimation()">
                    <div class="slider-ticks">
                      <span>15°C (Lạnh)</span>
                      <span>25°C (Mát)</span>
                      <span>45°C (Nóng)</span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Visualization Circle -->
              <div class="range-calc-visualizer">
                <div class="range-circle-box">
                  <svg class="range-svg-ring" viewBox="0 0 200 200">
                    <defs>
                      <linearGradient id="green-teal-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#1464f4" />
                        <stop offset="100%" stop-color="#00a3ff" />
                      </linearGradient>
                    </defs>
                    <circle class="range-svg-bg" cx="100" cy="100" r="90" />
                    <circle class="range-svg-progress" id="range-circle-progress" cx="100" cy="100" r="90" />
                  </svg>
                  <div class="range-number-box">
                    <div class="range-number-value" id="range-calculated-val">210</div>
                    <div class="range-number-unit">km dự tính</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Cockpit Metrics Status Bar (Symmetrical Bottom Row) -->
            <div class="range-cockpit-metrics-bar">
              <div class="metric-bar-item" id="metric-item-eff">
                <span class="metric-bar-label">Hiệu năng thực tế</span>
                <span class="metric-bar-val" id="range-metric-efficiency">100%</span>
              </div>
              <div class="metric-bar-item">
                <span class="metric-bar-label">Tiêu hao ước tính</span>
                <span class="metric-bar-val" id="range-metric-consumption">8.8 kWh/100km</span>
              </div>
              <div class="metric-bar-item">
                <span class="metric-bar-label">Sạc nhanh (10-80%)</span>
                <span class="metric-bar-val" id="range-metric-charge">26 phút</span>
              </div>
            </div>
          </div>
        </div>
      </div>
            <!-- PANE 2: GREEN ROI CALCULATOR -->
      <div id="pane-roi-calc" class="ev-tech-pane">
        <div class="roi-calc-grid">
          <!-- Form controls -->
          <div class="roi-calc-form-panel">
            <div class="roi-form-row">
              <div class="roi-input-group">
                <label class="roi-input-label">Mẫu xe điện VinFast</label>
                <select class="roi-select" id="roi-car-select" onchange="calculateGreenROI()">
                  <option value="vf3" selected>VinFast VF 3</option>
                  <option value="vf5">VinFast VF 5 Plus</option>
                  <option value="vf6">VinFast VF 6</option>
                  <option value="vf7">VinFast VF 7</option>
                  <option value="vf8">VinFast VF 8</option>
                  <option value="vf9">VinFast VF 9</option>
                </select>
              </div>

              <div class="roi-input-group">
                <label class="roi-input-label">So sánh với phân khúc xe xăng</label>
                <select class="roi-select" id="roi-gas-select" onchange="calculateGreenROI()">
                  <option value="7" selected>SUV Cỡ Nhỏ (~7 Lít/100km)</option>
                  <option value="9">SUV Cỡ Trung (~9 Lít/100km)</option>
                  <option value="12">SUV Cỡ Lớn (~12 Lít/100km)</option>
                </select>
              </div>
            </div>

            <div class="range-slider-group">
              <div class="range-slider-header">
                <span class="range-slider-label">Quãng đường di chuyển hàng tháng</span>
                <span class="range-slider-value" id="roi-distance-val">1,500 km</span>
              </div>
              <input type="range" class="range-slider-input" id="roi-distance-slider" min="500" max="5000" step="100" value="1500" oninput="calculateGreenROI()">
            </div>

            <div class="roi-breakdown">
              <div class="roi-breakdown-row">
                <span class="roi-breakdown-label">Giá xăng tham chiếu (RON 95)</span>
                <span class="roi-breakdown-value">23,000 VND / Lít</span>
              </div>
              <div class="roi-breakdown-row">
                <span class="roi-breakdown-label">Đơn giá điện sạc VinFast</span>
                <span class="roi-breakdown-value">3,858 VND / kWh</span>
              </div>
              <div class="roi-breakdown-row">
                <span class="roi-breakdown-label">Gói thuê pin xe điện</span>
                <span class="roi-breakdown-value" id="roi-battery-cost-val">900,000 VND / tháng</span>
              </div>
            </div>
          </div>

          <!-- ROI breakdown and Green Impact metrics -->
          <div class="roi-results-panel">
            <div class="roi-result-header">
              <div class="roi-saving-title">Tiết kiệm chi phí nhiên liệu</div>
              <div class="roi-saving-value" id="roi-savings-val">1,250,000 VND / Tháng</div>
            </div>

            <div class="roi-breakdown">
              <div class="roi-breakdown-row">
                <span class="roi-breakdown-label">Chi phí đổ xăng mỗi tháng</span>
                <span class="roi-breakdown-value" id="roi-gas-cost-val">2,415,000 VND</span>
              </div>
              <div class="roi-breakdown-row">
                <span class="roi-breakdown-label">Chi phí xe điện (Sạc + Thuê pin)</span>
                <span class="roi-breakdown-value" id="roi-ev-cost-val">1,533,000 VND</span>
              </div>
              <div class="roi-breakdown-row" style="border-top: 1px dashed #cbd5e1; padding-top: 12px; font-weight: 700; color: var(--color-ev-gold);">
                <span class="roi-breakdown-label" style="color: var(--color-ev-gold);">Tiết kiệm ròng hàng năm</span>
                <span class="roi-breakdown-value" id="roi-savings-annual-val" style="color: var(--color-ev-gold);">15,000,000 VND</span>
              </div>
            </div>

            <!-- Green Impact Alert Box -->
            <div class="roi-green-impact">
              <span class="roi-green-icon">🌳</span>
              <div class="roi-green-info">
                Bằng việc chọn xe điện, mỗi tháng anh/chị giúp cắt giảm lượng khí thải CO₂ tương đương với trồng 
                <span class="roi-green-number" id="roi-trees-val">9</span> cây xanh mỗi năm!
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- PANE 3: CHARGING STATION MAP DEMO -->
      <div id="pane-charging-map" class="ev-tech-pane">
        <style>
          @keyframes radarSweep {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
          }
          @keyframes pinPulse {
            0% { transform: translate(-50%, -50%) scale(0.9); opacity: 0.8; }
            100% { transform: translate(-50%, -50%) scale(1.15); opacity: 1; }
          }
          .map-pin {
            position: absolute;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 2px solid #ffffff;
            cursor: pointer;
            z-index: 5;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            animation: pinPulse 1.2s infinite alternate ease-in-out;
          }
          .map-pin.active {
            transform: translate(-50%, -50%) scale(1.4) !important;
            box-shadow: 0 0 15px currentColor !important;
            border-color: #ffffff !important;
          }
          .charging-controls-panel {
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 16px !important;
            padding: 24px !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 20px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
          }
          .charging-controls-panel label {
            color: #cbd5e1 !important;
            font-weight: 700 !important;
          }
          .charging-controls-panel select {
            background: rgba(8, 12, 28, 0.8) !important;
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            outline: none !important;
          }
          .charging-controls-panel select option {
            background: #070b13 !important;
            color: #ffffff !important;
          }
          .charging-map-display {
            display: grid !important;
            grid-template-columns: 1.2fr 1fr !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 16px !important;
            overflow: hidden !important;
            background: rgba(255, 255, 255, 0.02) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
          }
          .station-card {
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid rgba(255, 255, 255, 0.06) !important;
            border-radius: 10px;
            padding: 12px;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
            gap: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.01);
            color: #cbd5e1 !important;
          }
          .station-card:hover {
            transform: translateY(-2px);
            border-color: #1464f4 !important;
            background: rgba(20, 100, 244, 0.08) !important;
          }
          .station-card.active {
            background: rgba(20, 100, 244, 0.15) !important;
            border: 2.5px solid #1464f4 !important;
            box-shadow: 0 4px 12px rgba(20, 100, 244, 0.15) !important;
            color: #ffffff !important;
          }
          .station-card strong {
            color: #ffffff !important;
          }
          .station-card span {
            color: #94a3b8 !important;
          }
          .station-card .badge {
            background: rgba(20, 100, 244, 0.15) !important;
            color: #00d2ff !important;
            border: 1px solid rgba(20, 100, 244, 0.3) !important;
          }
          .map-simulation {
            background: #0b0f19 !important;
          }
          .charging-map-display > div:last-child {
            background: rgba(8, 12, 28, 0.85) !important;
            color: #ffffff !important;
            border-left: 1px solid rgba(255, 255, 255, 0.08) !important;
          }
          .charging-map-display h3, .charging-map-display h4 {
            color: #1e293b !important;
          }
          .charging-map-display .station-name {
            color: #1e293b !important;
          }
          .charging-map-display .station-meta, .charging-map-display p, .charging-map-display span {
            color: #475569 !important;
          }
        /* Mobile Charging Map Stacked Layout Fix */
          @media (max-width: 768px) {
            html body .charging-map-display {
              display: flex !important;
              flex-direction: column !important;
              border-radius: 16px !important;
              overflow: hidden !important;
              width: 100% !important;
            }

            html body .map-simulation {
              height: 250px !important;
              min-height: 250px !important;
              width: 100% !important;
            }

            html body .charging-map-display > div:last-child {
              border-left: none !important;
              border-top: 1.5px solid #cbd5e1 !important;
              padding: 12px !important;
              max-height: 380px !important;
              overflow-y: auto !important;
              width: 100% !important;
              box-sizing: border-box !important;
            }

            html body .station-card {
              width: 100% !important;
              box-sizing: border-box !important;
              padding: 12px 14px !important;
            }

            html body .station-card strong,
            html body .station-card .station-title {
              font-size: 14px !important;
              font-weight: 800 !important;
              line-height: 1.35 !important;
              word-break: break-word !important;
              display: block !important;
            }

            html body .station-card span,
            html body .station-card .station-address {
              font-size: 12px !important;
              line-height: 1.4 !important;
              word-break: break-word !important;
              display: block !important;
            }
          }
        </style>
        <div class="charging-map-grid" style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; min-height: 450px;">
          <!-- Left: Station Controls & Stats Panel -->
          <div class="charging-controls-panel">
            <div class="control-group">
              <label style="font-weight: 700; font-size: 12px; color: #cbd5e1; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 8px;">Tỉnh / Thành Phố</label>
              <select id="station-province-select" onchange="updateChargingStations()" style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.12); outline: none; font-size: 14px; font-weight: 600; color: #ffffff; background: rgba(8, 12, 28, 0.8);">
                <option value="hanoi" selected>Hà Nội</option>
                <option value="hcm">TP. Hồ Chí Minh</option>
                <option value="danang">Đà Nẵng</option>
                <option value="haiphong">Hải Phòng</option>
                <option value="cantho">Cần Thơ</option>
              </select>
            </div>
            
            <div class="control-group">
              <label style="font-weight: 700; font-size: 12px; color: #cbd5e1; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 8px;">Lọc Trụ Sạc</label>
              <div style="display: flex; flex-direction: column; gap: 8px;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 500; cursor: pointer; color: #cbd5e1;">
                  <input type="checkbox" id="filter-superfast" checked onchange="updateChargingStations()" style="width: 16px; height: 16px; accent-color: var(--color-primary);">
                  Sạc Siêu Nhanh DC 180kW/250kW
                </label>
                <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 500; cursor: pointer; color: #cbd5e1;">
                  <input type="checkbox" id="filter-fast" checked onchange="updateChargingStations()" style="width: 16px; height: 16px; accent-color: var(--color-primary);">
                  Sạc Nhanh DC 30kW/60kW
                </label>
                <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 500; cursor: pointer; color: #cbd5e1;">
                  <input type="checkbox" id="filter-ac" checked onchange="updateChargingStations()" style="width: 16px; height: 16px; accent-color: var(--color-primary);">
                  Sạc Thường AC 11kW
                </label>
              </div>
            </div>
            
            <!-- Realtime Station Stats -->
            <div class="charging-stats" style="margin-top: auto; border-top: 1px dashed rgba(255, 255, 255, 0.15); padding-top: 16px; display: flex; flex-direction: column; gap: 12px;">
              <div class="stat-item" style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 13px; color: #94a3b8;">Trạm sạc đang online:</span>
                <span id="stat-online" style="font-size: 14px; font-weight: 700; color: #10b981;">32/32</span>
              </div>
              <div class="stat-item" style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 13px; color: #94a3b8;">Trụ sạc sẵn sàng:</span>
                <span id="stat-available" style="font-size: 14px; font-weight: 700; color: var(--color-primary);">124 Trụ</span>
              </div>
              <div class="stat-item" style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 13px; color: #94a3b8;">Hiệu suất hoạt động:</span>
                <span style="font-size: 14px; font-weight: 700; color: var(--color-ev-gold);">98.8%</span>
              </div>
            </div>
          </div>
          
          <!-- Right: Simulated Interactive Map and Station List -->
          <div class="charging-map-display">
            <!-- Map Simulation Visualizer -->
            <div class="map-simulation" style="background: #0b0f19; position: relative; overflow: hidden; min-height: 400px; display: flex; align-items: center; justify-content: center;">
              <!-- Grid overlay to represent map grid -->
              <div style="position: absolute; top:0; left:0; width:100%; height:100%; background-image: radial-gradient(rgba(20, 100, 244, 0.15) 1.5px, transparent 1.5px), radial-gradient(rgba(20, 100, 244, 0.08) 1px, transparent 1px); background-size: 30px 30px, 15px 15px; background-position: 0 0, 7.5px 7.5px; opacity: 0.8;"></div>
              
              <!-- Radar sweep scanning effect for futuristic mapping -->
              <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: conic-gradient(from 0deg, rgba(20, 100, 244, 0) 50%, rgba(20, 100, 244, 0.02) 90%, rgba(20, 100, 244, 0.06) 100%); animation: radarSweep 6s linear infinite; transform-origin: center; pointer-events: none;"></div>
              
              <!-- Province center point label -->
              <div style="position: absolute; top: 12px; left: 12px; background: rgba(8, 12, 28, 0.85); border-radius: 6px; padding: 4px 10px; border: 1px solid rgba(255, 255, 255, 0.15); font-size: 11px; font-weight: 700; color: #ffffff; letter-spacing: 0.5px; text-transform: uppercase; z-index: 5;">
                Bản đồ giả lập 2D
              </div>
              
              <!-- SVG map container for pins and radar circles -->
              <svg id="svg-map-pins" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 2; pointer-events: none;">
                <!-- Animated radar rings around selected station -->
                <circle id="radar-ring-1" cx="0" cy="0" r="0" fill="none" stroke="var(--color-primary)" stroke-width="1.5" opacity="0" style="transition: all 0.3s;"></circle>
                <circle id="radar-ring-2" cx="0" cy="0" r="0" fill="none" stroke="var(--color-primary)" stroke-width="1.5" opacity="0" style="transition: all 0.3s;"></circle>
              </svg>
              
              <!-- DOM elements container for interactive pins -->
              <div id="map-pins-container" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 3;"></div>
            </div>
            
            <!-- Side Panel: List of Available Stations in chosen Province -->
            <div class="station-list-panel" style="border-left: 1px solid rgba(255, 255, 255, 0.08); background: rgba(8, 12, 28, 0.85); display: flex; flex-direction: column; height: 100%;">
              <div style="padding: 16px; border-bottom: 1px solid rgba(255, 255, 255, 0.08); background: rgba(8, 12, 28, 0.95);">
                <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: #ffffff;">Danh Sách Trạm Sạc</h4>
                <p id="station-count-lbl" style="margin: 4px 0 0 0; font-size: 12px; color: #94a3b8;">Tìm thấy 5 trạm sạc gần bạn</p>
              </div>
              <div id="station-scroll-list" style="overflow-y: auto; flex-grow: 1; padding: 12px; display: flex; flex-direction: column; gap: 10px; max-height: 380px;">
                <!-- Station cards injected by JS -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Embedded EV Calculator Logic Script -->
  <script>
    const evModels = {
      'vf3': { capacity: 18.64, baseRange: 210, efficiency: 8.8, rentalPrice: 900000 },
      'vf5': { capacity: 37.23, baseRange: 326, efficiency: 11.4, rentalPrice: 1600000 },
      'vf6': { capacity: 59.6, baseRange: 399, efficiency: 14.9, rentalPrice: 1800000 },
      'vf7': { capacity: 75.3, baseRange: 431, efficiency: 17.4, rentalPrice: 2900000 },
      'vf8': { capacity: 82.0, baseRange: 425, efficiency: 19.3, rentalPrice: 2900000 },
      'vf9': { capacity: 92.0, baseRange: 626, efficiency: 14.7, rentalPrice: 3200000 }
    };

    let activeRangeModel = 'vf3';

    function switchEvTechTab(tabId) {
      document.querySelectorAll('.ev-tech-tab-btn').forEach(btn => btn.classList.remove('active'));
      document.querySelectorAll('.ev-tech-pane').forEach(pane => pane.classList.remove('active'));

      const activeBtn = Array.from(document.querySelectorAll('.ev-tech-tab-btn')).find(btn => btn.getAttribute('onclick').includes(tabId));
      if (activeBtn) activeBtn.classList.add('active');

      const activePane = document.getElementById('pane-' + tabId);
      if (activePane) activePane.classList.add('active');

      if (tabId === 'roi-calc') {
        calculateGreenROI();
      } else if (tabId === 'charging-map') {
        updateChargingStations();
      }
    }

    const provinceStations = {
      'hanoi': [
        { id: 'hn-1', name: 'Trạm sạc Vincom Nguyễn Chí Thanh', addr: '54A Nguyễn Chí Thanh, Láng Thượng, Đống Đa', distance: '0.8 km', x: '45%', y: '38%', plugs: { superfast: 4, fast: 8, ac: 4 } },
        { id: 'hn-2', name: 'Trạm sạc Royal City Megamall', addr: '72A Nguyễn Trãi, Thượng Đình, Thanh Xuân', distance: '1.5 km', x: '35%', y: '60%', plugs: { superfast: 2, fast: 12, ac: 8 } },
        { id: 'hn-3', name: 'Trạm sạc Ocean Park - TechnoPark', addr: 'Khu đô thị Vinhomes Ocean Park, Gia Lâm', distance: '12.4 km', x: '82%', y: '52%', plugs: { superfast: 8, fast: 16, ac: 12 } },
        { id: 'hn-4', name: 'Trạm sạc Landmark Tây Hồ', addr: 'Đường Xuân La, Xuân La, Tây Hồ', distance: '4.2 km', x: '48%', y: '18%', plugs: { superfast: 0, fast: 6, ac: 4 } },
        { id: 'hn-5', name: 'Trạm sạc Vincom Plaza Long Biên', addr: 'Khu đô thị Vinhomes Riverside, Long Biên', distance: '8.7 km', x: '72%', y: '28%', plugs: { superfast: 4, fast: 4, ac: 6 } }
      ],
      'hcm': [
        { id: 'hcm-1', name: 'Trạm sạc Landmark 81 Bình Thạnh', addr: '720A Điện Biên Phủ, Phường 22, Bình Thạnh', distance: '1.2 km', x: '65%', y: '45%', plugs: { superfast: 8, fast: 12, ac: 8 } },
        { id: 'hcm-2', name: 'Trạm sạc Vincom Center Đồng Khởi', addr: '72 Lê Thánh Tôn, Bến Nghé, Quận 1', distance: '2.1 km', x: '48%', y: '58%', plugs: { superfast: 4, fast: 6, ac: 4 } },
        { id: 'hcm-3', name: 'Trạm sạc Vinhomes Grand Park Q9', addr: 'Nguyễn Xiển, Long Thạnh Mỹ, Quận 9', distance: '16.5 km', x: '85%', y: '28%', plugs: { superfast: 6, fast: 16, ac: 10 } },
        { id: 'hcm-4', name: 'Trạm sạc Crescent Mall Quận 7', addr: '101 Tôn Dật Tiên, Tân Phú, Quận 7', distance: '5.8 km', x: '52%', y: '82%', plugs: { superfast: 2, fast: 8, ac: 6 } },
        { id: 'hcm-5', name: 'Trạm sạc Aeon Mall Tân Phú', addr: '30 Bờ Bao Tân Thắng, Sơn Kỳ, Tân Phú', distance: '9.3 km', x: '20%', y: '35%', plugs: { superfast: 0, fast: 10, ac: 4 } }
      ],
      'danang': [
        { id: 'dn-1', name: 'Trạm sạc Vincom Plaza Ngô Quyền', addr: '910A Ngô Quyền, An Hải Bắc, Sơn Trà', distance: '0.5 km', x: '52%', y: '42%', plugs: { superfast: 4, fast: 8, ac: 4 } },
        { id: 'dn-2', name: 'Trạm sạc Sân Bay Quốc Tế Đà Nẵng', addr: 'Đường Duy Tân, Hòa Thuận Tây, Hải Châu', distance: '2.3 km', x: '35%', y: '58%', plugs: { superfast: 2, fast: 6, ac: 4 } },
        { id: 'dn-3', name: 'Trạm sạc Hyatt Regency Resort', addr: '5 Trường Sa, Hòa Hải, Ngũ Hành Sơn', distance: '7.8 km', x: '78%', y: '85%', plugs: { superfast: 0, fast: 4, ac: 6 } }
      ],
      'haiphong': [
        { id: 'hp-1', name: 'Trạm sạc Vincom Imperia Hải Phòng', addr: 'Khu đô thị Vinhomes Imperia, Hồng Bàng', distance: '1.0 km', x: '42%', y: '45%', plugs: { superfast: 6, fast: 10, ac: 6 } },
        { id: 'hp-2', name: 'Trạm sạc Vincom Lê Thánh Tông', addr: '4 Lê Thánh Tông, Máy Tơ, Ngô Quyền', distance: '2.5 km', x: '58%', y: '52%', plugs: { superfast: 2, fast: 8, ac: 4 } },
        { id: 'hp-3', name: 'Trạm sạc Vinhomes Royal Island', addr: 'Đảo Vũ Yên, Thủy Nguyên, Hải Phòng', distance: '8.2 km', x: '78%', y: '28%', plugs: { superfast: 4, fast: 12, ac: 8 } }
      ],
      'cantho': [
        { id: 'ct-1', name: 'Trạm sạc Vincom Plaza Xuân Khánh', addr: '209 Đường 30 Tháng 4, Xuân Khánh, Ninh Kiều', distance: '0.9 km', x: '48%', y: '50%', plugs: { superfast: 4, fast: 6, ac: 4 } },
        { id: 'ct-2', name: 'Trạm sạc Vincom Plaza Hùng Vương', addr: '2 Hùng Vương, Thới Bình, Ninh Kiều', distance: '1.8 km', x: '55%', y: '35%', plugs: { superfast: 2, fast: 4, ac: 4 } },
        { id: 'ct-3', name: 'Trạm sạc Bến Xe Trung Tâm Cần Thơ', addr: 'Khu đô thị Nam Cần Thơ, Cái Răng', distance: '4.5 km', x: '68%', y: '78%', plugs: { superfast: 0, fast: 8, ac: 4 } }
      ]
    };

    let activeStationId = null;

    function updateChargingStations() {
      const province = document.getElementById('station-province-select').value;
      const filterSuper = document.getElementById('filter-superfast').checked;
      const filterFast = document.getElementById('filter-fast').checked;
      const filterAc = document.getElementById('filter-ac').checked;

      const stations = provinceStations[province] || [];
      
      // Filter stations by available plug types
      const filtered = stations.filter(st => {
        const hasSuper = filterSuper && st.plugs.superfast > 0;
        const hasFast = filterFast && st.plugs.fast > 0;
        const hasAc = filterAc && st.plugs.ac > 0;
        return hasSuper || hasFast || hasAc;
      });

      // Update count label
      document.getElementById('station-count-lbl').textContent = `Tìm thấy ${filtered.length} trạm sạc phù hợp`;

      // Update stats
      let totalPlugs = 0;
      filtered.forEach(st => {
        if (filterSuper) totalPlugs += st.plugs.superfast;
        if (filterFast) totalPlugs += st.plugs.fast;
        if (filterAc) totalPlugs += st.plugs.ac;
      });
      document.getElementById('stat-online').textContent = `${filtered.length}/${stations.length}`;
      document.getElementById('stat-available').textContent = `${totalPlugs} Trụ`;

      // Render scroll list
      const listContainer = document.getElementById('station-scroll-list');
      listContainer.innerHTML = '';
      
      // Render pins
      const pinContainer = document.getElementById('map-pins-container');
      pinContainer.innerHTML = '';

      if (filtered.length === 0) {
        listContainer.innerHTML = '<div style="text-align: center; padding: 24px; color: #94a3b8; font-size: 13px;">Không tìm thấy trạm sạc nào phù hợp với bộ lọc.</div>';
        hideRadarRing();
        return;
      }

      filtered.forEach((st, idx) => {
        const isActive = (activeStationId === st.id || (!activeStationId && idx === 0));
        if (isActive && !activeStationId) {
          activeStationId = st.id;
        }

        // 1. Add Card to List
        const card = document.createElement('div');
        card.className = `station-card ${isActive ? 'active' : ''}`;
        card.onclick = () => focusStation(st.id);
        
        let plugBadges = '';
        if (st.plugs.superfast > 0) plugBadges += `<span style="background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); font-size: 9.5px; padding: 2px 6px; border-radius: 4px; font-weight: 700;">Super 250kW: ${st.plugs.superfast}</span>`;
        if (st.plugs.fast > 0) plugBadges += `<span style="background: rgba(250, 204, 21, 0.15); color: #facc15; border: 1px solid rgba(250, 204, 21, 0.3); font-size: 9.5px; padding: 2px 6px; border-radius: 4px; font-weight: 700;">Fast 60kW: ${st.plugs.fast}</span>`;
        if (st.plugs.ac > 0) plugBadges += `<span style="background: rgba(255, 255, 255, 0.08); color: #cbd5e1; border: 1px solid rgba(255, 255, 255, 0.12); font-size: 9.5px; padding: 2px 6px; border-radius: 4px; font-weight: 700;">AC 11kW: ${st.plugs.ac}</span>`;

        card.innerHTML = `
          <div style="font-weight: 700; font-size: 13px; color: #ffffff; text-align: left;">${st.name}</div>
          <div style="font-size: 11px; color: #94a3b8; text-overflow: ellipsis; white-space: nowrap; overflow: hidden; text-align: left;" title="${st.addr}">${st.addr}</div>
          <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 4px;">
            <div style="display: flex; flex-wrap: wrap; gap: 4px;">${plugBadges}</div>
            <span style="font-size: 11px; font-weight: 700; color: #00d2ff; flex-shrink:0;">${st.distance}</span>
          </div>
        `;
        listContainer.appendChild(card);

        // 2. Add Pin to Map
        const pin = document.createElement('div');
        pin.className = `map-pin ${isActive ? 'active' : ''}`;
        pin.style.left = st.x;
        pin.style.top = st.y;
        
        // Pin color by type
        let pinColor = '#1464f4'; // Default blue
        if (st.plugs.superfast > 0) pinColor = '#10b981'; // Green for superfast
        else if (st.plugs.fast > 0) pinColor = '#facc15'; // Gold/Yellow for fast
        
        pin.style.backgroundColor = pinColor;
        pin.style.color = pinColor;
        pin.onclick = () => focusStation(st.id);
        pinContainer.appendChild(pin);

        // Position radar ring on active station
        if (isActive) {
          positionRadarRing(st.x, st.y, pinColor);
        }
      });
    }

    function focusStation(stationId) {
      activeStationId = stationId;
      updateChargingStations();
      
      // Auto scroll active card to view
      setTimeout(() => {
        const activeCard = document.querySelector('.station-card.active');
        if (activeCard) {
          activeCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
      }, 50);
    }

    function positionRadarRing(xPercent, yPercent, color) {
      const mapSim = document.querySelector('.map-simulation');
      if (!mapSim) return;
      
      const width = mapSim.clientWidth;
      const height = mapSim.clientHeight;
      
      const xPx = (parseFloat(xPercent) / 100) * width;
      const yPx = (parseFloat(yPercent) / 100) * height;

      const ring1 = document.getElementById('radar-ring-1');
      const ring2 = document.getElementById('radar-ring-2');
      
      if (ring1 && ring2) {
        ring1.setAttribute('cx', xPx);
        ring1.setAttribute('cy', yPx);
        ring1.setAttribute('r', 10);
        ring1.setAttribute('stroke', color);
        ring1.setAttribute('opacity', '0.85');
        
        ring2.setAttribute('cx', xPx);
        ring2.setAttribute('cy', yPx);
        ring2.setAttribute('r', 10);
        ring2.setAttribute('stroke', color);
        ring2.setAttribute('opacity', '0.85');

        // Trigger CSS keyframe animation by dynamically altering SVG tags
        ring1.innerHTML = `<animate attributeName="r" values="5;45" dur="2s" repeatCount="indefinite" />
                           <animate attributeName="opacity" values="1;0" dur="2s" repeatCount="indefinite" />`;
                           
        ring2.innerHTML = `<animate attributeName="r" values="5;45" dur="2s" begin="1s" repeatCount="indefinite" />
                           <animate attributeName="opacity" values="1;0" dur="2s" begin="1s" repeatCount="indefinite" />`;
      }
    }

    function hideRadarRing() {
      const ring1 = document.getElementById('radar-ring-1');
      const ring2 = document.getElementById('radar-ring-2');
      if (ring1 && ring2) {
        ring1.setAttribute('opacity', '0');
        ring2.setAttribute('opacity', '0');
        ring1.innerHTML = '';
        ring2.innerHTML = '';
      }
    }

    function selectRangeModel(modelId) {
      activeRangeModel = modelId;
      document.querySelectorAll('.range-calc-model-card').forEach(card => card.classList.remove('active'));
      const activeCard = document.querySelector(`.range-calc-model-card[data-model="${modelId}"]`);
      if (activeCard) activeCard.classList.add('active');
      
      updateRangeEstimation();
    }

    function updateRangeEstimation() {
      const speed = parseInt(document.getElementById('range-speed-slider').value);
      const temp = parseInt(document.getElementById('range-temp-slider').value);
      
      document.getElementById('range-speed-val').textContent = speed + ' km/h';
      document.getElementById('range-temp-val').textContent = temp + ' °C';

      const model = evModels[activeRangeModel];
      if (!model) return;

      // Speed efficiency factor
      let speedMod = 1.0;
      if (speed < 50) {
        speedMod = 1.0 - (50 - speed) * 0.003;
      } else if (speed > 70) {
        speedMod = 1.0 - (speed - 70) * 0.0045;
      }

      // Air Conditioner or temperature battery factor
      let tempMod = 1.0;
      if (temp > 25) {
        tempMod = 1.0 - (temp - 25) * 0.007; // AC load
      } else if (temp < 25) {
        tempMod = 1.0 - (25 - temp) * 0.003; // Cold battery chemistry
      }

      const calculatedRange = Math.round(model.baseRange * speedMod * tempMod);
      const displayRange = Math.max(30, Math.min(calculatedRange, Math.round(model.baseRange * 1.05)));

      document.getElementById('range-calculated-val').textContent = displayRange;

      // Declare ratio
      const ratio = Math.min(1.0, displayRange / model.baseRange);

      // Update dynamic cockpit metrics
      const effPercent = Math.round(ratio * 100);
      const dynamicEfficiency = (model.efficiency / (speedMod * tempMod)).toFixed(1);
      const chargeTime = Math.round(25 + (model.capacity * 0.12));
      
      document.getElementById('range-metric-efficiency').textContent = effPercent + '%';
      document.getElementById('range-metric-consumption').textContent = dynamicEfficiency + ' kWh/100km';
      document.getElementById('range-metric-charge').textContent = chargeTime + ' phút';

      // Update dynamic border color for efficiency item
      const effItem = document.getElementById('metric-item-eff');
      const effVal = document.getElementById('range-metric-efficiency');
      if (effItem && effVal) {
        if (effPercent >= 95) {
          effItem.style.borderColor = '#10b981';
          effVal.style.color = '#10b981';
        } else if (effPercent >= 80) {
          effItem.style.borderColor = '#f59e0b';
          effVal.style.color = '#f59e0b';
        } else {
          effItem.style.borderColor = '#ef4444';
          effVal.style.color = '#ef4444';
        }
      }

      // Update stroke-dashoffset of circle SVG ring (circumference is 565.48)
      const offset = 565.48 * (1.0 - ratio);
      document.getElementById('range-circle-progress').style.strokeDashoffset = offset;
    }

    function calculateGreenROI() {
      const selectedModel = document.getElementById('roi-car-select').value;
      const gasCategory = parseFloat(document.getElementById('roi-gas-select').value);
      const distance = parseInt(document.getElementById('roi-distance-slider').value);

      document.getElementById('roi-distance-val').textContent = distance.toLocaleString() + ' km';

      const model = evModels[selectedModel];
      if (!model) return;

      // Format current model selected in dropdown options for ROI sync
      document.getElementById('roi-battery-cost-val').textContent = model.rentalPrice.toLocaleString() + ' VND / tháng';

      // 1. Gas cost calculation
      const gasPrice = 23000;
      const monthlyGasCost = Math.round((distance / 100) * gasCategory * gasPrice);

      // 2. EV cost calculation (electricity sạc)
      const electricityPrice = 3858;
      const monthlyChargingCost = Math.round((distance / 100) * model.efficiency * electricityPrice);
      const monthlyEvCost = monthlyChargingCost + model.rentalPrice;

      // 3. Savings
      const monthlySavings = monthlyGasCost - monthlyEvCost;
      const annualSavings = monthlySavings * 12;

      document.getElementById('roi-gas-cost-val').textContent = monthlyGasCost.toLocaleString() + ' VND';
      document.getElementById('roi-ev-cost-val').textContent = monthlyEvCost.toLocaleString() + ' VND';
      
      const savingsValEl = document.getElementById('roi-savings-val');
      if (monthlySavings > 0) {
        savingsValEl.textContent = monthlySavings.toLocaleString() + ' VND / Tháng';
        savingsValEl.style.color = 'var(--color-ev-green-hover)';
        document.getElementById('roi-savings-annual-val').textContent = annualSavings.toLocaleString() + ' VND';
      } else {
        savingsValEl.textContent = 'Đang hòa vốn';
        savingsValEl.style.color = 'var(--color-text-dark)';
        document.getElementById('roi-savings-annual-val').textContent = '0 VND';
      }

      // CO2 trees calculation (gas car = 120g CO2/km, EV = 0g direct)
      const co2SavedKg = distance * 0.12; 
      const treesPerYear = Math.max(1, Math.round((co2SavedKg * 12) / 22)); 
      document.getElementById('roi-trees-val').textContent = treesPerYear;
    }

    // Call range initializer on load
    document.addEventListener('DOMContentLoaded', () => {
      updateRangeEstimation();
    });
    
    // Add window resize listener to keep map radar ring updated
    window.addEventListener('resize', () => {
      const activeBtn = document.querySelector('.ev-tech-tab-btn.active');
      if (activeBtn && activeBtn.getAttribute('onclick').includes('charging-map') && activeStationId) {
        // Redraw focused station radar rings
        const province = document.getElementById('station-province-select').value;
        const stations = provinceStations[province] || [];
        const st = stations.find(s => s.id === activeStationId);
        if (st) {
          let pinColor = '#1464f4';
          if (st.plugs.superfast > 0) pinColor = '#10b981';
          else if (st.plugs.fast > 0) pinColor = '#facc15';
          positionRadarRing(st.x, st.y, pinColor);
        }
      }
    });
  </script>