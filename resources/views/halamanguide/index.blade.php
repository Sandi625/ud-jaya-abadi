@extends('layout.app')

@section('title', 'Daftar Pesanan')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

        body {
            font-family: 'Inter', Arial, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .custom-container {
            max-width: 1200px;
            margin: auto;
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .custom-heading {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 600;
            color: #222;
        }

        p.notice {
            color: #d32f2f;
            text-align: center;
            font-size: 16px;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .overflow-x-auto {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
            table-layout: auto;
            font-size: 14px;
        }

        thead th {
            padding: 14px 12px;
            font-weight: 600;
            color: #1a73e8;
            text-align: left;
            white-space: nowrap;
            border-bottom: 2px solid #c1d0fc;
        }

        tbody td {
            padding: 12px;
            color: #555;
            vertical-align: middle;
            white-space: normal;
            word-wrap: break-word;
            text-align: left;
        }

        td:nth-child(7),
        td:nth-child(5),
        td:nth-child(6) {
            text-align: center;
        }

        .badge-guide {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            background-color: #4caf50;
        }

        .badge-guide.empty {
            background-color: #d32f2f;
            padding: 4px 10px;
        }

        .action-link {
            color: white;
            font-weight: 600;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            background-color: #1a73e8;
            transition: background-color 0.3s ease;
            display: inline-block;
            font-size: 14px;
            text-align: center;
        }


        .action-link:hover {
            background-color: #155ab6;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .custom-container {
                padding: 20px 15px;
            }

            thead th,
            tbody td {
                font-size: 12px;
                padding: 10px 8px;
            }
        }
    </style>

    <div class="custom-container">
        <h1 class="custom-heading">Daftar Pesanan</h1>

        <p class="notice">
            Klik detail untuk melihat spesial request dan riwayat medis pelanggan
        </p>



        <div class="overflow-x-auto">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Guide</th>
                        <th>Kriteria</th>
                        <th>Paket</th>
                        <th>Tanggal Pesan</th>
                        <th>Tanggal Keberangkatan</th>
                        <th>Jumlah Peserta</th>
                        <th>Negara</th>
                        <th>Bahasa</th>
                        <th>Riwayat Medis</th>
                        <th>Special Request</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pesanans as $pesanan)
                        <tr>
                            <td>{{ $pesanan->nama }}</td>
                            <td>
                                @if ($pesanan->guide && $pesanan->guide->nama_guide)
                                    <span class="badge-guide">{{ $pesanan->guide->nama_guide }}</span>
                                @else
                                    <span class="badge-guide empty">-</span>
                                @endif
                            </td>
                            <td>
                                @forelse ($pesanan->kriterias as $kriteria)
                                    {{ $kriteria->nama }}{{ !$loop->last ? ',' : '' }}
                                @empty
                                    N/A
                                @endforelse
                            </td>
                            <td>{{ $pesanan->paket->nama_paket ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_keberangkatan)->format('d M Y') }}</td>
                            <td>{{ $pesanan->jumlah_peserta }}</td>
                            <td>{{ $pesanan->negara }}</td>
                            <td>{{ $pesanan->bahasa }}</td>
                            <td>{{ Str::limit($pesanan->riwayat_medis ?? '-', 40) }}</td>
                            <td>{{ Str::limit($pesanan->special_request ?? '-', 40) }}</td>
                            <td>
                                <a href="{{ route('halamanguide.show', $pesanan->id) }}" class="action-link">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
