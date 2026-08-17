// Smooth horizontal compare table scroll trigger
    function scrollTableToRight() {
      const tableDiv = document.getElementById("vinfast-compare-scrollable-table");
      if (tableDiv) {
        const scrollAmount = 320;
        const currentScroll = tableDiv.scrollLeft;
        const maxScroll = tableDiv.scrollWidth - tableDiv.clientWidth;
        
        if (currentScroll >= maxScroll - 5) {
          tableDiv.scrollTo({ left: 0, behavior: "smooth" });
        } else {
          tableDiv.scrollTo({ left: currentScroll + scrollAmount, behavior: "smooth" });
        }
      }
    }

    // Interactive Color Visualizer dynamic swapping
    function changeCarColor(dot) {
      const card = dot.closest('.car-card');
      if (!card) return;
      
      const dots = card.querySelectorAll('.color-dot');
      dots.forEach(d => {
        d.classList.remove('active');
        d.style.boxShadow = '0 0 0 1px rgba(0,0,0,0.15)';
      });
      
      dot.classList.add('active');
      dot.style.boxShadow = '0 0 0 2px var(--color-ev-green)';
      
      const filterVal = dot.getAttribute('data-filter');
      const colorName = dot.getAttribute('data-color-name');
      
      const img = card.querySelector('.car-card__img');
      if (img) {
        img.style.transition = 'filter 0.4s ease';
        if (filterVal === 'none') {
          img.style.filter = '';
        } else {
          img.style.filter = filterVal;
        }
      }
      
      const label = card.querySelector('.active-color-name');
      if (label) {
        label.textContent = colorName;
      }
    }

    // Dynamic front-end product card filtration with premium staggered animation
    function filterHomeCatalog(type, e) {
      const tabs = document.querySelectorAll('.filter-tab-btn');
      tabs.forEach(tab => tab.classList.remove('filter-tab-btn--active'));
      
      const evt = e || window.event;
      if (evt && evt.currentTarget) {
        evt.currentTarget.classList.add('filter-tab-btn--active');
      }

      // Smooth scroll to filter tabs container with sticky header offset (140px to account for header + marquee banner)
      const filterTabs = document.querySelector('.filter-tabs');
      if (filterTabs) {
        const headerOffset = 140; 
        const elementPosition = filterTabs.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
        
        window.scrollTo({
          top: offsetPosition,
          behavior: 'smooth'
        });
      }

      const cards = document.querySelectorAll('.car-card');
      let visibleIndex = 0; // For staggered delay calculation
      
      cards.forEach(card => {
        // Set premium ease transitions for both scale and opacity
        card.style.transition = 'opacity 0.4s cubic-bezier(0.25, 1, 0.5, 1), transform 0.4s cubic-bezier(0.25, 1, 0.5, 1)';
        
        const group = card.getAttribute('data-group');
        const isMatch = (type === 'all' || group === type);
        
        if (isMatch) {
          card.style.setProperty('display', 'flex', 'important');
          card.style.opacity = '0';
          card.style.transform = 'translateY(15px) scale(0.97)';
          
          // Staggered entry wave
          setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0) scale(1)';
          }, 50 + (visibleIndex * 60)); // 60ms increment delay
          
          visibleIndex++;
        } else {
          card.style.opacity = '0';
          card.style.transform = 'translateY(15px) scale(0.97)';
          setTimeout(() => {
            card.style.setProperty('display', 'none', 'important');
          }, 250);
        }
      });
    }

    // Make entire car card clickable to navigate to detail page (except interactive buttons)
    document.addEventListener('DOMContentLoaded', function() {
      const grid = document.getElementById('catalog-grid-container');
      if (grid) {
        grid.addEventListener('click', function(e) {
          const card = e.target.closest('.car-card');
          if (!card) return;
          
          // Ignore clicks on color dots, Zalo button, and category badge
          if (e.target.closest('.color-dot') || e.target.closest('.btn-zalo-card') || e.target.closest('.car-card__badge')) {
            return;
          }
          
          const detailBtn = card.querySelector('.btn-detail-card');
          if (detailBtn) {
            window.location.href = detailBtn.href;
          }
        });
      }
    });

    // Dynamic Loan & Installment Calculator logic
    let amortizationVisible = false;

    function selectBankPackage(rate, button) {
      // Remove active class from other pills
      const pills = document.querySelectorAll('.bank-pill-btn');
      pills.forEach(p => p.classList.remove('bank-pill-btn--active'));
      
      // Add active class to selected pill
      if (button) {
        button.classList.add('bank-pill-btn--active');
      }
      
      // Update slider and number input
      document.getElementById('calc_interest').value = rate;
      document.getElementById('calc_interest_num').value = rate;
      
      // Re-calculate
      updateLoanCalculator();
    }

    function syncInterestSlider(val) {
      let num = parseFloat(val);
      if (isNaN(num)) return;
      if (num < 4) num = 4;
      if (num > 15) num = 15;
      
      // De-activate pre-set pills since they customized it
      const pills = document.querySelectorAll('.bank-pill-btn');
      pills.forEach(p => p.classList.remove('bank-pill-btn--active'));
      
      document.getElementById('calc_interest').value = num;
      updateLoanCalculator();
    }

    function syncInterestInput(val) {
      document.getElementById('calc_interest_num').value = val;
      
      // De-activate pre-set pills since they customized it
      const pills = document.querySelectorAll('.bank-pill-btn');
      pills.forEach(p => p.classList.remove('bank-pill-btn--active'));
      
      updateLoanCalculator();
    }

    function toggleAmortizationSchedule() {
      const container = document.getElementById('amortization_schedule_container');
      if (amortizationVisible) {
        container.style.display = 'none';
        amortizationVisible = false;
      } else {
        container.style.display = 'block';
        amortizationVisible = true;
        // Make sure it calculates
        updateLoanCalculator();
      }
    }

    function updateLoanCalculator() {
      const selectEl = document.getElementById('calc_car_select');
      const prepayEl = document.getElementById('calc_prepay');
      const yearsEl = document.getElementById('calc_years');
      const interestEl = document.getElementById('calc_interest');
      
      if (!selectEl || !prepayEl || !yearsEl || !interestEl) {
        return; // Guard: Calculator elements not present on this page
      }

      const carPrice = parseFloat(selectEl.value);
      const prepayPercent = parseFloat(prepayEl.value);
      const years = parseInt(yearsEl.value);
      const annualRate = parseFloat(interestEl.value) / 100;
      
      document.getElementById('calc_prepay_lbl').textContent = prepayPercent + '%';
      document.getElementById('calc_years_lbl').textContent = years + ' năm';
      document.getElementById('calc_interest_lbl').textContent = (annualRate * 100).toFixed(1) + '%';
      
      const prepayAmount = carPrice * (prepayPercent / 100);
      const loanAmount = carPrice - prepayAmount;
      
      const months = years * 12;
      
      // Calculate first month total (Principal + Interest) on declining balance method
      const monthlyPrincipal = loanAmount / months;
      const monthlyInterestFirstMonth = loanAmount * (annualRate / 12);
      const monthlyTotalFirstMonth = monthlyPrincipal + monthlyInterestFirstMonth;
      
      document.getElementById('calc_res_prepay').textContent = Math.round(prepayAmount).toLocaleString('vi-VN') + 'đ';
      document.getElementById('calc_res_loan').textContent = Math.round(loanAmount).toLocaleString('vi-VN') + 'đ';
      
      // Display first month estimate
      document.getElementById('calc_res_monthly').textContent = Math.round(monthlyTotalFirstMonth).toLocaleString('vi-VN') + 'đ / tháng';
      
      // Generate amortization body
      const tbody = document.getElementById('amortization_tbody');
      if (tbody) {
        let html = '';
        let remainingBalance = loanAmount;
        
        // Show first 12 months
        const showMonths = Math.min(12, months);
        
        for (let i = 1; i <= showMonths; i++) {
          const interestMonth = remainingBalance * (annualRate / 12);
          const totalMonth = monthlyPrincipal + interestMonth;
          const endBalance = remainingBalance - monthlyPrincipal;
          
          html += `<tr style="border-bottom: 1px solid var(--color-border);">
            <td style="padding: 10px 14px;">Tháng ${i}</td>
            <td class="hide-on-mobile" style="padding: 10px 14px;">${Math.round(remainingBalance).toLocaleString('vi-VN')}đ</td>
            <td class="hide-on-mobile" style="padding: 10px 14px;">${Math.round(monthlyPrincipal).toLocaleString('vi-VN')}đ</td>
            <td class="hide-on-mobile" style="padding: 10px 14px;">${Math.round(interestMonth).toLocaleString('vi-VN')}đ</td>
            <td style="padding: 10px 14px; font-weight:600; color:#fff;">${Math.round(totalMonth).toLocaleString('vi-VN')}đ</td>
            <td style="padding: 10px 14px;">${Math.round(Math.max(0, endBalance)).toLocaleString('vi-VN')}đ</td>
          </tr>`;
          
          remainingBalance = endBalance;
        }
        
        if (months > 12) {
          html += `<tr>
            <td colspan="100%" style="padding: 14px; text-align: center; color: var(--color-gold); font-style: italic;">
              ... (Và các tháng tiếp theo dư nợ gốc & lãi giảm dần cho đến khi tất toán hoàn toàn gói vay) ...
            </td>
          </tr>`;
        }
        
        tbody.innerHTML = html;
      }
    }

    // Toggle FAQ Accordions
    function toggleFaq(button) {
      const faqItem = button.closest('.faq-item');
      const isActive = faqItem.classList.contains('faq-item--active');
      
      document.querySelectorAll('.faq-item').forEach(item => {
        item.classList.remove('faq-item--active');
      });
      
      if (!isActive) {
        faqItem.classList.add('faq-item--active');
      }
    }

    // Live Trade-in Estimator Logic
    function updateLiveEstimate() {
      const oldBrand = document.getElementById('old_brand');
      const targetCar = document.getElementById('target_car_id');
      const livePanel = document.getElementById('valuation-live-card');
      const estimatedText = document.getElementById('valuation-estimated-text');

      if (!oldBrand || !targetCar || !livePanel || !estimatedText) return;

      const brandVal = oldBrand.value;
      const targetVal = targetCar.options[targetCar.selectedIndex]?.text || '';

      if (brandVal && targetVal && targetCar.value !== "") {
        livePanel.style.display = 'flex';
        
        let subsidyAmount = '30.000.000đ';
        let extraBenefit = 'Đặc quyền kiểm định và cam kết định giá tối ưu tại nhà.';
        
        if (brandVal === 'VinFast') {
          subsidyAmount = '50.000.000đ';
          extraBenefit = 'Ưu đãi đặc biệt dành riêng cho chủ sở hữu VinFast cũ nâng cấp (Loyalty Bonus).';
        } else if (['Mercedes-Benz', 'BMW', 'Lexus', 'Porsche'].includes(brandVal)) {
          subsidyAmount = '40.000.000đ';
          extraBenefit = 'Hỗ trợ trợ giá đặc quyền áp dụng riêng cho khách hàng lên đời xe điện thông minh VinFast.';
        } else if (brandVal === 'Khác') {
          subsidyAmount = '20.000.000đ';
          extraBenefit = 'Cam kết thu mua đa thương hiệu với mức giá tốt nhất để anh/chị đổi lên dòng xe VinFast đẳng cấp.';
        }
        
        let carModelName = targetVal.split('(')[0].trim();
        
        estimatedText.innerHTML = `<strong>Nhận gói trợ giá lên đời <span style="color: var(--color-gold); font-size: 14px; font-weight:700;">${subsidyAmount}</span></strong> từ chương trình Thu cũ đổi mới VinFast khi nâng cấp từ xe <strong>${brandVal === 'Khác' ? 'của hãng hiện tại' : brandVal}</strong> lên dòng xe mới <strong>${carModelName}</strong>. <br><span style="color: var(--color-text-muted); font-size: 11.5px; font-style: italic;">${extraBenefit}</span>`;
      } else {
        livePanel.style.display = 'none';
      }
    }

    // Attach listeners
    document.addEventListener('DOMContentLoaded', function() {
      const oldBrand = document.getElementById('old_brand');
      const targetCar = document.getElementById('target_car_id');
      if (oldBrand && targetCar) {
        oldBrand.addEventListener('change', updateLiveEstimate);
        targetCar.addEventListener('change', updateLiveEstimate);
      }
    });

    // Switch Stage Offer tabs
    function switchStageOffer(index) {
      // 1. Update active tab
      const tabs = document.querySelectorAll('.offers-stage-tab');
      tabs.forEach((tab, i) => {
        if (i === index) {
          tab.classList.add('offers-stage-tab--active');
        } else {
          tab.classList.remove('offers-stage-tab--active');
        }
      });

      // 2. Update active background image
      const bgs = document.querySelectorAll('.offers-stage-bg');
      bgs.forEach((bg, i) => {
        if (i === index) {
          bg.classList.add('offers-stage-bg--active');
        } else {
          bg.classList.remove('offers-stage-bg--active');
        }
      });

      // 3. Update active card details
      const cards = document.querySelectorAll('.offers-stage-card');
      cards.forEach((card, i) => {
        if (i === index) {
          card.classList.add('offers-stage-card--active');
        } else {
          card.classList.remove('offers-stage-card--active');
        }
      });
    }

    // Touch & Mouse Drag to Scroll for Compare Table
    document.addEventListener("DOMContentLoaded", function() {
      const slider = document.getElementById("vinfast-compare-scrollable-table");
      if (!slider) return;
      
      let isDown = false;
      let startX;
      let scrollLeft;
      
      // Mouse dragging (Desktop)
      slider.addEventListener("mousedown", (e) => {
        isDown = true;
        slider.classList.add("active");
        startX = e.pageX;
        scrollLeft = slider.scrollLeft;
      });
      
      slider.addEventListener("mouseleave", () => {
        isDown = false;
        slider.classList.remove("active");
      });
      
      slider.addEventListener("mouseup", () => {
        isDown = false;
        slider.classList.remove("active");
      });
      
      slider.addEventListener("mousemove", (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX;
        const walk = (x - startX) * 1.5; // Scroll speed multiplier
        slider.scrollLeft = scrollLeft - walk;
      });
      
      // Touch swiping (Mobile)
      slider.addEventListener("touchstart", (e) => {
        isDown = true;
        startX = e.touches[0].pageX;
        scrollLeft = slider.scrollLeft;
      }, { passive: true });
      
      slider.addEventListener("touchmove", (e) => {
        if (!isDown) return;
        const x = e.touches[0].pageX;
        const walk = (x - startX) * 1.5; // Scroll speed multiplier
        slider.scrollLeft = scrollLeft - walk;
      }, { passive: true });
      
      slider.addEventListener("touchend", () => {
        isDown = false;
      });
      
      slider.addEventListener("touchcancel", () => {
        isDown = false;
      });
    });

    // Initialize calculator values on page load
    window.addEventListener("load", function() {
      updateLoanCalculator();
      updateLiveEstimate();
    });