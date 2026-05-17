<?php
require_once 'config.php';

class SAW {
    private PDO $db;
    private array $kriteria = [];
    private array $siswa = [];
    private array $nilaiMatrix = [];   // [siswa_id][kriteria_id] = nilai
    private array $maxMin = [];        // [kriteria_id] = ['max'=>..., 'min'=>...]
    private array $normalized = [];    // [siswa_id][kriteria_id] = Rij
    private array $skorAkhir = [];     // [siswa_id] = Vi

    public function __construct() {
        $this->db = getDB();
    }

    public function loadData(): void {
        // Kriteria
        $stmt = $this->db->query("SELECT * FROM kriteria ORDER BY urutan");
        $this->kriteria = $stmt->fetchAll();

        // Siswa
        $stmt = $this->db->query("SELECT * FROM siswa ORDER BY nama");
        $this->siswa = $stmt->fetchAll();

        // Nilai siswa
        $stmt = $this->db->query("SELECT * FROM nilai_siswa");
        foreach ($stmt->fetchAll() as $row) {
            $this->nilaiMatrix[$row['siswa_id']][$row['kriteria_id']] = (float)$row['nilai'];
        }
    }
    private function hitungMaxMin(): void {
        foreach ($this->kriteria as $k) {
            $kid = $k['id'];
            $vals = [];
            foreach ($this->siswa as $s) {
                $vals[] = $this->nilaiMatrix[$s['id']][$kid] ?? 0;
            }
            $this->maxMin[$kid] = [
                'max' => max($vals),
                'min' => min($vals),
            ];
        }
    }

    private function normalisasi(): void {
        foreach ($this->siswa as $s) {
            $sid = $s['id'];
            foreach ($this->kriteria as $k) {
                $kid  = $k['id'];
                $xij  = $this->nilaiMatrix[$sid][$kid] ?? 0;
                $max  = $this->maxMin[$kid]['max'];
                $min  = $this->maxMin[$kid]['min'];

                if ($k['jenis'] === 'benefit') {
                    $this->normalized[$sid][$kid] = ($max > 0) ? ($xij / $max) : 0;
                } else {
                    // cost
                    $this->normalized[$sid][$kid] = ($xij > 0) ? ($min / $xij) : 0;
                }
            }
        }
    }

    private function hitungSkor(): void {
        foreach ($this->siswa as $s) {
            $sid = $s['id'];
            $vi  = 0;
            foreach ($this->kriteria as $k) {
                $kid    = $k['id'];
                $bobot  = (float)$k['bobot'];
                $rij    = $this->normalized[$sid][$kid] ?? 0;
                $vi    += $bobot * $rij;
            }
            $this->skorAkhir[$sid] = round($vi, 6);
        }
    }

    private function simpanHasil(array $ranked): void {
        $this->db->exec("DELETE FROM hasil_seleksi");
        $stmt = $this->db->prepare(
            "INSERT INTO hasil_seleksi (siswa_id, skor_saw, peringkat, status) VALUES (?, ?, ?, 'selesai')"
        );
        foreach ($ranked as $peringkat => $row) {
            $stmt->execute([$row['siswa_id'], $row['skor_saw'], $peringkat + 1]);
        }
    }

    public function jalankan(): array {
        $this->loadData();
        $this->hitungMaxMin();
        $this->normalisasi();
        $this->hitungSkor();

        // Susun peringkat
        $ranked = [];
        foreach ($this->siswa as $s) {
            $sid = $s['id'];
            $ranked[] = [
                'siswa_id'    => $sid,
                'nama'        => $s['nama'],
                'kelas'       => $s['kelas'],
                'skor_saw'    => $this->skorAkhir[$sid],
                'normalized'  => $this->normalized[$sid] ?? [],
                'nilai_asli'  => $this->nilaiMatrix[$sid] ?? [],
            ];
        }
        usort($ranked, fn($a, $b) => $b['skor_saw'] <=> $a['skor_saw']);

        // Tambahkan peringkat
        foreach ($ranked as $i => &$r) {
            $r['peringkat'] = $i + 1;
        }
        unset($r);

        // Simpan ke DB
        $this->simpanHasil($ranked);

        return [
            'kriteria'   => $this->kriteria,
            'maxMin'     => $this->maxMin,
            'ranked'     => $ranked,
            'total'      => count($ranked),
            'tgl_hitung' => date('Y-m-d H:i:s'),
        ];
    }

    public function getHasil(): array {
        $stmt = $this->db->query("
            SELECT hs.*, s.nama, s.kelas, s.jenis_kelamin
            FROM hasil_seleksi hs
            JOIN siswa s ON s.id = hs.siswa_id
            ORDER BY hs.peringkat ASC
        ");
        return $stmt->fetchAll();
    }

    public function getSiswa(): array {
        return $this->db->query("SELECT * FROM siswa ORDER BY nama")->fetchAll();
    }

    public function tambahSiswa(array $data): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO siswa (nisn, nama, kelas, jenis_kelamin) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([
            $data['nisn'] ?? '',
            $data['nama'],
            $data['kelas'] ?? '',
            $data['jk'] ?? 'P',
        ]);
    }

    public function hapusSiswa(int $id): bool {
        return $this->db->prepare("DELETE FROM siswa WHERE id = ?")->execute([$id]);
    }

    public function getNilaiSiswa(int $siswaId): array {
        $stmt = $this->db->prepare("
            SELECT ns.*, k.kode, k.nama_kriteria, k.bobot, k.jenis
            FROM nilai_siswa ns
            JOIN kriteria k ON k.id = ns.kriteria_id
            WHERE ns.siswa_id = ?
            ORDER BY k.urutan
        ");
        $stmt->execute([$siswaId]);
        return $stmt->fetchAll();
    }

    public function simpanNilai(int $siswaId, array $nilaiArr): bool {
        // nilaiArr = [kriteria_id => nilai]
        $stmt = $this->db->prepare("
            INSERT INTO nilai_siswa (siswa_id, kriteria_id, nilai)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE nilai = VALUES(nilai)
        ");
        foreach ($nilaiArr as $kId => $val) {
            $stmt->execute([$siswaId, (int)$kId, (float)$val]);
        }
        return true;
    }

    public function getKriteria(): array {
        return $this->db->query("SELECT * FROM kriteria ORDER BY urutan")->fetchAll();
    }

    public function updateBobot(array $bobots): bool {
        // bobots = [id => bobot]
        $stmt = $this->db->prepare("UPDATE kriteria SET bobot = ? WHERE id = ?");
        foreach ($bobots as $id => $b) {
            $stmt->execute([(float)$b, (int)$id]);
        }
        return true;
    }

    public function getStats(): array {
        $totalSiswa   = $this->db->query("SELECT COUNT(*) FROM siswa")->fetchColumn();
        $totalNilai   = $this->db->query("SELECT COUNT(*) FROM nilai_siswa")->fetchColumn();
        $totalHasil   = $this->db->query("SELECT COUNT(*) FROM hasil_seleksi")->fetchColumn();
        $topSiswa     = $this->db->query("
            SELECT s.nama, hs.skor_saw, hs.peringkat
            FROM hasil_seleksi hs JOIN siswa s ON s.id = hs.siswa_id
            WHERE hs.peringkat = 1
        ")->fetch();
        return [
            'total_siswa'  => $totalSiswa,
            'total_nilai'  => $totalNilai,
            'sudah_hitung' => $totalHasil > 0,
            'top_siswa'    => $topSiswa,
        ];
    }
}
