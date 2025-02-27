<header class="pc-header">
    <div class="header-wrapper">
        <!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none m-0 trig-drp-search" data-bs-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <svg class="pc-icon">
                            <use xlink:href="#custom-search-normal-1"></use>
                        </svg>
                    </a>
                    <div class="dropdown-menu pc-h-dropdown drp-search">
                        <form class="px-3 py-2">
                            <input type="search" class="form-control border-0 shadow-none"
                                placeholder="Search here. . ." />
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <!-- [Mobile Media Block end] -->

        <div class="ms-auto d-flex align-items-center">
            <!-- Kotak Tanggal & Jam Real-time -->
            <div id="clockContainer" class="rounded p-2 px-4 text-white fw-bold d-flex align-items-center"
                style="background: #6183ff; font-size: 16px;">
                <i class="ti ti-calendar me-2"></i>
                <span id="realtimeDate">--, -- -- ----</span>
                <span class="mx-3">|</span> <!-- Garis pemisah -->
                <i class="ti ti-clock me-2"></i>
                <span id="realtimeClock">--:--</span>
            </div>
        </div>
    </div>
</header>

<!-- Script untuk Menampilkan Waktu & Tanggal Real-Time -->
<script>
    function updateTime() {
        let now = new Date();
        now.setSeconds(0, 0); // Membulatkan ke menit terdekat (detik ke 0)

        // Format Hari
        let days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        let dayName = days[now.getDay()];

        // Format Tanggal, Bulan, Tahun
        let months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober",
            "November", "Desember"
        ];
        let date = now.getDate();
        let monthName = months[now.getMonth()];
        let year = now.getFullYear();

        let fullDate = `${dayName}, ${date} ${monthName} ${year}`;

        // Format Jam
        let hours = now.getHours();
        let minutes = now.getMinutes().toString().padStart(2, '0');

        // Format 12 jam (AM/PM) - jika ingin format 24 jam, hapus bagian ini
        let ampm = hours >= 12 ? "PM" : "AM";
        hours = hours % 12 || 12; // Konversi ke 12 jam

        let timeString = `${hours}:${minutes} ${ampm}`;

        // Update tampilan
        document.getElementById("realtimeDate").textContent = fullDate;
        document.getElementById("realtimeClock").textContent = timeString;
    }

    // Perbarui setiap 10 detik agar tetap real-time
    updateTime();
    setInterval(updateTime, 10000);
</script>
