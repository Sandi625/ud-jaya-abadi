<?php

namespace App\Traits;

trait KriteriaTrait
{
   public function tentukanKriteriaUnggulanshow($hasil)
{
    $max = null;
    $kriteriaUnggulId = null;
    $kriteriaUnggulNama = 'Belum Dinilai';

    foreach ($hasil['detail'] as $kriteriaId => $detail) {
        $nilai = $detail['nilai_total'] ?? null;
        if ($nilai !== null && ($max === null || $nilai > $max)) {
            $max = $nilai;
            $kriteriaUnggulId = $kriteriaId;
            $kriteriaUnggulNama = $detail['nama']; // ← dari hitungProfileMatching
        }
    }

    return [
        'id' => $kriteriaUnggulId,
        'nama' => $kriteriaUnggulNama,
    ];
}


}
