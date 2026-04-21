const STORAGE_KEY = "pitstopBookings";

const services = {
  "Ganti Oli": { price: 350000, duration: 30 },
  "Servis Berkala": { price: 850000, duration: 120 },
  "Perbaikan Rem": { price: 275000, duration: 60 },
  "Tune Up Mesin": { price: 600000, duration: 90 },
  "Spooring Balancing": { price: 450000, duration: 60 },
  "Diagnosa Mesin": { price: 250000, duration: 45 },
};

const defaultBookings = [
  {
    id: "booking-1",
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
    id: "booking-2",
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
    id: "booking-3",
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

const form = document.querySelector("#bookingForm");
const tableBody = document.querySelector("#bookingTableBody");
const emptyState = document.querySelector("#emptyState");
const submitButton = document.querySelector("#submitButton");
const resetButton = document.querySelector("#resetButton");
const cancelEditButton = document.querySelector("#cancelEditButton");
const searchInput = document.querySelector("#searchInput");
const filterService = document.querySelector("#filterService");
const filterStatus = document.querySelector("#filterStatus");
const formTitle = document.querySelector("#formTitle");
const formModeLabel = document.querySelector("#formModeLabel");
const formFeedback = document.querySelector("#formFeedback");
const serviceGroup = document.querySelector("#serviceGroup");
const serviceInputs = [...document.querySelectorAll('input[name="jenisService"]')];

const fields = {
  bookingId: document.querySelector("#bookingId"),
  namaPelanggan: document.querySelector("#namaPelanggan"),
  nomorPlat: document.querySelector("#nomorPlat"),
  jenisKendaraan: document.querySelector("#jenisKendaraan"),
  merekKendaraan: document.querySelector("#merekKendaraan"),
  tanggalService: document.querySelector("#tanggalService"),
  jamService: document.querySelector("#jamService"),
};

const errors = {
  namaPelanggan: document.querySelector("#namaPelangganError"),
  nomorPlat: document.querySelector("#nomorPlatError"),
  jenisKendaraan: document.querySelector("#jenisKendaraanError"),
  merekKendaraan: document.querySelector("#merekKendaraanError"),
  tanggalService: document.querySelector("#tanggalServiceError"),
  jamService: document.querySelector("#jamServiceError"),
  jenisService: document.querySelector("#jenisServiceError"),
};

const previews = {
  kode: document.querySelector("#kodePreview"),
  biaya: document.querySelector("#estimasiPreview"),
  durasi: document.querySelector("#durasiPreview"),
  status: document.querySelector("#statusPreview"),
};

const stats = {
  totalBooking: document.querySelector("#totalBooking"),
  totalEstimasi: document.querySelector("#totalEstimasi"),
  totalMenunggu: document.querySelector("#totalMenunggu"),
  totalSelesai: document.querySelector("#totalSelesai"),
};

const createId = () => `booking-${Date.now()}-${Math.random().toString(16).slice(2)}`;

const formatCurrency = (value) =>
  new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    maximumFractionDigits: 0,
  }).format(Number(value) || 0);

const formatDate = (value) =>
  new Intl.DateTimeFormat("id-ID", {
    day: "2-digit",
    month: "short",
    year: "numeric",
  }).format(new Date(`${value}T00:00:00`));

const formatDuration = (minutes) => {
  const value = Number(minutes) || 0;

  if (value < 60) {
    return `${value} menit`;
  }

  const hours = Math.floor(value / 60);
  const rest = value % 60;

  return rest ? `${hours} jam ${rest} menit` : `${hours} jam`;
};

const getTodayValue = () => {
  const now = new Date();
  const year = now.getFullYear();
  const month = String(now.getMonth() + 1).padStart(2, "0");
  const date = String(now.getDate()).padStart(2, "0");

  return `${year}-${month}-${date}`;
};

const getSelectedServices = () =>
  serviceInputs.filter((input) => input.checked).map((input) => input.value);

const calculateSummary = (selectedServices) =>
  selectedServices.reduce(
    (summary, serviceName) => ({
      price: summary.price + services[serviceName].price,
      duration: summary.duration + services[serviceName].duration,
    }),
    { price: 0, duration: 0 },
  );

const saveToStorage = () => {
  localStorage.setItem(STORAGE_KEY, JSON.stringify(bookings));
};

const loadFromStorage = () => {
  const storedData = localStorage.getItem(STORAGE_KEY);

  if (!storedData) {
    bookings = [...defaultBookings];
    saveToStorage();
    return;
  }

  try {
    const parsedData = JSON.parse(storedData);
    bookings = Array.isArray(parsedData) ? parsedData.map(normalizeBooking) : [...defaultBookings];
  } catch (error) {
    bookings = [...defaultBookings];
    saveToStorage();
  }
};

const normalizeBooking = (booking, index) => {
  const selectedServices = Array.isArray(booking.jenisService)
    ? booking.jenisService.filter((serviceName) => services[serviceName])
    : [booking.jenisService].filter((serviceName) => services[serviceName]);
  const summary = calculateSummary(selectedServices);

  return {
    id: booking.id || createId(),
    kodeBooking: booking.kodeBooking || `PS-${String(index + 1).padStart(3, "0")}`,
    namaPelanggan: booking.namaPelanggan || "",
    nomorPlat: booking.nomorPlat || "",
    jenisKendaraan: booking.jenisKendaraan || "",
    merekKendaraan: booking.merekKendaraan || "",
    jenisService: selectedServices,
    tanggalService: booking.tanggalService || getTodayValue(),
    jamService: booking.jamService || "08:00",
    estimasiBiaya: summary.price || Number(booking.estimasiBiaya) || 0,
    estimasiDurasi: summary.duration || Number(booking.estimasiDurasi) || 0,
    statusBooking: booking.statusBooking || "Menunggu",
  };
};

const showFeedback = (message, type) => {
  formFeedback.textContent = message;
  formFeedback.className = `form-feedback show ${type}`;
};

const clearFeedback = () => {
  formFeedback.textContent = "";
  formFeedback.className = "form-feedback";
};

const setFieldError = (fieldName, message = "") => {
  errors[fieldName].textContent = message;

  if (fieldName === "jenisService") {
    serviceGroup.classList.toggle("invalid", Boolean(message));
    return;
  }

  fields[fieldName].closest(".form-group").classList.toggle("invalid", Boolean(message));
};

const clearValidation = () => {
  Object.keys(errors).forEach((fieldName) => setFieldError(fieldName));
};

const getBookingCode = () => {
  const editedBooking = bookings.find((booking) => booking.id === fields.bookingId.value);

  if (editedBooking) {
    return editedBooking.kodeBooking;
  }

  const latestNumber = bookings.reduce((latest, booking) => {
    const number = Number(String(booking.kodeBooking).replace(/\D/g, ""));
    return Number.isNaN(number) ? latest : Math.max(latest, number);
  }, 0);

  return `PS-${String(latestNumber + 1).padStart(3, "0")}`;
};

const getDateTime = (date, time) => new Date(`${date}T${time}:00`);

const getBookingEndTime = (booking) => {
  const start = getDateTime(booking.tanggalService, booking.jamService);
  return new Date(start.getTime() + booking.estimasiDurasi * 60000);
};

const hasConflict = (candidate) => {
  const candidateStart = getDateTime(candidate.tanggalService, candidate.jamService);
  const candidateEnd = getBookingEndTime(candidate);

  return bookings.some((booking) => {
    if (
      booking.id === candidate.id ||
      booking.tanggalService !== candidate.tanggalService ||
      booking.statusBooking === "Selesai"
    ) {
      return false;
    }

    const existingStart = getDateTime(booking.tanggalService, booking.jamService);
    const existingEnd = getBookingEndTime(booking);

    return candidateStart < existingEnd && candidateEnd > existingStart;
  });
};

const getFormData = () => {
  const selectedServices = getSelectedServices();
  const summary = calculateSummary(selectedServices);
  const editedBooking = bookings.find((booking) => booking.id === fields.bookingId.value);

  return {
    id: fields.bookingId.value || createId(),
    kodeBooking: getBookingCode(),
    namaPelanggan: fields.namaPelanggan.value.trim(),
    nomorPlat: fields.nomorPlat.value.trim().toUpperCase(),
    jenisKendaraan: fields.jenisKendaraan.value,
    merekKendaraan: fields.merekKendaraan.value.trim(),
    jenisService: selectedServices,
    tanggalService: fields.tanggalService.value,
    jamService: fields.jamService.value,
    estimasiBiaya: summary.price,
    estimasiDurasi: summary.duration,
    statusBooking: editedBooking?.statusBooking || "Menunggu",
  };
};

const validateBooking = (booking) => {
  clearValidation();
  clearFeedback();

  const validationErrors = {};
  const selectedDateTime =
    booking.tanggalService && booking.jamService
      ? getDateTime(booking.tanggalService, booking.jamService)
      : null;
  const closingTime = booking.tanggalService
    ? getDateTime(booking.tanggalService, "17:00")
    : null;
  const endTime = selectedDateTime && booking.estimasiDurasi
    ? getBookingEndTime(booking)
    : null;

  if (!booking.namaPelanggan) {
    validationErrors.namaPelanggan = "Nama pelanggan wajib diisi.";
  } else if (booking.namaPelanggan.length < 3) {
    validationErrors.namaPelanggan = "Nama minimal 3 karakter.";
  }

  if (!booking.nomorPlat) {
    validationErrors.nomorPlat = "Nomor plat wajib diisi.";
  } else if (!/^[A-Z]{1,2}\s?\d{1,4}\s?[A-Z]{1,3}$/.test(booking.nomorPlat)) {
    validationErrors.nomorPlat = "Format plat harus seperti B 1234 XYZ.";
  }

  if (!booking.jenisKendaraan) {
    validationErrors.jenisKendaraan = "Jenis kendaraan wajib dipilih.";
  }

  if (!booking.merekKendaraan) {
    validationErrors.merekKendaraan = "Merek atau seri kendaraan wajib diisi.";
  }

  if (!booking.tanggalService) {
    validationErrors.tanggalService = "Tanggal service wajib diisi.";
  }

  if (!booking.jamService) {
    validationErrors.jamService = "Jam kedatangan wajib diisi.";
  } else if (booking.jamService < "08:00" || booking.jamService > "17:00") {
    validationErrors.jamService = "Jam service hanya 08:00 sampai 17:00.";
  }

  if (!booking.jenisService.length) {
    validationErrors.jenisService = "Pilih minimal satu jenis service.";
  }

  if (selectedDateTime && selectedDateTime < new Date()) {
    validationErrors.tanggalService = "Tanggal dan jam tidak boleh di masa lalu.";
    validationErrors.jamService = "Pilih waktu kedatangan yang masih tersedia.";
  }

  if (endTime && closingTime && endTime > closingTime) {
    validationErrors.jamService = "Durasi service melewati jam tutup bengkel.";
  }

  if (booking.tanggalService && booking.jamService && booking.jenisService.length && hasConflict(booking)) {
    validationErrors.jamService = "Jadwal bentrok dengan booking lain.";
  }

  Object.entries(validationErrors).forEach(([fieldName, message]) => {
    setFieldError(fieldName, message);
  });

  if (Object.keys(validationErrors).length) {
    const firstError = Object.values(validationErrors)[0];
    showFeedback(`Validasi gagal: ${firstError}`, "error");
    formFeedback.scrollIntoView({ behavior: "smooth", block: "center" });
    return false;
  }

  return true;
};

const renderPreview = () => {
  const selectedServices = getSelectedServices();
  const summary = calculateSummary(selectedServices);
  const editedBooking = bookings.find((booking) => booking.id === fields.bookingId.value);

  previews.kode.textContent = getBookingCode();
  previews.biaya.textContent = formatCurrency(summary.price);
  previews.durasi.textContent = formatDuration(summary.duration);
  previews.status.textContent = editedBooking?.statusBooking || "Menunggu";
};

const renderStats = () => {
  const totalEstimasi = bookings.reduce((total, booking) => total + booking.estimasiBiaya, 0);
  const totalMenunggu = bookings.filter((booking) => booking.statusBooking === "Menunggu").length;
  const totalSelesai = bookings.filter((booking) => booking.statusBooking === "Selesai").length;

  stats.totalBooking.textContent = bookings.length;
  stats.totalEstimasi.textContent = formatCurrency(totalEstimasi);
  stats.totalMenunggu.textContent = totalMenunggu;
  stats.totalSelesai.textContent = totalSelesai;
};

const getFilteredBookings = () => {
  const keyword = searchInput.value.trim().toLowerCase();
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

    const matchKeyword = searchableText.includes(keyword);
    const matchService = selectedService === "Semua" || booking.jenisService.includes(selectedService);
    const matchStatus = selectedStatus === "Semua" || booking.statusBooking === selectedStatus;

    return matchKeyword && matchService && matchStatus;
  });
};

const renderTable = () => {
  const filteredBookings = getFilteredBookings();

  tableBody.innerHTML = filteredBookings
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
            <span class="status-badge status-${booking.statusBooking.toLowerCase()}">
              ${booking.statusBooking}
            </span>
          </td>
          <td>
            <div class="action-group">
              <button class="btn-action btn-edit" data-action="edit" data-id="${booking.id}">Edit</button>
              <button class="btn-action btn-status" data-action="status" data-id="${booking.id}">Status</button>
              <button class="btn-action btn-delete" data-action="delete" data-id="${booking.id}">Hapus</button>
            </div>
          </td>
        </tr>
      `,
    )
    .join("");

  emptyState.textContent = bookings.length
    ? "Data tidak ditemukan. Coba ubah pencarian atau filter."
    : "Belum ada data booking.";
  emptyState.classList.toggle("show", filteredBookings.length === 0);
};

const renderApp = () => {
  renderStats();
  renderPreview();
  renderTable();
};

const resetForm = () => {
  form.reset();
  fields.bookingId.value = "";
  formTitle.textContent = "Tambah Booking Baru";
  formModeLabel.textContent = "Form booking service";
  submitButton.textContent = "Simpan Booking";
  cancelEditButton.classList.remove("show");
  clearValidation();
  clearFeedback();
  renderPreview();
};

const saveBooking = () => {
  const booking = getFormData();

  if (!validateBooking(booking)) {
    return;
  }

  const isEditing = Boolean(fields.bookingId.value);

  bookings = isEditing
    ? bookings.map((item) => (item.id === booking.id ? booking : item))
    : [...bookings, booking];

  saveToStorage();
  searchInput.value = "";
  filterService.value = "Semua";
  filterStatus.value = "Semua";
  resetForm();
  renderApp();
  showFeedback(
    isEditing
      ? `Booking ${booking.kodeBooking} berhasil diperbarui.`
      : `Booking ${booking.kodeBooking} berhasil ditambahkan.`,
    "success",
  );
};

const editBooking = (booking) => {
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
  cancelEditButton.classList.add("show");
  clearValidation();
  showFeedback("Mode edit aktif. Klik Batal Edit untuk kembali.", "success");
  renderPreview();
  document.querySelector("#booking-section").scrollIntoView({ behavior: "smooth" });
};

const changeStatus = (bookingId) => {
  const statusList = ["Menunggu", "Diproses", "Selesai"];

  bookings = bookings.map((booking) => {
    if (booking.id !== bookingId) {
      return booking;
    }

    const currentIndex = statusList.indexOf(booking.statusBooking);
    const nextStatus = statusList[(currentIndex + 1) % statusList.length];

    return { ...booking, statusBooking: nextStatus };
  });

  saveToStorage();
  renderApp();
};

submitButton.addEventListener("click", saveBooking);

form.addEventListener("submit", (event) => {
  event.preventDefault();
  saveBooking();
});

resetButton.addEventListener("click", resetForm);
cancelEditButton.addEventListener("click", resetForm);

tableBody.addEventListener("click", (event) => {
  const button = event.target.closest("button[data-action]");

  if (!button) {
    return;
  }

  const booking = bookings.find((item) => item.id === button.dataset.id);

  if (!booking) {
    return;
  }

  if (button.dataset.action === "edit") {
    editBooking(booking);
  }

  if (button.dataset.action === "status") {
    changeStatus(booking.id);
  }

  if (button.dataset.action === "delete") {
    const confirmed = confirm(`Hapus booking ${booking.kodeBooking}?`);

    if (confirmed) {
      bookings = bookings.filter((item) => item.id !== booking.id);
      saveToStorage();
      renderApp();

      if (fields.bookingId.value === booking.id) {
        resetForm();
      }
    }
  }
});

[searchInput, filterService, filterStatus].forEach((input) => {
  input.addEventListener("input", renderTable);
  input.addEventListener("change", renderTable);
});

Object.entries(fields).forEach(([fieldName, input]) => {
  if (fieldName === "bookingId") {
    return;
  }

  input.addEventListener("input", () => setFieldError(fieldName));
  input.addEventListener("change", () => setFieldError(fieldName));
});

serviceInputs.forEach((input) => {
  input.addEventListener("change", () => {
    setFieldError("jenisService");
    renderPreview();
  });
});

fields.tanggalService.min = getTodayValue();
loadFromStorage();
renderApp();
