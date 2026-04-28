CREATE DATABASE IF NOT EXISTS spk_studentexchange 
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE spk_studentexchange;

CREATE TABLE IF NOT EXISTS pengguna (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin', 'panitia', 'kepala_sekolah') NOT NULL DEFAULT 'panitia',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS kriteria (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kode VARCHAR(5) NOT NULL UNIQUE,
  nama_kriteria VARCHAR(100) NOT NULL,
  jenis ENUM('benefit', 'cost') NOT NULL DEFAULT 'benefit',
  bobot FLOAT NOT NULL DEFAULT 0,
  keterangan TEXT,
  urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS siswa (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nisn VARCHAR(20),
  nama VARCHAR(150) NOT NULL,
  kelas VARCHAR(10),
  jenis_kelamin ENUM('L','P') DEFAULT 'P',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS nilai_siswa (
  id INT AUTO_INCREMENT PRIMARY KEY,
  siswa_id INT NOT NULL,
  kriteria_id INT NOT NULL,
  nilai FLOAT NOT NULL DEFAULT 0,
  tgl_input DATE DEFAULT (CURRENT_DATE),
  FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE CASCADE,
  FOREIGN KEY (kriteria_id) REFERENCES kriteria(id) ON DELETE CASCADE,
  UNIQUE KEY uq_siswa_kriteria (siswa_id, kriteria_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS hasil_seleksi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  siswa_id INT NOT NULL,
  skor_saw FLOAT NOT NULL DEFAULT 0,
  peringkat INT,
  status ENUM('proses','selesai') DEFAULT 'selesai',
  tgl_hitung TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO pengguna (nama, email, password, role) VALUES
('Administrator', 'admin@spk.sch.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Panitia Seleksi', 'panitia@spk.sch.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'panitia');

INSERT INTO kriteria (kode, nama_kriteria, jenis, bobot, keterangan, urutan) VALUES
('C1', 'Nilai Rata-Rata Rapor',       'benefit', 0.30, 'Nilai rata-rata akademik siswa dari rapor semester terakhir', 1),
('C2', 'Skor TOEFL/IELTS/TOEIC',      'benefit', 0.25, 'Skor kemampuan bahasa Inggris yang telah distandarisasi', 2),
('C3', 'Nilai Wawancara',             'benefit', 0.20, 'Skor wawancara yang dilakukan oleh panitia seleksi', 3),
('C4', 'Penilaian Motivation Letter', 'benefit', 0.15, 'Skor penilaian atas surat motivasi yang ditulis siswa', 4),
('C5', 'Keaktifan Organisasi/Prestasi','benefit', 0.10, 'Skor keaktifan organisasi dan pencapaian prestasi siswa', 5);

INSERT INTO siswa (nisn, nama, kelas, jenis_kelamin) VALUES
('001', 'Alifa Fitriana Parminasari',           'XII IPA 1', 'P'),
('002', 'Aluna Gusti Ayu Kumala',               'XII IPA 1', 'P'),
('003', 'Andara Arshavinia Prasetyo',           'XII IPA 2', 'P'),
('004', 'Anggun Cahyaning Aska',                'XII IPA 2', 'P'),
('005', 'Anggun Putri Nurjanah',                'XII IPA 3', 'P'),
('006', 'Annisa Nur Syifa',                     'XII IPA 1', 'P'),
('007', 'Aprilia Nur Ainj',                     'XII IPA 3', 'P'),
('008', 'Areefa Ghaida Zaher',                  'XII IPA 2', 'P'),
('009', 'Arga Juniar Wijaksono',                'XII IPA 1', 'L'),
('010', 'Arlin Anika',                          'XII IPA 3', 'P'),
('011', 'Avina Ramadhani Dwi Saputri',          'XII IPA 2', 'P'),
('012', 'Berliani Arifah Al Awali',             'XII IPA 1', 'P'),
('013', 'Cahaya Kali Emas',                     'XII IPA 3', 'P'),
('014', 'Charista Avri Damara',                 'XII IPA 2', 'P'),
('015', 'Duta Lutfi Wicaksono',                 'XII IPA 1', 'L'),
('016', 'Eka Dharma Saputra',                   'XII IPA 3', 'L'),
('017', 'Ensar Cindra Surya Putra',             'XII IPA 2', 'L'),
('018', 'Fadhilla Zahra Purwadani',             'XII IPA 1', 'P'),
('019', 'Febiana Setyaningsih',                 'XII IPA 2', 'P'),
('020', 'Hafifah Octavia',                      'XII IPA 3', 'P'),
('021', 'Ibnu Maliki',                          'XII IPA 1', 'L'),
('022', 'Iqlima Shinta Maharani',               'XII IPA 2', 'P'),
('023', 'Janeeta Khairunnisa',                  'XII IPA 1', 'P'),
('024', 'Lisna Nur Fitri',                      'XII IPA 3', 'P'),
('025', 'Muhammad Akmal Fatih',                 'XII IPA 2', 'L'),
('026', 'Muhammad Aqil Mukti',                  'XII IPA 1', 'L'),
('027', 'Muhammad Habiburrahman Al Andalusi',   'XII IPA 3', 'L'),
('028', 'Puan Aura Pangesti',                   'XII IPA 2', 'P'),
('029', 'Putri Rahmasari',                      'XII IPA 1', 'P'),
('030', 'Raffina Andini',                       'XII IPA 3', 'P'),
('031', 'Rahma Amellia Estiyanti',              'XII IPA 2', 'P'),
('032', 'Suci Fadilah Rahman',                  'XII IPA 1', 'P'),
('033', 'Syarifatul Ulya',                      'XII IPA 3', 'P'),
('034', 'Ulya Jihan Faizah',                    'XII IPA 2', 'P'),
('035', 'Yuniar Rosa Salsabila',                'XII IPA 1', 'P'),
('036', 'Zahra Azizah Latif',                   'XII IPA 3', 'P');

INSERT INTO nilai_siswa (siswa_id, kriteria_id, nilai) VALUES
-- Alifa Fitriana Parminasari
(1,1,88.5),(1,2,520),(1,3,82),(1,4,85),(1,5,80),
-- Aluna Gusti Ayu Kumala
(2,1,85),(2,2,490),(2,3,78),(2,4,80),(2,5,75),
-- Andara Arshavinia Prasetyo
(3,1,87.2),(3,2,545),(3,3,88),(3,4,90),(3,5,88),
-- Anggun Cahyaning Aska
(4,1,87.5),(4,2,510),(4,3,80),(4,4,83),(4,5,77),
-- Anggun Putri Nurjanah
(5,1,82),(5,2,475),(5,3,75),(5,4,78),(5,5,70),
-- Annisa Nur Syifa
(6,1,89),(6,2,530),(6,3,85),(6,4,87),(6,5,83),
-- Aprilia Nur Ainj
(7,1,83.5),(7,2,490),(7,3,76),(7,4,79),(7,5,72),
-- Areefa Ghaida Zaher
(8,1,91),(8,2,560),(8,3,90),(8,4,92),(8,5,90),
-- Arga Juniar Wijaksono
(9,1,86),(9,2,505),(9,3,81),(9,4,82),(9,5,78),
-- Arlin Anika
(10,1,84),(10,2,485),(10,3,77),(10,4,80),(10,5,73),
-- Avina Ramadhani Dwi Saputri
(11,1,92.5),(11,2,575),(11,3,91),(11,4,93),(11,5,92),
-- Berliani Arifah Al Awali
(12,1,88),(12,2,515),(12,3,83),(12,4,86),(12,5,81),
-- Cahaya Kali Emas
(13,1,85.5),(13,2,495),(13,3,79),(13,4,81),(13,5,76),
-- Charista Avri Damara
(14,1,87),(14,2,508),(14,3,84),(14,4,84),(14,5,79),
-- Duta Lutfi Wicaksono
(15,1,80),(15,2,465),(15,3,73),(15,4,75),(15,5,68),
-- Eka Dharma Saputra
(16,1,83),(16,2,478),(16,3,75),(16,4,77),(16,5,71),
-- Ensar Cindra Surya Putra
(17,1,86.5),(17,2,507),(17,3,82),(17,4,83),(17,5,80),
-- Fadhilla Zahra Purwadani
(18,1,89.5),(18,2,535),(18,3,86),(18,4,88),(18,5,85),
-- Febiana Setyaningsih
(19,1,88),(19,2,520),(19,3,84),(19,4,84),(19,5,82),
-- Hafifah Octavia
(20,1,90.5),(20,2,550),(20,3,89),(20,4,91),(20,5,89),
-- Ibnu Maliki
(21,1,82.5),(21,2,477),(21,3,74),(21,4,78),(21,5,71),
-- Iqlima Shinta Maharani
(22,1,87),(22,2,512),(22,3,81),(22,4,84),(22,5,78),
-- Janeeta Khairunnisa
(23,1,93),(23,2,580),(23,3,92),(23,4,94),(23,5,93),
-- Lisna Nur Fitri
(24,1,84.5),(24,2,488),(24,3,77),(24,4,81),(24,5,74),
-- Muhammad Akmal Fatih
(25,1,85),(25,2,493),(25,3,78),(25,4,80),(25,5,75),
-- Muhammad Aqil Mukti
(26,1,86),(26,2,503),(26,3,80),(26,4,82),(26,5,77),
-- Muhammad Habiburrahman Al Andalusi
(27,1,89),(27,2,528),(27,3,85),(27,4,87),(27,5,84),
-- Puan Aura Pangesti
(28,1,91.5),(28,2,562),(28,3,90),(28,4,92),(28,5,91),
-- Putri Rahmasari
(29,1,87.5),(29,2,513),(29,3,82),(29,4,85),(29,5,80),
-- Raffina Andini
(30,1,88.5),(30,2,522),(30,3,84),(30,4,87),(30,5,83),
-- Rahma Amellia Estiyanti
(31,1,90),(31,2,542),(31,3,88),(31,4,90),(31,5,87),
-- Suci Fadilah Rahman
(32,1,86.5),(32,2,506),(32,3,81),(32,4,83),(32,5,79),
-- Syarifatul Ulya
(33,1,89),(33,2,530),(33,3,86),(33,4,88),(33,5,85),
-- Ulya Jihan Faizah
(34,1,85.5),(34,2,497),(34,3,79),(34,4,82),(34,5,76),
-- Yuniar Rosa Salsabila
(35,1,88),(35,2,517),(35,3,83),(35,4,86),(35,5,82),
-- Zahra Azizah Latif
(36,1,87),(36,2,510),(36,3,81),(36,4,84),(36,5,79);
