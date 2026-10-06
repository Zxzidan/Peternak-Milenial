@extends('layouts.app')

@section('title', 'Konsultasi & Kesehatan Hewan — Peternak Milenial Jatim')

@section('content')
<!-- Page Header -->
<div class="mb-5 flex flex-col md:flex-row md:items-center justify-between gap-3">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2 py-0.5 rounded dark:bg-gray-800 dark:text-gray-300">
                Bidang Keswan
            </span>
        </div>
        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
            Konsultasi &amp; Kesehatan Hewan
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
            Layanan dokter hewan terintegrasi, buku rekam medis digital, dan pedoman penyakit ternak.
        </p>
    </div>
    <div class="flex items-center gap-2">
        @if(auth()->check() && auth()->user()->isAdmin())
        <button
            type="button"
            onclick="document.getElementById('form-rekam-medis').classList.toggle('hidden')"
            class="inline-flex items-center text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition shadow-xs"
        >
            + Catat Rekam Medis
        </button>
        @endif
        <button
            type="button"
            onclick="document.getElementById('form-etag').classList.toggle('hidden')"
            class="inline-flex items-center text-xs font-medium text-gray-700 bg-white dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-50 border border-gray-200 dark:border-gray-700 px-3 py-2 rounded-lg transition"
        >
            + E-Tag Baru
        </button>
    </div>
</div>

@if(auth()->check() && auth()->user()->isAdmin())
<!-- Form Catat Rekam Medis (Collapsible & Persistent) -->
<div id="form-rekam-medis" class="hidden mb-5 bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
        <div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Catat Rekam Medis Baru</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Data riwayat kesehatan tersimpan ke rekam medis ternak digital.</p>
        </div>
        <button type="button" onclick="document.getElementById('form-rekam-medis').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xs">Batal</button>
    </div>

    <form action="{{ route('konsultasi.health-record.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
        @csrf
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Ternak (E-Tag) <span class="text-red-500">*</span></label>
            <select name="livestock_id" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                @foreach ($livestocks as $ls)
                    <option value="{{ $ls->id }}">{{ $ls->tag_number }} - {{ $ls->breed }} ({{ ucfirst($ls->gender) }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Tindakan Medis <span class="text-red-500">*</span></label>
            <select name="record_type" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                <option value="pemeriksaan">Pemeriksaan Rutin</option>
                <option value="vaksinasi">Vaksinasi</option>
                <option value="pengobatan">Pengobatan &amp; Terapi</option>
                <option value="inseminasi_buatan">Inseminasi Buatan (IB)</option>
            </select>
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Pemeriksaan <span class="text-red-500">*</span></label>
            <input type="date" name="record_date" required value="{{ date('Y-m-d') }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div class="md:col-span-3">
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Judul / Diagnosa Utama <span class="text-red-500">*</span></label>
            <input type="text" name="title" required placeholder="Contoh: Pemeriksaan Mastitis Subklinis & Terapi Salep" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Detail Diagnosis</label>
            <input type="text" name="diagnosis" placeholder="Gejala klinis atau hasil uji..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div class="md:col-span-2">
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tindakan / Resep Obat</label>
            <input type="text" name="treatment" placeholder="Dosis antibiotik, salep, desinfeksi..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div class="md:col-span-3 flex justify-end gap-2 pt-2">
            <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-semibold px-4 py-2 rounded-lg shadow-xs transition">
                Simpan Rekam Medis
            </button>
        </div>
    </form>
</div>
@endif

<!-- Form Registrasi E-Tag Baru (Collapsible) -->
<div id="form-etag" class="hidden mb-5 bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
        <div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Pendaftaran E-Tag Ternak Baru</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Pendaftaran identitas barcode ternak binaan.</p>
        </div>
        <button type="button" onclick="document.getElementById('form-etag').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xs">Batal</button>
    </div>

    <form action="{{ route('konsultasi.livestock.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-3 text-xs">
        @csrf
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor E-Tag <span class="text-red-500">*</span></label>
            <input type="text" name="tag_number" required placeholder="Contoh: JTM-PAS-108" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white uppercase">
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Ternak <span class="text-red-500">*</span></label>
            <select name="livestock_type" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                <option value="sapi_perah">Sapi Perah</option>
                <option value="sapi_potong">Sapi Potong</option>
                <option value="kambing">Kambing</option>
                <option value="domba">Domba</option>
            </select>
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Bangsa / Ras <span class="text-red-500">*</span></label>
            <input type="text" name="breed" required placeholder="Friesian Holstein (FH) / Limousin" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Kelamin &amp; Tgl Lahir <span class="text-red-500">*</span></label>
            <div class="flex gap-1.5">
                <select name="gender" class="w-1/2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                    <option value="betina">Betina</option>
                    <option value="jantan">Jantan</option>
                </select>
                <input type="date" name="birth_date" required value="{{ date('Y-m-d', strtotime('-2 years')) }}" class="w-1/2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
        </div>
        <div class="md:col-span-4 flex justify-end gap-2 pt-1">
            <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-semibold px-4 py-2 rounded-lg shadow-xs transition">
                Daftarkan E-Tag ke Database
            </button>
        </div>
    </form>
</div>

<!-- Section 1: Utas Percakapan Dokter Hewan (Real Chat in Database) -->
<div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 mb-5 shadow-xs">
    @if ($consultation)
    <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-3.5">
        <div>
            <h2 class="text-sm font-bold text-gray-900 dark:text-white">Konsultasi Medis Aktif: {{ $consultation->subject ?? 'Konsultasi Puskeswan' }}</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400">Puskeswan Dinas &bull; {{ $consultation->veterinarian?->name ?? 'Dokter Hewan Dinas' }}</p>
        </div>
        <span class="text-xs font-medium text-green-700 bg-green-50 px-2 py-0.5 rounded dark:bg-green-950/60 dark:text-green-300 flex items-center">
            <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5 animate-pulse"></span> {{ $consultation->veterinarian?->name ?? 'Dokter Hewan Dinas' }} (Online)
        </span>
    </div>

    <!-- Chat Box Messages Loop -->
    <div class="space-y-3 max-h-80 overflow-y-auto p-3.5 bg-gray-50 dark:bg-gray-700/30 rounded-lg border border-gray-100 dark:border-gray-700 text-xs">
        @forelse ($consultation->messages as $msg)
            @php $isMe = ($msg->sender_id === auth()->id()); @endphp
            @if ($isMe)
                <div class="flex items-start gap-2 justify-end">
                    <div class="bg-primary-700 text-white p-3 rounded-xl rounded-tr-none max-w-md shadow-xs">
                        <div class="flex justify-between items-center mb-1 text-primary-200 text-[10px] gap-3">
                            <span class="font-semibold">{{ $msg->sender?->name ?? 'Anda' }}</span>
                            <span>{{ $msg->created_at->format('H:i WIB') }}</span>
                        </div>
                        <p class="leading-relaxed">{{ $msg->message }}</p>
                    </div>
                </div>
            @else
                <div class="flex items-start gap-2">
                    <div class="w-7 h-7 rounded-full bg-blue-100 dark:bg-blue-900/60 text-primary-700 dark:text-primary-300 flex items-center justify-center font-bold text-xs shrink-0">
                        {{ strtoupper(substr($msg->sender?->name ?? 'DR', 0, 2)) }}
                    </div>
                    <div class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-3 rounded-xl rounded-tl-none max-w-md border border-gray-200 dark:border-gray-700 shadow-xs">
                        <div class="flex justify-between items-center mb-1 text-gray-400 text-[10px] gap-3">
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $msg->sender?->name ?? 'Dokter Hewan' }}</span>
                            <span>{{ $msg->created_at->format('H:i WIB') }}</span>
                        </div>
                        <p class="leading-relaxed">{{ $msg->message }}</p>
                    </div>
                </div>
            @endif
        @empty
            <div class="text-center py-4 text-gray-400">Belum ada percakapan. Silakan mulai konsultasi.</div>
        @endforelse
    </div>

    <!-- Reply Input Form (Persisted to Database) -->
    <form action="{{ route('konsultasi.message', $consultation) }}" method="POST" class="mt-3 flex items-center gap-2">
        @csrf
        <input
            type="text"
            name="message"
            required
            placeholder="Ketik balasan untuk dokter hewan..."
            class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-xs rounded-lg p-2.5 w-full text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 shadow-xs"
        />
        <button
            type="submit"
            class="bg-primary-700 hover:bg-primary-800 text-white text-xs font-semibold px-4 py-2.5 rounded-lg shrink-0 transition shadow-xs flex items-center gap-1.5"
        >
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
            Kirim
        </button>
    </form>
    @else
    <!-- Empty State: Belum ada konsultasi aktif -->
    <div class="py-10 px-4 text-center">
        <div class="w-12 h-12 mx-auto rounded-xl bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 flex items-center justify-center text-gray-400 mb-2.5 shadow-xs">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a.75.75 0 0 1-.974-.94 4.053 4.053 0 0 0 .426-1.75c-.347-.63-.562-1.332-.562-2.08 0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
            </svg>
        </div>
        <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Belum ada sesi konsultasi aktif</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto mb-4">
            {{ auth()->check() && auth()->user()->isAdmin() ? 'Belum ada peternak yang mengajukan konsultasi kesehatan ternak.' : 'Ajukan konsultasi langsung dengan dokter hewan Dinas Peternakan Jawa Timur mengenai keluhan kesehatan atau gejala pada ternak Anda.' }}
        </p>

        @if(auth()->check() && auth()->user()->isPeternak())
        <form action="{{ route('konsultasi.start') }}" method="POST" class="max-w-md mx-auto text-left bg-gray-50 dark:bg-gray-700/40 p-4 rounded-xl border border-gray-200 dark:border-gray-700 space-y-2.5 text-xs">
            @csrf
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Topik / Keluhan <span class="text-red-500">*</span></label>
                <input type="text" name="subject" required placeholder="Contoh: Gejala nafsu makan menurun dan demam sapi" class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Pesan / Penjelasan Gejala <span class="text-red-500">*</span></label>
                <textarea name="message" rows="2" required placeholder="Jelaskan kondisi ternak Anda secara rinci..." class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white"></textarea>
            </div>
            <div class="flex justify-end pt-1">
                <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-semibold px-4 py-2 rounded-lg shadow-xs transition">
                    + Mulai Konsultasi dengan Dokter Hewan
                </button>
            </div>
        </form>
        @endif
    </div>
    @endif
</div>

<!-- Section 2: Rekam Medis Ternak Digital (From Database) -->
<div id="rekam-medis" class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 mb-5 shadow-xs">
    <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-3.5">
        <div>
            <h2 class="text-sm font-bold text-gray-900 dark:text-white">Buku Rekam Medis Digital &amp; E-Tagging</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Catatan riwayat kesehatan, vaksinasi, dan inseminasi buatan di database.</p>
        </div>
        <span class="text-xs font-semibold px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
            Total: {{ $healthRecords->count() }} Tindakan
        </span>
    </div>

    <div class="space-y-3">
        @forelse ($healthRecords as $record)
        <div class="p-3.5 bg-gray-50 dark:bg-gray-700/40 rounded-xl border border-gray-200/80 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-[10px] font-bold text-primary-700 bg-blue-50 px-2 py-0.5 rounded">
                        E-Tag: {{ $record->livestock?->tag_number ?? $record->livestock?->e_tag_number ?? 'JTM-001' }} ({{ $record->livestock?->breed ?? $record->livestock?->name ?? 'Ternak' }})
                    </span>
                    <span class="text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded capitalize">
                        {{ str_replace('_', ' ', $record->record_type) }}
                    </span>
                    <span class="text-gray-400 text-[11px]">{{ \Carbon\Carbon::parse($record->record_date)->format('d M Y') }}</span>
                </div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $record->title }}</h3>
                <p class="text-gray-600 dark:text-gray-300 mt-0.5">
                    <strong>Tindakan:</strong> {{ $record->treatment ?? 'Pemberian vitamin dan desinfeksi kandang' }} &bull;
                    <strong>Pemeriksa:</strong> {{ $record->veterinarian?->name ?? 'Dokter Hewan Dinas' }}
                </p>
            </div>

            @if(auth()->check() && auth()->user()->isAdmin())
            <form action="{{ route('konsultasi.health-record.destroy', $record) }}" method="POST" onsubmit="return confirm('Hapus riwayat rekam medis {{ $record->title }}?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium shrink-0">Hapus</button>
            </form>
            @endif
        </div>
        @empty
        <div class="text-center py-6 text-gray-400 text-xs bg-gray-50 dark:bg-gray-750/30 rounded-lg border border-dashed border-gray-200 dark:border-gray-700">
            Belum ada data rekam medis kesehatan ternak tersimpan di database.
        </div>
        @endforelse
    </div>
</div>

<!-- Section 3: Pedoman Penyakit Ternak (From Database) -->
<div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5 flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-gray-900 dark:text-white">Pedoman &amp; Basis Data Penyakit Hewan Menular</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pedoman diagnosis dini veteriner Jawa Timur.</p>
        </div>
        @if(auth()->check() && auth()->user()->isAdmin())
        <button
            type="button"
            onclick="document.getElementById('form-tambah-penyakit').classList.toggle('hidden')"
            class="px-2.5 py-1 bg-primary-700 hover:bg-primary-800 text-white text-xs font-semibold rounded-md transition shadow-xs"
        >
            + Tambah Data Penyakit
        </button>
        @endif
    </div>

    @if(auth()->check() && auth()->user()->isAdmin())
    <!-- Form Tambah Penyakit (Admin Only) -->
    <div id="form-tambah-penyakit" class="hidden mb-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
        <form action="{{ route('konsultasi.diseases.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
            @csrf
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Penyakit <span class="text-red-500">*</span></label>
                <input type="text" name="name" required placeholder="Contoh: Bovine Ephemeral Fever (BEF)" class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kode Penyakit <span class="text-red-500">*</span></label>
                <input type="text" name="code" required placeholder="BEF" class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white uppercase">
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tingkat Risiko <span class="text-red-500">*</span></label>
                <select name="risk_level" class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                    <option value="sedang">Sedang</option>
                    <option value="tinggi">Tinggi</option>
                    <option value="rendah">Rendah</option>
                </select>
            </div>
            <div class="md:col-span-3">
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Gejala Klinis <span class="text-red-500">*</span></label>
                <textarea name="symptoms" rows="2" required placeholder="Demam tinggi mendadak, tremor otot, pincang..." class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white"></textarea>
            </div>
            <div class="md:col-span-3">
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Pencegahan &amp; Penanganan <span class="text-red-500">*</span></label>
                <textarea name="prevention" rows="2" required placeholder="Pemberian antipiretik, pengendalian vektor lalat/nyamuk..." class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white"></textarea>
            </div>
            <div class="md:col-span-3 flex justify-end">
                <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-semibold py-2 px-4 rounded-lg shadow-xs transition">
                    Simpan Informasi Penyakit
                </button>
            </div>
        </form>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5 text-xs">
        @forelse ($diseases as $disease)
        <div class="p-3.5 bg-gray-50 dark:bg-gray-700/40 rounded-xl border border-gray-200/80 dark:border-gray-700">
            <div class="flex items-center justify-between mb-1.5">
                <span class="font-bold text-gray-900 dark:text-white text-sm">{{ $disease->name }} ({{ $disease->code }})</span>
                <div class="flex items-center gap-1.5">
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded {{ $disease->risk_level === 'tinggi' ? 'bg-red-50 text-red-700' : 'bg-amber-50 text-amber-700' }}">
                        Risiko {{ ucfirst($disease->risk_level) }}
                    </span>
                    @if(auth()->check() && auth()->user()->isAdmin())
                    <form action="{{ route('konsultasi.diseases.destroy', $disease) }}" method="POST" onsubmit="return confirm('Hapus info penyakit {{ $disease->name }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-400 hover:text-red-600 p-0.5 transition" title="Hapus Penyakit">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-1.5"><strong>Gejala:</strong> {{ $disease->symptoms }}</p>
            <p class="text-gray-500 dark:text-gray-400 leading-relaxed"><strong>Pencegahan:</strong> {{ $disease->prevention }}</p>
        </div>
        @empty
        <div class="col-span-2 text-center py-3 text-gray-400">Belum ada pedoman penyakit tersimpan.</div>
        @endforelse
    </div>
</div>
@endsection
