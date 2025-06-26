@extends('layout.master')
@php
use Carbon\Carbon;
@endphp

@section('title', 'Daftar Guide yang Digunakan dalam Pesanan')

@section('content')
    <div class="overflow-auto flex-grow-1">
        <h4 class="mb-4">Daftar Guide yang Digunakan dalam Pesanan</h4>

        <table class="table table-bordered w-100">
            <thead class="table-light">
                <tr>
                    <th>NO</th>
                    <th>Nama Guide</th>
                    {{-- <th>Email</th> --}}
                    {{-- <th>Bahasa</th> --}}
                    <th>Nomor HP</th>
                    <th>Jumlah Pesanan</th>
                    {{-- <th>Status</th> --}}
                    <th>Status Notif</th>          {{-- Tambahan --}}
                    <th>Tanggal Kirim Notif</th>  {{-- Tambahan --}}
                    <th>Isi Notif</th>            {{-- Tambahan --}}
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($guides as $index => $guide)
                    @php
                        $notif = $guide->notifikasis->first();

                        // Status notif otomatis jika 'notif belum terkirim'
                        $notifStatusRaw = $notif ? ($notif->status === 'notif belum terkirim' ? 'notif pending masih di proses' : $notif->status) : '-';

                        // Tanggal kirim notif aman dari error format()
                        $notifTanggal = ($notif && $notif->tanggal_kirim) ? \Carbon\Carbon::parse($notif->tanggal_kirim)->format('d M Y H:i') : '-';

                        $notifIsi = $notif->isi ?? '-';
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $guide->nama_guide }}</td>
                        {{-- <td>{{ $guide->email }}</td> --}}
                        {{-- <td>{{ $guide->bahasa }}</td> --}}
                        <td>{{ $guide->nomer_hp }}</td>
                        <td>{{ $guide->pesanans->count() }} Pesanan</td>
                        {{-- <td>
                            @if ($guide->status === 'aktif')
                                <span class="text-success">Aktif</span>
                            @elseif ($guide->status === 'sedang_guiding')
                                <span class="text-warning">Sedang Guiding</span>
                            @else
                                <span class="text-danger">Tidak Aktif</span>
                            @endif
                        </td> --}}

                        {{-- Status Notif Berwarna --}}
                        <td>
                            @if ($notifStatusRaw === 'notif sudah terkirim')
                                <span class="badge bg-success">{{ $notifStatusRaw }}</span>
                            @elseif ($notifStatusRaw === 'notif belum terkirim')
                                <span class="badge bg-danger">{{ $notifStatusRaw }}</span>
                            @elseif ($notifStatusRaw === 'notif pending masih di proses')
                                <span class="badge bg-warning text-dark">{{ $notifStatusRaw }}</span>
                            @else
                                <span class="badge bg-secondary">{{ $notifStatusRaw }}</span>
                            @endif
                        </td>

                        <td>{{ $notifTanggal }}</td>
                        <td style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $notifIsi }}</td>

                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('guide.detail', $guide->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Include SweetAlert2 script --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33',
            });
        </script>
    @endif
@endsection


