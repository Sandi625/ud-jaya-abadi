@extends('layout.master')

@section('title', 'Tambah Pesanan')

@section('content')
    <!-- Detail Paket (Deskripsi dan Itinerary) -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>



    <div class="container py-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h3 class="mb-4 text-dark fw-bold">Detail Paket</h3>

                {{-- Informasi Umum --}}
                <div class="mb-4">
                    <h5 class="text-secondary fw-bold">Informasi Umum</h5>
                    <hr>
                    <p><strong>Nama Paket:</strong> {{ $paketDetail->nama_paket ?? 'Nama Paket Tidak Ditemukan' }}</p>
                    <p><strong>Deskripsi:</strong> {{ $paketDetail->deskripsi_paket ?? 'Deskripsi Tidak Tersedia' }}</p>
                </div>

                {{-- Foto --}}
                <div class="mb-4">
                    <h5 class="text-secondary fw-bold">Foto</h5>
                    @if ($paketDetail && $paketDetail->foto)
                        <img src="{{ asset('storage/' . $paketDetail->foto) }}" alt="Foto Paket"
                            class="img-fluid rounded border shadow-sm" style="max-width: 300px;">
                    @else
                        <p class="text-muted fst-italic">Foto tidak tersedia</p>
                    @endif
                </div>

                {{-- Detail Lainnya --}}
                <div class="mb-4">
                    <h5 class="text-secondary fw-bold">Informasi Tambahan</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Harga:</strong> {{ $paketDetail->harga ?? 'Harga Tidak Tersedia' }}</p>
                            <p><strong>Durasi:</strong> {{ $paketDetail->durasi ?? 'Durasi Tidak Tersedia' }}</p>
                            <p><strong>Destinasi:</strong> {{ $paketDetail->destinasi ?? 'Destinasi Tidak Tersedia' }}</p>
                            <p><strong>Include:</strong> {{ $paketDetail->include ?? 'Tidak ada informasi include' }}</p>
                            <p><strong>Exclude:</strong> {{ $paketDetail->exclude ?? 'Tidak ada informasi exclude' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Itinerary:</strong>
                                @if ($paketDetail && $paketDetail->itinerary)
                                    <a href="{{ asset('storage/' . $paketDetail->itinerary) }}"
                                        class="btn btn-sm btn-primary" download>
                                        Download Itinerary PDF
                                    </a>
                                @else
                                    <span class="text-muted">No itinerary uploaded.</span>
                                @endif
                            </p>
                            <p><strong>Information Trip:</strong>
                                {{ $paketDetail->information_trip ?? 'Informasi trip tidak tersedia' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="container mt-5">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h4 class="mb-4 fw-bold text-dark">Formulir Pemesanan</h4>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('pesanan.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control"
                                        value="{{ old('nama', Auth::user()->name ?? '') }}" required>
                                    @error('nama')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ old('email', Auth::user()->email ?? '') }}" required>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nomor_telp" class="form-label">Nomor Telepon</label>
                                    <input type="tel" name="nomor_telp" id="nomor_telp" class="form-control"
                                        value="{{ old('nomor_telp') }}" required maxlength="20">
                                    @error('nomor_telp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="kebutuhan_guide" class="form-label">Kebutuhan Khusus</label>
                                    <textarea name="kebutuhan_guide" id="kebutuhan_guide" class="form-control" rows="3"
                                        placeholder="Contoh: Saya butuh guide yang bisa berbahasa Jepang." required>{{ old('kebutuhan_guide') }}</textarea>
                                    @error('kebutuhan_guide')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kriteria Prioritas</label>
                                    <div id="criteria-wrapper">
                                        <div class="row mb-2 criteria-item">
                                            <div class="col-10">
                                                <select name="id_kriteria[]" class="form-select">
                                                    <option value="">Pilih Kriteria</option>
                                                    @foreach ($kriterias as $kriteria)
                                                        <option value="{{ $kriteria->id }}">{{ $kriteria->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="btn btn-danger remove-criteria">−</button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="add-criteria" class="btn btn-primary mt-2">+ Tambah
                                        Kriteria</button>
                                </div>

                                <div class="mb-3">
                                    <label for="id_paket" class="form-label">Paket</label>
                                    <select name="id_paket" id="id_paket" class="form-select" readonly required>
                                        @foreach ($pakets as $paket)
                                            <option value="{{ $paket->id }}"
                                                {{ old('id_paket', $selectedPaketId) == $paket->id ? 'selected' : '' }}>
                                                {{ $paket->nama_paket }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_paket')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_pesan" class="form-label">Tanggal Pemesanan</label>
                                    <input type="date" name="tanggal_pesan" id="tanggal_pesan" class="form-control"
                                        value="{{ old('tanggal_pesan') }}" required>
                                    @error('tanggal_pesan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_keberangkatan" class="form-label">Tanggal Keberangkatan</label>
                                    <input type="date" name="tanggal_keberangkatan" id="tanggal_keberangkatan"
                                        class="form-control" value="{{ old('tanggal_keberangkatan') }}" required>
                                    @error('tanggal_keberangkatan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="jumlah_peserta" class="form-label">Jumlah Peserta</label>
                                    <input type="number" name="jumlah_peserta" id="jumlah_peserta" class="form-control"
                                        value="{{ old('jumlah_peserta') }}" required>
                                    @error('jumlah_peserta')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="negara" class="form-label">Negara</label>
                                    <input type="text" name="negara" id="negara" class="form-control"
                                        value="{{ old('negara') }}" required maxlength="100">
                                    @error('negara')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="bahasa" class="form-label">Bahasa yang Digunakan</label>
                                    <input type="text" name="bahasa" id="bahasa" class="form-control"
                                        value="{{ old('bahasa') }}" required maxlength="100">
                                    @error('bahasa')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="riwayat_medis" class="form-label">Riwayat Medis</label>
                                    <textarea name="riwayat_medis" id="riwayat_medis" class="form-control" rows="3" required>{{ old('riwayat_medis') }}</textarea>
                                    @error('riwayat_medis')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="paspor" class="form-label">Upload Paspor (Opsional)</label>
                                    <input type="file" name="paspor" id="paspor" class="form-control"
                                        accept="image/*">
                                    @error('paspor')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="special_request" class="form-label">Permintaan Khusus (Opsional)</label>
                                    <textarea name="special_request" id="special_request" class="form-control" rows="3"
                                        placeholder="Contoh: Alergi makanan tertentu, bantuan kursi roda, dll.">{{ old('special_request') }}</textarea>
                                    @error('special_request')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-success mt-3">Kirim Pemesanan</button>
                            </form>
                        </div>
                    </div>
                </div>




                @if (session('success'))
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: '{{ session('success') }}',
                                confirmButtonText: 'Back',
                                allowOutsideClick: false,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '{{ route('dashboard.pelanggan') }}';
                                }
                            });
                        });
                    </script>
                @endif

                @if ($errors->any())
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: 'Terjadi Kesalahan!',
                                html: `{!! implode('<br>', $errors->all()) !!}`,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                    </script>
                @endif


                <script>
                    const paketData = @json($pakets);

                    document.addEventListener('DOMContentLoaded', function() {
                        const paketSelect = document.getElementById('id_paket');

                        const namaElem = document.getElementById('paket-nama');
                        const deskripsiElem = document.getElementById('paket-deskripsi');
                        const hargaElem = document.getElementById('paket-harga');
                        const durasiElem = document.getElementById('paket-durasi');
                        const destinasiElem = document.getElementById('paket-destinasi');
                        const includeElem = document.getElementById('paket-include');
                        const excludeElem = document.getElementById('paket-exclude');
                        const itineraryElem = document.getElementById('paket-itinerary');
                        const infoTripElem = document.getElementById('paket-information-trip');
                        const fotoElem = document.getElementById('paket-foto');

                        function tampilkanDetailPaket(id) {
                            const paket = paketData.find(p => p.id == id);
                            if (paket) {
                                namaElem.textContent = paket.nama_paket || '-';
                                deskripsiElem.textContent = paket.deskripsi_paket || '-';
                                hargaElem.textContent = paket.harga ? 'Rp ' + Number(paket.harga).toLocaleString() : '-';
                                durasiElem.textContent = paket.durasi || '-';
                                destinasiElem.textContent = paket.destinasi || '-';
                                includeElem.textContent = paket.include || '-';
                                excludeElem.textContent = paket.exclude || '-';
                                infoTripElem.textContent = paket.information_trip || '-';
                                fotoElem.src = paket.foto ? `/storage/${paket.foto}` : '';
                                fotoElem.style.display = paket.foto ? 'block' : 'none';

                                // Update the itinerary section to include a download link
                                if (paket.itinerary) {
                                    // Create a download link for the itinerary
                                    itineraryElem.innerHTML =
                                        `<a href="/storage/${paket.itinerary}" class="inline-block px-6 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-md text-sm" download>Download Itinerary PDF</a>`;
                                } else {
                                    itineraryElem.textContent = 'Tidak ada itinerary yang diunggah.';
                                }
                            } else {
                                namaElem.textContent = deskripsiElem.textContent = hargaElem.textContent = '';
                                durasiElem.textContent = destinasiElem.textContent = includeElem.textContent = '';
                                excludeElem.textContent = itineraryElem.textContent = infoTripElem.textContent = '';
                                fotoElem.style.display = 'none';
                            }
                        }

                        tampilkanDetailPaket(paketSelect.value);

                        paketSelect.addEventListener('change', function() {
                            tampilkanDetailPaket(this.value);
                        });
                    });
                </script>

                <script>
                    function updateDisabledOptions() {
                        const allSelects = document.querySelectorAll('#criteria-wrapper select');
                        const selectedValues = Array.from(allSelects)
                            .map(select => select.value)
                            .filter(val => val !== "");

                        allSelects.forEach(select => {
                            const currentValue = select.value;
                            Array.from(select.options).forEach(option => {
                                if (option.value === "" || option.value === currentValue) {
                                    option.disabled = false;
                                } else {
                                    option.disabled = selectedValues.includes(option.value);
                                }
                            });
                        });
                    }

                    function updatePriorityLabels() {
                        const items = document.querySelectorAll('#criteria-wrapper .criteria-item');
                        items.forEach((item, index) => {
                            const label = item.querySelector('.priority-label');
                            if (label) {
                                label.textContent = `Prioritas ${index + 1}`;
                            }
                        });
                    }

                    function removeHandler() {
                        const wrapper = document.getElementById('criteria-wrapper');
                        const items = wrapper.querySelectorAll('.criteria-item');
                        if (items.length > 1) {
                            this.closest('.criteria-item').remove();
                            updatePriorityLabels();
                            updateDisabledOptions();
                        }
                    }

                    document.getElementById('add-criteria').addEventListener('click', () => {
                        const wrapper = document.getElementById('criteria-wrapper');
                        const first = wrapper.querySelector('.criteria-item');
                        const clone = first.cloneNode(true);

                        // Reset value
                        const select = clone.querySelector('select');
                        select.value = "";
                        select.removeEventListener('change', updateDisabledOptions);
                        select.addEventListener('change', updateDisabledOptions);

                        // Reset dan pasang ulang event handler tombol hapus
                        const oldRemoveBtn = clone.querySelector('.remove-criteria');
                        const newRemoveBtn = oldRemoveBtn.cloneNode(true);
                        oldRemoveBtn.replaceWith(newRemoveBtn);
                        newRemoveBtn.addEventListener('click', removeHandler);

                        wrapper.appendChild(clone);
                        updatePriorityLabels();
                        updateDisabledOptions();
                    });

                    document.addEventListener('DOMContentLoaded', () => {
                        const initialRemoveBtn = document.querySelector('.remove-criteria');
                        if (initialRemoveBtn) {
                            initialRemoveBtn.addEventListener('click', removeHandler);
                        }

                        const initialSelect = document.querySelector('#criteria-wrapper select');
                        if (initialSelect) {
                            initialSelect.addEventListener('change', updateDisabledOptions);
                        }

                        updatePriorityLabels();
                        updateDisabledOptions();
                    });
                </script>







                <img id="previewPaspor" class="mt-2 max-w-xs hidden" alt="Preview Paspor" />





            @endsection
