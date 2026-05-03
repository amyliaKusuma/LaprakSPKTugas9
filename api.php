<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once 'config.php';
require_once 'saw.php';
require_once 'evaluasi.php';
require_once 'ml_integration.php';

$saw    = new SAW();
$action = $_GET['action'] ?? $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'hitung_saw':
            echo json_encode(['success'=>true,'data'=>$saw->jalankan()]);
            break;
        case 'get_hasil':
            echo json_encode(['success'=>true,'data'=>$saw->getHasil()]);
            break;
        case 'get_siswa':
            echo json_encode(['success'=>true,'data'=>$saw->getSiswa()]);
            break;
        case 'tambah_siswa':
            $data=['nisn'=>trim($_POST['nisn']??''),'nama'=>trim($_POST['nama']??''),'kelas'=>trim($_POST['kelas']??''),'jk'=>$_POST['jk']??'P'];
            if(empty($data['nama'])){echo json_encode(['success'=>false,'message'=>'Nama siswa wajib diisi']);break;}
            $ok=$saw->tambahSiswa($data);
            echo json_encode(['success'=>$ok,'message'=>$ok?'Siswa berhasil ditambahkan':'Gagal menambahkan siswa']);
            break;
        case 'hapus_siswa':
            $id=(int)($_POST['id']??0);$ok=$saw->hapusSiswa($id);
            echo json_encode(['success'=>$ok,'message'=>$ok?'Siswa dihapus':'Gagal menghapus']);
            break;
        case 'get_nilai':
            echo json_encode(['success'=>true,'data'=>$saw->getNilaiSiswa((int)($_GET['siswa_id']??0))]);
            break;
        case 'simpan_nilai':
            $sid=(int)($_POST['siswa_id']??0);$nilais=$_POST['nilai']??[];
            if($sid<1||empty($nilais)){echo json_encode(['success'=>false,'message'=>'Data tidak lengkap']);break;}
            $ok=$saw->simpanNilai($sid,$nilais);
            echo json_encode(['success'=>$ok,'message'=>$ok?'Nilai berhasil disimpan':'Gagal menyimpan nilai']);
            break;
        case 'get_kriteria':
            echo json_encode(['success'=>true,'data'=>$saw->getKriteria()]);
            break;
        case 'update_bobot':
            $bobots=$_POST['bobot']??[];$total=array_sum(array_map('floatval',$bobots));
            if(abs($total-1.0)>0.001){echo json_encode(['success'=>false,'message'=>"Total bobot harus 100% (saat ini: ".round($total*100,1)."%)"]);break;}
            $ok=$saw->updateBobot($bobots);
            echo json_encode(['success'=>$ok,'message'=>$ok?'Bobot berhasil diperbarui':'Gagal memperbarui bobot']);
            break;
        case 'evaluasi':
            $ev=new EvaluasiSPK();$hasil=$ev->jalankan();
            echo json_encode(['success'=>!($hasil['error']??false),'data'=>$hasil]);
            break;
        case 'get_stats':
            echo json_encode(['success'=>true,'data'=>$saw->getStats()]);
            break;
        // ---- ML ----
        case 'ml_status':
            $ml=new MLIntegration();$online=$ml->isServerOnline();
            echo json_encode(['success'=>true,'online'=>$online,'message'=>$online?'Flask API server aktif':'Server ML tidak aktif. Jalankan: python ml/predict_api.py']);
            break;
        case 'ml_model_info':
            $ml=new MLIntegration();
            try{$info=$ml->getModelInfo();echo json_encode(['success'=>true,'data'=>$info['data']??$info]);}
            catch(Exception $e){echo json_encode(['success'=>false,'message'=>$e->getMessage()]);}
            break;
        case 'ml_prediksi_semua':
            $ml=new MLIntegration();
            try{$h=$ml->prediksiSemuaSiswa();echo json_encode(['success'=>($h['success']??true),'data'=>$h]);}
            catch(Exception $e){echo json_encode(['success'=>false,'message'=>$e->getMessage()]);}
            break;
        default:
            echo json_encode(['success'=>false,'message'=>'Action tidak dikenali: '.$action]);
    }
} catch(Exception $e){
    echo json_encode(['success'=>false,'message'=>'Error: '.$e->getMessage()]);
}
