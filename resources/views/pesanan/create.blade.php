@extends('layout.app')

@section('title', 'Tambah Pesanan')

@section('content')
    <!-- Detail Paket (Deskripsi dan Itinerary) -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>



    <div id="paket-detail" class="mt-10 space-y-8">
        <h2 class="text-3xl font-bold text-gray-800 border-b pb-2">Package Details</h2>

        <!-- Card 1: Nama, Deskripsi, Foto -->
        <div class="bg-white shadow-lg rounded-xl p-6 flex flex-col md:flex-row gap-8">
            <!-- Informasi -->
            <div class="flex-1 space-y-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Package Name</h3>
                    <p id="paket-nama" class="text-gray-900 text-base">
                        {{ $paketDetail->nama_paket ?? 'Nama Paket Tidak Ditemukan' }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Description</h3>
                    <p id="paket-deskripsi" class="text-gray-600 text-sm leading-relaxed">
                        {{ $paketDetail->deskripsi_paket ?? 'Deskripsi Tidak Tersedia' }}</p>
                </div>
            </div>

            <!-- Foto -->
            <div class="w-full md:w-80">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Photo</h3>
                <img id="paket-foto" src="{{ asset('storage/' . $paketDetail->foto) }}" alt="Foto Paket"
                    class="rounded-lg shadow w-full object-cover"
                    style="display: {{ $paketDetail->foto ? 'block' : 'none' }};">
            </div>
        </div>

        <!-- Card 2: Detail lainnya -->
        <div class="bg-white shadow-lg rounded-xl p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kolom Kiri -->
            <div class="space-y-4">
                <div>
                    <h4 class="font-medium text-gray-700">Price</h4>
                    <p id="paket-harga" class="text-gray-800">{{ $paketDetail->harga ?? 'Harga Tidak Tersedia' }}</p>
                </div>
                <div>
                    <h4 class="font-medium text-gray-700">Duration</h4>
                    <p id="paket-durasi" class="text-gray-800">{{ $paketDetail->durasi ?? 'Durasi Tidak Tersedia' }}</p>
                </div>
                <div>
                    <h4 class="font-medium text-gray-700">Destination</h4>
                    <p id="paket-destinasi" class="text-gray-800">
                        {{ $paketDetail->destinasi ?? 'Destinasi Tidak Tersedia' }}</p>
                </div>
                <div>
                    <h4 class="font-medium text-gray-700">Include</h4>
                    <p id="paket-include" class="text-gray-800">{{ $paketDetail->include ?? 'Tidak ada informasi include' }}
                    </p>
                </div>
                <div>
                    <h4 class="font-medium text-gray-700">Exclude</h4>
                    <p id="paket-exclude" class="text-gray-800">{{ $paketDetail->exclude ?? 'Tidak ada informasi exclude' }}
                    </p>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="space-y-4">
                <div>
                    <h4 class="font-medium text-gray-700">Itinerary</h4>
                    <p id="paket-itinerary" class="text-gray-800">
                        @if ($paketDetail && $paketDetail->itinerary)
                            <a href="{{ asset('storage/' . $paketDetail->itinerary) }}"
                                class="inline-block px-6 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-md text-sm"
                                download>Download Itinerary PDF</a>
                        @else
                            <span class="text-gray-600">No itinerary uploaded.</span>
                        @endif
                    </p>
                </div>

                <div>
                    <h4 class="font-medium text-gray-700">Information Trip</h4>
                    <p id="paket-information-trip" class="text-gray-800">
                        {{ $paketDetail->information_trip ?? 'Informasi trip tidak tersedia' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto mt-8 px-4">
        <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
            <h1 class="text-3xl font-bold mb-4 text-gray-800">Add Order</h1>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pesanan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nama -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="nama">Name</label>
                    <input type="text" name="nama" id="nama"
                        class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old('nama', Auth::user()->name ?? '') }}" required>
                    @error('nama')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="email">Email</label>
                    <input type="email" name="email" id="email"
                        class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old('email', Auth::user()->email ?? '') }}" required>
                    @error('email')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>


                <!-- Nomor Telepon -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="nomor_telp">Phone Number</label>
                    <input type="tel" name="nomor_telp" id="nomor_telp"
                        class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old('nomor_telp') }}" required maxlength="20"
                        title="Nomor HP harus terdiri dari 10 sampai 13 digit angka.">
                    @error('nomor_telp')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Keperluan atau Kebutuhan -->
<div class="mb-4">
    <label class="block text-gray-700 font-bold mb-2" for="kebutuhan_guide">What is your main need in choosing a guide?</label>
    <textarea name="kebutuhan_guide" id="kebutuhan_guide"
        class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        rows="3" placeholder="Contoh: Saya butuh guide yang bisa berbahasa Jepang karena tamu saya dari Jepang." required>{{ old('kebutuhan_guide') }}</textarea>
    @error('kebutuhan_guide')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>


          <p class="font-semibold mb-2">Select priority criteria for your guide:</p>

<div id="criteria-wrapper">
    <div class="criteria-item mb-3">
        <label class="priority-label block font-medium mb-1">Prioritas 1</label>
        <div class="flex gap-2 items-center">
            <select name="id_kriteria[]" class="w-full border px-3 py-2 rounded-md">
                <option value="">Pilih Kriteria</option>
                @foreach ($kriterias as $kriteria)
                    <option value="{{ $kriteria->id }}">{{ $kriteria->nama }}</option>
                @endforeach
            </select>
            <button type="button" class="remove-criteria bg-red-500 text-white px-2 rounded-md">&minus;</button>
        </div>
    </div>
</div>

<button type="button" id="add-criteria" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded-md">+ Kriteria</button>








                <!-- Paket -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="id_paket">Package</label>
                    <select name="id_paket" id="id_paket"
                        class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required readonly>
                        <option value="">Pilih Paket</option>
                        @foreach ($pakets as $paket)
                            <option value="{{ $paket->id }}"
                                {{ old('id_paket', $selectedPaketId) == $paket->id ? 'selected' : '' }}>
                                {{ $paket->nama_paket }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_paket')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Pesan -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="tanggal_pesan">Order Date</label>
                    <input type="date" name="tanggal_pesan" id="tanggal_pesan"
                        class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old('tanggal_pesan') }}" required>
                    @error('tanggal_pesan')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Keberangkatan -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="tanggal_keberangkatan">Departure Date</label>
                    <input type="date" name="tanggal_keberangkatan" id="tanggal_keberangkatan"
                        class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old('tanggal_keberangkatan') }}" required>
                    @error('tanggal_keberangkatan')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jumlah Peserta -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="jumlah_peserta">Number of participants</label>
                    <input type="text" name="jumlah_peserta" id="jumlah_peserta"
                        class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old('jumlah_peserta') }}" required maxlength="20" pattern="[0-9]*"
                        inputmode="numeric" title="Masukkan angka maksimal 20 digit">
                    @error('jumlah_peserta')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>



                <!-- Negara -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="negara">Country</label>
                    <input type="text" name="negara" id="negara"
                        class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old('negara') }}" required>
                    @error('negara')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Bahasa -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="bahasa">The language you use</label>
                    <input type="text" name="bahasa" id="bahasa"
                        class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old('bahasa') }}" required>
                    @error('bahasa')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Riwayat Medis -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="riwayat_medis">Medical History</label>
                    <textarea name="riwayat_medis" id="riwayat_medis" rows="4"
                        class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Example: Asthma, heart disease, hypertension or others" required>{{ old('riwayat_medis') }}</textarea>
                    @error('riwayat_medis')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Paspor -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="paspor">
                        Upload Passport Photo (Optional)
                        <span class="text-red-500">(Maximum 5MB)</span>
                    </label>
                    <input type="file" name="paspor" id="paspor" accept="image/*"
                        class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('paspor')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>



                <!-- Special Request -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="special_request">Special Request
                        (Optional)</label>
                    <textarea name="special_request" id="special_request" rows="4"
                        class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Example: Vegetarian meal, special needs, etc...">{{ old('special_request') }}</textarea>
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">
                        Save Order
                    </button>
                </div>
            </form>
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
                        window.location.href = '{{ route('customer.packages') }}';
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
