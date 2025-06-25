document.addEventListener("DOMContentLoaded", () => {
  const tourIdInput = document.getElementById('tourId');
  if (!tourIdInput || !window.startDateUrl) {
    console.error("Không tìm thấy tourId hoặc startDateUrl");
    return;
  }

  const tourId = tourIdInput.value;
  const url = window.startDateUrl.replace('TOUR_ID_PLACEHOLDER', tourId);

  let dummyData = {};
  let currentMonth = '';

  let availableMonths = [];

  const prevBtn = document.getElementById('prevMonthBtn');
  const nextBtn = document.getElementById('nextMonthBtn');

  fetch(url)
    .then(response => {
      if (!response.ok) throw new Error('Lỗi response');
      return response.json();
    })
    .then(data => {
      dummyData = processData(data);
      availableMonths = Object.keys(dummyData).sort((a, b) => compareMonthYear(a, b));
      currentMonth = availableMonths.length > 0 ? availableMonths[0] : '';

      renderMonths();
      renderCalendar();
      updateNavButtons();

      setupMonthNavigation();
    })
    .catch(error => {
      console.error("❌ Lỗi khi tải dữ liệu từ Laravel:", error);
    });

  // So sánh tháng theo định dạng "MM/YYYY" để sort đúng
  function compareMonthYear(a, b) {
    const [m1, y1] = a.split('/').map(Number);
    const [m2, y2] = b.split('/').map(Number);
    if (y1 !== y2) return y1 - y2;
    return m1 - m2;
  }

  // Chuyển dữ liệu API thành dạng { "MM/YYYY": [items] }
  function processData(data) {
    const formatted = {};
    data.forEach(item => {
      const startDate = new Date(item.startDate);
      const monthNum = (startDate.getMonth() + 1).toString().padStart(2, '0');
      const key = `${monthNum}/${startDate.getFullYear()}`;
      const hasPromo = item.promotion != null;
      const discount = hasPromo ? item.promotion.discount : 0;

      if (!formatted[key]) formatted[key] = [];

      formatted[key].push({
        day: startDate.getDate(),
        dateId: item.dateId,
        priceAdult: item.priceAdult,
        priceChildren: item.priceChildren,
        quantity: item.quantity,
        gift: hasPromo,
        promotionDescription: hasPromo ? item.promotion.description : null,
        promotionDiscount: discount, // thêm trường này để tính lại giá
        startDate: item.startDate,
        endDate: item.endDate,
      });
    });
    return formatted;
  }

  // Hiển thị danh sách tháng ở trên, click đổi tháng
  function renderMonths() {
    const monthSelector = document.getElementById('monthSelector');
    if (!monthSelector) return;

    monthSelector.innerHTML = '';

    availableMonths.forEach(month => {
      const div = document.createElement('div');
      div.className = 'month' + (month === currentMonth ? ' active' : '');
      div.textContent = month;
      div.style.cursor = 'pointer';
      div.onclick = () => {
        currentMonth = month;
        renderMonths();
        renderCalendar();
        updateNavButtons();
        clearBookingInfo();
      };
      monthSelector.appendChild(div);
    });
  }

  // Hiển thị lịch tháng, giá sẽ tùy theo ngày hiện tại có nằm trong khuyến mãi hay không
  function renderCalendar() {
    const label = document.getElementById('monthLabel');
    const daysContainer = document.getElementById('calendarDays');
    if (!label || !daysContainer) return;

    daysContainer.innerHTML = '';

    if (!currentMonth) {
      label.textContent = 'Không có dữ liệu';
      return;
    }

    label.textContent = 'THÁNG ' + currentMonth;

    const [monthStr, year] = currentMonth.split('/');
    const month = parseInt(monthStr, 10);
    const daysInMonth = new Date(year, month, 0).getDate();
    const firstDayOffset = new Date(year, month - 1, 1).getDay();

    // Chuyển Sunday (0) thành 6 để bắt đầu từ thứ 2
    const offset = firstDayOffset === 0 ? 6 : firstDayOffset - 1;

    const today = new Date();
    today.setHours(0,0,0,0);

    // Tạo khoảng trống đầu tuần
    for (let i = 0; i < offset; i++) {
      const emptyDiv = document.createElement('div');
      emptyDiv.className = 'empty-day';
      daysContainer.appendChild(emptyDiv);
    }

    // Tạo các ngày trong tháng
    for (let d = 1; d <= daysInMonth; d++) {
      const dayDiv = document.createElement('div');
      dayDiv.className = 'day';

      const info = dummyData[currentMonth]?.find(item => item.day === d);

      if (info) {
        const start = new Date(info.startDate);
        const end = new Date(info.endDate);
        start.setHours(0,0,0,0);
        end.setHours(23,59,59,999);

        const isInPromotion = (today >= start && today <= end);

        const priceAdultToShow = isInPromotion && info.gift
          ? Math.floor(info.priceAdult * (100 - info.promotionDiscount) / 100)
          : info.priceAdult;

        const giftIcon = isInPromotion && info.gift ? '🎁' : '';

        dayDiv.innerHTML = `
          <span title="${isInPromotion ? info.promotionDescription ?? '' : ''}">${info.day} ${giftIcon}</span>
          <div class="price">${priceAdultToShow.toLocaleString()}₫</div>
        `;

        dayDiv.style.cursor = 'pointer';

        dayDiv.onclick = () => {
          highlightSelectedDay(d);
          updateBookingInfo(info);
          dayDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
        };
      } else {
        dayDiv.textContent = d;
        dayDiv.style.color = '#999';
      }

      daysContainer.appendChild(dayDiv);
    }
  }

  // Tô màu ngày được chọn
  function highlightSelectedDay(day) {
    const dayDivs = document.querySelectorAll('#calendarDays .day');
    dayDivs.forEach(div => {
      div.classList.remove('selected-day');
      const span = div.querySelector('span');
      if (span && Number(span.textContent.trim()) === day) {
        div.classList.add('selected-day');
      }
    });
  }

  // Xóa thông tin booking khi đổi tháng hoặc reset
  function clearBookingInfo() {
    const fields = ['startDateInput', 'endDateInput', 'durationText', 'priceAdult', 'priceChildren', 'quantityText', 'dateId'];
    fields.forEach(id => {
      const el = document.getElementById(id);
      if (!el) return;
      if (el.tagName === 'INPUT') el.value = '';
      else el.textContent = '';
    });
  }

  // Cập nhật thông tin booking khi chọn ngày
  function updateBookingInfo(info) {
    const start = new Date(info.startDate);
    const end = new Date(info.endDate);

    start.setHours(0,0,0,0);
    end.setHours(23,59,59,999);

    const today = new Date();
    today.setHours(0,0,0,0);

    const startDateInput = document.getElementById('startDateInput');
    const endDateInput = document.getElementById('endDateInput');
    const durationText = document.getElementById('durationText');
    const priceAdult = document.getElementById('priceAdult');
    const priceChildren = document.getElementById('priceChildren');
    const quantityText = document.getElementById('quantityText');
    const dateIdInput = document.getElementById('dateId');

    if (startDateInput) startDateInput.value = start.toISOString().split('T')[0];
    if (endDateInput) endDateInput.value = end.toISOString().split('T')[0];

    const diffDays = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
    const nights = diffDays > 1 ? diffDays - 1 : 0;

    if (durationText) durationText.textContent = `${diffDays} Ngày ${nights} Đêm`;

    const isInPromotion = (today >= start && today <= end);
    const promoDiscount = info.promotionDiscount ?? 0;

    const adultPriceToShow = isInPromotion
      ? Math.floor(info.priceAdult * (100 - promoDiscount) / 100)
      : info.priceAdult;

    const childrenPriceToShow = isInPromotion
      ? Math.floor(info.priceChildren * (100 - promoDiscount) / 100)
      : info.priceChildren;

    if (priceAdult) priceAdult.textContent = `${adultPriceToShow.toLocaleString()}₫`;
    if (priceChildren) priceChildren.textContent = `${childrenPriceToShow.toLocaleString()}₫`;
    if (quantityText) quantityText.textContent = `${info.quantity}`;
    if (dateIdInput) dateIdInput.value = info.dateId;
  }

  // Cập nhật trạng thái nút chuyển tháng
  function updateNavButtons() {
    if (!prevBtn || !nextBtn) return;
    const currentIndex = availableMonths.indexOf(currentMonth);
    prevBtn.disabled = currentIndex <= 0;
    nextBtn.disabled = currentIndex === -1 || currentIndex >= availableMonths.length - 1;
  }

  // Gán sự kiện click cho nút chuyển tháng
  function setupMonthNavigation() {
    if (prevBtn) {
      prevBtn.addEventListener('click', () => {
        const currentIndex = availableMonths.indexOf(currentMonth);
        if (currentIndex > 0) {
          currentMonth = availableMonths[currentIndex - 1];
          renderMonths();
          renderCalendar();
          updateNavButtons();
          clearBookingInfo();
        }
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', () => {
        const currentIndex = availableMonths.indexOf(currentMonth);
        if (currentIndex < availableMonths.length - 1) {
          currentMonth = availableMonths[currentIndex + 1];
          renderMonths();
          renderCalendar();
          updateNavButtons();
          clearBookingInfo();
        }
      });
    }
  }
});
