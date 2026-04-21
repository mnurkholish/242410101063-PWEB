const STORAGE_KEY = "pitstopBookings";

const serviceCatalog = {
  "Ganti Oli": { price: 350000, duration: 30 },
  "Servis Berkala": { price: 850000, duration: 120 },
  "Perbaikan Rem": { price: 275000, duration: 60 },
  "Tune Up Mesin": { price: 600000, duration: 90 },
  "Spooring Balancing": { price: 450000, duration: 60 },
  "Diagnosa Mesin": { price: 250000, duration: 45 },
};

const statusFlow = ["Menunggu", "Diproses", "Selesai"];

const createId = () => {
  if (window.crypto && typeof window.crypto.randomUUID === "function") {
    return window.crypto.randomUUID();
  }

  return `booking-${Date.now()}-${Math.random().toString(16).slice(2)}`;
};

const initialBookings = [
  {
    id: createId(),
    kodeBooking: "PS-001",
    namaPelanggan: "Budi Santoso",
    nomorPlat: "B 1234 XYZ",
    jenisKendaraan: "Mobil",
    merekKendaraan: "Toyota Avanza 2021",
    jenisService: ["Ganti Oli", "Diagnosa Mesin"],
    tanggalService: "2026-04-22",
    jamService: "09:00",
    estimasiBiaya: 600000,
    estimasiDurasi: 75,
    statusBooking: "Diproses",
  },
  {
    id: createId(),
    kodeBooking: "PS-002",
    namaPelanggan: "Siti Aminah",
    nomorPlat: "D 5678 ABC",
    jenisKendaraan: "SUV",
    merekKendaraan: "Honda HR-V 2020",
    jenisService: ["Servis Berkala"],
    tanggalService: "2026-04-22",
    jamService: "11:00",
    estimasiBiaya: 850000,
    estimasiDurasi: 120,
    statusBooking: "Menunggu",
  },
  {
    id: createId(),
    kodeBooking: "PS-003",
    namaPelanggan: "Raka Pratama",
    nomorPlat: "F 9012 IJ",
    jenisKendaraan: "Motor",
    merekKendaraan: "Yamaha NMAX 2022",
    jenisService: ["Perbaikan Rem", "Ganti Oli"],
    tanggalService: "2026-04-23",
    jamService: "13:00",
    estimasiBiaya: 625000,
    estimasiDurasi: 90,
    statusBooking: "Selesai",
  },
];

let bookings = [];

const bookingForm = document.querySelector("#bookingForm");
const bookingTableBody = document.querySelector("#bookingTableBody");
const emptyState = document.querySelector("#emptyState");
const searchInput = document.querySelector("#searchInput");
const filterService = document.querySelector("#filterService");
const filterStatus = document.querySelector("#filterStatus");
const submitButton = document.querySelector("#submitButton");
const resetButton = document.querySelector("#resetButton");
const formTitle = document.querySelector("#formTitle");
const formModeLabel = document.querySelector("#formModeLabel");
const serviceGroup = document.querySelector("#serviceGroup");
const kodePreview = document.querySelector("#kodePreview");
const estimasiPreview = document.querySelector("#estimasiPreview");
const durasiPreview = document.querySelector("#durasiPreview");
const statusPreview = document.querySelector("#statusPreview");
const serviceInputs = document.querySelectorAll('input[name="jenisService"]');

const fields = {
  bookingId: document.querySelector("#bookingId"),
  namaPelanggan: document.querySelector("#namaPelanggan"),
  nomorPlat: document.querySelector("#nomorPlat"),
  jenisKendaraan: document.querySelector("#jenisKendaraan"),
  merekKendaraan: document.querySelector("#merekKendaraan"),
  tanggalService: document.querySelector("#tanggalService"),
  jamService: document.querySelector("#jamService"),
};

const stats = {
  totalBooking: document.querySelector("#totalBooking"),
  totalEstimasi: document.querySelector("#totalEstimasi"),
  totalMenunggu: document.querySelector("#totalMenunggu"),
  totalSelesai: document.querySelector("#totalSelesai"),
};

const saveBookings = () => {
  localStorage.setItem(STORAGE_KEY, JSON.stringify(bookings));
};

const formatCurrency = (value) =>
  new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    maximumFractionDigits: 0,
  }).format(value);

const formatDate = (value) =>
  new Intl.DateTimeFormat("id-ID", {
    day: "2-digit",
    month: "short",
    year: "numeric",
  }).format(new Date(`${value}T00:00:00`));

const formatDuration = (minutes) => {
  if (minutes < 60) {
    return `${minutes} menit`;
  }

  const hours = Math.floor(minutes / 60);
  const remainingMinutes = minutes % 60;

  return remainingMinutes
    ? `${hours} jam ${remainingMinutes} menit`
    : `${hours} jam`;
};

const normalizeText = (value) => value.trim().toLowerCase();

const getTodayInputValue = () => {
  const today = new Date();
  const year = today.getFullYear();
  const month = String(today.getMonth() + 1).padStart(2, "0");
  const date = String(today.getDate()).padStart(2, "0");

  return `${year}-${month}-${date}`;
};

const getSelectedServices = () =>
  [...serviceInputs]
    .filter((input) => input.checked)
    .map((input) => input.value);

const calculateServiceSummary = (selectedServices) =>
  selectedServices.reduce(
    (summary, serviceName) => {
      const service = serviceCatalog[serviceName];

      return {
        price: summary.price + service.price,
        duration: summary.duration + service.duration,
      };
    },
    { price: 0, duration: 0 },
  );

const getNextBookingCode = () => {
  const biggestNumber = bookings.reduce((biggest, booking) => {
    const codeNumber = Number(booking.kodeBooking.replace(/\D/g, ""));
    return Number.isNaN(codeNumber) ? biggest : Math.max(biggest, codeNumber);
  }, 0);

  return `PS-${String(biggestNumber + 1).padStart(3, "0")}`;
};

const setError = (fieldName, message = "") => {
  if (fieldName === "jenisService") {
    serviceGroup.classList.toggle("invalid", Boolean(message));
    document.querySelector("#jenisServiceError").textContent = message;
    return;
  }

  const input = fields[fieldName];
  const formGroup = input.closest(".form-group");
  const errorLabel = document.querySelector(`#${fieldName}Error`);

  formGroup.classList.toggle("invalid", Boolean(message));
  errorLabel.textContent = message;
};

const clearErrors = () => {
  Object.keys(fields).forEach((fieldName) => setError(fieldName));
  setError("jenisService");
};

const getDateTime = (date, time) => new Date(`${date}T${time}:00`);

const getEndTime = (booking) => {
  const startTime = getDateTime(booking.tanggalService, booking.jamService);
  return new Date(startTime.getTime() + booking.estimasiDurasi * 60000);
};

const hasScheduleConflict = (candidate) => {
  const candidateStart = getDateTime(
    candidate.tanggalService,
    candidate.jamService,
  );
  const candidateEnd = getEndTime(candidate);

  return bookings.some((booking) => {
    if (
      booking.id === candidate.id ||
      booking.tanggalService !== candidate.tanggalService ||
      booking.statusBooking === "Selesai"
    ) {
      return false;
    }

    const existingStart = getDateTime(
      booking.tanggalService,
      booking.jamService,
    );
    const existingEnd = getEndTime(booking);

    return candidateStart < existingEnd && candidateEnd > existingStart;
  });
};

const getFormData = () => {
  const selectedServices = getSelectedServices();
  const serviceSummary = calculateServiceSummary(selectedServices);
  const existingBooking = bookings.find(
    (booking) => booking.id === fields.bookingId.value,
  );

  return {
    id: fields.bookingId.value || createId(),
    kodeBooking: existingBooking?.kodeBooking || getNextBookingCode(),
    namaPelanggan: fields.namaPelanggan.value.trim(),
    nomorPlat: fields.nomorPlat.value.trim().toUpperCase(),
    jenisKendaraan: fields.jenisKendaraan.value,
    merekKendaraan: fields.merekKendaraan.value.trim(),
    jenisService: selectedServices,
    tanggalService: fields.tanggalService.value,
    jamService: fields.jamService.value,
    estimasiBiaya: serviceSummary.price,
    estimasiDurasi: serviceSummary.duration,
    statusBooking: existingBooking?.statusBooking || "Menunggu",
  };
};

const validateBooking = (booking) => {
  clearErrors();

  const errors = {};
  const selectedDateTime =
    booking.tanggalService && booking.jamService
      ? getDateTime(booking.tanggalService, booking.jamService)
      : null;
  const serviceEndTime =
    selectedDateTime && booking.estimasiDurasi
      ? getEndTime(booking)
      : null;
  const closingTime = booking.tanggalService
    ? getDateTime(booking.tanggalService, "17:00")
    : null;

  if (!booking.namaPelanggan) {
    errors.namaPelanggan = "Nama pelanggan wajib diisi.";
  } else if (booking.namaPelanggan.length < 3) {
    errors.namaPelanggan = "Nama minimal 3 karakter.";
  }

  if (!booking.nomorPlat) {
    errors.nomorPlat = "Nomor plat wajib diisi.";
  } else if (!/^[A-Z]{1,2}\s?\d{1,4}\s?[A-Z]{1,3}$/.test(booking.nomorPlat)) {
    errors.nomorPlat = "Format plat belum sesuai. Contoh: B 1234 XYZ.";
  }

  if (!booking.jenisKendaraan) {
    errors.jenisKendaraan = "Jenis kendaraan wajib dipilih.";
  }

  if (!booking.merekKendaraan) {
    errors.merekKendaraan = "Merek atau seri kendaraan wajib diisi.";
  } else if (booking.merekKendaraan.length < 3) {
    errors.merekKendaraan = "Merek atau seri minimal 3 karakter.";
  }

  if (!booking.jenisService.length) {
    errors.jenisService = "Pilih minimal satu jenis service.";
  }

  if (!booking.tanggalService) {
    errors.tanggalService = "Tanggal service wajib diisi.";
  }

  if (!booking.jamService) {
    errors.jamService = "Jam kedatangan wajib diisi.";
  } else if (booking.jamService < "08:00" || booking.jamService > "17:00") {
    errors.jamService = "Jam service hanya 08:00 sampai 17:00.";
  }

  if (selectedDateTime && selectedDateTime < new Date()) {
    errors.tanggalService = "Tanggal dan jam tidak boleh di masa lalu.";
    errors.jamService = "Pilih jam kedatangan yang masih tersedia.";
  }

  if (serviceEndTime && closingTime && serviceEndTime > closingTime) {
    errors.jamService =
      "Durasi service melewati jam tutup bengkel. Pilih jam lebih awal.";
  }

  if (booking.tanggalService && booking.jamService && hasScheduleConflict(booking)) {
    errors.jamService =
      "Jadwal bentrok dengan booking lain. Silakan pilih jam berbeda.";
  }

  Object.entries(errors).forEach(([fieldName, message]) =>
    setError(fieldName, message),
  );

  return Object.keys(errors).length === 0;
};

const getFilteredBookings = () => {
  const keyword = normalizeText(searchInput.value);
  const selectedService = filterService.value;
  const selectedStatus = filterStatus.value;

  return bookings.filter((booking) => {
    const searchableText = [
      booking.kodeBooking,
      booking.namaPelanggan,
      booking.nomorPlat,
      booking.merekKendaraan,
    ]
      .join(" ")
      .toLowerCase();

    const matchesKeyword = searchableText.includes(keyword);
    const matchesService =
      selectedService === "Semua" ||
      booking.jenisService.includes(selectedService);
    const matchesStatus =
      selectedStatus === "Semua" || booking.statusBooking === selectedStatus;

    return matchesKeyword && matchesService && matchesStatus;
  });
};

const renderStats = () => {
  const totalEstimasi = bookings.reduce(
    (total, booking) => total + booking.estimasiBiaya,
    0,
  );
  const totalMenunggu = bookings.filter(
    (booking) => booking.statusBooking === "Menunggu",
  ).length;
  const totalSelesai = bookings.filter(
    (booking) => booking.statusBooking === "Selesai",
  ).length;

  stats.totalBooking.textContent = bookings.length;
  stats.totalEstimasi.textContent = formatCurrency(totalEstimasi);
  stats.totalMenunggu.textContent = totalMenunggu;
  stats.totalSelesai.textContent = totalSelesai;
};

const getStatusClass = (status) => `status-${status.toLowerCase()}`;

const renderBookings = () => {
  const filteredBookings = getFilteredBookings();

  bookingTableBody.innerHTML = filteredBookings
    .map(
      (booking) => `
        <tr>
          <td><strong>${booking.kodeBooking}</strong></td>
          <td>
            ${booking.namaPelanggan}
            <div class="muted">${booking.nomorPlat}</div>
          </td>
          <td>
            ${booking.jenisKendaraan}
            <div class="muted">${booking.merekKendaraan}</div>
          </td>
          <td>
            ${booking.jenisService.join(", ")}
            <div class="muted">${formatDuration(booking.estimasiDurasi)}</div>
          </td>
          <td>
            ${formatDate(booking.tanggalService)}
            <div class="muted">${booking.jamService} WIB</div>
          </td>
          <td>${formatCurrency(booking.estimasiBiaya)}</td>
          <td>
            <span class="status-badge ${getStatusClass(booking.statusBooking)}">
              ${booking.statusBooking}
            </span>
          </td>
          <td>
            <div class="action-group">
              <button class="btn-action btn-edit" data-action="edit" data-id="${booking.id}">
                Edit
              </button>
              <button class="btn-action btn-status" data-action="status" data-id="${booking.id}">
                Status
              </button>
              <button class="btn-action btn-delete" data-action="delete" data-id="${booking.id}">
                Hapus
              </button>
            </div>
          </td>
        </tr>
      `,
    )
    .join("");

  emptyState.textContent = bookings.length
    ? "Data tidak ditemukan. Coba ubah kata kunci atau filter."
    : "Belum ada data booking.";
  emptyState.classList.toggle("show", filteredBookings.length === 0);
};

const renderSystemPreview = () => {
  const selectedServices = getSelectedServices();
  const serviceSummary = calculateServiceSummary(selectedServices);
  const existingBooking = bookings.find(
    (booking) => booking.id === fields.bookingId.value,
  );

  kodePreview.textContent = existingBooking?.kodeBooking || getNextBookingCode();
  estimasiPreview.textContent = formatCurrency(serviceSummary.price);
  durasiPreview.textContent = formatDuration(serviceSummary.duration);
  statusPreview.textContent = existingBooking?.statusBooking || "Menunggu";
};

const renderApp = () => {
  renderStats();
  renderBookings();
  renderSystemPreview();
};

const resetForm = () => {
  bookingForm.reset();
  fields.bookingId.value = "";
  clearErrors();
  formTitle.textContent = "Tambah Booking Baru";
  formModeLabel.textContent = "Form booking service";
  submitButton.textContent = "Simpan Booking";
  renderSystemPreview();
};

const fillFormForEdit = (booking) => {
  fields.bookingId.value = booking.id;
  fields.namaPelanggan.value = booking.namaPelanggan;
  fields.nomorPlat.value = booking.nomorPlat;
  fields.jenisKendaraan.value = booking.jenisKendaraan;
  fields.merekKendaraan.value = booking.merekKendaraan;
  fields.tanggalService.value = booking.tanggalService;
  fields.jamService.value = booking.jamService;

  serviceInputs.forEach((input) => {
    input.checked = booking.jenisService.includes(input.value);
  });

  formTitle.textContent = "Edit Data Booking";
  formModeLabel.textContent = `Mode edit: ${booking.kodeBooking}`;
  submitButton.textContent = "Update Booking";
  clearErrors();
  renderSystemPreview();
  document
    .querySelector("#booking-section")
    .scrollIntoView({ behavior: "smooth" });
};

const updateBookingStatus = (bookingId) => {
  bookings = bookings.map((booking) => {
    if (booking.id !== bookingId) {
      return booking;
    }

    const currentStatusIndex = statusFlow.indexOf(booking.statusBooking);
    const nextStatus =
      statusFlow[(currentStatusIndex + 1) % statusFlow.length];

    return {
      ...booking,
      statusBooking: nextStatus,
    };
  });

  saveBookings();
  renderApp();
};

const migrateBooking = (booking, index) => {
  const services = Array.isArray(booking.jenisService)
    ? booking.jenisService
    : [booking.jenisService].filter(Boolean);
  const knownServices = services.filter((serviceName) => serviceCatalog[serviceName]);
  const serviceSummary = calculateServiceSummary(knownServices);

  return {
    ...booking,
    id: booking.id || createId(),
    kodeBooking: booking.kodeBooking || `PS-${String(index + 1).padStart(3, "0")}`,
    merekKendaraan: booking.merekKendaraan || "Belum diisi",
    jenisService: knownServices,
    estimasiBiaya: serviceSummary.price || booking.estimasiBiaya || 0,
    estimasiDurasi: serviceSummary.duration || booking.estimasiDurasi || 30,
    statusBooking: booking.statusBooking || "Menunggu",
  };
};

const loadBookings = () => {
  const storedBookings = JSON.parse(localStorage.getItem(STORAGE_KEY));
  const source = storedBookings?.length ? storedBookings : initialBookings;

  bookings = source.map(migrateBooking);
  saveBookings();
};

bookingForm.addEventListener("submit", (event) => {
  event.preventDefault();

  const booking = getFormData();
  const isValid = validateBooking(booking);

  if (!isValid) {
    return;
  }

  const isEditing = Boolean(fields.bookingId.value);

  bookings = isEditing
    ? bookings.map((item) => (item.id === booking.id ? booking : item))
    : [...bookings, booking];

  saveBookings();
  renderApp();
  resetForm();
});

resetButton.addEventListener("click", resetForm);

bookingTableBody.addEventListener("click", (event) => {
  const button = event.target.closest("button[data-action]");

  if (!button) {
    return;
  }

  const { action, id } = button.dataset;
  const selectedBooking = bookings.find((booking) => booking.id === id);

  if (!selectedBooking) {
    return;
  }

  if (action === "edit") {
    fillFormForEdit(selectedBooking);
  }

  if (action === "status") {
    updateBookingStatus(id);
  }

  if (action === "delete") {
    const confirmed = confirm(
      `Hapus booking ${selectedBooking.kodeBooking} milik ${selectedBooking.namaPelanggan}?`,
    );

    if (confirmed) {
      bookings = bookings.filter((booking) => booking.id !== id);
      saveBookings();
      renderApp();

      if (fields.bookingId.value === id) {
        resetForm();
      }
    }
  }
});

[searchInput, filterService, filterStatus].forEach((element) => {
  element.addEventListener("input", renderBookings);
  element.addEventListener("change", renderBookings);
});

Object.keys(fields).forEach((fieldName) => {
  fields[fieldName].addEventListener("input", () => setError(fieldName));
  fields[fieldName].addEventListener("change", () => setError(fieldName));
});

serviceInputs.forEach((input) => {
  input.addEventListener("change", () => {
    setError("jenisService");
    renderSystemPreview();
  });
});

loadBookings();
fields.tanggalService.min = getTodayInputValue();
renderApp();
