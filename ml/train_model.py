"""
train_model.py — Training Model Machine Learning SPK Student Exchange
======================================================================
Tujuan   : Melatih Random Forest Classifier untuk memprediksi apakah
           seorang siswa LAYAK (1) atau TIDAK LAYAK (0) direkomendasikan
           mengikuti program pertukaran pelajar, berdasarkan 5 kriteria SAW.

Kriteria : C1=Nilai Rapor, C2=Skor TOEFL, C3=Nilai Wawancara,
           C4=Motivation Letter, C5=Org/Prestasi

Output   : model_siswa.pkl  — model terlatih
           scaler_siswa.pkl — StandardScaler terlatih
           hasil_evaluasi_ml.json — metadata evaluasi untuk dibaca PHP
"""

import pandas as pd
import numpy as np
import json
import joblib

from sklearn.model_selection   import train_test_split, cross_val_score
from sklearn.ensemble          import RandomForestClassifier
from sklearn.metrics           import (accuracy_score, classification_report,
                                       confusion_matrix, roc_auc_score)
from sklearn.preprocessing     import StandardScaler

# ============================================================
# 1. LOAD DATASET
# ============================================================
print("=" * 60)
print("  SPK STUDENT EXCHANGE — TRAINING MODEL RANDOM FOREST")
print("=" * 60)

data = pd.read_csv("data_siswa_training.csv")

print(f"\n[1] Dataset dimuat: {len(data)} baris")
print(f"    Label 1 (Layak)     : {data['label'].sum()} siswa")
print(f"    Label 0 (Tdk Layak) : {(data['label']==0).sum()} siswa")

# ============================================================
# 2. PISAHKAN FITUR (X) DAN LABEL (y)
# ============================================================
fitur_kolom = ['nilai_rapor','skor_toefl','nilai_wawancara',
               'motivation_letter','org_prestasi']
X = data[fitur_kolom]
y = data['label']

print(f"\n[2] Fitur yang digunakan ({len(fitur_kolom)}):")
for i, f in enumerate(fitur_kolom, 1):
    print(f"    C{i}: {f} — min={X[f].min()}, max={X[f].max()}, mean={X[f].mean():.2f}")

# ============================================================
# 3. SCALING (StandardScaler)
# ============================================================
# Nilai rapor (80–93) vs TOEFL (465–580) beda skala besar
# → StandardScaler menyamakan skala agar model tidak bias
# Rumus: z = (x - mean) / std
scaler   = StandardScaler()
X_scaled = scaler.fit_transform(X)

print(f"\n[3] StandardScaler diterapkan")
print(f"    Mean : {[round(m,2) for m in scaler.mean_.tolist()]}")
print(f"    Std  : {[round(s,2) for s in scaler.scale_.tolist()]}")

# ============================================================
# 4. SPLIT DATA — 80% Training, 20% Testing
# ============================================================
X_train, X_test, y_train, y_test = train_test_split(
    X_scaled, y, test_size=0.2, random_state=42, stratify=y
)
print(f"\n[4] Split data: Training={len(X_train)}, Testing={len(X_test)}")

# ============================================================
# 5. TRAINING MODEL — Random Forest Classifier
# ============================================================
# Random Forest = 100 Decision Tree yang vote bersama
# Tiap pohon dilatih dengan subset data berbeda (bagging)
# Keputusan akhir = suara terbanyak dari semua pohon
model = RandomForestClassifier(
    n_estimators=100,
    max_depth=5,
    random_state=42,
    class_weight='balanced'
)
model.fit(X_train, y_train)
print(f"\n[5] Model Random Forest dilatih ({model.n_estimators} pohon)")

# ============================================================
# 6. EVALUASI MODEL
# ============================================================
y_pred      = model.predict(X_test)
y_pred_prob = model.predict_proba(X_test)[:, 1]
akurasi     = accuracy_score(y_test, y_pred)
auc_score   = roc_auc_score(y_test, y_pred_prob) if len(set(y_test)) > 1 else 1.0
cv_scores   = cross_val_score(model, X_scaled, y, cv=5, scoring='accuracy')
cm          = confusion_matrix(y_test, y_pred)
report_dict = classification_report(y_test, y_pred, output_dict=True, zero_division=0)
report_txt  = classification_report(y_test, y_pred, zero_division=0)

print(f"\n[6] ===== EVALUASI MODEL =====")
print(f"    Akurasi (Test Set)   : {akurasi*100:.1f}%")
print(f"    ROC-AUC Score        : {auc_score:.4f}")
print(f"    Cross-Val (5-fold)   : {cv_scores.mean()*100:.1f}% ± {cv_scores.std()*100:.1f}%")
print(f"\n    Confusion Matrix:")
print(f"              Pred 0   Pred 1")
print(f"    Actual 0:   {cm[0][0]:4}     {cm[0][1]:4}")
print(f"    Actual 1:   {cm[1][0]:4}     {cm[1][1]:4}")
print(f"\n    Classification Report:")
print(report_txt)

# ============================================================
# 7. FEATURE IMPORTANCE
# ============================================================
importances  = model.feature_importances_
fitur_labels = ['C1 Nilai Rapor','C2 TOEFL','C3 Wawancara',
                'C4 Motivation Letter','C5 Org/Prestasi']
print(f"[7] ===== FEATURE IMPORTANCE =====")
for i in np.argsort(importances)[::-1]:
    bar = '█' * int(importances[i] * 40)
    print(f"    {fitur_labels[i]:25} : {importances[i]:.4f}  {bar}")

# ============================================================
# 8. CONTOH PREDIKSI MANUAL
# ============================================================
print(f"\n[8] ===== CONTOH PREDIKSI =====")
contoh = pd.DataFrame([
    {'nilai_rapor':93,'skor_toefl':580,'nilai_wawancara':92,'motivation_letter':94,'org_prestasi':93},
    {'nilai_rapor':85,'skor_toefl':493,'nilai_wawancara':78,'motivation_letter':80,'org_prestasi':75},
    {'nilai_rapor':80,'skor_toefl':465,'nilai_wawancara':73,'motivation_letter':75,'org_prestasi':68},
], columns=fitur_kolom)
cs     = scaler.transform(contoh)
clabel = model.predict(cs)
cproba = model.predict_proba(cs)
for nama, lbl, proba in zip(
        ["Janeeta Khairunnisa (Rank 1)","Muhammad Akmal Fatih (Mid)","Duta Lutfi Wicaksono (Last)"],
        clabel, cproba):
    print(f"    {nama}")
    print(f"       → {'✅ LAYAK' if lbl==1 else '❌ TIDAK LAYAK'} | Prob Layak: {proba[1]*100:.1f}%")

# ============================================================
# 9. SIMPAN MODEL DAN METADATA
# ============================================================
joblib.dump(model,  'model_siswa.pkl')
joblib.dump(scaler, 'scaler_siswa.pkl')

label_report = {}
for key in ['0','1']:
    if key in report_dict:
        label_report[key] = {
            'precision': round(report_dict[key].get('precision',0), 4),
            'recall':    round(report_dict[key].get('recall',0), 4),
            'f1_score':  round(report_dict[key].get('f1-score',0), 4),
            'support':   report_dict[key].get('support',0),
        }

metadata = {
    'akurasi':       round(akurasi, 4),
    'auc_score':     round(auc_score, 4),
    'cv_mean':       round(float(cv_scores.mean()), 4),
    'cv_std':        round(float(cv_scores.std()), 4),
    'n_training':    int(len(X_train)),
    'n_testing':     int(len(X_test)),
    'n_total':       int(len(data)),
    'n_estimators':  int(model.n_estimators),
    'confusion_matrix': cm.tolist(),
    'feature_importance': {fitur_labels[i]: round(float(importances[i]),4) for i in range(len(fitur_labels))},
    'classification_report': label_report,
    'fitur_kolom':   fitur_kolom,
    'label_1_count': int(data['label'].sum()),
    'label_0_count': int((data['label']==0).sum()),
    'scaler_mean':   [round(float(m),4) for m in scaler.mean_],
    'scaler_std':    [round(float(s),4) for s in scaler.scale_],
}
with open('hasil_evaluasi_ml.json','w') as f:
    json.dump(metadata, f, indent=2)

print(f"\n[9] File berhasil disimpan:")
print(f"    ✅ model_siswa.pkl")
print(f"    ✅ scaler_siswa.pkl")
print(f"    ✅ hasil_evaluasi_ml.json")
print(f"\n{'='*60}")
print(f"  SELESAI — Akurasi: {akurasi*100:.1f}% | AUC: {auc_score:.4f}")
print(f"{'='*60}\n")
