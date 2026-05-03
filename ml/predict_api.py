"""
predict_api.py — Flask REST API untuk Prediksi ML SPK Student Exchange
=======================================================================
Jalankan: python predict_api.py
Server  : http://localhost:5000

Endpoint:
  GET  /health          → cek status server
  POST /predict         → prediksi 1 siswa
  POST /predict_batch   → prediksi banyak siswa sekaligus
  GET  /model_info      → info & evaluasi model
"""

from flask import Flask, request, jsonify
import joblib, json, os, numpy as np

app = Flask(__name__)

BASE_DIR    = os.path.dirname(os.path.abspath(__file__))
model       = joblib.load(os.path.join(BASE_DIR, 'model_siswa.pkl'))
scaler      = joblib.load(os.path.join(BASE_DIR, 'scaler_siswa.pkl'))
with open(os.path.join(BASE_DIR, 'hasil_evaluasi_ml.json')) as f:
    eval_data = json.load(f)

FITUR = ['nilai_rapor','skor_toefl','nilai_wawancara','motivation_letter','org_prestasi']

def ekstrak(data):
    batas = {
        'nilai_rapor':       (0, 100),
        'skor_toefl':        (0, 990),
        'nilai_wawancara':   (0, 100),
        'motivation_letter': (0, 100),
        'org_prestasi':      (0, 100),
    }
    fitur, errors = [], []
    for key, (lo, hi) in batas.items():
        val = data.get(key)
        if val is None:
            errors.append(f"'{key}' wajib diisi")
        else:
            try:
                val = float(val)
                if not (lo <= val <= hi):
                    errors.append(f"'{key}' harus {lo}–{hi}")
                fitur.append(val)
            except:
                errors.append(f"'{key}' harus angka")
    return fitur, errors

@app.route('/health')
def health():
    return jsonify({'status': 'ok', 'message': 'SPK ML API aktif'})

@app.route('/predict', methods=['POST'])
def predict():
    d = request.get_json(force=True) or {}
    fitur, errs = ekstrak(d)
    if errs:
        return jsonify({'success': False, 'errors': errs}), 400
    X  = np.array(fitur).reshape(1, -1)
    Xs = scaler.transform(X)
    lb = int(model.predict(Xs)[0])
    pr = model.predict_proba(Xs)[0]
    pl = round(float(pr[1]) * 100, 2)
    confidence = "Sangat Yakin" if pl >= 80 else "Cukup Yakin" if pl >= 60 else "Ragu-ragu" if pl >= 40 else "Sangat Yakin Tidak Layak"
    return jsonify({
        'success': True, 'nama': d.get('nama','Siswa'),
        'label': lb, 'rekomendasi': 'LAYAK' if lb == 1 else 'TIDAK LAYAK',
        'prob_layak': pl, 'prob_tidak': round(float(pr[0])*100, 2),
        'confidence': confidence, 'fitur_input': dict(zip(FITUR, fitur)),
    })

@app.route('/predict_batch', methods=['POST'])
def predict_batch():
    d    = request.get_json(force=True) or {}
    rows = d.get('siswa', [])
    if not rows:
        return jsonify({'success': False, 'error': '"siswa" wajib diisi'}), 400
    hasil, errs = [], []
    for i, s in enumerate(rows):
        fitur, e = ekstrak(s)
        if e:
            errs.append({'index': i, 'nama': s.get('nama','?'), 'errors': e})
            continue
        X  = np.array(fitur).reshape(1, -1)
        Xs = scaler.transform(X)
        lb = int(model.predict(Xs)[0])
        pr = model.predict_proba(Xs)[0]
        hasil.append({
            'nama': s.get('nama', f'Siswa-{i+1}'),
            'label': lb,
            'rekomendasi': 'LAYAK' if lb == 1 else 'TIDAK LAYAK',
            'prob_layak':  round(float(pr[1])*100, 2),
            'prob_tidak':  round(float(pr[0])*100, 2),
        })
    layak = sum(1 for h in hasil if h['label'] == 1)
    return jsonify({
        'success': True, 'total': len(hasil),
        'layak': layak, 'tidak_layak': len(hasil) - layak,
        'hasil': hasil, 'errors': errs,
    })

@app.route('/model_info')
def model_info():
    return jsonify({'success': True, 'data': eval_data})

if __name__ == '__main__':
    print("\n" + "="*50)
    print("  SPK ML API — Student Exchange SMAN 3 Malang")
    print("  http://localhost:5000")
    print("="*50 + "\n")
    app.run(host='0.0.0.0', port=5000, debug=False)
