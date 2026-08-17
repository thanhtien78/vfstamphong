  <!-- SECTION 1: HERO STAGE (Slider Carousel) -->
  <section class="hero-stage">
    <div class="hero-slider" id="hero-carousel">
      <div class="hero-slides-container">
        
        <!-- SLIDE 1: THU NHẬP HIỆU QUẢ (VF 5 PLUS) -->
        <?php 
        $heroImg = $settings['hero_banner_image'] ?? "assets/uploads/vinfast-banner-thu-nhap.webp"; 
        ?>
        <div class="hero-slide active" style="background-image: url('<?php echo htmlspecialchars($heroImg); ?>');">
          <div class="container" style="width: 100%; max-width: 1200px; margin: 0 auto; padding: 0 20px; position: relative; height: 100%;">
            <div class="hero-flex-wrapper">
              <div class="hero-content">
                <span class="spotlight-tag">CHINH PHỤC MỌI NẺO ĐƯỜNG</span>
                <h1 class="hero-headline"><?php echo htmlspecialchars($heroHeadline); ?></h1>
                <p class="hero-subline"><?php echo htmlspecialchars($heroSubline); ?></p>
                <div class="hero-ctas">
                  <a href="xe-vinfast/vinfast-vf-5-plus" class="btn-primary" style="padding: 14px 28px; border-radius: 30px; font-weight: 700; text-decoration: none; text-align: center; font-size: 13.5px;"><?php echo htmlspecialchars($heroBtn1); ?></a>
                  <a href="#catalog-block" class="btn-secondary" style="padding: 14px 28px; border-radius: 30px; font-weight: 700; text-decoration: none; text-align: center; font-size: 13.5px;">Bảng giá xe mới</a>
                </div>
              </div>
              <div class="hero-hud-card">
                <div class="hud-header">
                  <span class="hud-title">VF 5 SPECIFICATIONS</span>
                  <span class="hud-badge">HUD ACTIVE</span>
                </div>
                <div class="hud-specs-list">
                  <div class="hud-spec-row">
                    <div class="hud-spec-icon-box">🧭</div>
                    <div class="hud-spec-info">
                      <span class="hud-spec-val">326 KM</span>
                      <span class="hud-spec-lbl">Quãng đường sạc đầy (NEDC)</span>
                    </div>
                  </div>
                  <div class="hud-spec-row">
                    <div class="hud-spec-icon-box">⚡</div>
                    <div class="hud-spec-info">
                      <span class="hud-spec-val">30 PHÚT</span>
                      <span class="hud-spec-lbl">Sạc nhanh DC (10 - 70%)</span>
                    </div>
                  </div>
                  <div class="hud-spec-row">
                    <div class="hud-spec-icon-box">🚀</div>
                    <div class="hud-spec-info">
                      <span class="hud-spec-val">9.0 GIÂY</span>
                      <span class="hud-spec-lbl">Tăng tốc từ 0 - 100 km/h</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- SLIDE 2: LÊN ĐỜI BỐN BÁNH (VF 8) -->
        <div class="hero-slide" style="background-image: url('assets/uploads/vinfast-banner-len-doi.webp');">
          <div class="container" style="width: 100%; max-width: 1200px; margin: 0 auto; padding: 0 20px; position: relative; height: 100%;">
            <div class="hero-flex-wrapper">
              <div class="hero-content">
                <span class="spotlight-tag">ĐẶC QUYỀN THU CŨ ĐỔI MỚI</span>
                <h2 class="hero-headline">LÊN ĐỜI BỐN BÁNH</h2>
                <p class="hero-subline">Lên cấp trải nghiệm di chuyển thời thượng và an tâm tuyệt đối trên mọi hành trình cùng dải SUV điện VinFast.</p>
                <div class="hero-ctas">
                  <a href="xe-vinfast/vinfast-vf-8" class="btn-primary" style="padding: 14px 28px; border-radius: 30px; font-weight: 700; text-decoration: none; text-align: center; font-size: 13.5px;">Khám phá VF 8</a>
                  <a href="#tradein-block" class="btn-secondary" style="padding: 14px 28px; border-radius: 30px; font-weight: 700; text-decoration: none; text-align: center; font-size: 13.5px;">Định giá xe cũ</a>
                </div>
              </div>
              <div class="hero-hud-card">
                <div class="hud-header">
                  <span class="hud-title">VF 8 SPECIFICATIONS</span>
                  <span class="hud-badge">HUD ACTIVE</span>
                </div>
                <div class="hud-specs-list">
                  <div class="hud-spec-row">
                    <div class="hud-spec-icon-box">🧭</div>
                    <div class="hud-spec-info">
                      <span class="hud-spec-val">425 KM</span>
                      <span class="hud-spec-lbl">Quãng đường sạc đầy (WLTP)</span>
                    </div>
                  </div>
                  <div class="hud-spec-row">
                    <div class="hud-spec-icon-box">⚡</div>
                    <div class="hud-spec-info">
                      <span class="hud-spec-val">24 PHÚT</span>
                      <span class="hud-spec-lbl">Sạc siêu nhanh (10 - 70%)</span>
                    </div>
                  </div>
                  <div class="hud-spec-row">
                    <div class="hud-spec-icon-box">🚀</div>
                    <div class="hud-spec-info">
                      <span class="hud-spec-val">5.5 GIÂY</span>
                      <span class="hud-spec-lbl">Tăng tốc từ 0 - 100 km/h</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- SLIDE 3: ƯU ĐÃI CHÀO HÈ (VF 6) -->
        <div class="hero-slide" style="background-image: url('assets/uploads/vinfast-banner-uu-dai.webp');">
          <div class="container" style="width: 100%; max-width: 1200px; margin: 0 auto; padding: 0 20px; position: relative; height: 100%;">
            <div class="hero-flex-wrapper">
              <div class="hero-content">
                <span class="spotlight-tag">GIẢI NHIỆT ĐÓN HÈ 2026</span>
                <h2 class="hero-headline">ƯU ĐÃI CHÀO HÈ</h2>
                <p class="hero-subline">Cơ hội vàng sở hữu xe điện thông minh VinFast với hàng loạt chương trình trợ giá lăn bánh đặc quyền.</p>
                <div class="hero-ctas">
                  <a href="xe-vinfast/vinfast-vf-6" class="btn-primary" style="padding: 14px 28px; border-radius: 30px; font-weight: 700; text-decoration: none; text-align: center; font-size: 13.5px;">Khám phá VF 6</a>
                  <a href="#catalog-block" class="btn-secondary" style="padding: 14px 28px; border-radius: 30px; font-weight: 700; text-decoration: none; text-align: center; font-size: 13.5px;">Nhận ưu đãi ngay</a>
                </div>
              </div>
              <div class="hero-hud-card">
                <div class="hud-header">
                  <span class="hud-title">VF 6 SPECIFICATIONS</span>
                  <span class="hud-badge">HUD ACTIVE</span>
                </div>
                <div class="hud-specs-list">
                  <div class="hud-spec-row">
                    <div class="hud-spec-icon-box">🧭</div>
                    <div class="hud-spec-info">
                      <span class="hud-spec-val">399 KM</span>
                      <span class="hud-spec-lbl">Quãng đường sạc đầy (WLTP)</span>
                    </div>
                  </div>
                  <div class="hud-spec-row">
                    <div class="hud-spec-icon-box">⚡</div>
                    <div class="hud-spec-info">
                      <span class="hud-spec-val">22 PHÚT</span>
                      <span class="hud-spec-lbl">Sạc nhanh DC (10 - 70%)</span>
                    </div>
                  </div>
                  <div class="hud-spec-row">
                    <div class="hud-spec-icon-box">🚀</div>
                    <div class="hud-spec-info">
                      <span class="hud-spec-val">8.5 GIÂY</span>
                      <span class="hud-spec-lbl">Tăng tốc từ 0 - 100 km/h</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <!-- Carousel Arrows -->
      <div class="slider-arrow slider-arrow-prev" onclick="moveHeroSlide(-1)">
        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5">
          <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
      </div>
      <div class="slider-arrow slider-arrow-next" onclick="moveHeroSlide(1)">
        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5">
          <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
      </div>

      <!-- Carousel Dots -->
      <div class="slider-dots">
        <div class="slider-dot active" onclick="setHeroSlide(0)"></div>
        <div class="slider-dot" onclick="setHeroSlide(1)"></div>
        <div class="slider-dot" onclick="setHeroSlide(2)"></div>
      </div>
    </div>
  </section>
  
  <script>
    let heroCurrentIndex = 0;
    let heroAutoplayTimer = null;
    
    function showHeroSlide(index) {
      const slides = document.querySelectorAll('.hero-slide');
      const dots = document.querySelectorAll('.slider-dot');
      if (slides.length === 0) return;
      
      if (index >= slides.length) heroCurrentIndex = 0;
      else if (index < 0) heroCurrentIndex = slides.length - 1;
      else heroCurrentIndex = index;
      
      slides.forEach((slide, i) => {
        if (i === heroCurrentIndex) {
          slide.classList.add('active');
        } else {
          slide.classList.remove('active');
        }
      });
      
      dots.forEach((dot, i) => {
        if (i === heroCurrentIndex) {
          dot.classList.add('active');
        } else {
          dot.classList.remove('active');
        }
      });
    }
    
    function moveHeroSlide(step) {
      showHeroSlide(heroCurrentIndex + step);
      resetHeroAutoplay();
    }
    
    function setHeroSlide(index) {
      showHeroSlide(index);
      resetHeroAutoplay();
    }
    
    function startHeroAutoplay() {
      heroAutoplayTimer = setInterval(() => {
        showHeroSlide(heroCurrentIndex + 1);
      }, 6000);
    }
    
    function resetHeroAutoplay() {
      clearInterval(heroAutoplayTimer);
      startHeroAutoplay();
    }
    
    document.addEventListener('DOMContentLoaded', () => {
      startHeroAutoplay();
      
      const carousel = document.getElementById('hero-carousel');
      if (carousel) {
        carousel.addEventListener('mouseenter', () => clearInterval(heroAutoplayTimer));
        carousel.addEventListener('mouseleave', () => startHeroAutoplay());
      }
    });
  </script>