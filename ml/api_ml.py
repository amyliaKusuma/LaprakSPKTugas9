"""
main.py — FastAPI Terintegrasi SPK Student Exchange
=====================================================
Tugas 9: Integrasi Evaluasi SPK (Tugas 7) + Machine Learning (Tugas 8)

Jalankan : uvicorn main:app --reload --port 8000
Docs     : http://localhost:8000/docs
"""

from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel, Field
from typing import List
import joblib, json, os, numpy as np
from datetime import datetime

app = FastAPI(
    title="SPK Student Exchange API — Tugas 9",
    description="Integrasi Evaluasi SPK (Tugas 7) + Machine Learning Random Forest (Tugas 8)",
    version="3.0.0",
)
app.add_middleware(CORSMiddleware, allow_origins=["*"], allow_methods=["*"], allow_headers=["*"])

BASE   = os.path.dirname(os.path.abspath(__file__))
model  = joblib.load(os.path.join(BASE, "model_siswa.pkl"))
scaler = joblib.load(os.path.join(BASE, "scaler_siswa.pkl"))
with open(os.path.join(BASE, "hasil_evaluasi_ml.json")) as f:
    eval_ml = json.load(f)

FITUR = ["nilai_rapor","skor_toefl","nilai_wawancara","motivation_letter","org_prestasi"]

GROUND_TRUTH = {
    "Janeeta Khairunnisa": 1,
    "Avina Ramadhani Dwi Saputri": 2,
    "Puan Aura Pangesti": 3,
    "Areefa Ghaida Zaher": 4,
    "Hafifah Octavia": 5,
    "Rahma Amellia Estiyanti": 6,
    "Andara Arshavinia Prasetyo": 7,
    "Fadhilla Zahra Purwadani": 8,
    "Syarifatul Ulya": 9,
    "Annisa Nur Syifa": 10,
    "Muhammad Habiburrahman Al Andalusi": 11,
    "Raffina Andini": 12,
    "Febiana Setyaningsih": 13,
    "Berliani Arifah Al Awali": 14,
    "Yuniar Rosa Salsabila": 15,
    "Alifa Fitriana Parminasari": 16,
    "Putri Rahmasari": 17,
    "Zahra Azizah Latif": 18,
    "Charista Avri Damara": 19,
    "Iqlima Shinta Maharani": 20,
    "Ensar Cindra Surya Putra": 21,
    "Anggun Cahyaning Aska": 22,
    "Suci Fadilah Rahman": 23,
    "Arga Juniar Wijaksono": 24,
    "Muhammad Aqil Mukti": 25,
    "Ulya Jihan Faizah": 26,
    "Cahaya Kali Emas": 27,
    "Muhammad Akmal Fatih": 28,
    "Aluna Gusti Ayu Kumala": 29,
    "Lisna Nur Fitri": 30,
    "Arlin Anika": 31,
    "Aprilia Nur Ainj": 32,
    "Eka Dharma Saputra": 33,
    "Anggun Putri Nurjanah": 34,
    "Ibnu Maliki": 35,
    "Duta Lutfi Wicaksono": 36,
}

class SiswaInput(BaseModel):
    nama: str = Field(..., example="Janeeta Khairunnisa")
    nilai_rapor: float = Field(..., ge=0, le=100, example=93.0)
    skor_toefl: float = Field(..., ge=0, le=990, example=580)
    nilai_wawancara: float = Field(..., ge=0, le=100, example=92)
    motivation_letter: float = Field(..., ge=0, le=100, example=94)
    org_prestasi: float = Field(..., ge=0, le=100, example=93)

class SiswaSAWInput(BaseModel):
    nama: str
    rank_spk: int
    skor_saw: float

class HasilSAWRequest(BaseModel):
    data: List[SiswaSAWInput]

class BatchRequest(BaseModel):
    siswa: List[SiswaInput]

def prediksi_satu(s: SiswaInput) -> dict:
    fitur = [s.nilai_rapor, s.skor_toefl, s.nilai_wawancara, s.motivation_letter, s.org_prestasi]
    X     = np.array(fitur).reshape(1, -1)
    Xs    = scaler.transform(X)
    label = int(model.predict(Xs)[0])
    proba = model.predict_proba(Xs)[0]
    pl    = round(float(proba[1]) * 100, 2)
    if pl >= 80:   conf = "Sangat Yakin Layak"
    elif pl >= 60: conf = "Cukup Yakin Layak"
    elif pl >= 40: conf = "Ragu-ragu"
    else:          conf = "Sangat Yakin Tidak Layak"
    return {
        "nama": s.nama, "label": label,
        "rekomendasi": "LAYAK" if label == 1 else "TIDAK LAYAK",
        "prob_layak": pl, "prob_tidak": round(float(proba[0]) * 100, 2),
        "confidence": conf,
    }

def hitung_spearman(hasil_saw: List[SiswaSAWInput]) -> dict:
    n, sum_d2, details = len(hasil_saw), 0, []
    for row in hasil_saw:
        rank_pakar = GROUND_TRUTH.get(row.nama)
        if rank_pakar is None:
            continue
        d = row.rank_spk - rank_pakar
        d2 = d * d
        sum_d2 += d2
        details.append({"nama": row.nama, "rank_spk": row.rank_spk,
                        "rank_pakar": rank_pakar, "d": d, "d2": d2, "skor_saw": row.skor_saw})
    rs = round(1 - (6 * sum_d2) / (n * (n * n - 1)), 4) if n > 1 else 0
    level = "Sangat Baik" if rs >= 0.90 else "Cukup Baik" if rs >= 0.70 else "Rendah"
    return {"rs": rs, "sum_d2": sum_d2, "n": n, "level": level, "details": details}

def hitung_akurasi(hasil_saw: List[SiswaSAWInput]) -> dict:
    nama_list = [r.nama for r in hasil_saw]
    def topk(k):
        spk   = nama_list[:k]
        pakar = [n for n, r in GROUND_TRUTH.items() if r <= k]
        cocok = len(set(spk) & set(pakar))
        return {"k": k, "pct": round(cocok/k*100, 2), "cocok": cocok, "spk": spk, "pakar": pakar}
    return {f"top{k}": topk(k) for k in [1, 3, 5, 10]}

def hitung_mae(details: list) -> float:
    if not details: return 0
    return round(sum(abs(d["d"]) for d in details) / len(details), 4)

def buat_rekomendasi(rs: float, akurasi: dict, mae: float) -> list:
    rek = []
    if rs >= 0.90:
        rek.append({"level":"baik","judul":"Korelasi Spearman Sangat Baik",
            "isi":f"Nilai rs={rs} (≥0.90) menunjukkan SPK sangat konsisten dengan penilaian pakar. Bobot tidak perlu diubah."})
    elif rs >= 0.70:
        rek.append({"level":"sedang","judul":"Korelasi Spearman Cukup Baik",
            "isi":f"Nilai rs={rs} (0.70–0.89). Pertimbangkan review bobot C3 dan C4."})
    else:
        rek.append({"level":"buruk","judul":"Korelasi Spearman Rendah",
            "isi":f"Nilai rs={rs} (<0.70). Kalibrasi ulang bobot menggunakan AHP."})

    if akurasi.get("top1",{}).get("pct") == 100:
        rek.append({"level":"baik","judul":"Akurasi Top-1 Sempurna",
            "isi":"SPK berhasil mengidentifikasi kandidat terbaik yang sama dengan pakar."})
    else:
        rek.append({"level":"sedang","judul":"Akurasi Top-1 Perlu Diperbaiki",
            "isi":"SPK memilih kandidat berbeda dari pakar untuk posisi teratas."})

    if mae <= 1.5:
        rek.append({"level":"baik","judul":f"MAE Rendah ({mae})",
            "isi":"Rata-rata selisih peringkat sangat kecil. Sistem sangat presisi."})
    elif mae <= 3.0:
        rek.append({"level":"sedang","judul":f"MAE Sedang ({mae})",
            "isi":"Lakukan validasi bobot dengan pakar untuk mempersempit gap."})
    else:
        rek.append({"level":"buruk","judul":f"MAE Tinggi ({mae})",
            "isi":"Pertimbangkan hybrid SAW+AHP dan validasi silang dengan beberapa pakar."})

    rek.append({"level":"info","judul":"Rekomendasi Pengembangan",
        "isi":"1) Tambah kriteria soft-skill. 2) Gunakan hybrid SAW+AHP. 3) Validasi ground truth setiap tahun ajaran baru."})
    return rek


@app.get("/", tags=["Info"])
def root():
    return {
        "app": "SPK Student Exchange — Tugas 9",
        "integrasi": ["Evaluasi SPK (Tugas 7)", "Machine Learning (Tugas 8)"],
        "docs": "http://localhost:8000/docs",
        "timestamp": datetime.now().isoformat(),
    }

@app.get("/health", tags=["Info"])
def health():
    return {"status": "ok", "message": "FastAPI SPK aktif di port 8000"}

# ── ML Endpoints (Tugas 8) ───────────────────────────────────
@app.get("/ml/model-info", tags=["Machine Learning"])
def ml_model_info():
    return {"success": True, "data": eval_ml}

@app.post("/ml/predict", tags=["Machine Learning"])
def ml_predict(siswa: SiswaInput):
    return {"success": True, "data": prediksi_satu(siswa)}

@app.post("/ml/predict-batch", tags=["Machine Learning"])
def ml_predict_batch(req: BatchRequest):
    hasil = [prediksi_satu(s) for s in req.siswa]
    layak = sum(1 for h in hasil if h["label"] == 1)
    return {"success": True, "total": len(hasil), "layak": layak,
            "tidak_layak": len(hasil) - layak, "hasil": hasil}

# ── Evaluasi Endpoints (Tugas 7) ─────────────────────────────
@app.post("/evaluasi/spearman", tags=["Evaluasi SPK"])
def evaluasi_spearman(req: HasilSAWRequest):
    return {"success": True, "data": hitung_spearman(req.data)}

@app.post("/evaluasi/akurasi", tags=["Evaluasi SPK"])
def evaluasi_akurasi(req: HasilSAWRequest):
    return {"success": True, "data": hitung_akurasi(req.data)}

@app.post("/evaluasi/mae", tags=["Evaluasi SPK"])
def evaluasi_mae(req: HasilSAWRequest):
    sp  = hitung_spearman(req.data)
    mae = hitung_mae(sp["details"])
    return {"success": True, "mae": mae,
            "interpretasi": "Sangat Presisi" if mae <= 1.5 else "Cukup" if mae <= 3.0 else "Perlu Kalibrasi"}

@app.post("/evaluasi/lengkap", tags=["Evaluasi SPK"])
def evaluasi_lengkap(req: HasilSAWRequest):
    sp  = hitung_spearman(req.data)
    ak  = hitung_akurasi(req.data)
    mae = hitung_mae(sp["details"])
    rek = buat_rekomendasi(sp["rs"], ak, mae)
    return {
        "success": True,
        "spearman": sp, "akurasi": ak, "mae": mae,
        "rekomendasi": rek,
        "tgl_evaluasi": datetime.now().isoformat(),
    }

# ── INTEGRASI Endpoint (Tugas 9) ─────────────────────────────
@app.post("/integrasi", tags=["Integrasi Tugas 9"])
def integrasi_penuh(req: HasilSAWRequest):
    """
    ENDPOINT UTAMA TUGAS 9
    Menggabungkan Evaluasi SPK (Spearman + Top-K + MAE)
    dan info Model ML dalam SATU response terintegrasi.
    Input: hasil SAW dari database (nama + rank_spk + skor_saw)
    """
    # Evaluasi SPK
    sp  = hitung_spearman(req.data)
    ak  = hitung_akurasi(req.data)
    mae = hitung_mae(sp["details"])
    rek = buat_rekomendasi(sp["rs"], ak, mae)

    return {
        "success": True,
        "ringkasan": {
            "total_siswa":    len(req.data),
            "spearman_rs":    sp["rs"],
            "spearman_level": sp["level"],
            "akurasi_top1":   ak["top1"]["pct"],
            "akurasi_top5":   ak["top5"]["pct"],
            "mae":            mae,
            "tgl":            datetime.now().isoformat(),
        },
        "evaluasi_spk": {
            "spearman": sp,
            "akurasi":  ak,
            "mae":      mae,
        },
        "rekomendasi": rek,
        "model_ml": {
            "akurasi_model": eval_ml["akurasi"],
            "auc_score":     eval_ml["auc_score"],
            "n_estimators":  eval_ml["n_estimators"],
            "cv_mean":       eval_ml["cv_mean"],
            "feature_importance": eval_ml["feature_importance"],
        },
    }