const fs = require('fs');
const path = require('path');

function generateSvg() {
    const width = 2400;
    const height = 1850;

    let svg = `<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ${width} ${height}" width="${width}" height="${height}" style="background-color: #0f172a; font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;">
  <defs>
    <linearGradient id="bgGrad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#0b0f19"/>
      <stop offset="100%" stop-color="#1e293b"/>
    </linearGradient>

    <!-- Gradients for Layers -->
    <linearGradient id="viewHeader" x1="0%" y1="0%" x2="100%" y2="0%">
      <stop offset="0%" stop-color="#0284c7"/>
      <stop offset="100%" stop-color="#38bdf8"/>
    </linearGradient>
    <linearGradient id="ctrlHeader" x1="0%" y1="0%" x2="100%" y2="0%">
      <stop offset="0%" stop-color="#d97706"/>
      <stop offset="100%" stop-color="#fbbf24"/>
    </linearGradient>
    <linearGradient id="modelHeader" x1="0%" y1="0%" x2="100%" y2="0%">
      <stop offset="0%" stop-color="#059669"/>
      <stop offset="100%" stop-color="#34d399"/>
    </linearGradient>

    <!-- Markers -->
    <marker id="arrow" viewBox="0 0 10 10" refX="6" refY="5" markerWidth="6" markerHeight="6" orient="auto-start-reverse">
      <path d="M 0 1 L 10 5 L 0 9 z" fill="#94a3b8"/>
    </marker>
    <marker id="arrow-blue" viewBox="0 0 10 10" refX="6" refY="5" markerWidth="6" markerHeight="6" orient="auto-start-reverse">
      <path d="M 0 1 L 10 5 L 0 9 z" fill="#38bdf8"/>
    </marker>
    <marker id="arrow-amber" viewBox="0 0 10 10" refX="6" refY="5" markerWidth="6" markerHeight="6" orient="auto-start-reverse">
      <path d="M 0 1 L 10 5 L 0 9 z" fill="#fbbf24"/>
    </marker>
    <marker id="arrow-emerald" viewBox="0 0 10 10" refX="6" refY="5" markerWidth="6" markerHeight="6" orient="auto-start-reverse">
      <path d="M 0 1 L 10 5 L 0 9 z" fill="#34d399"/>
    </marker>

    <!-- Drop Shadows -->
    <filter id="shadow" x="-5%" y="-5%" width="110%" height="110%">
      <feDropShadow dx="0" dy="8" stdDeviation="6" flood-color="#000000" flood-opacity="0.45"/>
    </filter>
  </defs>

  <!-- Background -->
  <rect width="100%" height="100%" fill="url(#bgGrad)"/>

  <!-- Top Title Banner -->
  <rect x="50" y="30" width="2300" height="90" rx="16" fill="#1e293b" stroke="#334155" stroke-width="1.5" filter="url(#shadow)"/>
  <text x="80" y="70" font-size="26" font-weight="bold" fill="#f8fafc">UML CLASS DIAGRAM — ARSITEKTUR MODEL-VIEW-CONTROLLER (MVC)</text>
  <text x="80" y="98" font-size="14" fill="#94a3b8">Sistem Informasi Profil &amp; Layanan Mandiri Desa Jambelaer | Framework Laravel 13 | Analisis Berbasis Kode Sumber Aktual</text>
  
  <!-- Legend -->
  <g transform="translate(1600, 52)">
    <rect x="0" y="0" width="18" height="18" rx="4" fill="#0284c7"/>
    <text x="26" y="14" font-size="12" fill="#e2e8f0">View («boundary»)</text>

    <rect x="180" y="0" width="18" height="18" rx="4" fill="#d97706"/>
    <text x="206" y="14" font-size="12" fill="#e2e8f0">Controller («control»)</text>

    <rect x="380" y="0" width="18" height="18" rx="4" fill="#059669"/>
    <text x="406" y="14" font-size="12" fill="#e2e8f0">Model («entity»)</text>

    <line x1="550" y1="9" x2="590" y2="9" stroke="#94a3b8" stroke-width="2" stroke-dasharray="4" marker-end="url(#arrow)"/>
    <text x="600" y="14" font-size="12" fill="#94a3b8">Dependency / Call</text>
  </g>

  <!-- ========================================================================= -->
  <!-- LAYER 1: VIEW LAYER (BLADE TEMPLATES)                                      -->
  <!-- ========================================================================= -->
  <g transform="translate(50, 150)">
    <rect x="0" y="0" width="700" height="1650" rx="16" fill="#111827" stroke="#0284c7" stroke-width="2" filter="url(#shadow)"/>
    <rect x="0" y="0" width="700" height="50" rx="16" fill="url(#viewHeader)"/>
    <rect x="0" y="25" width="700" height="25" fill="url(#viewHeader)"/>
    <text x="25" y="32" font-size="18" font-weight="bold" fill="#ffffff">VIEW LAYER («boundary» — Blade Templates)</text>
    <text x="500" y="32" font-size="12" fill="#e0f2fe">resources/views/</text>

    <!-- Sub-package: Frontend Views -->
    <rect x="20" y="70" width="660" height="760" rx="12" fill="#1e293b" stroke="#334155" stroke-width="1.5"/>
    <text x="40" y="100" font-size="15" font-weight="bold" fill="#38bdf8">1. Frontend &amp; Layanan Publik Views</text>
    <line x1="40" y1="110" x2="660" y2="110" stroke="#334155" stroke-width="1"/>

    <!-- View Items -->
    ${[
      { name: "View_Login & Register", path: "pages/auth/login, register.blade.php", desc: "Form otentikasi warga & masyarakat" },
      { name: "View_ProfilDesa", path: "pages/profil-desa.blade.php", desc: "Sejarah, visi misi, potensi, wilayah" },
      { name: "View_StrukturDesa", path: "pages/struktur-desa.blade.php", desc: "Bagan perangkat & aparatur desa" },
      { name: "View_Berita & Detail", path: "pages/berita, berita-detail.blade.php", desc: "Portal artikel & berita desa" },
      { name: "View_UMKM & Detail", path: "pages/umkm, umkm-detail.blade.php", desc: "Katalog produk & produsen lokal" },
      { name: "View_Wisata & Detail", path: "pages/wisata, wisata-detail.blade.php", desc: "Destinasi wisata & panduan kunjungan" },
      { name: "View_Budaya & Detail", path: "pages/budaya, budaya-detail.blade.php", desc: "Seni tradisi & kearifan lokal" },
      { name: "View_Galeri & Detail", path: "pages/galeri, galeri-detail.blade.php", desc: "Foto & video dokumentasi desa" },
      { name: "View_Acara", path: "pages/acara.blade.php", desc: "Kalender agenda & acara desa" },
      { name: "View_PengajuanSurat", path: "pages/pengajuan-surat.blade.php", desc: "Form permohonan surat administrasi" },
      { name: "View_Pengaduan", path: "pages/pengaduan.blade.php", desc: "Form pengaduan aspirasi warga" },
      { name: "View_PertanyaanUmum", path: "pages/pertanyaan-umum.blade.php", desc: "Form interaksi tanya-jawab publik" },
      { name: "View_PendaftaranUmkm", path: "pages/pendaftaran-umkm.blade.php", desc: "Form pengajuan produk UMKM warga" },
      { name: "View_PengajuanSaya", path: "pages/pengajuan-saya/*.blade.php", desc: "Tracking status, riwayat & edit permohonan" }
    ].map((item, idx) => `
      <g transform="translate(35, ${125 + idx * 44})">
        <rect x="0" y="0" width="630" height="38" rx="8" fill="#0f172a" stroke="#1e293b"/>
        <text x="15" y="18" font-size="12" font-weight="bold" fill="#f1f5f9">${item.name}</text>
        <text x="15" y="32" font-size="10" fill="#64748b">${item.desc}</text>
        <text x="615" y="24" font-size="11" fill="#38bdf8" text-anchor="end">${item.path}</text>
      </g>
    `).join('')}

    <!-- Sub-package: Admin Backoffice Views -->
    <rect x="20" y="850" width="660" height="770" rx="12" fill="#1e293b" stroke="#334155" stroke-width="1.5"/>
    <text x="40" y="880" font-size="15" font-weight="bold" fill="#38bdf8">2. Admin Backoffice Views</text>
    <line x1="40" y1="890" x2="660" y2="890" stroke="#334155" stroke-width="1"/>

    ${[
      { name: "View_AdminDashboard", path: "admin/dashboard.blade.php", desc: "Statistik permohonan, berita, & grafik" },
      { name: "View_AdminPengajuanSurat", path: "admin/pengajuan-surat/*.blade.php", desc: "Verifikasi, persetujuan, & generate surat" },
      { name: "View_AdminJenisSurat", path: "admin/jenis-surat/*.blade.php", desc: "Konfigurasi format & syarat surat" },
      { name: "View_AdminPengaduan", path: "admin/pengaduan/*.blade.php", desc: "Daftar aduan warga & form tanggapan" },
      { name: "View_AdminPertanyaanUmum", path: "admin/pertanyaan-umum/*.blade.php", desc: "Daftar tanya-jawab & form jawaban" },
      { name: "View_AdminPendaftaranUmkm", path: "admin/pendaftaran-umkm/*.blade.php", desc: "Validasi & kurasi publikasi UMKM" },
      { name: "View_AdminBerita", path: "admin/berita/*.blade.php", desc: "CRUD artikel warta & berita desa" },
      { name: "View_AdminProduk", path: "admin/produk/*.blade.php", desc: "CRUD etalase produk UMKM" },
      { name: "View_AdminWisata", path: "admin/wisata/*.blade.php", desc: "CRUD objek destinasi wisata" },
      { name: "View_AdminBudaya", path: "admin/budaya/*.blade.php", desc: "CRUD warisan seni & budaya" },
      { name: "View_AdminGaleri", path: "admin/galeri/*.blade.php", desc: "CRUD media album foto & video" },
      { name: "View_AdminAcara", path: "admin/acara/*.blade.php", desc: "CRUD kalender kegiatan desa" },
      { name: "View_AdminProfilDesa", path: "admin/tentang_desa/index.blade.php", desc: "Kelola profil, sejarah, & timeline" },
      { name: "View_AdminStruktur", path: "admin/tentang/index.blade.php", desc: "Kelola susunan perangkat desa" },
      { name: "View_AdminKelolaAdmin", path: "admin/kelola-admin/*.blade.php", desc: "Manajemen akun perangkat desa & hak akses" },
      { name: "View_AdminPengaturan", path: "admin/pengaturan/index.blade.php", desc: "Pengaturan kontak, logo, & sistem" }
    ].map((item, idx) => `
      <g transform="translate(35, ${905 + idx * 43})">
        <rect x="0" y="0" width="630" height="37" rx="8" fill="#0f172a" stroke="#1e293b"/>
        <text x="15" y="17" font-size="12" font-weight="bold" fill="#f1f5f9">${item.name}</text>
        <text x="15" y="30" font-size="10" fill="#64748b">${item.desc}</text>
        <text x="615" y="24" font-size="11" fill="#38bdf8" text-anchor="end">${item.path}</text>
      </g>
    `).join('')}
  </g>

  <!-- ========================================================================= -->
  <!-- LAYER 2: CONTROLLER LAYER                                                 -->
  <!-- ========================================================================= -->
  <g transform="translate(790, 150)">
    <rect x="0" y="0" width="740" height="1650" rx="16" fill="#111827" stroke="#d97706" stroke-width="2" filter="url(#shadow)"/>
    <rect x="0" y="0" width="740" height="50" rx="16" fill="url(#ctrlHeader)"/>
    <rect x="0" y="25" width="740" height="25" fill="url(#ctrlHeader)"/>
    <text x="25" y="32" font-size="18" font-weight="bold" fill="#ffffff">CONTROLLER LAYER («control» — Application Logic)</text>
    <text x="530" y="32" font-size="12" fill="#fef3c7">app/Http/Controllers/</text>

    <!-- Sub-package: Frontend Controllers -->
    <rect x="20" y="70" width="700" height="710" rx="12" fill="#1e293b" stroke="#334155" stroke-width="1.5"/>
    <text x="40" y="100" font-size="15" font-weight="bold" fill="#fbbf24">1. Frontend Controllers (App\\Http\\Controllers)</text>
    <line x1="40" y1="110" x2="700" y2="110" stroke="#334155" stroke-width="1"/>

    ${[
      {
        name: "AuthController",
        methods: "+showLoginForm(), +login(Request), +showRegisterForm(), +register(Request), +logout(Request), +showAdminLoginForm(), +adminLogin(Request), +adminLogout(Request)"
      },
      {
        name: "PengajuanSuratController",
        methods: "+create(): View, +store(Request): Redirect, +edit($id): View, +update(Request, $id): Redirect, +batal($id): Redirect"
      },
      {
        name: "PengaduanController",
        methods: "+create(): View, +store(Request): Redirect, +edit($id): View, +update(Request, $id): Redirect, +batal($id): Redirect"
      },
      {
        name: "PertanyaanUmumController",
        methods: "+create(): View, +store(Request): Redirect, +edit($id): View, +update(Request, $id): Redirect, +batal($id): Redirect"
      },
      {
        name: "PendaftaranUmkmController",
        methods: "+create(): View, +store(Request): Redirect, +edit($id): View, +update(Request, $id): Redirect, +batal($id): Redirect"
      },
      {
        name: "PengajuanSayaController",
        methods: "+index(): View, +showDetail($jenis, $id): View, +show($id): Redirect"
      },
      {
        name: "ProfilDesaController",
        methods: "+index(): View (queries Pengaturan, Timeline, Misi, Struktur)"
      },
      {
        name: "UMKMController",
        methods: "+index(): View, +jenis($jenis): View, +detail($slug): View"
      },
      {
        name: "KontakController & SitemapController",
        methods: "Kontak: +store(Request): Response | Sitemap: +index(): Response (XML)"
      }
    ].map((c, idx) => `
      <g transform="translate(35, ${125 + idx * 71})">
        <rect x="0" y="0" width="670" height="62" rx="8" fill="#0f172a" stroke="#334155"/>
        <text x="15" y="20" font-size="13" font-weight="bold" fill="#f8fafc">${c.name}</text>
        <line x1="15" y1="28" x2="655" y2="28" stroke="#1e293b"/>
        <text x="15" y="44" font-size="10.5" fill="#94a3b8">${c.methods}</text>
      </g>
    `).join('')}

    <!-- Sub-package: Admin Backoffice Controllers -->
    <rect x="20" y="800" width="700" height="820" rx="12" fill="#1e293b" stroke="#334155" stroke-width="1.5"/>
    <text x="40" y="830" font-size="15" font-weight="bold" fill="#fbbf24">2. Admin Backoffice Controllers (App\\Http\\Controllers\\Admin)</text>
    <line x1="40" y1="840" x2="700" y2="840" stroke="#334155" stroke-width="1"/>

    ${[
      {
        name: "DashboardController",
        methods: "+index(): View (aggregates statistics for surat, aduan, berita, umkm)"
      },
      {
        name: "PengajuanSuratController (Admin)",
        methods: "+index(), +show($id), +updateStatus(Request, $id) [Alur Staff->Sekdes->Kades], +destroy($id)"
      },
      {
        name: "JenisSuratController",
        methods: "+index(), +create(), +store(Request), +show($id), +edit($id), +update(Request, $id), +destroy($id), +toggleActive($id)"
      },
      {
        name: "PengaduanController & PertanyaanUmumController (Admin)",
        methods: "+index(), +show($id), +updateStatus(Request, $id) [tanggapan/jawaban & status], +destroy($id)"
      },
      {
        name: "PendaftaranUmkmController (Admin)",
        methods: "+index(), +show($id), +updateStatus(Request, $id), +publikasikan($id) [Publish to UMKM], +destroy($id)"
      },
      {
        name: "BeritaController & UMKMController (Admin)",
        methods: "Berita: +index(), +create(), +store(), +edit(), +update(), +destroy() | UMKM: CRUD Produk"
      },
      {
        name: "WisataController, BudayaController, GaleriController (Admin)",
        methods: "+index(), +create(), +store(Request), +edit(), +update(Request, $id), +destroy($id)"
      },
      {
        name: "AcaraController (Admin)",
        methods: "+index(), +create(), +store(), +show(), +edit(), +update(), +destroy(), +publikasiAcara(), +updateStatus()"
      },
      {
        name: "ProfilDesaController & StrukturDesaController (Admin)",
        methods: "+desaIndex(), +desaUpdateSejarah/Kades/Visi/Peta, +timelineStore/Update/Destroy, +misiStore/Update/Destroy, +strukturCRUD"
      },
      {
        name: "AdminManagementController & PengaturanController",
        methods: "AdminMgmt: CRUD User (Staff/Kasi/Sekdes/Kades) | Pengaturan: +index(), +update(Request)"
      }
    ].map((c, idx) => `
      <g transform="translate(35, ${855 + idx * 75})">
        <rect x="0" y="0" width="670" height="66" rx="8" fill="#0f172a" stroke="#334155"/>
        <text x="15" y="20" font-size="13" font-weight="bold" fill="#f8fafc">${c.name}</text>
        <line x1="15" y1="28" x2="655" y2="28" stroke="#1e293b"/>
        <text x="15" y="44" font-size="10.5" fill="#94a3b8">${c.methods}</text>
      </g>
    `).join('')}
  </g>

  <!-- ========================================================================= -->
  <!-- LAYER 3: MODEL LAYER                                                       -->
  <!-- ========================================================================= -->
  <g transform="translate(1570, 150)">
    <rect x="0" y="0" width="780" height="1650" rx="16" fill="#111827" stroke="#059669" stroke-width="2" filter="url(#shadow)"/>
    <rect x="0" y="0" width="780" height="50" rx="16" fill="url(#modelHeader)"/>
    <rect x="0" y="25" width="780" height="25" fill="url(#modelHeader)"/>
    <text x="25" y="32" font-size="18" font-weight="bold" fill="#ffffff">MODEL LAYER («entity» — Domain &amp; Eloquent ORM)</text>
    <text x="640" y="32" font-size="12" fill="#d1fae5">app/Models/</text>

    <!-- Sub-package: Models List -->
    <rect x="20" y="70" width="740" height="1550" rx="12" fill="#1e293b" stroke="#334155" stroke-width="1.5"/>

    ${[
      {
        name: "User",
        table: "users",
        pk: "user_id",
        fields: "+name, email, password, role [enum: masyarakat, staff_desa, kasi_pemerintahan, sekretaris_desa, kepala_desa, admin], nik, no_hp, alamat, rt, rw, jenis_kelamin",
        relations: "Relasi: pengajuanSurat() [1..*], pengaduan() [1..*], pertanyaanUmum() [1..*], pendaftaranUmkm() [1..*], berita() [1..*], umkm() [1..*], wisata(), budaya(), galeri(), agendaAcara(), strukturDesa()"
      },
      {
        name: "PengajuanSurat",
        table: "pengajuan_surats",
        pk: "pengajuan_surat_id",
        fields: "+nomor_pengajuan, user_id [FK], jenis_surat_id [FK], status [enum: draft, menunggu_proses, diproses, diverifikasi, disetujui, ditolak, selesai, dibatalkan], keperluan, data_isian [JSON], dokumen_persyaratan [JSON], nomor_surat, tanggal_surat, diproses_oleh, diverifikasi_oleh, disetujui_oleh, file_surat",
        relations: "Relasi: user() [N..1], jenisSurat() [N..1], diprosesBy() [N..1 User], diverifikasiBy() [N..1 User], disetujuiBy() [N..1 User], riwayat() [1..* RiwayatPengajuanSurat]"
      },
      {
        name: "JenisSurat",
        table: "jenis_surat",
        pk: "id",
        fields: "+kode_surat, nama_surat, deskripsi, persyaratan [JSON/Array], format_nomor, is_active [bool]",
        relations: "Relasi: pengajuanSurats() [1..* PengajuanSurat]"
      },
      {
        name: "RiwayatPengajuanSurat",
        table: "riwayat_pengajuan_surats",
        pk: "id",
        fields: "+pengajuan_surat_id [FK], user_id [FK], status [string], catatan [text]",
        relations: "Relasi: pengajuanSurat() [N..1], user() [N..1]"
      },
      {
        name: "Pengaduan",
        table: "pengaduans",
        pk: "pengaduan_id",
        fields: "+kode_pengaduan, user_id [FK], nama_pengadu, email, nomor_telepon, judul, deskripsi, kategori, lokasi, lampiran, status [menunggu, diproses, selesai, ditolak, dibatalkan], tanggapan, ditanggapi_oleh [FK], ditanggapi_pada",
        relations: "Relasi: user() [N..1 User]"
      },
      {
        name: "PertanyaanUmum",
        table: "pertanyaan_umums",
        pk: "pertanyaan_id",
        fields: "+kode_pertanyaan, user_id [FK], nama_penanya, email, nomor_telepon, subjek, pesan, status [menunggu, dijawab, ditutup, dibatalkan], jawaban, dijawab_oleh [FK], dijawab_pada",
        relations: "Relasi: user() [N..1 User]"
      },
      {
        name: "PendaftaranUmkm",
        table: "pendaftaran_umkms",
        pk: "pendaftaran_umkm_id",
        fields: "+kode_pendaftaran, user_id [FK], nama_pemilik, nama_usaha, nomor_telepon, email, alamat_usaha, kategori_usaha, deskripsi_usaha, foto_produk, status [menunggu, diproses, disetujui, ditolak, dibatalkan], catatan, disetujui_oleh [FK]",
        relations: "Relasi: user() [N..1 User], produkDipublikasikan() [1..1 UMKM]"
      },
      {
        name: "UMKM",
        table: "produk",
        pk: "produk_id",
        fields: "+nama_usaha, pemilik, jenis_usaha, deskripsi, alamat, kontak, foto, status, pendaftaran_umkm_id [FK], user_id [FK]",
        relations: "Relasi: user() [N..1 User], pendaftaranUmkm() [N..1 PendaftaranUmkm]"
      },
      {
        name: "Berita",
        table: "berita",
        pk: "berita_id",
        fields: "+judul, slug, ringkasan, konten, kategori, gambar, is_published [bool], views [int], user_id [FK], published_at",
        relations: "Relasi: user() [N..1 User]"
      },
      {
        name: "Wisata, Budaya, Galeri, AgendaAcara",
        table: "wisata, budaya, galeri, agenda_acaras",
        pk: "wisata_id, budaya_id, galeri_id, agenda_acara_id",
        fields: "Atribut: nama/judul, slug, deskripsi, lokasi, fasilitas/kategori/tipe, status, user_id [FK]",
        relations: "Relasi: masing-masing memiliki user() [N..1 User / Creator]"
      },
      {
        name: "StrukturDesa, Pengaturan, Timeline, Misi",
        table: "struktur_desa, pengaturan, tentang_timeline, tentang_misi",
        pk: "struktur_desa_id, pengaturan_id, tentang_timeline_id, tentang_misi_id",
        fields: "Struktur: +nama, jabatan, nip, urutan, status, periode | Pengaturan: +key, value | Timeline: +tahun, peristiwa | Misi: +misi",
        relations: "StrukturDesa: user() [N..1] | Konten Profil: dikelola oleh ProfilDesaController"
      }
    ].map((m, idx) => `
      <g transform="translate(35, ${85 + idx * 138})">
        <rect x="0" y="0" width="710" height="128" rx="8" fill="#0f172a" stroke="#334155"/>
        <text x="15" y="20" font-size="14" font-weight="bold" fill="#34d399">${m.name}</text>
        <text x="700" y="20" font-size="11" fill="#64748b" text-anchor="end">table: ${m.table} | PK: ${m.pk}</text>
        <line x1="15" y1="28" x2="695" y2="28" stroke="#1e293b"/>
        <text x="15" y="46" font-size="10.5" fill="#e2e8f0">${m.fields.length > 120 ? m.fields.substring(0, 118) + '...' : m.fields}</text>
        ${m.fields.length > 120 ? `<text x="15" y="62" font-size="10.5" fill="#e2e8f0">${m.fields.substring(118, 235)}...</text>` : ''}
        <line x1="15" y1="74" x2="695" y2="74" stroke="#1e293b" stroke-dasharray="3"/>
        <text x="15" y="94" font-size="10" font-weight="bold" fill="#38bdf8">${m.relations.length > 110 ? m.relations.substring(0, 108) + '...' : m.relations}</text>
        ${m.relations.length > 110 ? `<text x="15" y="112" font-size="10" fill="#94a3b8">${m.relations.substring(108, 220)}</text>` : ''}
      </g>
    `).join('')}
  </g>

  <!-- ========================================================================= -->
  <!-- CONNECTORS: VIEW -> CONTROLLER & CONTROLLER -> MODEL                      -->
  <!-- ========================================================================= -->
  <g stroke-width="2">
    <!-- View to Controller lines -->
    <path d="M 750 350 L 790 350" stroke="#38bdf8" stroke-dasharray="5,5" marker-end="url(#arrow-blue)"/>
    <path d="M 750 600 L 790 600" stroke="#38bdf8" stroke-dasharray="5,5" marker-end="url(#arrow-blue)"/>
    <path d="M 750 1100 L 790 1100" stroke="#38bdf8" stroke-dasharray="5,5" marker-end="url(#arrow-blue)"/>
    <path d="M 750 1400 L 790 1400" stroke="#38bdf8" stroke-dasharray="5,5" marker-end="url(#arrow-blue)"/>

    <!-- Controller to Model lines -->
    <path d="M 1530 350 L 1570 350" stroke="#fbbf24" stroke-dasharray="5,5" marker-end="url(#arrow-amber)"/>
    <path d="M 1530 600 L 1570 600" stroke="#fbbf24" stroke-dasharray="5,5" marker-end="url(#arrow-amber)"/>
    <path d="M 1530 1100 L 1570 1100" stroke="#fbbf24" stroke-dasharray="5,5" marker-end="url(#arrow-amber)"/>
    <path d="M 1530 1400 L 1570 1400" stroke="#fbbf24" stroke-dasharray="5,5" marker-end="url(#arrow-amber)"/>
  </g>

  <!-- Annotations on arrows -->
  <rect x="742" y="325" width="56" height="20" rx="4" fill="#0284c7"/>
  <text x="770" y="339" font-size="9" font-weight="bold" fill="#ffffff" text-anchor="middle">Route</text>

  <rect x="742" y="575" width="56" height="20" rx="4" fill="#0284c7"/>
  <text x="770" y="589" font-size="9" font-weight="bold" fill="#ffffff" text-anchor="middle">HTTP Post</text>

  <rect x="742" y="1075" width="56" height="20" rx="4" fill="#0284c7"/>
  <text x="770" y="1089" font-size="9" font-weight="bold" fill="#ffffff" text-anchor="middle">Admin UI</text>

  <rect x="1522" y="325" width="56" height="20" rx="4" fill="#d97706"/>
  <text x="1550" y="339" font-size="9" font-weight="bold" fill="#ffffff" text-anchor="middle">Eloquent</text>

  <rect x="1522" y="575" width="56" height="20" rx="4" fill="#d97706"/>
  <text x="1550" y="589" font-size="9" font-weight="bold" fill="#ffffff" text-anchor="middle">Mutation</text>

  <rect x="1522" y="1075" width="56" height="20" rx="4" fill="#d97706"/>
  <text x="1550" y="1089" font-size="9" font-weight="bold" fill="#ffffff" text-anchor="middle">Workflow</text>

</svg>`;

    return svg;
}

const outputPath = path.join(__dirname, 'class_diagram_mvc.svg');
fs.writeFileSync(outputPath, generateSvg(), 'utf-8');
console.log('SVG successfully generated at ' + outputPath);
