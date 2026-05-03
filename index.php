<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SPK Student Exchange – SMAN 3 Malang</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
/* ============================================================
   RESET & VARIABLES
   ============================================================ */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}

:root{
  --bg:         #0b0f1a;
  --bg2:        #111827;
  --bg3:        #1a2235;
  --card:       #151d2e;
  --border:     #1e2d45;
  --accent:     #3b82f6;
  --accent2:    #06b6d4;
  --accent3:    #8b5cf6;
  --gold:       #f59e0b;
  --silver:     #94a3b8;
  --bronze:     #b45309;
  --green:      #10b981;
  --red:        #ef4444;
  --text:       #e2e8f0;
  --text2:      #94a3b8;
  --text3:      #64748b;
  --mono:       'DM Mono', monospace;
  --sans:       'Space Grotesk', sans-serif;
  --radius:     12px;
  --shadow:     0 4px 24px rgba(0,0,0,0.5);
}

html{scroll-behavior:smooth}
body{
  font-family:var(--sans);
  background:var(--bg);
  color:var(--text);
  min-height:100vh;
  overflow-x:hidden;
}

/* ============================================================
   GRID NOISE BACKGROUND
   ============================================================ */
body::before{
  content:'';
  position:fixed;inset:0;
  background-image:
    radial-gradient(ellipse 80% 60% at 20% 10%, rgba(59,130,246,.08) 0%, transparent 60%),
    radial-gradient(ellipse 60% 40% at 80% 80%, rgba(139,92,246,.06) 0%, transparent 60%);
  pointer-events:none;z-index:0;
}

/* ============================================================
   SIDEBAR
   ============================================================ */
.sidebar{
  position:fixed;left:0;top:0;bottom:0;width:240px;
  background:var(--bg2);
  border-right:1px solid var(--border);
  display:flex;flex-direction:column;
  z-index:100;
  transition:transform .3s ease;
}
.sidebar-logo{
  padding:28px 20px 20px;
  border-bottom:1px solid var(--border);
}
.sidebar-logo .app-title{
  font-size:13px;font-weight:700;letter-spacing:.12em;
  text-transform:uppercase;color:var(--accent);
  margin-bottom:4px;
}
.sidebar-logo .app-sub{
  font-size:11px;color:var(--text3);
  font-family:var(--mono);
}
.nav{padding:16px 0;flex:1;overflow-y:auto}
.nav-item{
  display:flex;align-items:center;gap:10px;
  padding:10px 20px;font-size:13.5px;font-weight:500;
  color:var(--text2);cursor:pointer;
  transition:all .15s ease;border-left:3px solid transparent;
  user-select:none;
}
.nav-item:hover{color:var(--text);background:rgba(59,130,246,.06);border-left-color:rgba(59,130,246,.3)}
.nav-item.active{color:var(--accent);background:rgba(59,130,246,.1);border-left-color:var(--accent)}
.nav-item .icon{font-size:17px;width:20px;text-align:center}
.nav-section{
  padding:16px 20px 6px;font-size:10px;font-weight:700;
  letter-spacing:.12em;text-transform:uppercase;color:var(--text3);
}
.sidebar-footer{
  padding:16px 20px;border-top:1px solid var(--border);
  font-size:11px;color:var(--text3);font-family:var(--mono);
  line-height:1.6;
}

/* ============================================================
   MAIN
   ============================================================ */
.main{
  margin-left:240px;
  min-height:100vh;
  position:relative;z-index:1;
}
.topbar{
  background:rgba(11,15,26,.8);
  backdrop-filter:blur(12px);
  border-bottom:1px solid var(--border);
  padding:0 32px;height:60px;
  display:flex;align-items:center;justify-content:space-between;
  position:sticky;top:0;z-index:50;
}
.topbar-title{font-size:15px;font-weight:600}
.topbar-right{display:flex;align-items:center;gap:12px}
.btn{
  display:inline-flex;align-items:center;gap:6px;
  padding:7px 16px;border-radius:8px;
  font-size:13px;font-weight:600;font-family:var(--sans);
  cursor:pointer;border:none;transition:all .15s ease;
  text-decoration:none;
}
.btn-primary{background:var(--accent);color:#fff}
.btn-primary:hover{background:#2563eb;transform:translateY(-1px)}
.btn-success{background:var(--green);color:#fff}
.btn-success:hover{background:#059669}
.btn-danger{background:var(--red);color:#fff}
.btn-danger:hover{background:#dc2626}
.btn-ghost{background:transparent;color:var(--text2);border:1px solid var(--border)}
.btn-ghost:hover{border-color:var(--accent);color:var(--accent)}
.btn-sm{padding:5px 12px;font-size:12px}
.btn-icon{padding:6px 8px}

.page{padding:28px 32px;display:none}
.page.active{display:block}

/* ============================================================
   STAT CARDS
   ============================================================ */
.stats-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
  gap:16px;margin-bottom:28px;
}
.stat-card{
  background:var(--card);border:1px solid var(--border);
  border-radius:var(--radius);padding:20px;
  display:flex;align-items:flex-start;gap:14px;
  transition:border-color .2s,transform .2s;
}
.stat-card:hover{border-color:var(--accent);transform:translateY(-2px)}
.stat-icon{
  width:42px;height:42px;border-radius:10px;
  display:flex;align-items:center;justify-content:center;
  font-size:20px;flex-shrink:0;
}
.stat-icon.blue{background:rgba(59,130,246,.15)}
.stat-icon.cyan{background:rgba(6,182,212,.15)}
.stat-icon.purple{background:rgba(139,92,246,.15)}
.stat-icon.green{background:rgba(16,185,129,.15)}
.stat-icon.gold{background:rgba(245,158,11,.15)}
.stat-val{font-size:26px;font-weight:700;font-family:var(--mono);line-height:1;margin-bottom:4px}
.stat-lbl{font-size:12px;color:var(--text2)}
.stat-sub{font-size:11px;color:var(--text3);margin-top:2px;font-family:var(--mono)}

/* ============================================================
   SECTION CARD
   ============================================================ */
.section-card{
  background:var(--card);border:1px solid var(--border);
  border-radius:var(--radius);margin-bottom:20px;
  overflow:hidden;
}
.section-head{
  padding:16px 20px;border-bottom:1px solid var(--border);
  display:flex;align-items:center;justify-content:space-between;
}
.section-head h2{font-size:14px;font-weight:600}
.section-head p{font-size:12px;color:var(--text3);margin-top:2px}
.section-body{padding:20px}

/* ============================================================
   TABLE
   ============================================================ */
.table-wrap{overflow-x:auto}
table{width:100%;border-collapse:collapse;font-size:13px}
thead tr{background:rgba(30,45,69,.8)}
th{
  padding:10px 14px;text-align:left;
  font-size:11px;font-weight:700;letter-spacing:.06em;
  text-transform:uppercase;color:var(--text3);
  white-space:nowrap;
}
td{
  padding:10px 14px;border-bottom:1px solid rgba(30,45,69,.6);
  color:var(--text);
}
tr:last-child td{border-bottom:none}
tr:hover td{background:rgba(59,130,246,.04)}
.td-mono{font-family:var(--mono);font-size:12.5px}
.td-center{text-align:center}

/* Rank badge */
.rank{
  display:inline-flex;align-items:center;justify-content:center;
  width:28px;height:28px;border-radius:50%;
  font-size:12px;font-weight:700;font-family:var(--mono);
}
.rank-1{background:rgba(245,158,11,.2);color:var(--gold);border:1px solid rgba(245,158,11,.4)}
.rank-2{background:rgba(148,163,184,.15);color:var(--silver);border:1px solid rgba(148,163,184,.3)}
.rank-3{background:rgba(180,83,9,.15);color:#cd7c3a;border:1px solid rgba(180,83,9,.3)}
.rank-n{background:rgba(30,45,69,.8);color:var(--text3);border:1px solid var(--border)}

/* Score bar */
.score-bar-wrap{display:flex;align-items:center;gap:10px}
.score-bar{flex:1;height:6px;background:var(--border);border-radius:3px;overflow:hidden}
.score-bar-fill{height:100%;border-radius:3px;transition:width .5s ease}
.score-num{font-family:var(--mono);font-size:12px;white-space:nowrap;min-width:50px;text-align:right}

/* Bobot chip */
.bobot-chip{
  display:inline-block;padding:2px 8px;border-radius:20px;
  font-size:11px;font-weight:600;font-family:var(--mono);
  background:rgba(59,130,246,.15);color:var(--accent);
  border:1px solid rgba(59,130,246,.3);
}

/* ============================================================
   BADGE / TAG
   ============================================================ */
.badge{
  display:inline-block;padding:2px 8px;border-radius:20px;
  font-size:11px;font-weight:600;
}
.badge-green{background:rgba(16,185,129,.15);color:var(--green);border:1px solid rgba(16,185,129,.3)}
.badge-red{background:rgba(239,68,68,.15);color:var(--red);border:1px solid rgba(239,68,68,.3)}
.badge-blue{background:rgba(59,130,246,.15);color:var(--accent);border:1px solid rgba(59,130,246,.3)}

/* ============================================================
   FORM ELEMENTS
   ============================================================ */
.form-group{margin-bottom:16px}
.form-group label{display:block;font-size:12px;font-weight:600;color:var(--text2);margin-bottom:6px}
.form-control{
  width:100%;padding:9px 12px;
  background:var(--bg2);border:1px solid var(--border);
  border-radius:8px;color:var(--text);font-family:var(--sans);
  font-size:13px;transition:border-color .15s;
}
.form-control:focus{outline:none;border-color:var(--accent);box-shadow:0 0 0 3px rgba(59,130,246,.12)}
.form-control::placeholder{color:var(--text3)}
select.form-control{cursor:pointer}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.form-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px}
.form-hint{font-size:11px;color:var(--text3);margin-top:4px}

/* ============================================================
   MODAL
   ============================================================ */
.modal-overlay{
  position:fixed;inset:0;background:rgba(0,0,0,.7);
  backdrop-filter:blur(6px);
  z-index:1000;display:none;align-items:center;justify-content:center;
}
.modal-overlay.open{display:flex}
.modal{
  background:var(--bg2);border:1px solid var(--border);
  border-radius:16px;width:90%;max-width:560px;
  max-height:90vh;overflow-y:auto;
  box-shadow:0 24px 64px rgba(0,0,0,.6);
  animation:modalIn .2s ease;
}
.modal-wide{max-width:860px}
@keyframes modalIn{from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)}}
.modal-head{
  padding:20px 24px 16px;border-bottom:1px solid var(--border);
  display:flex;align-items:flex-start;justify-content:space-between;
}
.modal-head h3{font-size:16px;font-weight:700}
.modal-head p{font-size:12px;color:var(--text3);margin-top:2px}
.modal-close{
  background:none;border:none;color:var(--text3);
  font-size:20px;cursor:pointer;padding:2px 6px;
  border-radius:6px;transition:color .15s;
}
.modal-close:hover{color:var(--text)}
.modal-body{padding:20px 24px}
.modal-footer{
  padding:16px 24px;border-top:1px solid var(--border);
  display:flex;align-items:center;justify-content:flex-end;gap:10px;
}

/* ============================================================
   NOTICE / ALERT
   ============================================================ */
.notice{
  padding:12px 16px;border-radius:8px;font-size:13px;
  display:flex;align-items:flex-start;gap:10px;margin-bottom:16px;
}
.notice-info{background:rgba(59,130,246,.1);border:1px solid rgba(59,130,246,.25);color:#93c5fd}
.notice-success{background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.25);color:#6ee7b7}
.notice-warn{background:rgba(245,158,11,.1);border:1px solid rgba(245,158,11,.25);color:#fcd34d}

/* ============================================================
   TOP 3 PODIUM
   ============================================================ */
.podium{
  display:flex;align-items:flex-end;justify-content:center;
  gap:12px;padding:16px 0 24px;margin-bottom:8px;
}
.podium-item{
  display:flex;flex-direction:column;align-items:center;gap:8px;
  flex:1;max-width:180px;
}
.podium-card{
  background:var(--bg3);border:1px solid var(--border);
  border-radius:12px;padding:16px 12px;text-align:center;
  width:100%;transition:transform .2s;
}
.podium-card:hover{transform:translateY(-4px)}
.podium-card.pos-1{border-color:rgba(245,158,11,.4);background:rgba(245,158,11,.06)}
.podium-card.pos-2{border-color:rgba(148,163,184,.25);background:rgba(148,163,184,.04)}
.podium-card.pos-3{border-color:rgba(180,83,9,.3);background:rgba(180,83,9,.04)}
.podium-medal{font-size:28px;margin-bottom:4px}
.podium-name{font-size:12.5px;font-weight:600;line-height:1.3;margin-bottom:6px}
.podium-score{
  font-family:var(--mono);font-size:18px;font-weight:700;
  margin-bottom:2px;
}
.podium-score.pos-1{color:var(--gold)}
.podium-score.pos-2{color:var(--silver)}
.podium-score.pos-3{color:#cd7c3a}
.podium-pct{font-size:11px;color:var(--text3)}
.podium-bar{
  height:60px;width:100%;border-radius:6px 6px 0 0;
  display:flex;align-items:center;justify-content:center;
  font-size:20px;font-weight:900;
}
.podium-bar.pos-1{background:rgba(245,158,11,.25);color:var(--gold);height:60px}
.podium-bar.pos-2{background:rgba(148,163,184,.15);color:var(--silver);height:40px}
.podium-bar.pos-3{background:rgba(180,83,9,.15);color:#cd7c3a;height:28px}

/* ============================================================
   NORMALISASI DETAIL TABLE
   ============================================================ */
.detail-grid{
  display:grid;grid-template-columns:repeat(5,1fr);gap:8px;
  margin-top:12px;
}
.detail-cell{
  background:var(--bg);border:1px solid var(--border);
  border-radius:8px;padding:10px;text-align:center;
}
.detail-cell-lbl{font-size:10px;color:var(--text3);margin-bottom:4px;font-family:var(--mono)}
.detail-cell-raw{font-size:13px;font-weight:600;color:var(--text);margin-bottom:2px}
.detail-cell-norm{font-size:11px;color:var(--accent);font-family:var(--mono)}

/* ============================================================
   BOBOT SLIDER
   ============================================================ */
.bobot-row{
  display:grid;grid-template-columns:120px 1fr 70px 60px;
  align-items:center;gap:12px;padding:12px 0;
  border-bottom:1px solid rgba(30,45,69,.5);
}
.bobot-row:last-child{border-bottom:none}
.bobot-label{font-size:13px;font-weight:600}
.bobot-sub{font-size:11px;color:var(--text3)}
input[type=range]{
  -webkit-appearance:none;width:100%;height:4px;
  border-radius:2px;background:var(--border);outline:none;
}
input[type=range]::-webkit-slider-thumb{
  -webkit-appearance:none;width:16px;height:16px;border-radius:50%;
  background:var(--accent);cursor:pointer;
  box-shadow:0 0 6px rgba(59,130,246,.5);
}
.bobot-pct{
  font-family:var(--mono);font-size:14px;font-weight:700;
  color:var(--accent);text-align:center;
}
.bobot-total{
  margin-top:16px;padding:12px 16px;border-radius:8px;
  background:var(--bg);border:1px solid var(--border);
  display:flex;align-items:center;justify-content:space-between;
}
.bobot-total .lbl{font-size:13px;font-weight:600}
.bobot-total .val{font-family:var(--mono);font-size:16px;font-weight:700}
.bobot-total.ok .val{color:var(--green)}
.bobot-total.err .val{color:var(--red)}

/* ============================================================
   LOADING / SPINNER
   ============================================================ */
.spinner{
  display:inline-block;width:18px;height:18px;
  border:2px solid rgba(59,130,246,.3);border-top-color:var(--accent);
  border-radius:50%;animation:spin .7s linear infinite;
}
@keyframes spin{to{transform:rotate(360deg)}}
.loading-overlay{
  position:fixed;inset:0;background:rgba(0,0,0,.6);
  backdrop-filter:blur(4px);z-index:2000;
  display:none;align-items:center;justify-content:center;
  flex-direction:column;gap:16px;
}
.loading-overlay.show{display:flex}
.loading-txt{font-size:14px;color:var(--text2);font-family:var(--mono)}

/* ============================================================
   TOAST
   ============================================================ */
#toast-container{
  position:fixed;bottom:24px;right:24px;z-index:3000;
  display:flex;flex-direction:column;gap:8px;
}
.toast{
  padding:12px 18px;border-radius:10px;font-size:13px;font-weight:500;
  min-width:220px;max-width:340px;
  display:flex;align-items:center;gap:10px;
  animation:toastIn .3s ease;
  box-shadow:0 8px 24px rgba(0,0,0,.4);
}
@keyframes toastIn{from{opacity:0;transform:translateX(30px)} to{opacity:1;transform:translateX(0)}}
.toast-success{background:#064e3b;border:1px solid rgba(16,185,129,.4);color:#6ee7b7}
.toast-error{background:#450a0a;border:1px solid rgba(239,68,68,.4);color:#fca5a5}
.toast-info{background:#1e3a5f;border:1px solid rgba(59,130,246,.4);color:#93c5fd}

/* ============================================================
   EMPTY STATE
   ============================================================ */
.empty{
  padding:48px 20px;text-align:center;
}
.empty-icon{font-size:40px;margin-bottom:12px;opacity:.5}
.empty-title{font-size:15px;font-weight:600;margin-bottom:6px}
.empty-sub{font-size:13px;color:var(--text3)}

/* ============================================================
   RESPONSIVE
   ============================================================ */
@media(max-width:768px){
  .sidebar{width:200px}
  .main{margin-left:200px}
  .topbar,.page{padding-left:16px;padding-right:16px}
  .form-grid,.form-grid-3{grid-template-columns:1fr}
  .podium{gap:8px}
}
</style>
</head>
<body>

<!-- ============================================================
     LOADING OVERLAY
     ============================================================ -->
<div class="loading-overlay" id="loadingOverlay">
  <div class="spinner" style="width:36px;height:36px;border-width:3px"></div>
  <div class="loading-txt" id="loadingTxt">Memproses perhitungan SAW...</div>
</div>

<!-- ============================================================
     TOAST CONTAINER
     ============================================================ -->
<div id="toast-container"></div>

<!-- ============================================================
     SIDEBAR
     ============================================================ -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="app-title">⚡ SPK Seleksi</div>
    <div class="app-sub">Student Exchange · SMAN 3 Malang</div>
  </div>
  <nav class="nav">
    <div class="nav-section">Menu Utama</div>
    <div class="nav-item active" data-page="dashboard" onclick="showPage('dashboard',this)">
      <span class="icon">📊</span> Dashboard
    </div>
    <div class="nav-item" data-page="perhitungan" onclick="showPage('perhitungan',this)">
      <span class="icon">🧮</span> Hitung SAW
    </div>
    <div class="nav-item" data-page="hasil" onclick="showPage('hasil',this)">
      <span class="icon">🏆</span> Hasil Peringkat
    </div>
    <div class="nav-item" data-page="ml" onclick="showPage('ml',this)">
      <span class="icon">🤖</span> Machine Learning
    </div>
    <div class="nav-item" data-page="evaluasi" onclick="showPage('evaluasi',this)">
      <span class="icon">🔬</span> Evaluasi SPK
    </div>
    <div class="nav-section">Data Master</div>
    <div class="nav-item" data-page="siswa" onclick="showPage('siswa',this)">
      <span class="icon">👥</span> Data Siswa
    </div>
    <div class="nav-item" data-page="kriteria" onclick="showPage('kriteria',this)">
      <span class="icon">⚖️</span> Kriteria & Bobot
    </div>
  </nav>
  <div class="sidebar-footer">
    Metode: SAW<br>
    Kriteria: 5 | Siswa: <span id="sidebarTotal">36</span><br>
    © 2026 PTI – UB
  </div>
</aside>

<!-- ============================================================
     MAIN
     ============================================================ -->
<main class="main">
  <div class="topbar">
    <div class="topbar-title" id="topbarTitle">📊 Dashboard</div>
    <div class="topbar-right">
      <button class="btn btn-primary" onclick="showPage('perhitungan', document.querySelector('[data-page=perhitungan]'))">
        🧮 Hitung SAW
      </button>
    </div>
  </div>

  <!-- ======================== DASHBOARD ======================== -->
  <div class="page active" id="page-dashboard">
    <div class="stats-grid" id="statsGrid">
      <div class="stat-card">
        <div class="stat-icon blue">👥</div>
        <div>
          <div class="stat-val" id="statSiswa">–</div>
          <div class="stat-lbl">Total Siswa</div>
          <div class="stat-sub">Peserta Seleksi</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon cyan">📋</div>
        <div>
          <div class="stat-val">5</div>
          <div class="stat-lbl">Kriteria Penilaian</div>
          <div class="stat-sub">Semua Benefit</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon purple">🎯</div>
        <div>
          <div class="stat-val" id="statStatus">–</div>
          <div class="stat-lbl">Status Perhitungan</div>
          <div class="stat-sub">SAW</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon gold">🏆</div>
        <div>
          <div class="stat-val" id="statTopScore">–</div>
          <div class="stat-lbl">Skor Tertinggi</div>
          <div class="stat-sub" id="statTopNama">–</div>
        </div>
      </div>
    </div>

    <!-- Podium -->
    <div class="section-card" id="podiumCard" style="display:none">
      <div class="section-head">
        <div>
          <h2>🏆 Top 3 Kandidat Terbaik</h2>
          <p>Berdasarkan skor SAW tertinggi</p>
        </div>
      </div>
      <div class="section-body">
        <div class="podium" id="podiumContainer"></div>
      </div>
    </div>

    <!-- Informasi Metode -->
    <div class="section-card">
      <div class="section-head"><div><h2>📚 Metode SAW – Simple Additive Weighting</h2></div></div>
      <div class="section-body">
        <div class="notice notice-info">
          <span>ℹ️</span>
          <div>SAW menghitung skor akhir dengan menjumlahkan hasil perkalian bobot kriteria dengan nilai ternormalisasi setiap alternatif. Formula: <strong>Vi = Σ(Wj × Rij)</strong></div>
        </div>
        <div class="form-grid-3">
          <div style="background:var(--bg3);border:1px solid var(--border);border-radius:10px;padding:16px;">
            <div style="font-size:20px;margin-bottom:8px">1️⃣</div>
            <div style="font-size:13px;font-weight:700;margin-bottom:4px">Matriks Keputusan</div>
            <div style="font-size:12px;color:var(--text3)">Susun data nilai asli seluruh siswa pada setiap kriteria ke dalam matriks X[i][j]</div>
          </div>
          <div style="background:var(--bg3);border:1px solid var(--border);border-radius:10px;padding:16px;">
            <div style="font-size:20px;margin-bottom:8px">2️⃣</div>
            <div style="font-size:13px;font-weight:700;margin-bottom:4px">Normalisasi</div>
            <div style="font-size:12px;color:var(--text3)">Benefit: <span style="font-family:var(--mono);color:var(--accent)">Rij = Xij / Max(Xj)</span><br>Cost: <span style="font-family:var(--mono);color:var(--accent)">Rij = Min(Xj) / Xij</span></div>
          </div>
          <div style="background:var(--bg3);border:1px solid var(--border);border-radius:10px;padding:16px;">
            <div style="font-size:20px;margin-bottom:8px">3️⃣</div>
            <div style="font-size:13px;font-weight:700;margin-bottom:4px">Skor Akhir</div>
            <div style="font-size:12px;color:var(--text3)"><span style="font-family:var(--mono);color:var(--accent)">Vi = Σ(Wj × Rij)</span><br>Urutkan Vi terbesar = terbaik</div>
          </div>
        </div>

        <div style="margin-top:20px">
          <div style="font-size:13px;font-weight:600;margin-bottom:10px;color:var(--text2)">Bobot Kriteria SAW</div>
          <div id="kriteriaSummary" style="display:flex;gap:8px;flex-wrap:wrap"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- ======================== PERHITUNGAN ======================== -->
  <div class="page" id="page-perhitungan">
    <div class="section-card">
      <div class="section-head">
        <div>
          <h2>🧮 Jalankan Perhitungan SAW</h2>
          <p>Klik tombol di bawah untuk menghitung dan memperbarui peringkat seluruh siswa</p>
        </div>
      </div>
      <div class="section-body">
        <div class="notice notice-warn">
          <span>⚠️</span>
          <div>Menjalankan perhitungan akan menimpa hasil sebelumnya. Pastikan semua data nilai siswa sudah lengkap terlebih dahulu.</div>
        </div>
        <div style="text-align:center;padding:24px 0">
          <button class="btn btn-primary" style="padding:14px 36px;font-size:15px" onclick="hitungSAW()">
            🚀 Hitung SAW Sekarang
          </button>
        </div>
      </div>
    </div>

    <!-- Hasil perhitungan langsung tampil di sini -->
    <div id="hasilPerhitungan" style="display:none">
      <div class="section-card">
        <div class="section-head">
          <div><h2>📊 Matriks Normalisasi & Skor SAW</h2><p id="hasilInfo"></p></div>
          <button class="btn btn-ghost btn-sm" onclick="showPage('hasil', document.querySelector('[data-page=hasil]'))">Lihat Peringkat →</button>
        </div>
        <div class="section-body">
          <div class="table-wrap">
            <table id="tblNormalisasi">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama Siswa</th>
                  <th class="td-center">R C1<br><small>Rapor</small></th>
                  <th class="td-center">R C2<br><small>TOEFL</small></th>
                  <th class="td-center">R C3<br><small>Wawancara</small></th>
                  <th class="td-center">R C4<br><small>Mot.Letter</small></th>
                  <th class="td-center">R C5<br><small>Org</small></th>
                  <th class="td-center">Skor SAW</th>
                </tr>
              </thead>
              <tbody id="tblNormalisasiBody"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ======================== HASIL ======================== -->
  <div class="page" id="page-hasil">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
      <div>
        <h1 style="font-size:18px;font-weight:700">🏆 Peringkat Siswa – Seleksi Student Exchange</h1>
        <p style="font-size:13px;color:var(--text3);margin-top:4px">Diurutkan berdasarkan Skor SAW tertinggi</p>
      </div>
      <button class="btn btn-success" onclick="hitungSAW()">🔄 Hitung Ulang</button>
    </div>

    <div id="hasilEmpty" class="section-card">
      <div class="section-body">
        <div class="empty">
          <div class="empty-icon">📭</div>
          <div class="empty-title">Belum ada hasil perhitungan</div>
          <div class="empty-sub">Silakan jalankan perhitungan SAW terlebih dahulu</div>
          <button class="btn btn-primary" style="margin-top:16px" onclick="showPage('perhitungan', document.querySelector('[data-page=perhitungan]'))">Hitung SAW →</button>
        </div>
      </div>
    </div>

    <div id="hasilTable" style="display:none">
      <div class="section-card">
        <div class="section-head">
          <div><h2>Tabel Peringkat Lengkap</h2><p id="hasilTableInfo"></p></div>
        </div>
        <div class="section-body">
          <div class="table-wrap">
            <table>
              <thead>
                <tr>
                  <th>Rank</th>
                  <th>Nama Siswa</th>
                  <th>Kelas</th>
                  <th>Skor SAW</th>
                  <th>Persentase</th>
                  <th class="td-center">Status</th>
                </tr>
              </thead>
              <tbody id="tblHasilBody"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ======================== SISWA ======================== -->
  <div class="page" id="page-siswa">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
      <div>
        <h1 style="font-size:18px;font-weight:700">👥 Data Siswa Peserta Seleksi</h1>
        <p style="font-size:13px;color:var(--text3);margin-top:4px">Kelola data siswa dan input nilai kriteria</p>
      </div>
      <button class="btn btn-primary" onclick="openModalTambahSiswa()">+ Tambah Siswa</button>
    </div>

    <div class="section-card">
      <div class="section-body" style="padding-top:12px;padding-bottom:12px">
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>NISN</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>JK</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody id="tblSiswaBody">
              <tr><td colspan="6" style="text-align:center;color:var(--text3);padding:24px">Loading...</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- ======================== KRITERIA ======================== -->
  <div class="page" id="page-kriteria">
    <div style="margin-bottom:20px">
      <h1 style="font-size:18px;font-weight:700">⚖️ Kriteria & Bobot SAW</h1>
      <p style="font-size:13px;color:var(--text3);margin-top:4px">Atur bobot setiap kriteria penilaian (total harus = 100%)</p>
    </div>

    <div class="section-card">
      <div class="section-head"><div><h2>Pengaturan Bobot Kriteria</h2></div></div>
      <div class="section-body">
        <div class="notice notice-info">
          <span>ℹ️</span>
          <div>Total bobot semua kriteria harus tepat <strong>100%</strong>. Setelah mengubah bobot, jalankan ulang perhitungan SAW untuk memperbarui peringkat.</div>
        </div>
        <div id="bobotContainer"></div>
        <div class="bobot-total" id="bobotTotal">
          <span class="lbl">Total Bobot</span>
          <span class="val" id="bobotTotalVal">0%</span>
        </div>
        <div style="margin-top:16px;display:flex;justify-content:flex-end">
          <button class="btn btn-primary" onclick="simpanBobot()">💾 Simpan Bobot</button>
        </div>
      </div>
    </div>

    <div class="section-card" style="margin-top:20px">
      <div class="section-head"><div><h2>Detail Kriteria</h2></div></div>
      <div class="section-body">
        <div class="table-wrap">
          <table id="tblKriteria">
            <thead>
              <tr><th>Kode</th><th>Nama Kriteria</th><th>Jenis</th><th>Bobot</th><th>Keterangan</th></tr>
            </thead>
            <tbody id="tblKriteriaBody"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- ======================== EVALUASI ======================== -->
  <div class="page" id="page-evaluasi">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
      <div>
        <h1 style="font-size:18px;font-weight:700">🔬 Evaluasi & Peningkatan Kinerja SPK</h1>
        <p style="font-size:13px;color:var(--text3);margin-top:4px">Mengukur efektivitas SPK menggunakan Spearman Correlation, Akurasi Top-K, dan MAE</p>
      </div>
      <button class="btn btn-primary" onclick="jalankanEvaluasi()">▶️ Jalankan Evaluasi</button>
    </div>

    <div class="notice notice-info" style="margin-bottom:20px">
      <span>ℹ️</span>
      <div><strong>Ground Truth</strong> ditetapkan berdasarkan penilaian holistik pakar/tim seleksi terhadap 36 siswa SMAN 3 Malang. Evaluasi membandingkan urutan SPK dengan urutan pakar menggunakan beberapa metrik statistik.</div>
    </div>

    <div id="evalEmpty" class="section-card">
      <div class="section-body">
        <div class="empty">
          <div class="empty-icon">🔬</div>
          <div class="empty-title">Siap Menjalankan Evaluasi</div>
          <div class="empty-sub">Pastikan perhitungan SAW sudah dijalankan, lalu klik tombol "Jalankan Evaluasi" di atas.</div>
        </div>
      </div>
    </div>

    <div id="evalContent" style="display:none">

      <!-- Kartu Metrik Utama -->
      <div class="stats-grid" id="evalStatGrid" style="grid-template-columns:repeat(auto-fit,minmax(200px,1fr))"></div>

      <!-- Spearman Detail -->
      <div class="section-card">
        <div class="section-head">
          <div>
            <h2>📐 Spearman Rank Correlation</h2>
            <p>Mengukur kesesuaian urutan peringkat SPK vs. pakar · Rumus: rs = 1 − (6·Σd²) / (n·(n²−1))</p>
          </div>
          <div id="spearmanBadge"></div>
        </div>
        <div class="section-body">
          <div id="spearmanFormula" style="background:var(--bg);border:1px solid var(--border);border-radius:8px;padding:14px;font-family:var(--mono);font-size:13px;margin-bottom:16px;line-height:2"></div>
          <div class="table-wrap">
            <table>
              <thead>
                <tr>
                  <th>Rank SPK</th>
                  <th>Nama Siswa</th>
                  <th class="td-center">Rank SPK</th>
                  <th class="td-center">Rank Pakar</th>
                  <th class="td-center">d (selisih)</th>
                  <th class="td-center">d²</th>
                  <th>Skor SAW</th>
                </tr>
              </thead>
              <tbody id="tblSpearman"></tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Akurasi Top-K -->
      <div class="section-card">
        <div class="section-head">
          <div><h2>🎯 Akurasi Top-K</h2><p>Perbandingan kandidat terpilih SPK vs. kandidat terpilih pakar</p></div>
        </div>
        <div class="section-body">
          <div id="akurasiGrid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;margin-bottom:20px"></div>
          <div class="table-wrap">
            <table>
              <thead>
                <tr><th>Metrik</th><th>SPK Pilih</th><th>Pakar Pilih</th><th class="td-center">Cocok</th><th class="td-center">Akurasi</th></tr>
              </thead>
              <tbody id="tblAkurasi"></tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Sensitivitas Bobot -->
      <div class="section-card">
        <div class="section-head">
          <div><h2>⚗️ Analisis Sensitivitas Bobot</h2><p>Uji dampak perubahan bobot kriteria terhadap Top 3 kandidat terpilih</p></div>
        </div>
        <div class="section-body">
          <div id="sensitivitasGrid"></div>
        </div>
      </div>

      <!-- Rekomendasi -->
      <div class="section-card">
        <div class="section-head">
          <div><h2>💡 Rekomendasi Perbaikan SPK</h2><p>Analisis otomatis berdasarkan hasil metrik evaluasi</p></div>
        </div>
        <div class="section-body" id="rekomendasiBody"></div>
      </div>

    </div>
  </div>



  <!-- ======================== MACHINE LEARNING ======================== -->
  <div class="page" id="page-ml">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
      <div>
        <h1 style="font-size:18px;font-weight:700">🤖 SPK + Machine Learning — Random Forest</h1>
        <p style="font-size:13px;color:var(--text3);margin-top:4px">Prediksi kelayakan siswa menggunakan model Random Forest yang dilatih dari data historis 48 siswa</p>
      </div>
      <div style="display:flex;gap:8px">
        <button class="btn btn-ghost" onclick="cekStatusML()">🔄 Cek Server</button>
        <button class="btn btn-primary" onclick="jalankanPrediksiSemua()">🚀 Prediksi Semua Siswa</button>
      </div>
    </div>

    <!-- Status Server -->
    <div id="mlServerStatus" class="notice notice-warn" style="margin-bottom:20px">
      <span>⏳</span><div>Mengecek status Flask API server...</div>
    </div>

    <!-- Panduan Setup -->
    <div class="section-card">
      <div class="section-head"><div><h2>📋 Cara Setup Python ML Server</h2><p>Ikuti 3 langkah sebelum menggunakan fitur Machine Learning</p></div></div>
      <div class="section-body">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:14px">
          <div style="background:var(--bg3);border:1px solid var(--border);border-radius:10px;padding:16px">
            <div style="font-size:20px;margin-bottom:8px">1️⃣</div>
            <div style="font-size:13px;font-weight:700;margin-bottom:6px">Install Library Python</div>
            <code style="display:block;background:var(--bg);padding:10px;border-radius:6px;font-size:11px;color:var(--accent);border:1px solid var(--border)">pip install pandas scikit-learn joblib flask</code>
          </div>
          <div style="background:var(--bg3);border:1px solid var(--border);border-radius:10px;padding:16px">
            <div style="font-size:20px;margin-bottom:8px">2️⃣</div>
            <div style="font-size:13px;font-weight:700;margin-bottom:6px">Training Model (sekali saja)</div>
            <code style="display:block;background:var(--bg);padding:10px;border-radius:6px;font-size:11px;color:var(--accent);border:1px solid var(--border)">cd spk_tugas8/ml<br>python train_model.py</code>
          </div>
          <div style="background:var(--bg3);border:1px solid var(--border);border-radius:10px;padding:16px">
            <div style="font-size:20px;margin-bottom:8px">3️⃣</div>
            <div style="font-size:13px;font-weight:700;margin-bottom:6px">Jalankan Flask Server</div>
            <code style="display:block;background:var(--bg);padding:10px;border-radius:6px;font-size:11px;color:var(--accent);border:1px solid var(--border)">python predict_api.py</code>
            <div style="font-size:11px;color:var(--text3);margin-top:6px">Biarkan terminal ini tetap berjalan</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Info Model (muncul setelah server aktif) -->
    <div class="section-card" id="mlModelInfo" style="display:none">
      <div class="section-head"><div><h2>📊 Evaluasi Model Random Forest</h2><p>Hasil training dari dataset 48 siswa SMAN 3 Malang</p></div></div>
      <div class="section-body">
        <div class="stats-grid" id="mlModelStats" style="grid-template-columns:repeat(auto-fit,minmax(155px,1fr))"></div>
        <div style="margin-top:20px">
          <div style="font-size:13px;font-weight:600;margin-bottom:12px;color:var(--text2)">🔍 Feature Importance — Faktor Paling Berpengaruh ke Prediksi</div>
          <div id="mlFeatureImportance"></div>
        </div>
        <div style="margin-top:20px;display:grid;grid-template-columns:1fr 1fr;gap:16px">
          <div>
            <div style="font-size:13px;font-weight:600;margin-bottom:10px;color:var(--text2)">📋 Classification Report</div>
            <div id="mlClassReport"></div>
          </div>
          <div>
            <div style="font-size:13px;font-weight:600;margin-bottom:10px;color:var(--text2)">🔲 Confusion Matrix</div>
            <div id="mlConfMatrix"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Hasil Prediksi Batch -->
    <div class="section-card" id="mlHasilCard" style="display:none">
      <div class="section-head">
        <div><h2>🎯 Hasil Prediksi ML — Seluruh Siswa</h2><p id="mlHasilInfo"></p></div>
      </div>
      <div class="section-body">
        <div style="display:flex;gap:12px;margin-bottom:16px;flex-wrap:wrap">
          <div style="background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.3);border-radius:8px;padding:10px 20px;text-align:center">
            <div style="font-size:24px;font-weight:700;font-family:var(--mono);color:var(--green)" id="mlCountLayak">-</div>
            <div style="font-size:12px;color:var(--green)">✅ LAYAK</div>
          </div>
          <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);border-radius:8px;padding:10px 20px;text-align:center">
            <div style="font-size:24px;font-weight:700;font-family:var(--mono);color:var(--red)" id="mlCountTidak">-</div>
            <div style="font-size:12px;color:var(--red)">❌ TIDAK LAYAK</div>
          </div>
        </div>
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Siswa</th>
                <th class="td-center">Prediksi ML</th>
                <th>Probabilitas Layak</th>
                <th class="td-center">Prob. Tidak</th>
                <th class="td-center">Rank SAW</th>
              </tr>
            </thead>
            <tbody id="mlTabelHasil"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</main>

<!-- ============================================================
     MODAL: Tambah Siswa
     ============================================================ -->
<div class="modal-overlay" id="modalSiswa">
  <div class="modal">
    <div class="modal-head">
      <div><h3>+ Tambah Siswa</h3><p>Isi data siswa peserta seleksi</p></div>
      <button class="modal-close" onclick="closeModal('modalSiswa')">×</button>
    </div>
    <div class="modal-body">
      <div class="form-grid">
        <div class="form-group">
          <label>NISN</label>
          <input type="text" class="form-control" id="fNisn" placeholder="12345678">
        </div>
        <div class="form-group">
          <label>Jenis Kelamin</label>
          <select class="form-control" id="fJk">
            <option value="P">Perempuan</option>
            <option value="L">Laki-laki</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label>Nama Lengkap <span style="color:var(--red)">*</span></label>
        <input type="text" class="form-control" id="fNama" placeholder="Nama lengkap siswa">
      </div>
      <div class="form-group">
        <label>Kelas</label>
        <input type="text" class="form-control" id="fKelas" placeholder="XII IPA 1">
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeModal('modalSiswa')">Batal</button>
      <button class="btn btn-primary" onclick="simpanSiswa()">Simpan Siswa</button>
    </div>
  </div>
</div>

<!-- ============================================================
     MODAL: Input Nilai
     ============================================================ -->
<div class="modal-overlay" id="modalNilai">
  <div class="modal modal-wide">
    <div class="modal-head">
      <div><h3 id="modalNilaiTitle">Input Nilai Siswa</h3><p id="modalNilaiSub">Masukkan nilai untuk setiap kriteria penilaian</p></div>
      <button class="modal-close" onclick="closeModal('modalNilai')">×</button>
    </div>
    <div class="modal-body">
      <div class="notice notice-info" style="margin-bottom:16px">
        <span>📌</span>
        <div><strong>Panduan Rentang Nilai:</strong> C1 Rapor (80–100) · C2 TOEFL (450–677) · C3 Wawancara (0–100) · C4 Mot.Letter (0–100) · C5 Org (0–100)</div>
      </div>
      <div id="nilaiFormContainer"></div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeModal('modalNilai')">Batal</button>
      <button class="btn btn-success" onclick="simpanNilai()">💾 Simpan Nilai</button>
    </div>
  </div>
</div>

<!-- ============================================================
     JAVASCRIPT
     ============================================================ -->
<script>
// ============================================================
// STATE
// ============================================================
let currentSiswaId = null;
let kriteriaList = [];
let hasilData = [];

// ============================================================
// INIT
// ============================================================
document.addEventListener('DOMContentLoaded', () => {
  loadStats();
  loadKriteriaData();
  loadHasil();
  loadSiswa();
});

// ============================================================
// PAGE NAVIGATION
// ============================================================
function showPage(pageId, el) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
  document.getElementById('page-' + pageId)?.classList.add('active');
  if (el) el.classList.add('active');

  const titles = {
    dashboard: '📊 Dashboard',
    perhitungan: '🧮 Hitung SAW',
    hasil: '🏆 Hasil Peringkat',
    siswa: '👥 Data Siswa',
    kriteria: '⚖️ Kriteria & Bobot',
    evaluasi: '🔬 Evaluasi SPK',
    ml: '🤖 Machine Learning'
  };
  document.getElementById('topbarTitle').textContent = titles[pageId] || '';

  if (pageId === 'siswa') loadSiswa();
  if (pageId === 'kriteria') loadKriteriaPage();
  if (pageId === 'hasil') loadHasil();
  if (pageId === 'dashboard') { loadStats(); loadKriteriaData(); }
  if (pageId === 'evaluasi') { /* ready, user clicks run */ }
  if (pageId === 'ml') { cekStatusML(); }
}

// ============================================================
// API CALLS
// ============================================================
async function api(params) {
  const isPost = params.method === 'POST' || params._post;
  const action = params.action;

  if (isPost) {
    const form = new FormData();
    form.append('action', action);
    if (params.data) {
      Object.entries(params.data).forEach(([k, v]) => {
        if (typeof v === 'object') {
          Object.entries(v).forEach(([k2, v2]) => form.append(`${k}[${k2}]`, v2));
        } else {
          form.append(k, v);
        }
      });
    }
    const resp = await fetch('api.php', { method: 'POST', body: form });
    return resp.json();
  } else {
    const resp = await fetch(`api.php?action=${action}`);
    return resp.json();
  }
}

// ============================================================
// STATS (DASHBOARD)
// ============================================================
async function loadStats() {
  const res = await api({ action: 'get_stats' });
  if (!res.success) return;
  const d = res.data;

  document.getElementById('statSiswa').textContent = d.total_siswa;
  document.getElementById('sidebarTotal').textContent = d.total_siswa;
  document.getElementById('statStatus').textContent = d.sudah_hitung ? 'Selesai ✓' : 'Belum';

  if (d.top_siswa) {
    document.getElementById('statTopScore').textContent = parseFloat(d.top_siswa.skor_saw).toFixed(4);
    document.getElementById('statTopNama').textContent = d.top_siswa.nama;
  }
}

async function loadKriteriaData() {
  const res = await api({ action: 'get_kriteria' });
  if (!res.success) return;
  kriteriaList = res.data;

  const wrap = document.getElementById('kriteriaSummary');
  if (!wrap) return;
  wrap.innerHTML = res.data.map(k =>
    `<div style="background:var(--bg3);border:1px solid var(--border);border-radius:8px;padding:10px 14px;min-width:120px">
      <div style="font-size:10px;color:var(--text3);margin-bottom:4px;font-family:var(--mono)">${k.kode} · ${k.jenis.toUpperCase()}</div>
      <div style="font-size:13px;font-weight:600;margin-bottom:4px">${k.nama_kriteria}</div>
      <div class="bobot-chip">${Math.round(k.bobot * 100)}%</div>
    </div>`
  ).join('');
}

// ============================================================
// HITUNG SAW
// ============================================================
async function hitungSAW() {
  showLoading('Memproses perhitungan SAW...');
  try {
    const res = await api({ action: 'hitung_saw' });
    hideLoading();

    if (!res.success) {
      toast('Gagal: ' + res.message, 'error');
      return;
    }

    toast('Perhitungan SAW berhasil! ' + res.data.total + ' siswa diurutkan.', 'success');
    tampilHasilPerhitungan(res.data);
    loadStats();
    tampilPodium(res.data.ranked);
    loadHasil();

    document.getElementById('hasilPerhitungan').style.display = 'block';
    document.getElementById('podiumCard').style.display = 'block';
  } catch (e) {
    hideLoading();
    toast('Error: ' + e.message, 'error');
  }
}

function tampilHasilPerhitungan(data) {
  document.getElementById('hasilInfo').textContent =
    `${data.total} siswa · Dihitung: ${data.tgl_hitung}`;

  const body = document.getElementById('tblNormalisasiBody');
  const kIds = kriteriaList.map(k => k.id);

  body.innerHTML = data.ranked.map((r, i) => {
    const norm = r.normalized;
    const rankClass = i === 0 ? 'rank-1' : i === 1 ? 'rank-2' : i === 2 ? 'rank-3' : 'rank-n';
    const barPct = (r.skor_saw * 100).toFixed(1);
    const barColor = r.skor_saw > 0.96 ? '#f59e0b' : r.skor_saw > 0.93 ? '#3b82f6' : '#6366f1';

    const normCells = kIds.map(kid => {
      const val = norm[kid] ?? 0;
      return `<td class="td-mono td-center">${val.toFixed(4)}</td>`;
    }).join('');

    return `<tr>
      <td><span class="rank ${rankClass}">${r.peringkat}</span></td>
      <td style="font-weight:600">${r.nama}</td>
      ${normCells}
      <td>
        <div class="score-bar-wrap">
          <div class="score-bar">
            <div class="score-bar-fill" style="width:${barPct}%;background:${barColor}"></div>
          </div>
          <span class="score-num" style="color:${barColor}">${r.skor_saw.toFixed(4)}</span>
        </div>
      </td>
    </tr>`;
  }).join('');
}

function tampilPodium(ranked) {
  const podiumCard = document.getElementById('podiumCard');
  const container = document.getElementById('podiumContainer');
  if (!ranked || ranked.length < 3) return;

  podiumCard.style.display = 'block';

  const medals = ['🥇','🥈','🥉'];
  const posClass = ['pos-1','pos-2','pos-3'];
  const heights = [60,40,28];

  // order: 2nd, 1st, 3rd
  const order = [ranked[1], ranked[0], ranked[2]];
  const orderPos = [1, 0, 2];

  container.innerHTML = order.map((r, idx) => {
    const pos = orderPos[idx];
    return `
      <div class="podium-item">
        <div class="podium-card ${posClass[pos]}">
          <div class="podium-medal">${medals[pos]}</div>
          <div class="podium-name">${r.nama}</div>
          <div class="podium-score ${posClass[pos]}">${r.skor_saw.toFixed(4)}</div>
          <div class="podium-pct">${(r.skor_saw * 100).toFixed(2)}%</div>
        </div>
        <div class="podium-bar ${posClass[pos]}" style="height:${heights[pos]}px">${pos + 1}</div>
      </div>`;
  }).join('');
}

// ============================================================
// HASIL
// ============================================================
async function loadHasil() {
  const res = await api({ action: 'get_hasil' });
  const empty = document.getElementById('hasilEmpty');
  const table = document.getElementById('hasilTable');

  if (!res.success || res.data.length === 0) {
    empty.style.display = 'block';
    table.style.display = 'none';
    return;
  }

  hasilData = res.data;
  empty.style.display = 'none';
  table.style.display = 'block';
  document.getElementById('hasilTableInfo').textContent = `${res.data.length} siswa diranking`;

  const body = document.getElementById('tblHasilBody');
  body.innerHTML = res.data.map(r => {
    const pct = (r.skor_saw * 100).toFixed(2);
    const rankNum = parseInt(r.peringkat);
    const rankClass = rankNum === 1 ? 'rank-1' : rankNum === 2 ? 'rank-2' : rankNum === 3 ? 'rank-3' : 'rank-n';
    const barColor = r.skor_saw > 0.96 ? '#f59e0b' : r.skor_saw > 0.93 ? '#3b82f6' : '#6366f1';
    let statusBadge = '';
    if (rankNum <= 3) statusBadge = `<span class="badge badge-green">🏆 Top ${rankNum}</span>`;
    else if (rankNum <= 10) statusBadge = `<span class="badge badge-blue">⭐ Top 10</span>`;
    else statusBadge = `<span class="badge" style="background:rgba(30,45,69,.8);color:var(--text3);border:1px solid var(--border)">Peringkat ${rankNum}</span>`;

    return `<tr>
      <td><span class="rank ${rankClass}">${rankNum}</span></td>
      <td style="font-weight:600">${r.nama}</td>
      <td style="color:var(--text3)">${r.kelas}</td>
      <td>
        <div class="score-bar-wrap">
          <div class="score-bar">
            <div class="score-bar-fill" style="width:${pct}%;background:${barColor}"></div>
          </div>
          <span class="score-num" style="color:${barColor}">${parseFloat(r.skor_saw).toFixed(4)}</span>
        </div>
      </td>
      <td class="td-mono">${pct}%</td>
      <td class="td-center">${statusBadge}</td>
    </tr>`;
  }).join('');

  // Update podium from existing data
  if (res.data.length >= 3) {
    tampilPodium(res.data.map(r => ({
      nama: r.nama,
      skor_saw: parseFloat(r.skor_saw),
      peringkat: parseInt(r.peringkat)
    })));
    document.getElementById('podiumCard').style.display = 'block';
  }
}

// ============================================================
// SISWA
// ============================================================
async function loadSiswa() {
  const res = await api({ action: 'get_siswa' });
  if (!res.success) return;

  const body = document.getElementById('tblSiswaBody');
  if (res.data.length === 0) {
    body.innerHTML = `<tr><td colspan="6" style="text-align:center;color:var(--text3);padding:24px">Tidak ada data siswa</td></tr>`;
    return;
  }

  body.innerHTML = res.data.map((s, i) => `
    <tr>
      <td class="td-mono" style="color:var(--text3)">${i + 1}</td>
      <td class="td-mono">${s.nisn || '–'}</td>
      <td style="font-weight:600">${s.nama}</td>
      <td>${s.kelas || '–'}</td>
      <td><span class="badge ${s.jenis_kelamin === 'P' ? 'badge-blue' : ''}" style="${s.jenis_kelamin === 'L' ? 'background:rgba(16,185,129,.1);color:var(--green);border:1px solid rgba(16,185,129,.3)' : ''}">${s.jenis_kelamin === 'P' ? 'Perempuan' : 'Laki-laki'}</span></td>
      <td>
        <div style="display:flex;gap:6px">
          <button class="btn btn-ghost btn-sm btn-icon" onclick="openModalNilai(${s.id},'${s.nama.replace(/'/g,"\\'")}')">📝 Nilai</button>
          <button class="btn btn-danger btn-sm btn-icon" onclick="hapusSiswa(${s.id},'${s.nama.replace(/'/g,"\\'")}')">🗑️</button>
        </div>
      </td>
    </tr>
  `).join('');
}

function openModalTambahSiswa() {
  document.getElementById('fNisn').value = '';
  document.getElementById('fNama').value = '';
  document.getElementById('fKelas').value = '';
  document.getElementById('fJk').value = 'P';
  openModal('modalSiswa');
}

async function simpanSiswa() {
  const nama = document.getElementById('fNama').value.trim();
  if (!nama) { toast('Nama siswa wajib diisi!', 'error'); return; }

  const res = await api({
    action: 'tambah_siswa', _post: true,
    data: {
      nama,
      nisn:  document.getElementById('fNisn').value.trim(),
      kelas: document.getElementById('fKelas').value.trim(),
      jk:    document.getElementById('fJk').value,
    }
  });

  toast(res.message, res.success ? 'success' : 'error');
  if (res.success) { closeModal('modalSiswa'); loadSiswa(); loadStats(); }
}

async function hapusSiswa(id, nama) {
  if (!confirm(`Hapus siswa "${nama}"? Data nilai juga akan terhapus.`)) return;
  const res = await api({ action: 'hapus_siswa', _post: true, data: { id } });
  toast(res.message, res.success ? 'success' : 'error');
  if (res.success) { loadSiswa(); loadStats(); }
}

// ============================================================
// NILAI
// ============================================================
async function openModalNilai(siswaId, nama) {
  currentSiswaId = siswaId;
  document.getElementById('modalNilaiTitle').textContent = `📝 Input Nilai: ${nama}`;

  const resK = await api({ action: 'get_kriteria' });
  const resN = await fetch(`api.php?action=get_nilai&siswa_id=${siswaId}`).then(r => r.json());

  const nilaiMap = {};
  if (resN.success) resN.data.forEach(n => nilaiMap[n.kriteria_id] = n.nilai);

  const container = document.getElementById('nilaiFormContainer');
  container.innerHTML = resK.data.map(k => `
    <div class="form-group">
      <label>
        <span class="bobot-chip">${k.kode}</span>
        &nbsp;${k.nama_kriteria}
        <span style="color:var(--text3);font-weight:400;margin-left:6px">(Bobot: ${Math.round(k.bobot * 100)}%)</span>
      </label>
      <input type="number" step="0.1" class="form-control"
        id="nilaiInput_${k.id}"
        value="${nilaiMap[k.id] ?? ''}"
        placeholder="Masukkan nilai ${k.kode}">
      <div class="form-hint">${k.keterangan}</div>
    </div>
  `).join('');

  openModal('modalNilai');
}

async function simpanNilai() {
  if (!currentSiswaId) return;

  const resK = await api({ action: 'get_kriteria' });
  const nilaiData = {};
  let valid = true;

  resK.data.forEach(k => {
    const el = document.getElementById('nilaiInput_' + k.id);
    const val = parseFloat(el?.value);
    if (isNaN(val) || val < 0) { valid = false; }
    nilaiData[k.id] = val || 0;
  });

  if (!valid) { toast('Pastikan semua nilai terisi dengan benar', 'error'); return; }

  const form = new FormData();
  form.append('action', 'simpan_nilai');
  form.append('siswa_id', currentSiswaId);
  Object.entries(nilaiData).forEach(([k, v]) => form.append(`nilai[${k}]`, v));

  const res = await fetch('api.php', { method: 'POST', body: form }).then(r => r.json());
  toast(res.message, res.success ? 'success' : 'error');
  if (res.success) closeModal('modalNilai');
}

// ============================================================
// KRITERIA
// ============================================================
async function loadKriteriaPage() {
  const res = await api({ action: 'get_kriteria' });
  if (!res.success) return;
  kriteriaList = res.data;

  // Bobot sliders
  const container = document.getElementById('bobotContainer');
  container.innerHTML = res.data.map(k => `
    <div class="bobot-row">
      <div>
        <div class="bobot-label">${k.kode} – ${k.nama_kriteria.split(' ').slice(0,2).join(' ')}</div>
        <div class="bobot-sub">${k.jenis.toUpperCase()}</div>
      </div>
      <input type="range" min="0" max="100" step="1"
        value="${Math.round(k.bobot * 100)}"
        id="slider_${k.id}"
        oninput="updateBobotDisplay()">
      <div class="bobot-pct" id="pct_${k.id}">${Math.round(k.bobot * 100)}%</div>
      <input type="number" min="0" max="100" step="1"
        value="${Math.round(k.bobot * 100)}"
        class="form-control" style="padding:6px 8px;font-size:12px"
        id="num_${k.id}"
        oninput="syncSlider(${k.id})">
    </div>
  `).join('');

  updateBobotDisplay();

  // Tabel kriteria
  const body = document.getElementById('tblKriteriaBody');
  body.innerHTML = res.data.map(k => `
    <tr>
      <td><span class="bobot-chip">${k.kode}</span></td>
      <td style="font-weight:600">${k.nama_kriteria}</td>
      <td><span class="badge badge-green">${k.jenis.toUpperCase()}</span></td>
      <td class="td-mono">${Math.round(k.bobot * 100)}%</td>
      <td style="color:var(--text3);font-size:12px">${k.keterangan}</td>
    </tr>
  `).join('');
}

function syncSlider(kId) {
  const num = document.getElementById('num_' + kId);
  const slider = document.getElementById('slider_' + kId);
  slider.value = num.value;
  updateBobotDisplay();
}

function updateBobotDisplay() {
  let total = 0;
  kriteriaList.forEach(k => {
    const slider = document.getElementById('slider_' + k.id);
    const num = document.getElementById('num_' + k.id);
    const pct = document.getElementById('pct_' + k.id);
    if (!slider) return;
    const val = parseInt(slider.value);
    if (num) num.value = val;
    if (pct) pct.textContent = val + '%';
    total += val;
  });

  const el = document.getElementById('bobotTotal');
  const valEl = document.getElementById('bobotTotalVal');
  if (valEl) valEl.textContent = total + '%';
  if (el) {
    el.classList.toggle('ok', total === 100);
    el.classList.toggle('err', total !== 100);
  }
}

async function simpanBobot() {
  const bobots = {};
  let total = 0;
  kriteriaList.forEach(k => {
    const val = parseInt(document.getElementById('slider_' + k.id)?.value || 0);
    bobots[k.id] = val / 100;
    total += val;
  });

  if (total !== 100) {
    toast(`Total bobot harus 100%. Saat ini: ${total}%`, 'error');
    return;
  }

  const form = new FormData();
  form.append('action', 'update_bobot');
  Object.entries(bobots).forEach(([k, v]) => form.append(`bobot[${k}]`, v));
  const res = await fetch('api.php', { method: 'POST', body: form }).then(r => r.json());
  toast(res.message, res.success ? 'success' : 'error');
  if (res.success) { loadKriteriaData(); loadKriteriaPage(); }
}

// ============================================================
// MODAL HELPERS
// ============================================================
function openModal(id) {
  document.getElementById(id)?.classList.add('open');
}
function closeModal(id) {
  document.getElementById(id)?.classList.remove('open');
}
document.querySelectorAll('.modal-overlay').forEach(overlay => {
  overlay.addEventListener('click', e => {
    if (e.target === overlay) overlay.classList.remove('open');
  });
});

// ============================================================
// LOADING
// ============================================================
function showLoading(txt = 'Memproses...') {
  document.getElementById('loadingTxt').textContent = txt;
  document.getElementById('loadingOverlay').classList.add('show');
}
function hideLoading() {
  document.getElementById('loadingOverlay').classList.remove('show');
}

// ============================================================
// TOAST
// ============================================================
function toast(msg, type = 'info') {
  const icons = { success: '✅', error: '❌', info: 'ℹ️' };
  const el = document.createElement('div');
  el.className = `toast toast-${type}`;
  el.innerHTML = `<span>${icons[type]}</span><span>${msg}</span>`;
  document.getElementById('toast-container').appendChild(el);
  setTimeout(() => el.remove(), 4000);
}

// ============================================================
// EVALUASI SPK
// ============================================================
async function jalankanEvaluasi() {
  showLoading('Menjalankan evaluasi SPK...');
  try {
    const res = await fetch('api.php?action=evaluasi');
    const data = await res.json();
    hideLoading();

    if (!data.success) {
      toast(data.data?.message || 'Evaluasi gagal. Jalankan SAW terlebih dahulu.', 'error');
      return;
    }

    toast('Evaluasi selesai!', 'success');
    document.getElementById('evalEmpty').style.display  = 'none';
    document.getElementById('evalContent').style.display = 'block';
    renderEvaluasi(data.data);
  } catch(e) {
    hideLoading();
    toast('Error: ' + e.message, 'error');
  }
}

function renderEvaluasi(d) {
  const sp  = d.spearman;
  const ak  = d.akurasi;
  const mae = d.mae;

  // ------ Interpretasi Spearman ------
  const rsVal = parseFloat(sp.rs);
  let rsLevel, rsColor, rsDesc;
  if (rsVal >= 0.90)      { rsLevel='Sangat Baik'; rsColor='var(--green)';  rsDesc='SPK sangat konsisten dengan penilaian pakar'; }
  else if (rsVal >= 0.70) { rsLevel='Cukup Baik';  rsColor='var(--gold)';   rsDesc='Konsistensi cukup, bobot dapat dikaji ulang'; }
  else                    { rsLevel='Rendah';       rsColor='var(--red)';    rsDesc='Penyimpangan signifikan, kalibrasi diperlukan'; }

  // ------ MAE Interpretasi ------
  let maeLevel, maeColor;
  if (mae <= 1.5)      { maeLevel='Sangat Presisi'; maeColor='var(--green)'; }
  else if (mae <= 3.0) { maeLevel='Cukup';          maeColor='var(--gold)'; }
  else                 { maeLevel='Perlu Kalibrasi'; maeColor='var(--red)'; }

  // ------ 4 Stat Cards ------
  document.getElementById('evalStatGrid').innerHTML = `
    <div class="stat-card">
      <div class="stat-icon" style="background:rgba(16,185,129,.15)">📐</div>
      <div>
        <div class="stat-val" style="color:${rsColor}">${rsVal.toFixed(4)}</div>
        <div class="stat-lbl">Spearman rs</div>
        <div class="stat-sub">${rsLevel}</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon" style="background:rgba(59,130,246,.15)">🎯</div>
      <div>
        <div class="stat-val" style="color:${ak.top1.pct==100?'var(--green)':'var(--red)'}">${ak.top1.pct}%</div>
        <div class="stat-lbl">Akurasi Top-1</div>
        <div class="stat-sub">Kandidat Terbaik</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon" style="background:rgba(245,158,11,.15)">⭐</div>
      <div>
        <div class="stat-val" style="color:${ak.top5.pct>=80?'var(--green)':'var(--gold)'}">${ak.top5.pct}%</div>
        <div class="stat-lbl">Akurasi Top-5</div>
        <div class="stat-sub">${ak.top5.cocok} / 5 cocok</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon" style="background:rgba(139,92,246,.15)">📏</div>
      <div>
        <div class="stat-val" style="color:${maeColor}">${mae}</div>
        <div class="stat-lbl">MAE Peringkat</div>
        <div class="stat-sub">${maeLevel}</div>
      </div>
    </div>`;

  // ------ Spearman Formula Box ------
  document.getElementById('spearmanFormula').innerHTML =
    `<span style="color:var(--text3)">Rumus :</span> rs = 1 − (6 × Σd²) / (n × (n²−1))<br>` +
    `<span style="color:var(--text3)">Substitusi :</span> rs = 1 − (6 × <strong style="color:var(--accent)">${sp.sum_d2}</strong>) / (<strong style="color:var(--accent)">${sp.n}</strong> × (${sp.n}²−1))<br>` +
    `<span style="color:var(--text3)">Hasil :</span> rs = 1 − ${(6*sp.sum_d2)} / ${sp.n*(sp.n*sp.n-1)} = <strong style="color:${rsColor};font-size:15px">${rsVal.toFixed(4)}</strong> → ${rsLevel} · ${rsDesc}`;

  // Spearman badge
  document.getElementById('spearmanBadge').innerHTML =
    `<span class="badge" style="background:rgba(16,185,129,.15);color:${rsColor};border:1px solid ${rsColor};font-size:13px;padding:4px 12px">${rsLevel} (${rsVal.toFixed(4)})</span>`;

  // ------ Tabel Spearman ------
  const tbody = document.getElementById('tblSpearman');
  tbody.innerHTML = sp.details.map(r => {
    const absD = Math.abs(r.d);
    const dColor = absD === 0 ? 'var(--green)' : absD <= 2 ? 'var(--gold)' : 'var(--red)';
    const rClass = r.rank_spk===1?'rank-1':r.rank_spk===2?'rank-2':r.rank_spk===3?'rank-3':'rank-n';
    return `<tr>
      <td><span class="rank ${rClass}">${r.rank_spk}</span></td>
      <td style="font-weight:600">${r.nama}</td>
      <td class="td-mono td-center">${r.rank_spk}</td>
      <td class="td-mono td-center">${r.rank_pakar}</td>
      <td class="td-mono td-center" style="color:${dColor};font-weight:700">${r.d > 0 ? '+'+r.d : r.d}</td>
      <td class="td-mono td-center" style="color:${r.d2===0?'var(--green)':'var(--text)'}">${r.d2}</td>
      <td>
        <div class="score-bar-wrap">
          <div class="score-bar"><div class="score-bar-fill" style="width:${(r.skor_saw*100).toFixed(1)}%;background:var(--accent)"></div></div>
          <span class="score-num">${parseFloat(r.skor_saw).toFixed(4)}</span>
        </div>
      </td>
    </tr>`;
  }).join('');

  // ------ Akurasi Grid Cards ------
  const akCards = [
    { k:'top1',  label:'Top-1', icon:'🥇' },
    { k:'top3',  label:'Top-3', icon:'🏅' },
    { k:'top5',  label:'Top-5', icon:'⭐' },
    { k:'top10', label:'Top-10',icon:'📋' },
  ];
  document.getElementById('akurasiGrid').innerHTML = akCards.map(c => {
    const item = ak[c.k];
    const pct  = parseFloat(item.pct);
    const col  = pct>=80?'var(--green)':pct>=60?'var(--gold)':'var(--red)';
    return `<div class="stat-card" style="flex-direction:column;align-items:flex-start">
      <div style="font-size:22px;margin-bottom:8px">${c.icon}</div>
      <div style="font-size:22px;font-weight:700;font-family:var(--mono);color:${col};margin-bottom:4px">${pct}%</div>
      <div style="font-size:13px;font-weight:600;margin-bottom:2px">Akurasi ${c.label}</div>
      <div style="font-size:11px;color:var(--text3)">${item.cocok} dari ${item.total} kandidat cocok</div>
      <div class="score-bar" style="width:100%;margin-top:10px">
        <div class="score-bar-fill" style="width:${pct}%;background:${col}"></div>
      </div>
    </div>`;
  }).join('');

  // ------ Tabel Akurasi Detail ------
  document.getElementById('tblAkurasi').innerHTML = akCards.map(c => {
    const item = ak[c.k];
    const pct  = parseFloat(item.pct);
    const col  = pct>=80?'var(--green)':pct>=60?'var(--gold)':'var(--red)';
    const spkList  = Array.isArray(item.spk)  ? item.spk.join(', ')  : item.spk;
    const pkrList  = Array.isArray(item.pakar) ? item.pakar.join(', '): item.pakar;
    return `<tr>
      <td style="font-weight:600">${c.icon} ${c.label}</td>
      <td style="font-size:12px;color:var(--text2)">${spkList}</td>
      <td style="font-size:12px;color:var(--text3)">${pkrList}</td>
      <td class="td-mono td-center" style="color:var(--green)">${item.cocok}/${item.total}</td>
      <td class="td-mono td-center" style="color:${col};font-weight:700">${pct}%</td>
    </tr>`;
  }).join('');

  // ------ Sensitivitas ------
  const sensCols = ['C1 Rapor','C2 TOEFL','C3 Wawancara','C4 Mot.Letter','C5 Org'];
  document.getElementById('sensitivitasGrid').innerHTML =
    '<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:14px">' +
    d.sensitivitas.map((s, si) => {
      const bobotPcts = s.bobots.map((b,i) => `<span style="font-size:10px;background:var(--bg2);padding:2px 6px;border-radius:4px;border:1px solid var(--border)">${sensCols[i].split(' ')[0]}=${Math.round(b*100)}%</span>`).join(' ');
      const top3html  = s.top3.map((t,i)=>`
        <div style="display:flex;align-items:center;gap:8px;padding:6px 0;border-bottom:1px solid rgba(30,45,69,.4)">
          <span style="font-size:14px">${['🥇','🥈','🥉'][i]}</span>
          <span style="font-size:12px;font-weight:600;flex:1">${t.nama}</span>
          <span style="font-family:var(--mono);font-size:11px;color:var(--accent)">${t.skor.toFixed(4)}</span>
        </div>`).join('');
      const isCurrent = si === 0;
      return `<div style="background:var(--card);border:1px solid ${isCurrent?'var(--accent)':'var(--border)'};border-radius:10px;padding:14px;${isCurrent?'box-shadow:0 0 0 1px var(--accent)':''}">
        <div style="font-size:11px;font-weight:700;color:${isCurrent?'var(--accent)':'var(--text3)'};margin-bottom:6px;text-transform:uppercase;letter-spacing:.05em">${isCurrent?'✅ Bobot Aktif':'Skenario '+(si)}</div>
        <div style="font-size:12px;font-weight:600;margin-bottom:8px;line-height:1.4">${s.label.split('(')[0].trim()}</div>
        <div style="display:flex;flex-wrap:wrap;gap:4px;margin-bottom:10px">${bobotPcts}</div>
        <div style="font-size:10px;font-weight:700;color:var(--text3);letter-spacing:.05em;margin-bottom:6px">TOP 3 KANDIDAT</div>
        ${top3html}
      </div>`;
    }).join('') + '</div>';

  // ------ Rekomendasi ------
  const lvlMap = {
    baik:   { bg:'rgba(16,185,129,.08)',  border:'rgba(16,185,129,.3)',  tx:'var(--green)' },
    sedang: { bg:'rgba(245,158,11,.08)',  border:'rgba(245,158,11,.3)',  tx:'var(--gold)' },
    buruk:  { bg:'rgba(239,68,68,.08)',   border:'rgba(239,68,68,.3)',   tx:'var(--red)' },
    info:   { bg:'rgba(59,130,246,.08)',  border:'rgba(59,130,246,.3)',  tx:'var(--accent)' },
  };
  document.getElementById('rekomendasiBody').innerHTML =
    '<div style="display:flex;flex-direction:column;gap:12px">' +
    d.rekomendasi.map(r => {
      const s = lvlMap[r.level] || lvlMap.info;
      return `<div style="background:${s.bg};border:1px solid ${s.border};border-radius:10px;padding:16px;display:flex;gap:14px">
        <div style="font-size:22px;flex-shrink:0">${r.icon}</div>
        <div>
          <div style="font-size:13px;font-weight:700;color:${s.tx};margin-bottom:5px">${r.judul}</div>
          <div style="font-size:13px;color:var(--text2);line-height:1.6">${r.isi}</div>
        </div>
      </div>`;
    }).join('') + '</div>';
}


// ============================================================

// ============================================================
// MACHINE LEARNING
// ============================================================
let mlServerOnline = false;
let sawRankCache   = {};

async function cekStatusML() {
  const el = document.getElementById('mlServerStatus');
  el.innerHTML = '<span>⏳</span><div>Mengecek server Flask di localhost:5000...</div>';
  el.className = 'notice notice-warn';
  try {
    const res  = await fetch('api.php?action=ml_status');
    const data = await res.json();
    mlServerOnline = data.online;
    if (data.online) {
      el.innerHTML = '<span>✅</span><div><strong>Flask API server aktif</strong> — Model ML siap digunakan di localhost:5000</div>';
      el.className = 'notice notice-success';
      loadMLModelInfo();
    } else {
      el.innerHTML = `<span>❌</span><div><strong>Server ML tidak aktif.</strong> Buka terminal → masuk folder <code style="background:rgba(0,0,0,.3);padding:1px 5px;border-radius:3px">spk_tugas8/ml</code> → jalankan: <code style="background:rgba(0,0,0,.3);padding:1px 5px;border-radius:3px">python predict_api.py</code> → klik 🔄 Cek Server lagi.</div>`;
      el.className = 'notice notice-warn';
    }
  } catch(e) {
    el.innerHTML = '<span>⚠️</span><div>Tidak dapat terhubung. Pastikan XAMPP aktif dan Flask server berjalan.</div>';
    el.className = 'notice notice-warn';
  }
}

async function loadMLModelInfo() {
  try {
    const res  = await fetch('api.php?action=ml_model_info');
    const data = await res.json();
    if (!data.success || !data.data) return;
    renderMLModelInfo(data.data);
    document.getElementById('mlModelInfo').style.display = 'block';
  } catch(e) {}
}

function renderMLModelInfo(d) {
  // ── Stat Cards ──
  document.getElementById('mlModelStats').innerHTML = `
    <div class="stat-card"><div class="stat-icon green">🎯</div><div>
      <div class="stat-val" style="color:var(--green)">${(d.akurasi*100).toFixed(1)}%</div>
      <div class="stat-lbl">Akurasi Model</div><div class="stat-sub">Test Set</div></div></div>
    <div class="stat-card"><div class="stat-icon blue">📈</div><div>
      <div class="stat-val" style="color:var(--accent)">${d.auc_score.toFixed(4)}</div>
      <div class="stat-lbl">ROC-AUC Score</div><div class="stat-sub">Mendekati 1 = terbaik</div></div></div>
    <div class="stat-card"><div class="stat-icon purple">🌲</div><div>
      <div class="stat-val">${d.n_estimators}</div>
      <div class="stat-lbl">Pohon (Trees)</div><div class="stat-sub">Random Forest</div></div></div>
    <div class="stat-card"><div class="stat-icon cyan">🔄</div><div>
      <div class="stat-val" style="color:var(--accent2)">${(d.cv_mean*100).toFixed(1)}%</div>
      <div class="stat-lbl">Cross-Val 5-Fold</div><div class="stat-sub">±${(d.cv_std*100).toFixed(1)}%</div></div></div>
    <div class="stat-card"><div class="stat-icon gold">📊</div><div>
      <div class="stat-val">${d.n_total}</div>
      <div class="stat-lbl">Data Training</div>
      <div class="stat-sub">Layak:${d.label_1_count} Tdk:${d.label_0_count}</div></div></div>`;

  // ── Feature Importance ──
  const fi      = d.feature_importance || {};
  const sorted  = Object.entries(fi).sort((a,b) => b[1]-a[1]);
  const colors  = ['#f59e0b','#3b82f6','#8b5cf6','#10b981','#06b6d4'];
  document.getElementById('mlFeatureImportance').innerHTML = sorted.map(([name,val],i) => `
    <div style="margin-bottom:10px">
      <div style="display:flex;justify-content:space-between;margin-bottom:4px">
        <span style="font-size:12px;font-weight:600">${name}</span>
        <span style="font-family:var(--mono);font-size:12px;color:${colors[i]}">${(val*100).toFixed(1)}%</span>
      </div>
      <div class="score-bar" style="height:8px">
        <div class="score-bar-fill" style="width:${(val*100).toFixed(1)}%;background:${colors[i]}"></div>
      </div>
    </div>`).join('');

  // ── Classification Report ──
  const cr = d.classification_report || {};
  document.getElementById('mlClassReport').innerHTML = `
    <table style="width:100%;font-size:12px;border-collapse:collapse">
      <thead><tr style="background:rgba(30,45,69,.8)">
        <th style="padding:7px 10px;text-align:left">Kelas</th>
        <th style="padding:7px 10px;text-align:center">Precision</th>
        <th style="padding:7px 10px;text-align:center">Recall</th>
        <th style="padding:7px 10px;text-align:center">F1-Score</th>
        <th style="padding:7px 10px;text-align:center">Support</th>
      </tr></thead>
      <tbody>
        ${['0','1'].filter(k=>cr[k]).map(k=>`<tr style="border-bottom:1px solid rgba(30,45,69,.6)">
          <td style="padding:7px 10px;font-weight:600">${k==='0'?'❌ Tidak Layak':'✅ Layak'}</td>
          <td style="padding:7px 10px;text-align:center;font-family:var(--mono)">${(cr[k].precision*100).toFixed(1)}%</td>
          <td style="padding:7px 10px;text-align:center;font-family:var(--mono)">${(cr[k].recall*100).toFixed(1)}%</td>
          <td style="padding:7px 10px;text-align:center;font-family:var(--mono)">${(cr[k].f1_score*100).toFixed(1)}%</td>
          <td style="padding:7px 10px;text-align:center;font-family:var(--mono)">${cr[k].support}</td>
        </tr>`).join('')}
      </tbody>
    </table>`;

  // ── Confusion Matrix ──
  const cm = d.confusion_matrix || [[0,0],[0,0]];
  document.getElementById('mlConfMatrix').innerHTML = `
    <div style="display:inline-grid;grid-template-columns:auto auto auto;gap:4px;font-family:var(--mono);font-size:12px">
      <div></div>
      <div style="text-align:center;color:var(--text3);padding:4px 8px">Pred 0</div>
      <div style="text-align:center;color:var(--text3);padding:4px 8px">Pred 1</div>
      <div style="color:var(--text3);padding:4px 8px;display:flex;align-items:center">Actual 0</div>
      <div style="background:rgba(16,185,129,.15);border:1px solid rgba(16,185,129,.3);border-radius:6px;padding:10px 16px;text-align:center;font-size:18px;font-weight:700;color:var(--green)">${cm[0][0]}</div>
      <div style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);border-radius:6px;padding:10px 16px;text-align:center;font-size:18px;font-weight:700;color:var(--red)">${cm[0][1]}</div>
      <div style="color:var(--text3);padding:4px 8px;display:flex;align-items:center">Actual 1</div>
      <div style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);border-radius:6px;padding:10px 16px;text-align:center;font-size:18px;font-weight:700;color:var(--red)">${cm[1][0]}</div>
      <div style="background:rgba(16,185,129,.15);border:1px solid rgba(16,185,129,.3);border-radius:6px;padding:10px 16px;text-align:center;font-size:18px;font-weight:700;color:var(--green)">${cm[1][1]}</div>
    </div>
    <div style="margin-top:10px;font-size:11px;color:var(--text3)">
      ✅ TN=${cm[0][0]} · FP=${cm[0][1]} · FN=${cm[1][0]} · TP=${cm[1][1]}
    </div>`;
}

async function jalankanPrediksiSemua() {
  if (!mlServerOnline) {
    toast('Server ML belum aktif. Klik 🔄 Cek Server terlebih dahulu.', 'error');
    return;
  }
  showLoading('Memproses prediksi ML untuk seluruh siswa...');
  try {
    // Ambil data SAW untuk perbandingan rank
    const resSAW = await fetch('api.php?action=get_hasil');
    const datSAW = await resSAW.json();
    sawRankCache  = {};
    if (datSAW.success) datSAW.data.forEach(s => {
      sawRankCache[s.nama] = { rank: parseInt(s.peringkat), skor: parseFloat(s.skor_saw) };
    });

    const res  = await fetch('api.php?action=ml_prediksi_semua');
    const data = await res.json();
    hideLoading();
    if (!data.success) { toast('Prediksi gagal: ' + (data.message||''), 'error'); return; }
    toast(`Prediksi selesai! ✅ Layak: ${data.data.layak} · ❌ Tidak: ${data.data.tidak_layak}`, 'success');
    renderMLHasil(data.data);
  } catch(e) { hideLoading(); toast('Error: '+e.message, 'error'); }
}

function renderMLHasil(d) {
  document.getElementById('mlHasilCard').style.display = 'block';
  document.getElementById('mlCountLayak').textContent  = d.layak;
  document.getElementById('mlCountTidak').textContent  = d.tidak_layak;
  document.getElementById('mlHasilInfo').textContent   =
    `${d.total} siswa diprediksi · Layak: ${d.layak} · Tidak Layak: ${d.tidak_layak}`;

  const body = document.getElementById('mlTabelHasil');
  body.innerHTML = d.hasil.map((h, i) => {
    const isLayak   = h.label === 1;
    const barColor  = h.prob_layak >= 80 ? 'var(--green)' : h.prob_layak >= 50 ? 'var(--gold)' : 'var(--red)';
    const sawInfo   = sawRankCache[h.nama];
    const sawBadge  = sawInfo
      ? `<span class="rank ${sawInfo.rank<=3?'rank-'+sawInfo.rank:'rank-n'}">${sawInfo.rank}</span>`
      : '<span style="color:var(--text3)">–</span>';
    return `<tr>
      <td class="td-mono" style="color:var(--text3)">${i+1}</td>
      <td style="font-weight:600">${h.nama}</td>
      <td class="td-center">
        <span class="badge ${isLayak?'badge-green':'badge-red'}" style="font-size:12px;padding:3px 10px">
          ${isLayak?'✅ LAYAK':'❌ TIDAK LAYAK'}
        </span>
      </td>
      <td>
        <div class="score-bar-wrap">
          <div class="score-bar"><div class="score-bar-fill" style="width:${h.prob_layak}%;background:${barColor}"></div></div>
          <span class="score-num" style="color:${barColor}">${h.prob_layak}%</span>
        </div>
      </td>
      <td class="td-mono td-center" style="color:var(--red);font-size:12px">${h.prob_tidak}%</td>
      <td class="td-center">${sawBadge}</td>
    </tr>`;
  }).join('');
}

</script>
</body>
</html>
