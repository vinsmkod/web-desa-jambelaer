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
                    <h2 class="font-display font-bold text-xl text-emerald-950 mb-6">Kirim Pertanyaan</h2>

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

                    <form id="contact-form" method="POST" action="{{ route('kontak.store') }}" class="space-y-5">
                        @csrf
                        <div class="grid sm:grid-cols-2 gap-5">
                            <!-- Floating: Nama -->
                            <div class="relative">
                                <input id="f-name" name="name" type="text" required placeholder=" "
                                    class="peer w-full px-4 pt-6 pb-2 border border-slate-200 rounded-xl focus:border-emerald-700 focus:ring-1 focus:ring-emerald-700 outline-none transition-all text-sm font-medium">
                                <label for="f-name" class="absolute left-4 top-4 text-xs font-semibold text-slate-400 tracking-wider uppercase pointer-events-none origin-left transition-all
                                    peer-placeholder-shown:text-sm peer-placeholder-shown:top-4
                                    peer-focus:-translate-y-2.5 peer-focus:scale-75 peer-focus:text-emerald-700
                                    -translate-y-2.5 scale-75">Nama Lengkap</label>
                            </div>
                            <!-- Floating: Email -->
                            <div class="relative">
                                <input id="f-email" name="email" type="email" required placeholder=" "
                                    class="peer w-full px-4 pt-6 pb-2 border border-slate-200 rounded-xl focus:border-emerald-700 focus:ring-1 focus:ring-emerald-700 outline-none transition-all text-sm font-medium">
                                <label for="f-email" class="absolute left-4 top-4 text-xs font-semibold text-slate-400 tracking-wider uppercase pointer-events-none origin-left transition-all
                                    peer-placeholder-shown:text-sm peer-placeholder-shown:top-4
                                    peer-focus:-translate-y-2.5 peer-focus:scale-75 peer-focus:text-emerald-700
                                    -translate-y-2.5 scale-75">Alamat Email</label>
                            </div>
                        </div>
                        <!-- Floating: Subjek -->
                        <div class="relative">
                            <input id="f-subj" name="subject" type="text" required placeholder=" "
                                class="peer w-full px-4 pt-6 pb-2 border border-slate-200 rounded-xl focus:border-emerald-700 focus:ring-1 focus:ring-emerald-700 outline-none transition-all text-sm font-medium">
                            <label for="f-subj" class="absolute left-4 top-4 text-xs font-semibold text-slate-400 tracking-wider uppercase pointer-events-none origin-left transition-all
                                peer-placeholder-shown:text-sm peer-placeholder-shown:top-4
                                peer-focus:-translate-y-2.5 peer-focus:scale-75 peer-focus:text-emerald-700
                                -translate-y-2.5 scale-75">Subjek Pesan</label>
                        </div>
                        <!-- Floating: Pesan -->
                        <div class="relative">
                            <textarea id="f-msg" name="message" rows="4" required placeholder=" "
                                class="peer w-full px-4 pt-6 pb-2 border border-slate-200 rounded-xl focus:border-emerald-700 focus:ring-1 focus:ring-emerald-700 outline-none transition-all text-sm font-medium resize-none"></textarea>
                            <label for="f-msg" class="absolute left-4 top-4 text-xs font-semibold text-slate-400 tracking-wider uppercase pointer-events-none origin-left transition-all
                                peer-placeholder-shown:text-sm peer-placeholder-shown:top-4
                                peer-focus:-translate-y-2.5 peer-focus:scale-75 peer-focus:text-emerald-700
                                -translate-y-2.5 scale-75">Isi Pesan</label>
                        </div>

                        <button id="submit-btn" type="submit"
                            class="w-full inline-flex items-center justify-center h-14 text-sm font-bold tracking-wide uppercase text-white bg-emerald-900 hover:bg-emerald-800 rounded-xl shadow-md transition-all duration-200 cursor-pointer">
                            Kirim Aspirasi
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

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const original = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<span>Mengirim...</span>
            <svg class="animate-spin ml-2 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>`;

        setTimeout(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = original;
            lucide.createIcons(); // re-init lucide on new button content
            successBox.classList.remove('hidden');
            successBox.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
            form.reset();
            setTimeout(() => successBox.classList.add('hidden'), 8000);
        }, 1500);
    });
</script>
@endpush