<?php

namespace App\Services;

class ProfileMatchingService
{
    public function hitungGap($nilaiKandidat, $profilStandar)
    {
        return $nilaiKandidat - $profilStandar;
    }

    public function konversiGap($gap)
    {
        $bobotNilai = [
            0 => 5,
            1 => 4.5, -1 => 4,
            2 => 3.5, -2 => 3,
            3 => 2.5, -3 => 2,
            4 => 1.5, -4 => 1
        ];

        return $bobotNilai[$gap] ?? 0;
    }

    public function hitungNilaiTotalKriteria($nilaiCoreFactor, $nilaiSecondaryFactor)
    {
        // Asumsi bobot core factor 60% dan secondary factor 40%
        return (0.6 * $nilaiCoreFactor) + (0.4 * $nilaiSecondaryFactor);
    }

    public function hitungNilaiAkhir($nilaiTotalKriteria)
    {
        // Asumsi semua kriteria memiliki bobot yang sama
        return array_sum($nilaiTotalKriteria) / count($nilaiTotalKriteria);
    }
}
