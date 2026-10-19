<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MUSI RUN VII</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="assets/main.css" rel="stylesheet">
<!--

TemplateMo 596 Electric Xtra

https://templatemo.com/tm-596-electric-xtra

-->
</head>
<body>
    <!-- Animated Grid Background -->
    <div class="grid-bg"></div>
    <div class="gradient-overlay"></div>
    <div class="scanlines"></div>

    <!-- Animated Shapes -->
    <div class="shapes-container">
        <div class="shape shape-circle"></div>
        <div class="shape shape-triangle"></div>
        <div class="shape shape-square"></div>
    </div>

    <!-- Floating Particles -->
    <div id="particles"></div>

    <!-- Navigation -->
    <nav id="navbar">
        <div class="nav-container">
            <a href="#home" class="logo-link">
                <!-- <svg class="logo-svg" viewBox="0 0 40 40" xmlns="images/logo.png"> -->
                    <img class="logo-svg"  viewBox="0 0 40 40"  src="assets/images/logo.png" alt="">
                    <defs>
                        <linearGradient id="logoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color: #f5be00;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#00B2FF;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <polygon points="20,2 38,14 38,26 20,38 2,26 2,14" fill="none" stroke="url(#logoGradient)" stroke-width="2"/>
                    <polygon points="20,8 32,16 32,24 20,32 8,24 8,16" fill="url(#logoGradient)" opacity="0.3"/>
                    <circle cx="20" cy="20" r="3" fill="url(#logoGradient)"/>
                </svg>
                <span class="logo-text">MUSI RUN VII</span>
            </a>
            <ul class="nav-links" id="navLinks">
                <li><a href="#tentang" class="nav-link">Tentang</a></li>
                <li><a href="#jadwal" class="nav-link">Jadwal</a></li>
                <li><a href="#registrasi" class="nav-link">Registrasi</a></li>
                <li><a href="{{ route('desain') }}" class="nav-link">Desain & Rute</a></li>
                <li><a href="#faq" class="nav-link">FAQ</a></li>
                <li><a href="#arsip" class="nav-link">Arsip</a></li>
                <li><a href="#kontak" class="nav-link">Kontak</a></li>

            </ul>

            <div class="menu-toggle" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-background" aria-hidden="true">
            <video class="hero-video" autoplay muted loop playsinline webkit-playsinline preload="metadata">
                <source src="{{ asset('assets/video_background.mp4') }}" type="video/mp4">
            </video>
        </div>
        <img class="logo-hero" src="assets/images/logo.png" alt="MUSI RUN">
        <div class="hero-content" >
            <div class="text-rotator">
                <div class="text-set active">
                    <h1>SUMATERA EKSPRES</h1>
                    <h2 class="glitch-text" >MUSI RUN 2027</h2>
                    <!-- <p class="subtitle">Enter the next dimension of digital innovation</p> -->
                </div>
                <!-- <div class="text-set">
                    <h1 class="glitch-text" data-text="BEYOND LIMITS">BEYOND LIMITS</h1>
                    <p class="subtitle">Where technology meets infinite possibilities</p>
                </div>
                <div class="text-set">
                    <h1 class="glitch-text" data-text="ELECTRIC DREAMS">ELECTRIC DREAMS</h1>
                    <p class="subtitle">Powering tomorrow's digital revolution today</p>
                </div> -->
            </div>
        </div>
        <div class="cta-container">
            <a href="/registrasi" class="cta-button cta-primary register-trigger">Daftar Sekarang</a>
            <a href="#tentang" class="cta-button cta-secondary">Pelajari Lebih Lanjut</a>
        </div>
    </section>


    <!-- star about -->
    <section class="about" id="tentang">
         <div class="about-content" style="margin-top: 80px;">
            <div class="about-text">
                <h4>about</h4>
                <h2>TENTANG Musi Run 2027</h2>
                <p class="about-lead">Satu Langkah, Seribu Semangat, Bersama Menuju Sehat.</p>
                <h3 class="about-subheading">Lebih dari sekadar lomba</h3>
                <p>Lari bukan sekadar tentang siapa yang paling cepat mencapai garis finis. Lari dimulai dari keberanian, semangat yang terus dijaga, dan perjalanan yang menyatukan banyak orang dalam satu energi positif.</p>
                <h3 class="about-subheading">Seri VII di Palembang</h3>
                <p>Memasuki tahun 2027, Sumeks Musi Run Seri VII hadir sebagai perayaan olahraga dan gaya hidup sehat yang menghidupkan semangat Palembang serta Sumatera Selatan. Event ini akan diselenggarakan pada Minggu, 24 Januari 2027 di Stadion Jakabaring Sport City.</p>
                <h3 class="about-subheading">Bergerak bersama</h3>
                <p>Setiap kilometer menjadi cerita dan setiap langkah menjadi bagian dari gerakan untuk membangun masyarakat yang lebih sehat, aktif, dan optimistis. Sumeks Musi Run mempertemukan pelari profesional, komunitas, keluarga, generasi muda, dan masyarakat umum dalam suasana penuh kebersamaan.</p>
                <p>Dengan Jakabaring Sport City sebagai titik pertemuan ribuan langkah, Seri VII diharapkan menjadi gerakan positif yang memperkenalkan Palembang sebagai kota olahraga, pariwisata, dan ekonomi kreatif.</p>
                <div class="about-goals">
                  <h3>TUJUAN</h3>
                  <p>Pelaksanaan Sumeks Musi Run 2027 Seri VII bertujuan untuk:</p>
                  <ol>
                    <li>Membangun budaya hidup sehat</li>
                    <li>Menyatukan masyarakat melalui olahraga</li>
                    <li>Menguatkan ekosistem olahraga di Sumatera Selatan</li>
                    <li>Memperkuat citra Palembang sebagai kota sport tourism</li>
                    <li>Mendorong pertumbuhan ekonomi lokal</li>
                    <li>Membangun ruang interaksi yang positif bagi generasi muda</li>
                    <li>Memperkuat eksistensi Sumeks Musi Run sebagai event olahraga tahunan</li>
                    <li>Menciptakan pengalaman event yang berkesan</li>
                  </ol>
                </div>
            </div>

             <div class="about-visual">
                <div class="about-graphic-alt">
                    <img src="assets/images/tentang.jpeg" alt="Peserta berlari dalam event Musi Run">
                </div>
            </div>
        </div>
    </section>

    <!-- star jadwal  -->
        <section class="schedule" id="jadwal">
          <div class="container">
            <div class="schedule-content">
              <!-- Gambar -->
              <div class="schedule-image">
                <img src="assets/images/jadwal.jpeg" alt="Jadwal Musi Run 2026">
              </div>

              <!-- Teks -->
              <div class="schedule-text">
                 <h4>event schedule</h4>
                <h2>JADWAL DAN ALUR WAKTU</h2>

                <div class="schedule-item">
                  <h4>Periode Early Bird</h4>
                  <p>🗓️ 16 Oktober 2026 - 30 November 2026</p>
                </div>

                <div class="schedule-item">
                  <h4>Periode Normal</h4>
                  <p>🗓️ 1 Desember 2026 - 15 Januari 2027</p>
                </div>

                <div class="schedule-item">
                  <h4>Pengambilan RPC</h4>
                  <p>📅 15 Januari 2027 - 17 Januari 2027<br>
                     🕒 Pukul 09.30 - 17.00 WIB<br>
                     📍 <a href="#" style="color: whitesmoke; text-decoration: none;"><strong>Lobby Graha Pena Sumatera Ekspres</strong></a>
                  </p>
                </div>

                <div class="schedule-item">
                  <h4>Waktu Start</h4>
                  <p>📅 <br>
                     🕕 <br>
                     📍 <a href="#" style="color: whitesmoke; text-decoration: none;"><strong>Stadion Gelora Jakabaring Sport City (JSC)</strong></a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- registrasi-->
        <section class="features" id="registrasi">
          <h2 class="section-title">Peserta dan Registrasi</h2>
          <div class="features-container">

            <!-- Tabs -->
            <div class="feature-tabs">
              <div class="tab-item active" data-tab="7-kilometer">
                <span class="tab-icon"></span>
                <span>7 Kilometer</span>
              </div>
              <div class="tab-item" data-tab="12-km">
                <span class="tab-icon"></span>
                <span>12 Kilometer</span>
              </div>
            </div>

            <!-- Konten -->
            <div class="feature-content">

              <!-- 7K -->
              <div class="content-panel active" id="7-kilometer">
                <div class="feature-flex">

                  <!-- Kolom kiri -->
                  <div class="feature-left">
                    <h3>7 Kilometer</h3>
                    <h5>Early Bird</h5>
                    <h4>Rp. 160.000</h4>
                    <h5>Normal</h5>
                    <h4>Rp. 200.000</h4>
                    <br>
                    <h4>Benefit</h4>
                    <ul class="feature-list">
                      <li>Jersey</li>
                      <li>Mendali</li>
                      <li>BIB + Chips</li>
                      <li>E-Certificate (All Finisher)</li>
                      <li>Asuransi</li>
                      <li>Bingkisan Sponsor</li>
                    </ul>
                  </div>

                  <!-- Kolom kanan -->
                  <div class="feature-right">
                    <h3>Hadiah Pemenang</h3>
                    <ul class="hadiah-list">
                      <li><strong>Juara 1:</strong> Rp. 3.500.000</li>
                      <li><strong>Juara 2:</strong> Rp. 2.500.000</li>
                      <li><strong>Juara 3:</strong> Rp. 1.500.000</li>
                      <li><strong>Harapan 1:</strong> Rp. 800.000</li>
                      <li><strong>Harapan 2:</strong> Rp. 500.000</li>
                    </ul>

                    <!-- Tombol Daftar Sekarang -->
                    <div class="btn-wrapper">
                      <a href="/registrasi" class="btn-daftar register-trigger">Daftar Sekarang</a>
                    </div>
                  </div>

                </div>
              </div>

              <!-- 12K -->
              <div class="content-panel" id="12-km">
                <div class="feature-flex">

                  <!-- Kolom kiri -->
                  <div class="feature-left">
                    <h3>12 Kilometer</h3>
                    <h5>Early Bird</h5>
                    <h4>Rp. 190.000</h4>
                    <h5>Normal</h5>
                    <h4>Rp. 250.000</h4>
                    <br>
                    <h4>Benefit</h4>
                    <ul class="feature-list">
                      <li>Jersey</li>
                      <li>Mendali</li>
                      <li>BIB + Chips</li>
                      <li>E-Certificate (All Finisher)</li>
                      <li>Asuransi</li>
                      <li>Bingkisan Sponsor</li>
                    </ul>
                  </div>

                  <!-- Kolom kanan -->
                  <div class="feature-right">
                    <h3>Hadiah Pemenang</h3>
                    <ul class="hadiah-list">
                      <li><strong>Juara 1:</strong> Rp. 5.000.000</li>
                      <li><strong>Juara 2:</strong> Rp. 3.500.000</li>
                      <li><strong>Juara 3:</strong> Rp. 2.500.000</li>
                      <li><strong>Harapan 1:</strong> Rp. 1.500.000</li>
                    </ul>

                    <!-- Tombol Daftar Sekarang -->
                    <div class="btn-wrapper">
                      <a href="/registrasi" class="btn-daftar register-trigger">Daftar Sekarang</a>
                    </div>
                  </div>

                </div>
              </div>

            </div> <!-- end feature-content -->
          </div> <!-- end features-container -->
        </section>

        <!-- Star FAQ -->
        <section class="faq" id="faq">
            <h4 style="text-align: center;">frequently asked questions</h4>
          <h2 class="faq-title">INFORMASI DAN PERSYARATAN</h2>

          <div class="faq-container">
            <div class="faq-item">
              <button class="faq-question">Kriteria pemenang pada event Musi Run 2027</button>
              <div class="faq-answer">
                <ol>
                    <li>Pemenang adalah WNI.</li>
                    <li>Pemenang ditentukan berdasarkan waktu tercepat dan terkualifikasikan dengan benar.</li>
                    <li>Kategori pemenang terdiri dari: 7K Putra & Putri, dan 12K Putra & Putri.</li>
                    <li>Pemenang hanya dapat menang di kategori yang dipilih saat daftar lomba.</li>
                    <li>Pengambilan hadiah tidak dapat diwakilkan dan wajib menunjukkan identitas asli.</li>
                    <li>Panitia berhak memberikan hadiah dalam bentuk cash atau transfer.</li>
                    <li>Pihak penyelenggara berhak mendiskualifikasi peserta.</li>
                    <li>Keberatan/sanggahan maksimal 24 jam setelah pengumuman dengan bukti.</li>
                    <li>Keputusan panitia bersifat mutlak dan tidak dapat diganggu gugat.</li>
                    <li>Pada hari registrasi, peserta wajib membawa hardcopy Par-Q & Surat Kuasa RPC Musi Run 2025 (jika diwakilkan).</li>
                </ol>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-question">Bagaimana penggunaan nomor dada/BIB dan status kepesertaan</button>
              <div class="faq-answer">
                <ol>
                  <li>Peserta wajib menggunakan nomor BIB (nomor dada) di bagian depan baju peserta agar terlihat dengan baik.</li>
                  <li>Status kepesertaan tidak dapat digantikan atau ditukar.</li>
                  <li>BIB tidak boleh dirobek atau dilipat agar tidak merusak chip pencatat waktu.</li>
                </ol>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-question">Apa yang menyebabkan peserta didiskualifikasi</button>
              <div class="faq-answer">
                <ol>
                    <li>Peserta adalah WNA.</li>
                    <li>Memanipulasi data kepesertaan.</li>
                    <li>Menggunakan BIB orang lain.</li>
                    <li>Mengambil jalan pintas.</li>
                </ol>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-question">Bagaimana jika tidak memiliki KTP</button>
              <div class="faq-answer">
                <ol>
                    <li>Peserta minimal harus berumur 12 tahun pada hari pendaftaran.</li>
                    <li>Bisa memakai Kartu Pelajar atau NIK.</li>
                </ol>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-question">Apakah setiap peserta akan mendapatkan medali finisher</button>
              <div class="faq-answer">
                <ol>
                    <li>Setiap peserta yang mampu menyelesaikan lomba hingga garis finish akan mendapatkan medali finisher.</li>
                </ol>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-question">Apakah yang harus disiapkan peserta mengenai persiapan diri dalam mengikuti lomba</button>
              <div class="faq-answer">
                <ol>
                    <li>Dengan mendaftar dan mengambil bagian dalam Siloam Sriwijaya Race Run 2027, Peserta menyatakan telah membaca, memahami, menerima, dan setuju untuk tunduk pada Peraturan dan Ketentuan Siloam Sriwijaya Race Run 2027 yang dapat dibaca melalui pengumuman dan juga waiver yang ada pada pengambilan RPC.</li>
                    <li>Peserta harus menyadari bahwa lomba lari ini memiliki risiko, maka peserta diharapkan telah mempersiapkan diri baik secara fisik dan mental. Apabila Penyelenggara menjumpai peserta dalam kondisi fisik tidak prima dan tidak layak mengikuti lomba, maka Penyelenggara akan menghentikan peserta mengikuti
                        lomba dan mencabut nomor dada peserta dan tidak bertanggung jawab apabila Peserta tetap memaksakan diri melakukan start dan atau meneruskan lomba.</li>
                </ol>
              </div>
            </div>

          </div>
        </section>

        {{-- download surat kuasa --}}
        <div class="download-section">
            <br>
            <br>
            <h2 class="faq-title"  id="arsip">Download File Musi Run 2027</h2>
               <div class="download-buttons">
                    <a href="assets/images/jadwal.jpeg" download class="download-btn">
                        📄 PAR-Q Musi Run 2027
                    </a>
                    <a href="assets/files/tes.docx" download class="download-btn">
                         📝 Surat Kuasa RPC Musi Run 2027
                    </a>
                </div>
        </div>

        <!-- Start Kontak -->
        <section class="about" id="kontak">
          <h2 class="section-title">Kontak dan Bantuan</h2>
          <div class="about-content">
            <div class="contact-info">
              <h3>Hubungi Kami</h3>

              <div class="info-item">
                <div class="info-icon">📧</div>
                <div class="info-details">
                  <h4>Email</h4>
                  <a href="mailto:sumeksiklan@gmail.com">sumeksiklan@gmail.com</a>
                </div>
              </div>

              <div class="info-item">
                <div class="info-icon">📱</div>
                <div class="info-details">
                  <h4>Informasi Pembayaran</h4>
                  <a href="https://wa.me/6281367641990" target="_blank">Dayat : 0813-6764-1990</a>
                  <br>
                  <a  target="_blank">Arianto : 0821-7759-9417</a>
                  <br>
                  <a href="https://wa.me/628127105635" target="_blank">Karsono : 0812-7105-635</a>
                </div>
              </div>

              <div class="info-item">
                <div class="info-icon">📍</div>
                <div class="info-details">
                  <h4>Lokasi</h4>
                  <a href="#"><p>Graha Pena Jl. Kol. H. Burlian No.773, KM 6.5<br>
                    Samping Hutan Wisata Punti Kayu,<br>
                    Kec. Alang-Alang Lebar, Palembang.</p></a>
                </div>
              </div>

              <!-- Map Interaktif -->
              <div class="map-container">
               <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.555787473211!2d104.72532647432169!3d-2.9431081970331383!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3b74474e069a81%3A0x438eeb4afc445670!2sSumeks%20-%20Sumatera%20Ekspres%20Palembang!5e0!3m2!1sid!2sid!4v1761657559419!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>

            </div>

            <div class="about-visual">
              <div class="about-graphic"></div>
            </div>
          </div>
        </section>
        <!-- End Kontak -->

        <div class="registration-modal" id="registrationModal" aria-hidden="true">
          <div class="registration-modal__backdrop" data-modal-close></div>
          <section class="registration-modal__card" role="dialog" aria-modal="true" aria-labelledby="registrationModalTitle">
            <button class="registration-modal__close" type="button" aria-label="Tutup" data-modal-close>&times;</button>
            <p class="registration-modal__eyebrow">MUSI RUN VII 2027</p>
            <h2 id="registrationModalTitle">Siap menjadi bagian dari langkah ini?</h2>
            <p class="registration-modal__intro">Sebelum mengisi formulir, pastikan Anda sudah menyiapkan data diri dan bukti pembayaran.</p>
            <ul class="registration-modal__steps">
              <li><span>01</span><div><strong>Pilih kategori jarak</strong><small>Tentukan kategori 7K atau 12K.</small></div></li>
              <li><span>02</span><div><strong>Lakukan pembayaran</strong><small>Gunakan rekening resmi panitia.</small></div></li>
              <li><span>03</span><div><strong>Upload bukti pembayaran</strong><small>Tunggu email approval setelah submit.</small></div></li>
            </ul>
            <div class="registration-modal__actions">
              <button class="registration-modal__cancel" type="button" data-modal-close>Nanti</button>
              <a class="registration-modal__confirm" href="/registrasi">Mulai Registrasi <span>&rarr;</span></a>
            </div>
          </section>
        </div>

        <!-- Footer -->
        <footer>
            <div class="footer-content">
                <p class="copyright">© Copyright <strong>Sumatera Ekspres 2026</strong>. All Rights Reserved.</p>
            </div>
        </footer>


    <!-- FAQ -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
      const modal = document.getElementById('registrationModal');
      const triggers = document.querySelectorAll('.register-trigger');
      const closeButtons = modal.querySelectorAll('[data-modal-close]');

      const closeModal = () => {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
      };

      triggers.forEach(trigger => trigger.addEventListener('click', event => {
        event.preventDefault();
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
        modal.querySelector('.registration-modal__confirm').focus();
      }));
      closeButtons.forEach(button => button.addEventListener('click', closeModal));
      document.addEventListener('keydown', event => { if (event.key === 'Escape') closeModal(); });
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
      const faqQuestions = document.querySelectorAll('.faq-question');

      faqQuestions.forEach(button => {
        button.addEventListener('click', () => {
          const faqItem = button.parentElement;

          // Tutup semua FAQ lain
          document.querySelectorAll('.faq-item').forEach(item => {
            if (item !== faqItem) item.classList.remove('active');
          });

          // Toggle FAQ yang diklik
          faqItem.classList.toggle('active');
        });
        });
        });
    </script>


{{-- // Toggle dropdown saat diklik arsip --}}
    <script>
      document.addEventListener("DOMContentLoaded", function() {
    const dropdownToggle = document.querySelector(".dropdown-toggle");
    const dropdown = document.querySelector(".dropdown");

    dropdownToggle.addEventListener("click", function(e) {
      e.preventDefault(); // Mencegah halaman loncat ke atas
      dropdown.classList.toggle("active");
    });

    // Tutup dropdown jika klik di luar area dropdown
    document.addEventListener("click", function(e) {
      if (!dropdown.contains(e.target)) {
        dropdown.classList.remove("active");
      }
    });
  });
    </script>




<script src="assets/style.js"></script>
</body>
</html>
