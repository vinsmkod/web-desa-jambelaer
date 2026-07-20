@extends('layouts.app')

@section('title', 'Kontak')
@section('meta_desc', 'Hubungi Kantor Desa Jambelaer, Dawuan, Subang. Kirim pertanyaan, atau permintaan kemitraan UMKM melalui formulir kontak resmi kami.')

@section('content')
<div class="pt-28 pb-24 bg-gradient-to-b from-ivory to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 reveal-on-scroll">
            <span class="text-xs font-bold tracking-widest uppercase text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">Layanan Informasi</span>
            <h1 class="font-display font-extrabold text-3xl sm:text-4xl text-emerald-950 mt-3">Hubungi Kantor Desa Kami</h1>
            <p class="mt-4 text-slate-500 font-light text-sm sm:text-base">
                Apakah Anda memiliki pertanyaan mengenai pelayanan administrasi, potensi kemitraan UMKM, atau kunjungan budaya? Tim kami siap melayani Anda.
            </p>
            <div class="w-16 h-1 bg-gradient-to-r from-emerald-800 to-amber-600 mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="grid lg:grid-cols-12 gap-12 items-stretch reveal-on-scroll delay-100">

            <!-- ── Left: Contact Info ── -->
            <div class="lg:col-span-5 bg-gradient-to-br from-emerald-950 to-emerald-900 rounded-3xl p-8 sm:p-10 text-white flex flex-col justify-between shadow-lg">
                <div class="space-y-8">
                    <div>
                        <h2 class="font-display font-bold text-2xl text-white">Kantor Desa Jambelaer</h2>
                        <p class="text-emerald-200/70 text-xs font-light mt-1">Kecamatan Dawuan, Kabupaten Subang, Jawa Barat, 41270</p>
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0 text-amber-400">
                                <i data-lucide="map-pin" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <span class="text-xs text-emerald-300 font-semibold tracking-wider block uppercase">Alamat Lengkap</span>
                                <span class="text-sm font-light text-emerald-50 mt-1 block leading-relaxed">Jl. Raya Jambelaer No. 12, Dawuan, Subang, Jawa Barat, 41270</span>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0 text-amber-400">
                                <i data-lucide="phone" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <span class="text-xs text-emerald-300 font-semibold tracking-wider block uppercase">Hubungi Kami</span>
                                <span class="text-sm font-light text-emerald-50 mt-1 block">(0260) 123456 / +62 812-3456-7890</span>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0 text-amber-400">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <span class="text-xs text-emerald-300 font-semibold tracking-wider block uppercase">Email Resmi</span>
                                <span class="text-sm font-light text-emerald-50 mt-1 block">info@jambelaer-subang.desa.id</span>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0 text-amber-400">
                                <i data-lucide="clock" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <span class="text-xs text-emerald-300 font-semibold tracking-wider block uppercase">Jam Operasional</span>
                                <span class="text-sm font-light text-emerald-50 mt-1 block">Senin – Jumat: 08:00 – 15:30 WIB</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-8 border-t border-white/10 mt-8">
                    <span class="text-xs text-emerald-300 font-semibold tracking-wider block uppercase mb-3">Media Sosial Desa</span>
                    <div class="flex items-center space-x-3">
                        <a href="#" class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center hover:bg-amber-600 transition-all text-emerald-100"><i data-lucide="facebook" class="w-4 h-4"></i></a>
                        <a href="#" class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center hover:bg-amber-600 transition-all text-emerald-100"><i data-lucide="instagram" class="w-4 h-4"></i></a>
                        <a href="#" class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center hover:bg-amber-600 transition-all text-emerald-100"><i data-lucide="youtube" class="w-4 h-4"></i></a>
                    </div>
                </div>
            </div>

            <!-- ── Right: Form + Map ── -->
            <div class="lg:col-span-7 flex flex-col space-y-6">

                <!-- Form Card -->
                <div class="bg-white border border-slate-100 rounded-3xl p-8 sm:p-10 shadow-sm flex-grow">
                    <h2 class="font-display font-bold text-xl text-emerald-950 mb-6">Hubungi Kami</h2>

                    <!-- Success Alert -->
                    @if(session('success'))
                    <div id="contact-success" class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex items-start space-x-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0 text-emerald-800">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <span class="font-bold text-emerald-950 text-sm block">Pesan Berhasil Terkirim!</span>
                            <span class="text-xs text-emerald-700/80 font-light mt-0.5 block">{{ session('success') }}</span>
                        </div>
                    </div>
                    @else
                    <div id="contact-success" class="hidden mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex items-start space-x-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0 text-emerald-800">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <span class="font-bold text-emerald-950 text-sm block">Pesan Berhasil Terkirim!</span>
                            <span class="text-xs text-emerald-700/80 font-light mt-0.5 block">Terima kasih atas pesan Anda. Kami akan segera meninjau pesan Anda.</span>
                        </div>
                    </div>
                    @endif

                    <!-- Error Alert -->
                    <div id="contact-error" class="hidden mb-6 p-4 rounded-xl bg-red-50 border border-red-200 flex items-start space-x-3">
                        <div class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0 text-red-800">
                            <i data-lucide="alert-circle" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <span class="font-bold text-red-950 text-sm block">Gagal Mengirim Pesan!</span>
                            <ul id="error-list" class="text-xs text-red-700/80 font-light mt-0.5 list-disc list-inside space-y-1"></ul>
                        </div>
                    </div>

                    <form id="contact-form" method="POST" action="{{ route('kontak.store') }}" class="space-y-5">
                        @csrf

                        <!-- Dropdown: Jenis Pesan -->
                        <div class="relative">
                            <select id="jenis-pesan" name="jenis_pesan" required
                                class="peer w-full px-4 pt-6 pb-2 border border-slate-200 rounded-xl focus:border-emerald-700 focus:ring-1 focus:ring-emerald-700 outline-none transition-all text-sm font-medium bg-white cursor-pointer appearance-none">
                                <option value="">-- Pilih Jenis Pesan --</option>
                                <option value="pertanyaan_umum">Pertanyaan Umum</option>
                                <option value="pengaduan">Pengaduan</option>
                                <option value="kerja_sama">Kerja Sama</option>
                                <option value="pengajuan_acara">Pengajuan Acara</option>
                            </select>
                            <label for="jenis-pesan" class="absolute left-4 top-4 text-xs font-semibold text-slate-400 tracking-wider uppercase pointer-events-none origin-left transition-all
                                peer-focus:-translate-y-2.5 peer-focus:scale-75 peer-focus:text-emerald-700
                                -translate-y-2.5 scale-75">Jenis Pesan</label>
                            <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-5 pointer-events-none text-slate-400"></i>
                        </div>

                        <!-- Common: Nama Lengkap -->
                        <div class="relative">
                            <input id="f-name" name="name" type="text" required placeholder=" "
                                class="peer w-full px-4 pt-6 pb-2 border border-slate-200 rounded-xl focus:border-emerald-700 focus:ring-1 focus:ring-emerald-700 outline-none transition-all text-sm font-medium">
                            <label for="f-name" class="absolute left-4 top-4 text-xs font-semibold text-slate-400 tracking-wider uppercase pointer-events-none origin-left transition-all
                                peer-placeholder-shown:text-sm peer-placeholder-shown:top-4
                                peer-focus:-translate-y-2.5 peer-focus:scale-75 peer-focus:text-emerald-700
                                -translate-y-2.5 scale-75">Nama Lengkap</label>
                        </div>

                        <!-- PERTANYAAN UMUM: Email + Subjek + Pesan -->
                        <div id="field-email" class="hidden relative">
                            <input id="f-email" name="email" type="email" placeholder=" "
                                class="peer w-full px-4 pt-6 pb-2 border border-slate-200 rounded-xl focus:border-emerald-700 focus:ring-1 focus:ring-emerald-700 outline-none transition-all text-sm font-medium">
                            <label for="f-email" class="absolute left-4 top-4 text-xs font-semibold text-slate-400 tracking-wider uppercase pointer-events-none origin-left transition-all
                                peer-placeholder-shown:text-sm peer-placeholder-shown:top-4
                                peer-focus:-translate-y-2.5 peer-focus:scale-75 peer-focus:text-emerald-700
                                -translate-y-2.5 scale-75">Alamat Email</label>
                        </div>

                        <!-- PENGADUAN + KERJA SAMA + PENGAJUAN ACARA: No WhatsApp -->
                        <div id="field-whatsapp" class="hidden relative">
                            <input id="f-whatsapp" name="no_whatsapp" type="text" placeholder=" "
                                class="peer w-full px-4 pt-6 pb-2 border border-slate-200 rounded-xl focus:border-emerald-700 focus:ring-1 focus:ring-emerald-700 outline-none transition-all text-sm font-medium">
                            <label for="f-whatsapp" class="absolute left-4 top-4 text-xs font-semibold text-slate-400 tracking-wider uppercase pointer-events-none origin-left transition-all
                                peer-placeholder-shown:text-sm peer-placeholder-shown:top-4
                                peer-focus:-translate-y-2.5 peer-focus:scale-75 peer-focus:text-emerald-700
                                -translate-y-2.5 scale-75">Nomor WhatsApp</label>
                        </div>

                        <!-- PERTANYAAN UMUM + PENGADUAN: Subjek -->
                        <div id="field-subject" class="hidden relative">
                            <input id="f-subject" name="subject" type="text" placeholder=" "
                                class="peer w-full px-4 pt-6 pb-2 border border-slate-200 rounded-xl focus:border-emerald-700 focus:ring-1 focus:ring-emerald-700 outline-none transition-all text-sm font-medium">
                            <label id="label-subject" for="f-subject" class="absolute left-4 top-4 text-xs font-semibold text-slate-400 tracking-wider uppercase pointer-events-none origin-left transition-all
                                peer-placeholder-shown:text-sm peer-placeholder-shown:top-4
                                peer-focus:-translate-y-2.5 peer-focus:scale-75 peer-focus:text-emerald-700
                                -translate-y-2.5 scale-75">Subjek Pesan</label>
                        </div>

                        <!-- KERJA SAMA: Email + Nama Instansi -->
                        <div id="field-email-kerja-sama" class="hidden relative">
                            <input id="f-email-ks" name="email" type="email" placeholder=" "
                                class="peer w-full px-4 pt-6 pb-2 border border-slate-200 rounded-xl focus:border-emerald-700 focus:ring-1 focus:ring-emerald-700 outline-none transition-all text-sm font-medium">
                            <label for="f-email-ks" class="absolute left-4 top-4 text-xs font-semibold text-slate-400 tracking-wider uppercase pointer-events-none origin-left transition-all
                                peer-placeholder-shown:text-sm peer-placeholder-shown:top-4
                                peer-focus:-translate-y-2.5 peer-focus:scale-75 peer-focus:text-emerald-700
                                -translate-y-2.5 scale-75">Alamat Email</label>
                        </div>

                        <div id="field-nama-instansi" class="hidden relative">
                            <input id="f-instansi" name="nama_instansi" type="text" placeholder=" "
                                class="peer w-full px-4 pt-6 pb-2 border border-slate-200 rounded-xl focus:border-emerald-700 focus:ring-1 focus:ring-emerald-700 outline-none transition-all text-sm font-medium">
                            <label for="f-instansi" class="absolute left-4 top-4 text-xs font-semibold text-slate-400 tracking-wider uppercase pointer-events-none origin-left transition-all
                                peer-placeholder-shown:text-sm peer-placeholder-shown:top-4
                                peer-focus:-translate-y-2.5 peer-focus:scale-75 peer-focus:text-emerald-700
                                -translate-y-2.5 scale-75">Nama Instansi / Organisasi</label>
                        </div>

                        <!-- PENGAJUAN ACARA: Nama Acara + Tanggal + Waktu + Lokasi + Jumlah Peserta -->
                        <div id="field-nama-acara" class="hidden relative">
                            <input id="f-nama-acara" name="nama_acara" type="text" placeholder=" "
                                class="peer w-full px-4 pt-6 pb-2 border border-slate-200 rounded-xl focus:border-emerald-700 focus:ring-1 focus:ring-emerald-700 outline-none transition-all text-sm font-medium">
                            <label for="f-nama-acara" class="absolute left-4 top-4 text-xs font-semibold text-slate-400 tracking-wider uppercase pointer-events-none origin-left transition-all
                                peer-placeholder-shown:text-sm peer-placeholder-shown:top-4
                                peer-focus:-translate-y-2.5 peer-focus:scale-75 peer-focus:text-emerald-700
                                -translate-y-2.5 scale-75">Nama Acara</label>
                        </div>

                        <div id="field-tanggal-waktu" class="hidden grid sm:grid-cols-2 gap-5">
                            <div class="relative">
                                <input id="f-tanggal-acara" name="tanggal_acara" type="date" placeholder=" "
                                    class="peer w-full px-4 pt-6 pb-2 border border-slate-200 rounded-xl focus:border-emerald-700 focus:ring-1 focus:ring-emerald-700 outline-none transition-all text-sm font-medium">
                                <label for="f-tanggal-acara" class="absolute left-4 top-4 text-xs font-semibold text-slate-400 tracking-wider uppercase pointer-events-none origin-left transition-all
                                    peer-focus:-translate-y-2.5 peer-focus:scale-75 peer-focus:text-emerald-700
                                    -translate-y-2.5 scale-75">Tanggal Acara</label>
                            </div>
                            <div class="relative">
                                <input id="f-waktu-acara" name="waktu_acara" type="time" placeholder=" "
                                    class="peer w-full px-4 pt-6 pb-2 border border-slate-200 rounded-xl focus:border-emerald-700 focus:ring-1 focus:ring-emerald-700 outline-none transition-all text-sm font-medium">
                                <label for="f-waktu-acara" class="absolute left-4 top-4 text-xs font-semibold text-slate-400 tracking-wider uppercase pointer-events-none origin-left transition-all
                                    peer-focus:-translate-y-2.5 peer-focus:scale-75 peer-focus:text-emerald-700
                                    -translate-y-2.5 scale-75">Waktu Acara</label>
                            </div>
                        </div>

                        <div id="field-lokasi-peserta" class="hidden grid sm:grid-cols-2 gap-5">
                            <div class="relative">
                                <input id="f-lokasi-acara" name="lokasi_acara" type="text" placeholder=" "
                                    class="peer w-full px-4 pt-6 pb-2 border border-slate-200 rounded-xl focus:border-emerald-700 focus:ring-1 focus:ring-emerald-700 outline-none transition-all text-sm font-medium">
                                <label for="f-lokasi-acara" class="absolute left-4 top-4 text-xs font-semibold text-slate-400 tracking-wider uppercase pointer-events-none origin-left transition-all
                                    peer-placeholder-shown:text-sm peer-placeholder-shown:top-4
                                    peer-focus:-translate-y-2.5 peer-focus:scale-75 peer-focus:text-emerald-700
                                    -translate-y-2.5 scale-75">Lokasi Acara</label>
                            </div>
                            <div class="relative">
                                <input id="f-jumlah-peserta" name="jumlah_peserta" type="number" min="1" placeholder=" "
                                    class="peer w-full px-4 pt-6 pb-2 border border-slate-200 rounded-xl focus:border-emerald-700 focus:ring-1 focus:ring-emerald-700 outline-none transition-all text-sm font-medium">
                                <label for="f-jumlah-peserta" class="absolute left-4 top-4 text-xs font-semibold text-slate-400 tracking-wider uppercase pointer-events-none origin-left transition-all
                                    peer-placeholder-shown:text-sm peer-placeholder-shown:top-4
                                    peer-focus:-translate-y-2.5 peer-focus:scale-75 peer-focus:text-emerald-700
                                    -translate-y-2.5 scale-75">Perkiraan Jumlah Peserta</label>
                            </div>
                        </div>

                        <!-- PERTANYAAN UMUM + PENGADUAN + KERJA SAMA + PENGAJUAN ACARA: Pesan -->
                        <div id="field-message" class="hidden relative">
                            <textarea id="f-msg" name="message" rows="4" placeholder=" "
                                class="peer w-full px-4 pt-6 pb-2 border border-slate-200 rounded-xl focus:border-emerald-700 focus:ring-1 focus:ring-emerald-700 outline-none transition-all text-sm font-medium resize-none"></textarea>
                            <label id="label-message" for="f-msg" class="absolute left-4 top-4 text-xs font-semibold text-slate-400 tracking-wider uppercase pointer-events-none origin-left transition-all
                                peer-placeholder-shown:text-sm peer-placeholder-shown:top-4
                                peer-focus:-translate-y-2.5 peer-focus:scale-75 peer-focus:text-emerald-700
                                -translate-y-2.5 scale-75">Isi Pesan</label>
                        </div>

                        <button id="submit-btn" type="submit" disabled
                            class="w-full inline-flex items-center justify-center h-14 text-sm font-bold tracking-wide uppercase text-white bg-emerald-900 hover:bg-emerald-800 disabled:bg-slate-300 disabled:cursor-not-allowed rounded-xl shadow-md transition-all duration-200">
                            Pilih Jenis Pesan
                            <i data-lucide="send" class="w-4 h-4 ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const form = document.getElementById('contact-form');
    const successBox = document.getElementById('contact-success');
    const submitBtn = document.getElementById('submit-btn');
    const jenisPesanSelect = document.getElementById('jenis-pesan');

    // Field Elements
    const fieldEmail = document.getElementById('field-email');
    const fieldWhatsapp = document.getElementById('field-whatsapp');
    const fieldSubject = document.getElementById('field-subject');
    const fieldEmailKerjaSama = document.getElementById('field-email-kerja-sama');
    const fieldNamaInstansi = document.getElementById('field-nama-instansi');
    const fieldNamaAcara = document.getElementById('field-nama-acara');
    const fieldTanggalWaktu = document.getElementById('field-tanggal-waktu');
    const fieldLokasiPeserta = document.getElementById('field-lokasi-peserta');
    const fieldMessage = document.getElementById('field-message');

    // Input Elements
    const inputEmail = document.getElementById('f-email');
    const inputWhatsapp = document.getElementById('f-whatsapp');
    const inputSubject = document.getElementById('f-subject');
    const inputEmailKS = document.getElementById('f-email-ks');
    const inputInstansi = document.getElementById('f-instansi');
    const inputNamaAcara = document.getElementById('f-nama-acara');
    const inputTanggalAcara = document.getElementById('f-tanggal-acara');
    const inputWaktuAcara = document.getElementById('f-waktu-acara');
    const inputLokasiAcara = document.getElementById('f-lokasi-acara');
    const inputJumlahPeserta = document.getElementById('f-jumlah-peserta');
    const inputMessage = document.getElementById('f-msg');

    // Label elements
    const labelSubject = document.getElementById('label-subject');
    const labelMessage = document.getElementById('label-message');

    // Fungsi untuk hide semua field dinamis
    function hideAllDynamicFields() {
        fieldEmail.classList.add('hidden');
        fieldWhatsapp.classList.add('hidden');
        fieldSubject.classList.add('hidden');
        fieldEmailKerjaSama.classList.add('hidden');
        fieldNamaInstansi.classList.add('hidden');
        fieldNamaAcara.classList.add('hidden');
        fieldTanggalWaktu.classList.add('hidden');
        fieldLokasiPeserta.classList.add('hidden');
        fieldMessage.classList.add('hidden');

        // Clear required and disable inputs
        inputEmail.removeAttribute('required');
        inputEmail.disabled = true;

        inputWhatsapp.removeAttribute('required');
        inputWhatsapp.disabled = true;

        inputSubject.removeAttribute('required');
        inputSubject.disabled = true;

        inputEmailKS.removeAttribute('required');
        inputEmailKS.disabled = true;

        inputInstansi.removeAttribute('required');
        inputInstansi.disabled = true;

        inputNamaAcara.removeAttribute('required');
        inputNamaAcara.disabled = true;

        inputTanggalAcara.removeAttribute('required');
        inputTanggalAcara.disabled = true;

        inputWaktuAcara.removeAttribute('required');
        inputWaktuAcara.disabled = true;

        inputLokasiAcara.removeAttribute('required');
        inputLokasiAcara.disabled = true;

        inputJumlahPeserta.removeAttribute('required');
        inputJumlahPeserta.disabled = true;

        inputMessage.removeAttribute('required');
        inputMessage.disabled = true;
    }

    // Fungsi untuk show field dengan required
    function showFieldWithRequired(field, input) {
        field.classList.remove('hidden');
        input.disabled = false;
        input.setAttribute('required', 'required');
    }

    // Update form berdasarkan jenis pesan
    function updateFormFields() {
        const jenisPesan = jenisPesanSelect.value;
        hideAllDynamicFields();

        // Reset button state
        submitBtn.disabled = false;

        if (jenisPesan === 'pertanyaan_umum') {
            // Pertanyaan Umum: Nama, Email, Subjek, Pesan
            showFieldWithRequired(fieldEmail, inputEmail);
            showFieldWithRequired(fieldSubject, inputSubject);
            labelSubject.textContent = 'Subjek Pesan';
            inputMessage.name = 'message'; // pastikan name benar
            showFieldWithRequired(fieldMessage, inputMessage);
            labelMessage.textContent = 'Isi Pesan';
            submitBtn.innerHTML = 'Kirim Pesan <i data-lucide="send" class="w-4 h-4 ml-2"></i>';
        }
        else if (jenisPesan === 'pengaduan') {
            // Pengaduan: Nama, WhatsApp, Subjek, Pesan
            showFieldWithRequired(fieldWhatsapp, inputWhatsapp);
            showFieldWithRequired(fieldSubject, inputSubject);
            labelSubject.textContent = 'Subjek Pengaduan';
            inputMessage.name = 'message'; // pastikan name benar
            showFieldWithRequired(fieldMessage, inputMessage);
            labelMessage.textContent = 'Isi Pengaduan';
            submitBtn.innerHTML = 'Kirim Pengaduan <i data-lucide="send" class="w-4 h-4 ml-2"></i>';
        }
        else if (jenisPesan === 'kerja_sama') {
            // Kerja Sama: Nama, WhatsApp, Email, Nama Instansi, Pesan
            showFieldWithRequired(fieldWhatsapp, inputWhatsapp);
            showFieldWithRequired(fieldEmailKerjaSama, inputEmailKS);
            showFieldWithRequired(fieldNamaInstansi, inputInstansi);
            inputMessage.name = 'message'; // pastikan name benar
            showFieldWithRequired(fieldMessage, inputMessage);
            labelMessage.textContent = 'Isi Pesan';
            submitBtn.innerHTML = 'Kirim Kerja Sama <i data-lucide="send" class="w-4 h-4 ml-2"></i>';
        }
        else if (jenisPesan === 'pengajuan_acara') {
            showFieldWithRequired(fieldWhatsapp, inputWhatsapp);
            showFieldWithRequired(fieldNamaAcara, inputNamaAcara);
            
            showFieldWithRequired(fieldTanggalWaktu, inputTanggalAcara);
            inputWaktuAcara.disabled = false;
            inputWaktuAcara.setAttribute('required', 'required');

            showFieldWithRequired(fieldLokasiPeserta, inputLokasiAcara);
            inputJumlahPeserta.disabled = false;
            inputJumlahPeserta.setAttribute('required', 'required');

            inputMessage.name = 'deskripsi_acara'; // controller pakai 'deskripsi_acara'
            showFieldWithRequired(fieldMessage, inputMessage);
            labelMessage.textContent = 'Deskripsi Acara';
            submitBtn.innerHTML = 'Kirim Pengajuan <i data-lucide="send" class="w-4 h-4 ml-2"></i>';
        }
        else {
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Pilih Jenis Pesan <i data-lucide="send" class="w-4 h-4 ml-2"></i>';
        }

        lucide.createIcons();
    }

    const errorBox = document.getElementById('contact-error');
    const errorList = document.getElementById('error-list');

    jenisPesanSelect.addEventListener('change', updateFormFields);

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Reset alerts
        successBox.classList.add('hidden');
        errorBox.classList.add('hidden');
        errorList.innerHTML = '';

        const originalBtnHTML = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<span>Mengirim...</span>
            <svg class="animate-spin ml-2 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>`;

        // Submit via fetch
        fetch(form.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new FormData(form)
        })
        .then(response => {
            return response.json().then(data => {
                if (!response.ok) {
                    if (data.errors && typeof data.errors === 'object') {
                        // Laravel validation errors object
                        const errorMsgs = Object.values(data.errors).flat();
                        throw new Error(errorMsgs.join('<br>'));
                    }
                    throw new Error(data.message || 'Terjadi kesalahan saat memproses data.');
                }
                return data;
            });
        })
        .then(data => {
            successBox.classList.remove('hidden');
            const successDesc = successBox.querySelector('span:nth-child(2)') || successBox.querySelector('.text-emerald-700\\/80');
            if (successDesc) {
                successDesc.textContent = data.message;
            }
            form.reset();
            updateFormFields();
            
            // Scroll to success box
            successBox.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        })
        .catch(err => {
            // Error
            errorBox.classList.remove('hidden');
            
            // Try to split error message by line breaks if it contains multiple errors
            const errors = err.message.split('<br>');
            errors.forEach(errMsg => {
                const li = document.createElement('li');
                li.textContent = errMsg;
                errorList.appendChild(li);
            });

            // Restore submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnHTML;
            lucide.createIcons();

            errorBox.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        });
    });

    updateFormFields();
</script>
@endpush