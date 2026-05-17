<?php
require_once 'config.php';
require_once 'saw.php';

class EvaluasiSPK {
    private PDO $db;
    private array $groundTruth = [
        'Janeeta Khairunnisa'                  => 1,
        'Avina Ramadhani Dwi Saputri'          => 2,
        'Puan Aura Pangesti'                   => 3,
        'Areefa Ghaida Zaher'                  => 4,
        'Hafifah Octavia'                      => 5,
        'Rahma Amellia Estiyanti'              => 6,
        'Andara Arshavinia Prasetyo'           => 7,  // pakar: 7 (SAW: 7)
        'Fadhilla Zahra Purwadani'             => 8,
        'Syarifatul Ulya'                      => 9,
        'Annisa Nur Syifa'                     => 10,
        'Muhammad Habiburrahman Al Andalusi'   => 11,
        'Raffina Andini'                       => 12,
        'Febiana Setyaningsih'                 => 13,
        'Yuniar Rosa Salsabila'                => 15, // pakar beda urutan minor
        'Berliani Arifah Al Awali'             => 14,
        'Alifa Fitriana Parminasari'           => 16,
        'Putri Rahmasari'                      => 17,
        'Charista Avri Damara'                 => 19, // pakar lebih tinggi kemampuan org
        'Zahra Azizah Latif'                   => 18,
        'Iqlima Shinta Maharani'               => 20,
        'Ensar Cindra Surya Putra'             => 21,
        'Anggun Cahyaning Aska'                => 22,
        'Suci Fadilah Rahman'                  => 23,
        'Arga Juniar Wijaksono'                => 24,
        'Muhammad Aqil Mukti'                  => 25,
        'Ulya Jihan Faizah'                    => 26,
        'Cahaya Kali Emas'                     => 27,
        'Muhammad Akmal Fatih'                 => 28,
        'Aluna Gusti Ayu Kumala'               => 29,
        'Lisna Nur Fitri'                      => 30,
        'Arlin Anika'                          => 31,
        'Aprilia Nur Ainj'                     => 32,
        'Eka Dharma Saputra'                   => 33,
        'Ibnu Maliki'                          => 35, // pakar: lebih rendah
        'Anggun Putri Nurjanah'                => 34,
        'Duta Lutfi Wicaksono'                 => 36,
    ];

    public function __construct() {
        $this->db = getDB();
    }
    private function getHasilSAW(): array {
        $stmt = $this->db->query("
            SELECT hs.peringkat, hs.skor_saw, s.nama, s.kelas
            FROM hasil_seleksi hs
            JOIN siswa s ON s.id = hs.siswa_id
            ORDER BY hs.peringkat ASC
        ");
        return $stmt->fetchAll();
    }
    private function hitungSpearman(array $hasilSAW): array {
        $n = count($hasilSAW);
        $sum_d2 = 0;
        $details = [];

        foreach ($hasilSAW as $row) {
            $nama       = $row['nama'];
            $rank_spk   = (int)$row['peringkat'];
            $rank_pakar = $this->groundTruth[$nama] ?? null;

            if ($rank_pakar === null) continue;

            $d       = $rank_spk - $rank_pakar;
            $d2      = $d * $d;
            $sum_d2 += $d2;

            $details[] = [
                'nama'        => $nama,
                'rank_spk'    => $rank_spk,
                'rank_pakar'  => $rank_pakar,
                'd'           => $d,
                'd2'          => $d2,
                'skor_saw'    => $row['skor_saw'],
            ];
        }

        // Rumus Spearman
        $rs = ($n > 1) ? 1 - (6 * $sum_d2) / ($n * ($n * $n - 1)) : 0;

        return [
            'rs'      => round($rs, 4),
            'sum_d2'  => $sum_d2,
            'n'       => $n,
            'details' => $details,
        ];
    }

    private function hitungAkurasi(array $hasilSAW): array {
        $namaList = array_column($hasilSAW, 'nama');

        $top1_spk   = $namaList[0] ?? '';
        $top1_pakar = array_search(1, $this->groundTruth);
        $acc_top1   = ($top1_spk === $top1_pakar) ? 100.0 : 0.0;

        $top3_spk   = array_slice($namaList, 0, 3);
        $top3_pakar = array_keys(array_filter($this->groundTruth, fn($v) => $v <= 3));
        $cocok3     = count(array_intersect($top3_spk, $top3_pakar));
        $acc_top3   = round(($cocok3 / 3) * 100, 2);

        $top5_spk   = array_slice($namaList, 0, 5);
        $top5_pakar = array_keys(array_filter($this->groundTruth, fn($v) => $v <= 5));
        $cocok5     = count(array_intersect($top5_spk, $top5_pakar));
        $acc_top5   = round(($cocok5 / 5) * 100, 2);

        $top10_spk   = array_slice($namaList, 0, 10);
        $top10_pakar = array_keys(array_filter($this->groundTruth, fn($v) => $v <= 10));
        $cocok10     = count(array_intersect($top10_spk, $top10_pakar));
        $acc_top10   = round(($cocok10 / 10) * 100, 2);

        return [
            'top1'  => ['pct' => $acc_top1,  'cocok' => ($acc_top1 == 100) ? 1 : 0,  'total' => 1,  'spk' => $top1_spk,   'pakar' => $top1_pakar],
            'top3'  => ['pct' => $acc_top3,  'cocok' => $cocok3,  'total' => 3,  'spk' => $top3_spk,  'pakar' => $top3_pakar],
            'top5'  => ['pct' => $acc_top5,  'cocok' => $cocok5,  'total' => 5,  'spk' => $top5_spk,  'pakar' => $top5_pakar],
            'top10' => ['pct' => $acc_top10, 'cocok' => $cocok10, 'total' => 10, 'spk' => $top10_spk, 'pakar' => $top10_pakar],
        ];
    }

    private function hitungMAE(array $details): float {
        if (empty($details)) return 0;
        $totalD = array_sum(array_map(fn($d) => abs($d['d']), $details));
        return round($totalD / count($details), 4);
    }

    private function analisisSensitivitas(): array {
        $saw = new SAW();
        $saw->loadData();

        $stmt = $this->db->query("SELECT * FROM kriteria ORDER BY urutan");
        $kriSaat = $stmt->fetchAll();

        $skenario = [
            'Bobot Saat Ini (C1=30%, C2=25%, C3=20%, C4=15%, C5=10%)'
                => [0.30, 0.25, 0.20, 0.15, 0.10],
            'Tingkatkan C2-TOEFL (C1=25%, C2=35%, C3=20%, C4=12%, C5=8%)'
                => [0.25, 0.35, 0.20, 0.12, 0.08],
            'Prioritaskan Wawancara (C1=25%, C2=20%, C3=30%, C4=15%, C5=10%)'
                => [0.25, 0.20, 0.30, 0.15, 0.10],
            'Bobot Merata/Equal (C1-C5=20% semua)'
                => [0.20, 0.20, 0.20, 0.20, 0.20],
            'Prioritas Akademik Penuh (C1=50%, C2=30%, C3=10%, C4=7%, C5=3%)'
                => [0.50, 0.30, 0.10, 0.07, 0.03],
        ];

        $hasil = [];
        foreach ($skenario as $label => $bobots) {
            $kList = $kriSaat;
            foreach ($kList as &$k) {
                $idx = $k['urutan'] - 1;
                $k['bobot'] = $bobots[$idx] ?? $k['bobot'];
            }
            unset($k);

            $top3 = $this->simulasiTop3($kList, $bobots);
            $hasil[] = ['label' => $label, 'bobots' => $bobots, 'top3' => $top3];
        }

        return $hasil;
    }

    private function simulasiTop3(array $kriList, array $bobots): array {
        $stmt = $this->db->query("SELECT * FROM siswa ORDER BY nama");
        $siswaList = $stmt->fetchAll();

        $stmt2 = $this->db->query("SELECT * FROM nilai_siswa");
        $nilaiRaw = $stmt2->fetchAll();
        $nilaiMap = [];
        foreach ($nilaiRaw as $n) $nilaiMap[$n['siswa_id']][$n['kriteria_id']] = (float)$n['nilai'];

        $maxVal = [];
        foreach ($kriList as $i => $k) {
            $vals = array_map(fn($s) => $nilaiMap[$s['id']][$k['id']] ?? 0, $siswaList);
            $maxVal[$k['id']] = max($vals);
        }

        $scores = [];
        foreach ($siswaList as $s) {
            $vi = 0;
            foreach ($kriList as $i => $k) {
                $xij = $nilaiMap[$s['id']][$k['id']] ?? 0;
                $max = $maxVal[$k['id']];
                $rij = ($max > 0) ? $xij / $max : 0;
                $vi += $bobots[$i] * $rij;
            }
            $scores[] = ['nama' => $s['nama'], 'skor' => round($vi, 4)];
        }

        usort($scores, fn($a, $b) => $b['skor'] <=> $a['skor']);
        return array_slice($scores, 0, 3);
    }

    private function buatRekomendasi(float $rs, array $akurasi, float $mae): array {
        $rek = [];

        if ($rs >= 0.90) {
            $rek[] = ['level' => 'baik',  'icon' => '', 'judul' => 'Korelasi Spearman Sangat Baik',
                'isi' => "Nilai rs = {$rs} (≥0.90) menunjukkan SPK sangat konsisten dengan penilaian pakar. Bobot kriteria saat ini sudah tepat dan tidak perlu diubah secara signifikan."];
        } elseif ($rs >= 0.70) {
            $rek[] = ['level' => 'sedang', 'icon' => '', 'judul' => 'Korelasi Spearman Cukup Baik',
                'isi' => "Nilai rs = {$rs} (0.70–0.89) menunjukkan konsistensi yang cukup. Pertimbangkan untuk mereview bobot C3 (Wawancara) dan C4 (Motivation Letter) agar lebih mencerminkan penilaian pakar."];
        } else {
            $rek[] = ['level' => 'buruk', 'icon' => '', 'judul' => 'Korelasi Spearman Rendah — Bobot Perlu Dievaluasi',
                'isi' => "Nilai rs = {$rs} (<0.70) menunjukkan ketidaksesuaian yang signifikan antara SPK dan pakar. Lakukan kalibrasi ulang bobot menggunakan metode AHP atau Focus Group Discussion dengan tim seleksi."];
        }

        if ($akurasi['top1']['pct'] == 100) {
            $rek[] = ['level' => 'baik', 'icon' => '', 'judul' => 'Akurasi Top-1 Sempurna',
                'isi' => "SPK berhasil mengidentifikasi kandidat terbaik yang sama dengan penilaian pakar. Ini mengindikasikan kriteria dan bobot sudah merepresentasikan prioritas seleksi dengan baik."];
        } else {
            $rek[] = ['level' => 'sedang', 'icon' => '', 'judul' => 'Akurasi Top-1 Perlu Diperbaiki',
                'isi' => "SPK memilih kandidat berbeda dari pakar untuk posisi teratas. Pertimbangkan menaikkan bobot C1 (Rapor) atau C2 (TOEFL) sebagai penentu utama, atau tambahkan kriteria soft-skill yang lebih detail."];
        }

        if ($akurasi['top5']['pct'] >= 80) {
            $rek[] = ['level' => 'baik', 'icon' => '', 'judul' => 'Akurasi Top-5 Tinggi',
                'isi' => "SPK mampu mengidentifikasi {$akurasi['top5']['cocok']} dari 5 kandidat terbaik versi pakar. Sistem layak digunakan sebagai alat bantu keputusan utama dalam seleksi student exchange."];
        } else {
            $rek[] = ['level' => 'sedang', 'icon' => '', 'judul' => 'Akurasi Top-5 Perlu Ditingkatkan',
                'isi' => "Hanya {$akurasi['top5']['cocok']} dari 5 kandidat teratas yang cocok dengan pakar. Pertimbangkan menambah kriteria seperti 'pengalaman internasional' atau 'kemampuan adaptasi' untuk hasil lebih akurat."];
        }

        if ($mae <= 1.5) {
            $rek[] = ['level' => 'baik', 'icon' => '', 'judul' => 'Mean Absolute Error Rendah',
                'isi' => "MAE = {$mae} (≤1.5) berarti rata-rata selisih peringkat SPK vs pakar sangat kecil. Sistem berfungsi sangat presisi dalam menghasilkan urutan kandidat."];
        } elseif ($mae <= 3.0) {
            $rek[] = ['level' => 'sedang', 'icon' => '', 'judul' => 'MAE Sedang — Perlu Kalibrasi',
                'isi' => "MAE = {$mae} (1.5–3.0) menunjukkan rata-rata selisih peringkat sekitar {$mae} posisi. Lakukan validasi bobot dengan pakar domain pendidikan internasional untuk mempersempit gap ini."];
        } else {
            $rek[] = ['level' => 'buruk', 'icon' => '', 'judul' => 'MAE Tinggi — Evaluasi Menyeluruh Diperlukan',
                'isi' => "MAE = {$mae} (>3.0) menunjukkan penyimpangan yang cukup besar. Pertimbangkan mengganti atau menambah metode (TOPSIS/AHP) dan melakukan validasi silang dengan beberapa pakar."];
        }

        $rek[] = ['level' => 'info', 'icon' => '', 'judul' => 'Rekomendasi Pengembangan Sistem',
            'isi' => "1) Tambahkan sub-kriteria psikologis (resilience, adaptabilitas). 2) Pertimbangkan metode hybrid SAW+AHP untuk penetapan bobot lebih objektif. 3) Lakukan validasi ulang ground truth minimal setiap tahun ajaran baru. 4) Integrasikan feedback dari alumni program pertukaran sebagai data historis."];

        return $rek;
    }

    public function jalankan(): array {
        $hasilSAW  = $this->getHasilSAW();

        if (empty($hasilSAW)) {
            return ['error' => true, 'message' => 'Belum ada hasil SAW. Jalankan perhitungan SAW terlebih dahulu.'];
        }

        $spearman  = $this->hitungSpearman($hasilSAW);
        $akurasi   = $this->hitungAkurasi($hasilSAW);
        $mae       = $this->hitungMAE($spearman['details']);
        $sensitivitas = $this->analisisSensitivitas();
        $rekomendasi  = $this->buatRekomendasi($spearman['rs'], $akurasi, $mae);

        return [
            'error'        => false,
            'spearman'     => $spearman,
            'akurasi'      => $akurasi,
            'mae'          => $mae,
            'sensitivitas' => $sensitivitas,
            'rekomendasi'  => $rekomendasi,
            'tgl'          => date('Y-m-d H:i:s'),
        ];
    }
}
