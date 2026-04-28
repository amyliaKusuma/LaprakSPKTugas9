<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once 'config.php';
require_once 'saw.php';

$saw    = new SAW();
$action = $_GET['action'] ?? $_POST['action'] ?? '';

try {
    switch ($action) {

        // ---- Hitung SAW ----
        case 'hitung_saw':
            $hasil = $saw->jalankan();
            echo json_encode(['success' => true, 'data' => $hasil]);
            break;

        // ---- Ambil Hasil ----
        case 'get_hasil':
            $hasil = $saw->getHasil();
            echo json_encode(['success' => true, 'data' => $hasil]);
            break;

        // ---- Daftar Siswa ----
        case 'get_siswa':
            echo json_encode(['success' => true, 'data' => $saw->getSiswa()]);
            break;

        // ---- Tambah Siswa ----
        case 'tambah_siswa':
            $data = [
                'nisn'  => trim($_POST['nisn'] ?? ''),
                'nama'  => trim($_POST['nama'] ?? ''),
                'kelas' => trim($_POST['kelas'] ?? ''),
                'jk'    => $_POST['jk'] ?? 'P',
            ];
            if (empty($data['nama'])) {
                echo json_encode(['success' => false, 'message' => 'Nama siswa wajib diisi']);
                break;
            }
            $ok = $saw->tambahSiswa($data);
            echo json_encode(['success' => $ok, 'message' => $ok ? 'Siswa berhasil ditambahkan' : 'Gagal menambahkan siswa']);
            break;

        // ---- Hapus Siswa ----
        case 'hapus_siswa':
            $id = (int)($_POST['id'] ?? 0);
            $ok = $saw->hapusSiswa($id);
            echo json_encode(['success' => $ok, 'message' => $ok ? 'Siswa dihapus' : 'Gagal menghapus']);
            break;

        // ---- Nilai Siswa ----
        case 'get_nilai':
            $sid  = (int)($_GET['siswa_id'] ?? 0);
            $data = $saw->getNilaiSiswa($sid);
            echo json_encode(['success' => true, 'data' => $data]);
            break;

        // ---- Simpan Nilai ----
        case 'simpan_nilai':
            $sid    = (int)($_POST['siswa_id'] ?? 0);
            $nilais = $_POST['nilai'] ?? [];
            if ($sid < 1 || empty($nilais)) {
                echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
                break;
            }
            $ok = $saw->simpanNilai($sid, $nilais);
            echo json_encode(['success' => $ok, 'message' => $ok ? 'Nilai berhasil disimpan' : 'Gagal menyimpan nilai']);
            break;

        // ---- Kriteria ----
        case 'get_kriteria':
            echo json_encode(['success' => true, 'data' => $saw->getKriteria()]);
            break;

        // ---- Update Bobot ----
        case 'update_bobot':
            $bobots = $_POST['bobot'] ?? [];
            // Validasi: total harus = 1
            $total = array_sum(array_map('floatval', $bobots));
            if (abs($total - 1.0) > 0.001) {
                echo json_encode(['success' => false, 'message' => "Total bobot harus 100% (saat ini: " . round($total * 100, 1) . "%)"]);
                break;
            }
            $ok = $saw->updateBobot($bobots);
            echo json_encode(['success' => $ok, 'message' => $ok ? 'Bobot berhasil diperbarui' : 'Gagal memperbarui bobot']);
            break;

        // ---- Statistik ----
        case 'get_stats':
            echo json_encode(['success' => true, 'data' => $saw->getStats()]);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Action tidak dikenali: ' . $action]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
