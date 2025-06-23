<?php

namespace App\Traits;

use App\Models\Penilaian;

trait ProfileMatchingTrait
{
   public function hitungProfileMatching(Penilaian $penilaian, $kriteriaPesanan = null)
{
    $hasilPerhitungan = [];
    $nilaiTotalKriteria = [];

    foreach ($penilaian->detailPenilaians as $detail) {
        $subkriteria = $detail->subkriteria;
        $kriteria = $subkriteria->kriteria;

        // Gunakan nilai standar dari pesanan jika tersedia
        $standar = $kriteriaPesanan[$subkriteria->id] ?? $subkriteria->profil_standar;

        $gap = $this->profileMatchingService->hitungGap($detail->nilai, $standar);
        $bobotNilai = $this->profileMatchingService->konversiGap($gap);

        if (!isset($hasilPerhitungan[$kriteria->id])) {
            $hasilPerhitungan[$kriteria->id] = [
                'nama' => $kriteria->nama,
                'core_factor' => [],
                'secondary_factor' => [],
                'detail' => []
            ];
        }

        $faktorKey = $subkriteria->is_core_factor ? 'core_factor' : 'secondary_factor';
        $hasilPerhitungan[$kriteria->id][$faktorKey][] = $bobotNilai;

        $hasilPerhitungan[$kriteria->id]['detail'][] = [
            'subkriteria_id' => $subkriteria->id,
            'nama_subkriteria' => $subkriteria->nama,
            'nilai' => $detail->nilai,
            'profil_standar' => $standar,
            'gap' => $gap,
            'bobot_nilai' => $bobotNilai,
            'is_core_factor' => $subkriteria->is_core_factor
        ];
    }

    foreach ($hasilPerhitungan as $kriteriaId => $hasil) {
        $nilaiCoreFactor = !empty($hasil['core_factor']) ? array_sum($hasil['core_factor']) / count($hasil['core_factor']) : 0;
        $nilaiSecondaryFactor = !empty($hasil['secondary_factor']) ? array_sum($hasil['secondary_factor']) / count($hasil['secondary_factor']) : 0;

        $nilaiTotalKriteria[$kriteriaId] = $this->profileMatchingService->hitungNilaiTotalKriteria($nilaiCoreFactor, $nilaiSecondaryFactor);

        $hasilPerhitungan[$kriteriaId]['nilai_cf'] = $nilaiCoreFactor;
        $hasilPerhitungan[$kriteriaId]['nilai_sf'] = $nilaiSecondaryFactor;
        $hasilPerhitungan[$kriteriaId]['nilai_total'] = $nilaiTotalKriteria[$kriteriaId];
    }

    $nilaiAkhir = $this->profileMatchingService->hitungNilaiAkhir($nilaiTotalKriteria);

    return [
        'detail' => $hasilPerhitungan,
        'nilai_akhir' => $nilaiAkhir
    ];
}

}
