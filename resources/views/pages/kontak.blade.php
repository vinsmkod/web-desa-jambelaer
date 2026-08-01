@extends('layouts.app')

@section('title', 'Kontak')
@section('meta_desc', 'Hubungi Kantor Desa Jambelaer, Dawuan, Subang. Kirim pertanyaan, atau permintaan kemitraan UMKM melalui formulir kontak resmi kami.')

@section('content')

{{-- ══════════════════════════════════════════════════════════════════
     PAGE HEADER BANNER
══════════════════════════════════════════════════════════════════ --}}
<div class="relative h-64 sm:h-80 overflow-hidden bg-forest-900 rounded-[32px] mx-3 sm:mx-5 lg:mx-6 mt-8 sm:mt-10 shadow-sm">
    <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1920&q=80"
         alt="Kantor Desa Jambelaer" class="w-full h-full object-cover opacity-70">
    <div class="absolute inset-0 bg-gradient-to-t from-forest-900 to-forest-900/50"></div>
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
        <span class="section-label !bg-white/10 !text-sand-300 !border-white/20">Layanan Informasi</span>
        <h1 class="font-display font-extrabold text-3xl sm:text-4xl text-white mt-3">Hubungi Kantor Desa</h1>
        <p class="text-sm text-white/50 mt-2 font-light max-w-md">Kami siap melayani pertanyaan, aspirasi, dan keperluan Anda</p>
    </div>
</div>

<div class="bg-white pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ══════════════════════════════════════════════════════════
             KONTAK INFO STRIP
        ══════════════════════════════════════════════════════════ --}}
        <div class="py-10 border-b border-stone-100">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="flex items-start gap-4 p-4 sm:p-5 bg-forest-50 border border-forest-100 rounded-xl">
                    <div class="w-10 h-10 rounded-lg bg-forest-800 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="map-pin" class="w-4 h-4 text-sand-300"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold tracking-widest uppercase text-forest-600 block">Alamat</span>
                        <span class="text-sm text-stone-700 font-medium leading-snug mt-1 block">Jl. Raya Jambelaer, Dawuan, Subang 41270</span>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 sm:p-5 bg-sand-50 border border-sand-100 rounded-xl">
                    <div class="w-10 h-10 rounded-lg bg-sand-500 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="phone" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold tracking-widest uppercase text-sand-600 block">Telepon</span>
                        <span class="text-sm text-stone-700 font-medium leading-snug mt-1 block">{{ \App\Models\Pengaturan::get('kontak_telp', '(0260) 123456') }}</span>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 sm:p-5 bg-stone-50 border border-stone-100 rounded-xl">
                    <div class="w-10 h-10 rounded-lg bg-stone-600 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="mail" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold tracking-widest uppercase text-stone-500 block">Email</span>
                        <span class="text-sm text-stone-700 font-medium leading-snug mt-1 block break-all">{{ \App\Models\Pengaturan::get('kontak_email', 'info@jambelaer-subang.desa.id') }}</span>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 sm:p-5 bg-sky-50 border border-sky-100 rounded-xl">
                    <div class="w-10 h-10 rounded-lg bg-sky-600 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="clock" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold tracking-widest uppercase text-sky-600 block">Jam Layanan</span>
                        <span class="text-sm text-stone-700 font-medium leading-snug mt-1 block">Sen–Jum: 08.00–15.30 WIB</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════
             FORM + INFO PANEL
        ══════════════════════════════════════════════════════════ --}}
        <div class="py-14 grid lg:grid-cols-12 gap-10 items-start reveal-on-scroll">

            {{-- Left: Info Panel --}}
            <div class="lg:col-span-5 space-y-5">
                {{-- Office Info Card --}}
                <div class="bg-forest-900 text-white rounded-xl p-7">
                    <h2 class="font-display font-bold text-lg text-white mb-5 pb-4 border-b border-white/10">
                        Kantor Desa Jambelaer
                    </h2>
                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <div class="w-9 h-9 rounded-lg bg-white/8 border border-white/10 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="map-pin" class="w-4 h-4 text-sand-400"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-sand-500 font-bold tracking-widest uppercase block">Alamat Lengkap</span>
                                <span class="text-sm text-white/70 font-light mt-1 block leading-relaxed">Jl. Raya Jambelaer No. 12, Kecamatan Dawuan, Kabupaten Subang, Jawa Barat 41270</span>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-9 h-9 rounded-lg bg-white/8 border border-white/10 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="phone" class="w-4 h-4 text-sand-400"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-sand-500 font-bold tracking-widest uppercase block">Telepon / Fax</span>
                                <span class="text-sm text-white/70 font-light mt-1 block">{{ \App\Models\Pengaturan::get('kontak_telp', '(0260) 123456') }}</span>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-9 h-9 rounded-lg bg-white/8 border border-white/10 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="mail" class="w-4 h-4 text-sand-400"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-sand-500 font-bold tracking-widest uppercase block">Email Resmi</span>
                                <span class="text-sm text-white/70 font-light mt-1 block">{{ \App\Models\Pengaturan::get('kontak_email', 'info@jambelaer-subang.desa.id') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Jam Layanan Card --}}
                <div class="bg-white border border-stone-200 rounded-xl p-6">
                    <h3 class="font-display font-bold text-sm text-forest-900 mb-4 flex items-center gap-2">
                        <i data-lucide="calendar-clock" class="w-4 h-4 text-sand-500"></i>
                        Jam Operasional Layanan
                    </h3>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between py-2 border-b border-stone-50">
                            <span class="text-sm text-stone-600 font-medium">Senin – Kamis</span>
                            <span class="text-sm font-semibold text-forest-800 bg-forest-50 px-3 py-1 rounded-full text-xs">08.00 – 15.30 WIB</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-stone-50">
                            <span class="text-sm text-stone-600 font-medium">Jumat</span>
                            <span class="text-sm font-semibold text-forest-800 bg-forest-50 px-3 py-1 rounded-full text-xs">08.00 – 11.30 WIB</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-stone-400 font-medium">Sabtu – Minggu</span>
                            <span class="text-xs font-semibold text-red-600 bg-red-50 px-3 py-1 rounded-full">Libur</span>
                        </div>
                    </div>
                </div>

                {{-- Sosmed Card --}}
                <div class="bg-sand-50 border border-sand-100 rounded-xl p-6">
                    <h3 class="font-display font-bold text-sm text-forest-900 mb-4">Media Sosial Resmi Desa</h3>
                    @php
                        $kIg = \App\Models\Pengaturan::get('sosmed_instagram', '');
                        $kYt = \App\Models\Pengaturan::get('sosmed_youtube', '');
                        $kTt = \App\Models\Pengaturan::get('sosmed_tiktok', '');
                    @endphp
                    <div class="flex flex-wrap gap-2">
                        @if($kIg)
                        <a href="{{ str_starts_with($kIg, 'http') ? $kIg : 'https://'.$kIg }}" target="_blank" rel="noopener"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg bg-white border border-stone-200 text-sm text-stone-700 hover:border-pink-300 hover:text-pink-600 transition-all">
                            <i data-lucide="instagram" class="w-4 h-4"></i> Instagram
                        </a>
                        @endif
                        @if($kYt)
                        <a href="{{ str_starts_with($kYt, 'http') ? $kYt : 'https://'.$kYt }}" target="_blank" rel="noopener"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg bg-white border border-stone-200 text-sm text-stone-700 hover:border-red-300 hover:text-red-600 transition-all">
                            <i data-lucide="youtube" class="w-4 h-4"></i> YouTube
                        </a>
                        @endif
                        @if(!$kIg && !$kYt && !$kTt)
                        <p class="text-xs text-stone-400 font-light">Media sosial belum dikonfigurasi.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right: Form --}}
            <div class="lg:col-span-7">
                <div class="bg-white border border-stone-200 rounded-xl p-7 sm:p-9 shadow-sm">
                    <h2 class="font-display font-bold text-xl text-forest-900 mb-1">Kirim Pesan</h2>
                    <p class="text-sm text-stone-400 font-light mb-7">Isi formulir di bawah ini, kami akan membalas pesan Anda.</p>

                    {{-- Success Alert --}}
                    @if(session('success'))
                    <div id="contact-success" class="mb-6 p-4 rounded-xl bg-forest-50 border border-forest-200 flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-forest-800 flex items-center justify-center flex-shrink-0 text-white">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <span class="font-bold text-forest-900 text-sm block">Pesan Berhasil Terkirim!</span>
                            <span class="text-xs text-forest-700/80 font-light mt-0.5 block">{{ session('success') }}</span>
                        </div>
                    </div>
                    @else
                    <div id="contact-success" class="hidden mb-6 p-4 rounded-xl bg-forest-50 border border-forest-200 flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-forest-800 flex items-center justify-center flex-shrink-0 text-white">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <span class="font-bold text-forest-900 text-sm block">Pesan Berhasil Terkirim!</span>
                            <span class="text-xs text-forest-700/80 font-light mt-0.5 block">Terima kasih atas pesan Anda. Kami akan segera merespons.</span>
                        </div>
                    </div>
                    @endif

                    {{-- Error Alert --}}
                    <div id="contact-error" class="hidden mb-6 p-4 rounded-xl bg-red-50 border border-red-200 flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-red-600 flex items-center justify-center flex-shrink-0 text-white">
                            <i data-lucide="alert-circle" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <span class="font-bold text-red-900 text-sm block">Gagal Mengirim Pesan</span>
                            <ul id="error-list" class="text-xs text-red-700/80 font-light mt-1 list-disc list-inside space-y-1"></ul>
                        </div>
                    </div>

                    <form id="contact-form" method="POST" action="{{ route('kontak.store') }}" class="space-y-4">
                        @csrf

                        {{-- Style umum input --}}
                        <style>
                            .input-village {
                                width: 100%;
                                padding: 14px 16px 6px 16px;
                                border: 1px solid #e7e5e4;
                                border-radius: 8px;
                                font-size: 0.875rem;
                                font-weight: 500;
                                color: #292524;
                                background: #fdfaf5;
                                outline: none;
                                transition: border-color 0.2s, box-shadow 0.2s;
                                appearance: none;
                            }
                            .input-village:focus {
                                border-color: #1a4731;
                                box-shadow: 0 0 0 3px rgba(26,71,49,0.08);
                                background: #ffffff;
                            }
                            .label-float {
                                position: absolute;
                                left: 16px;
                                top: 4px;
                                font-size: 0.65rem;
                                font-weight: 700;
                                letter-spacing: 0.1em;
                                text-transform: uppercase;
                                color: #a8a29e;
                                pointer-events: none;
                            }
                            .input-wrap { position: relative; }
                        </style>

                        {{-- Jenis Pesan --}}
                        <div class="input-wrap">
                            <label class="label-float">Jenis Pesan</label>
                            <select id="jenis-pesan" name="jenis_pesan" required class="input-village pt-7 cursor-pointer">
                                <option value="">— Pilih Jenis Pesan —</option>
                                <option value="pertanyaan_umum">Pertanyaan Umum</option>
                                <option value="pengaduan">Pengaduan</option>
                                <option value="kerja_sama">Kerja Sama</option>
                                <option value="pengajuan_acara">Pengajuan Acara</option>
                            </select>
                            <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-5 pointer-events-none text-stone-400"></i>
                        </div>

                        {{-- Nama Lengkap --}}
                        <div class="input-wrap">
                            <label class="label-float" for="f-name">Nama Lengkap</label>
                            <input id="f-name" name="name" type="text" required placeholder="" class="input-village pt-7">
                        </div>

                        {{-- WhatsApp (Pertanyaan Umum) --}}
                        <div id="field-email" class="hidden input-wrap">
                            <label class="label-float" for="f-email">Nomor WhatsApp</label>
                            <input id="f-email" name="no_whatsapp" type="tel" placeholder="" class="input-village pt-7">
                        </div>

                        {{-- WhatsApp (Pengaduan/Kerjasama/Acara) --}}
                        <div id="field-whatsapp" class="hidden input-wrap">
                            <label class="label-float" for="f-whatsapp">Nomor WhatsApp</label>
                            <input id="f-whatsapp" name="no_whatsapp" type="text" placeholder="" class="input-village pt-7">
                        </div>

                        {{-- Subjek --}}
                        <div id="field-subject" class="hidden input-wrap">
                            <label id="label-subject" class="label-float" for="f-subject">Subjek Pesan</label>
                            <input id="f-subject" name="subject" type="text" placeholder="" class="input-village pt-7">
                        </div>

                        {{-- Email Kerja Sama --}}
                        <div id="field-email-kerja-sama" class="hidden input-wrap">
                            <label class="label-float" for="f-email-ks">Alamat Email</label>
                            <input id="f-email-ks" name="email" type="email" placeholder="" class="input-village pt-7">
                        </div>

                        {{-- Nama Instansi --}}
                        <div id="field-nama-instansi" class="hidden input-wrap">
                            <label class="label-float" for="f-instansi">Nama Instansi / Organisasi</label>
                            <input id="f-instansi" name="nama_instansi" type="text" placeholder="" class="input-village pt-7">
                        </div>

                        {{-- Nama Acara --}}
                        <div id="field-nama-acara" class="hidden input-wrap">
                            <label class="label-float" for="f-nama-acara">Nama Acara</label>
                            <input id="f-nama-acara" name="nama_acara" type="text" placeholder="" class="input-village pt-7">
                        </div>

                        {{-- Tanggal & Waktu --}}
                        <div id="field-tanggal-waktu" class="hidden grid sm:grid-cols-2 gap-4">
                            <div class="input-wrap">
                                <label class="label-float" for="f-tanggal-acara">Tanggal Acara</label>
                                <input id="f-tanggal-acara" name="tanggal_acara" type="date" class="input-village pt-7">
                            </div>
                            <div class="input-wrap">
                                <label class="label-float" for="f-waktu-acara">Waktu Acara</label>
                                <input id="f-waktu-acara" name="waktu_acara" type="time" class="input-village pt-7">
                            </div>
                        </div>

                        {{-- Lokasi & Peserta --}}
                        <div id="field-lokasi-peserta" class="hidden grid sm:grid-cols-2 gap-4">
                            <div class="input-wrap">
                                <label class="label-float" for="f-lokasi-acara">Lokasi Acara</label>
                                <input id="f-lokasi-acara" name="lokasi_acara" type="text" placeholder="" class="input-village pt-7">
                            </div>
                            <div class="input-wrap">
                                <label class="label-float" for="f-jumlah-peserta">Perkiraan Peserta</label>
                                <input id="f-jumlah-peserta" name="jumlah_peserta" type="number" min="1" placeholder="" class="input-village pt-7">
                            </div>
                        </div>

                        {{-- Pesan --}}
                        <div id="field-message" class="hidden input-wrap">
                            <label id="label-message" class="label-float" for="f-msg">Isi Pesan</label>
                            <textarea id="f-msg" name="message" rows="4" placeholder="" class="input-village pt-7 resize-none"></textarea>
                        </div>

                        {{-- Submit --}}
                        <button id="submit-btn" type="submit" disabled
                            class="w-full btn-primary justify-center h-13 text-[11px] disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0 disabled:hover:shadow-none">
                            <span id="btn-text">Pilih Jenis Pesan</span>
                            <i data-lucide="send" class="w-4 h-4 ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════
             MAPS
        ══════════════════════════════════════════════════════════ --}}
        <div class="py-10 border-t border-stone-100 reveal-on-scroll delay-100">
            <div class="text-center mb-8">
                <span class="section-label">Peta Lokasi</span>
                <h2 class="font-display font-extrabold text-2xl text-forest-900 mt-3">Temukan Kami di Sini</h2>
                <div class="section-divider"></div>
            </div>
            <div class="bg-white border border-stone-200 rounded-xl p-3 shadow-sm max-w-5xl mx-auto">
                <div class="h-80 sm:h-96 rounded-lg overflow-hidden">
                    <iframe
                        src="{{ !empty($mapsUrl) ? $mapsUrl : 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.262529813204!2d107.6761755!3d-6.612457!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6923c6db1dfea3%3A0xc0f3970f1ff4dff9!2sKantor%20Desa%20Jambelaer!5e0!3m2!1sid!2sid!4v1720894000000!5m2!1sid!2sid' }}"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="flex items-center gap-3 px-3 pt-3 pb-1">
                    <i data-lucide="map-pin" class="w-4 h-4 text-forest-600 flex-shrink-0"></i>
                    <span class="text-xs text-stone-500 font-light">Jl. Raya Jambelaer, Kecamatan Dawuan, Kabupaten Subang, Jawa Barat 41270</span>
                    <a href="https://maps.google.com" target="_blank" class="ml-auto text-[11px] text-forest-700 font-semibold hover:text-forest-500 whitespace-nowrap flex items-center gap-1">
                        Buka Maps <i data-lucide="external-link" class="w-3 h-3"></i>
                    </a>
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
    const btnText = document.getElementById('btn-text');
    const jenisPesanSelect = document.getElementById('jenis-pesan');

    const fieldEmail = document.getElementById('field-email');
    const fieldWhatsapp = document.getElementById('field-whatsapp');
    const fieldSubject = document.getElementById('field-subject');
    const fieldEmailKerjaSama = document.getElementById('field-email-kerja-sama');
    const fieldNamaInstansi = document.getElementById('field-nama-instansi');
    const fieldNamaAcara = document.getElementById('field-nama-acara');
    const fieldTanggalWaktu = document.getElementById('field-tanggal-waktu');
    const fieldLokasiPeserta = document.getElementById('field-lokasi-peserta');
    const fieldMessage = document.getElementById('field-message');

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
    const labelSubject = document.getElementById('label-subject');
    const labelMessage = document.getElementById('label-message');

    function hideAllDynamicFields() {
        [fieldEmail, fieldWhatsapp, fieldSubject, fieldEmailKerjaSama,
         fieldNamaInstansi, fieldNamaAcara, fieldTanggalWaktu,
         fieldLokasiPeserta, fieldMessage].forEach(f => f.classList.add('hidden'));

        [inputEmail, inputWhatsapp, inputSubject, inputEmailKS, inputInstansi,
         inputNamaAcara, inputTanggalAcara, inputWaktuAcara,
         inputLokasiAcara, inputJumlahPeserta, inputMessage].forEach(inp => {
            inp.removeAttribute('required');
            inp.disabled = true;
        });
    }

    function showFieldWithRequired(field, input) {
        field.classList.remove('hidden');
        input.disabled = false;
        input.setAttribute('required', 'required');
    }

    function updateFormFields() {
        const jenisPesan = jenisPesanSelect.value;
        hideAllDynamicFields();
        submitBtn.disabled = false;

        if (jenisPesan === 'pertanyaan_umum') {
            showFieldWithRequired(fieldEmail, inputEmail);
            showFieldWithRequired(fieldSubject, inputSubject);
            labelSubject.textContent = 'Subjek Pesan';
            inputMessage.name = 'message';
            showFieldWithRequired(fieldMessage, inputMessage);
            labelMessage.textContent = 'Isi Pesan';
            btnText.textContent = 'Kirim Pesan';
        } else if (jenisPesan === 'pengaduan') {
            showFieldWithRequired(fieldWhatsapp, inputWhatsapp);
            showFieldWithRequired(fieldSubject, inputSubject);
            labelSubject.textContent = 'Subjek Pengaduan';
            inputMessage.name = 'message';
            showFieldWithRequired(fieldMessage, inputMessage);
            labelMessage.textContent = 'Isi Pengaduan';
            btnText.textContent = 'Kirim Pengaduan';
        } else if (jenisPesan === 'kerja_sama') {
            showFieldWithRequired(fieldWhatsapp, inputWhatsapp);
            showFieldWithRequired(fieldEmailKerjaSama, inputEmailKS);
            showFieldWithRequired(fieldNamaInstansi, inputInstansi);
            inputMessage.name = 'message';
            showFieldWithRequired(fieldMessage, inputMessage);
            labelMessage.textContent = 'Isi Pesan Kerja Sama';
            btnText.textContent = 'Kirim Kerja Sama';
        } else if (jenisPesan === 'pengajuan_acara') {
            showFieldWithRequired(fieldWhatsapp, inputWhatsapp);
            showFieldWithRequired(fieldNamaAcara, inputNamaAcara);
            showFieldWithRequired(fieldTanggalWaktu, inputTanggalAcara);
            inputWaktuAcara.disabled = false;
            inputWaktuAcara.setAttribute('required', 'required');
            showFieldWithRequired(fieldLokasiPeserta, inputLokasiAcara);
            inputJumlahPeserta.disabled = false;
            inputJumlahPeserta.setAttribute('required', 'required');
            inputMessage.name = 'deskripsi_acara';
            showFieldWithRequired(fieldMessage, inputMessage);
            labelMessage.textContent = 'Deskripsi Acara';
            btnText.textContent = 'Kirim Pengajuan';
        } else {
            submitBtn.disabled = true;
            btnText.textContent = 'Pilih Jenis Pesan';
        }
        lucide.createIcons();
    }

    const errorBox = document.getElementById('contact-error');
    const errorList = document.getElementById('error-list');

    jenisPesanSelect.addEventListener('change', updateFormFields);

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        successBox.classList.add('hidden');
        errorBox.classList.add('hidden');
        errorList.innerHTML = '';

        const originalBtnText = btnText.textContent;
        submitBtn.disabled = true;
        btnText.textContent = 'Mengirim...';

        fetch(form.action, {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: new FormData(form)
        })
        .then(response => {
            return response.json().then(data => {
                if (!response.ok) {
                    if (data.errors && typeof data.errors === 'object') {
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
            form.reset();
            updateFormFields();
            successBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        })
        .catch(err => {
            errorBox.classList.remove('hidden');
            const errors = err.message.split('<br>');
            errors.forEach(errMsg => {
                const li = document.createElement('li');
                li.textContent = errMsg;
                errorList.appendChild(li);
            });
            submitBtn.disabled = false;
            btnText.textContent = originalBtnText;
            lucide.createIcons();
            errorBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });
    });

    updateFormFields();
</script>
@endpush