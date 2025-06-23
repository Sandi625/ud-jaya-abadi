@extends('layout.master')
@section('title', 'Hasil Perhitungan Profile Matching')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">

            {{-- ===== Judul halaman & tombol navigasi ===== --}}
            <h3 class="fw-bold text-dark mb-4 border-bottom pb-2">
                Hasil Perhitungan Profile Matching
            </h3>

            <div class="d-flex flex-wrap gap-2 mb-4">
                {{-- Contoh tombol cetak (aktifkan bila route tersedia) --}}
                {{-- <a href="{{ route('penilaian.pdf.all') }}" class="btn btn-primary">
                    <i class="fa fa-print me-1"></i> Cetak Semua Penilaian
                </a> --}}
                <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            {{-- ===== LOOP: Hasil per‑Kriteria ===== --}}
            @foreach ($hasilPerKriteria as $kriteriaId => $kriteriaData)
                <div class="card mb-5 border-0 shadow-sm">
                    <div class="card-body">

                        <h4 class="fw-semibold text-primary mb-3">
                            Kriteria: {{ $kriteriaData['nama_kriteria'] }}
                        </h4>

                        {{-- ---------- Tabel Pembobotan ---------- --}}
                        <h6 class="fw-bold mb-2">Tabel Pembobotan {{ $kriteriaData['nama_kriteria'] }}</h6>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-sm align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Guide</th>
                                        <th>Kriteria</th>
                                        @foreach ($kriteriaData['subkriterias'] as $idx => $sub)
                                            <th>K{{ $idx + 1 }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kriteriaData['kandidat_results'] as $idx => $kandidat)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td>{{ $kandidat['nama_guide'] }}</td>
                                            <td>{{ $kriteriaData['nama_kriteria'] }}</td>
                                            @foreach ($kriteriaData['subkriterias'] as $sub)
                                                @php
                                                    $det = collect($kandidat['detail'])
                                                            ->firstWhere('subkriteria_id', $sub->id);
                                                @endphp
                                                <td>{{ $det['nilai'] ?? '-' }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach

                                    {{-- Baris profil standar --}}
                                    <tr class="table-secondary fw-semibold">
                                        <td colspan="3">Profil Standar</td>
                                        @foreach ($kriteriaData['subkriterias'] as $sub)
                                            <td>{{ $sub->profil_standar }}</td>
                                        @endforeach
                                    </tr>

                                    {{-- GAP --}}
                                    @foreach ($kriteriaData['kandidat_results'] as $idx => $kandidat)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td>{{ $kandidat['nama_guide'] }}</td>
                                            <td>{{ $kriteriaData['nama_kriteria'] }}</td>
                                            @foreach ($kriteriaData['subkriterias'] as $sub)
                                                @php
                                                    $det = collect($kandidat['detail'])
                                                            ->firstWhere('subkriteria_id', $sub->id);
                                                @endphp
                                                <td>{{ $det['gap'] ?? '-' }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- ---------- Tabel Hasil Bobot ---------- --}}
                        <h6 class="fw-bold mb-2">Tabel Hasil Bobot {{ $kriteriaData['nama_kriteria'] }}</h6>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-sm align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Guide</th>
                                        <th>Kriteria</th>
                                        <th>GAP&nbsp;(Mean)</th>
                                        @foreach ($kriteriaData['subkriterias'] as $idx => $sub)
                                            <th>K{{ $idx + 1 }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kriteriaData['kandidat_results'] as $idx => $kandidat)
                                        @php
                                            $totalGap = 0; $countSub = count($kriteriaData['subkriterias']);
                                        @endphp
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td>{{ $kandidat['nama_guide'] }}</td>
                                            <td>{{ $kriteriaData['nama_kriteria'] }}</td>
                                            {{-- hitung bobot & gap --}}
                                            @foreach ($kriteriaData['subkriterias'] as $sub)
                                                @php
                                                    $det   = collect($kandidat['detail'])
                                                            ->firstWhere('subkriteria_id', $sub->id);
                                                    $nilai = $det['bobot_nilai'] ?? 0;
                                                    $gap   = $nilai - ($sub->bobot_ideal ?? 0);
                                                    $totalGap += $gap;
                                                @endphp
                                                <td>{{ $nilai }}</td>
                                            @endforeach
                                            <td class="fw-semibold">
                                                {{ number_format($totalGap / $countSub, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- ---------- Tabel Pengelompokan Nilai GAP per Kriteria ---------- --}}
                        <h6 class="fw-bold mb-2">Pengelompokan Nilai Bobot GAP</h6>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-sm align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Guide</th>
                                        @foreach ($kriteriaData['subkriterias'] as $idx => $sub)
                                            <th>K{{ $idx + 1 }}</th>
                                        @endforeach
                                        <th>Core Factor</th>
                                        <th>Secondary Factor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kriteriaData['kandidat_results'] as $idx => $kandidat)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td>{{ $kandidat['nama_guide'] }}</td>
                                            @foreach ($kriteriaData['subkriterias'] as $sub)
                                                @php
                                                    $det = collect($kandidat['detail'])
                                                            ->firstWhere('subkriteria_id', $sub->id);
                                                @endphp
                                                <td>{{ $det['bobot_nilai'] ?? '-' }}</td>
                                            @endforeach
                                            <td>{{ number_format($kandidat['nilai_cf'], 2) }}</td>
                                            <td>{{ number_format($kandidat['nilai_sf'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- ---------- Tabel Total Nilai ---------- --}}
                        <h6 class="fw-bold mb-2">Perhitungan Nilai Total</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Guide</th>
                                        <th>Nilai CF</th>
                                        <th>Nilai SF</th>
                                        <th>Nilai Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kriteriaData['kandidat_results'] as $idx => $kandidat)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td>{{ $kandidat['nama_guide'] }}</td>
                                            <td>{{ number_format($kandidat['nilai_cf'], 2) }}</td>
                                            <td>{{ number_format($kandidat['nilai_sf'], 2) }}</td>
                                            <td class="fw-semibold">
                                                {{ number_format($kandidat['nilai_total'], 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            @endforeach

            {{-- ===== Ranking Guide – Admin ===== --}}
            <h4 class="fw-bold text-dark mb-3">Ranking Guide (versi Admin)</h4>
            <div class="table-responsive mb-5">
                <table class="table table-bordered table-sm align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Ranking</th>
                            <th>Nama Guide</th>
                            <th>Nilai Akhir</th>
                            <th>Unggul di Kriteria</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rankingAdmin as $idx => $item)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td>{{ $item['penilaian']->guide->nama_guide ?? '-' }}</td>
                                <td>{{ number_format($item['hasil']['nilai_akhir'], 2) }}</td>
                                <td class="text-primary fw-semibold">
                                    {{ $item['kriteria_unggulan'] ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ===== Ranking Guide – Pelanggan ===== --}}
            @php
                /* --------- Group & Sort hasil ranking pelanggan di dalam view --------- */
                $grouped = [];
                foreach ($rankingPelanggan as $item) {
                    $guide = $item['penilaian']->guide;
                    if (!$guide) continue;

                    $id = $guide->id;
                    $grouped[$id]['nama']  = $guide->nama_guide ?? '-';
                    $grouped[$id]['nilai'] = ($grouped[$id]['nilai'] ?? 0) + ($item['hasil']['nilai_akhir'] ?? 0);

                    // Kriteria unggulan
                    $krit = $item['kriteria_unggulan'] ?? '';
                    if ($krit && (!isset($grouped[$id]['kriteria']) || !in_array($krit, $grouped[$id]['kriteria']))) {
                        $grouped[$id]['kriteria'][] = $krit;
                    }
                }
                // convert & sort
                $grouped = array_values($grouped);
                usort($grouped, fn($a,$b) => $b['nilai'] <=> $a['nilai']);
            @endphp

            <h4 class="fw-bold text-dark mb-3">Ranking Guide (versi Pelanggan)</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Ranking</th>
                            <th>Nama Guide</th>
                            <th>Nilai Akhir</th>
                            <th>Unggul di Kriteria</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grouped as $idx => $g)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td>{{ $g['nama'] }}</td>
                                <td>{{ number_format($g['nilai'], 2) }}</td>
                                <td class="text-primary fw-semibold">
                                    {{ isset($g['kriteria']) ? implode(', ', $g['kriteria']) : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>  {{-- card‑body --}}
    </div>      {{-- card --}}
</div>          {{-- container --}}
@endsection
