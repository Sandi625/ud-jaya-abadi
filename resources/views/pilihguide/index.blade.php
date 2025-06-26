@extends('layout.master')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Pesanan & Kriteria yang Dipilih</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Order ID</th>
                <th>Nama Pemesan</th>
                            <th class="px-4 py-2 border">Kebutuhan Guide</th>

                <th>Tanggal Keberangkatan</th>
                <th>Kriteria yang Dipilih (Prioritas)</th>
                <th>Guide</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($pesanans as $index => $pesanan)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $pesanan->order_id }}</td>
            <td>{{ $pesanan->nama }}</td>
             <td class="px-4 py-2 border">
                    {{ $pesanan->kebutuhan_guide ?? '-' }}
                </td>
            <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_keberangkatan)->format('d M Y') }}</td>
            <td>
                <ul>
                    @foreach($pesanan->detailPesanans->sortBy('prioritas') as $detail)
                        <li>
                            Prioritas {{ $detail->prioritas }}:
                            {{ $detail->kriteria->nama ?? 'Kriteria tidak ditemukan' }}
                        </li>
                    @endforeach
                </ul>
            </td>
            <td>
                @if($pesanan->detailPesanans->count() > 0)
                    <ul>
                        @foreach($pesanan->detailPesanans as $detail)
                            @if($detail->guide)
                                <li>{{ $detail->guide->nama_guide }}</li>
                            @else
                                <li><em>Guide tidak ditemukan</em></li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <em>Belum memilih guide</em>
                @endif
            </td>
            <td>
                <a href="{{ route('pilihguide.edit', $pesanan->id) }}" class="btn btn-sm btn-warning">Pilih Guide</a>

                {{-- <form action="{{ route('pesanan.destroy', $pesanan->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form> --}}
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection

