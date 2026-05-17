<?php
class MLIntegration {

    private string $apiBase;
    private int    $timeout;
    public function __construct(
        string $base = 'http://localhost:8000',
        int $timeout = 10
    ) {
        $this->apiBase = rtrim($base, '/');
        $this->timeout = $timeout;
    }

    public function isServerOnline(): bool {

        try {

            $r = $this->get('/health');

            return ($r['status'] ?? '') === 'ok';

        } catch (Exception $e) {

            return false;
        }
    }

    public function getModelInfo(): array {

        return $this->get('/ml/model-info');
    }

    public function prediksiSemuaSiswa(): array {

        $db = getDB();

        $fieldMap = [
            'C1' => 'nilai_rapor',
            'C2' => 'skor_toefl',
            'C3' => 'nilai_wawancara',
            'C4' => 'motivation_letter',
            'C5' => 'org_prestasi'
        ];

        $siswaList = $db->query("
            SELECT id, nama
            FROM siswa
            ORDER BY nama
        ")->fetchAll();

        $batch = [];

        foreach ($siswaList as $s) {

            $stmt = $db->prepare("
                SELECT
                    k.kode,
                    ns.nilai
                FROM nilai_siswa ns
                JOIN kriteria k
                    ON k.id = ns.kriteria_id
                WHERE ns.siswa_id = ?
                ORDER BY k.urutan
            ");

            $stmt->execute([$s['id']]);

            $nilaiRows = $stmt->fetchAll();

            if (count($nilaiRows) < 5) {
                continue;
            }

            $row = [
                'nama' => $s['nama'],
                '_id'  => $s['id']
            ];

            foreach ($nilaiRows as $n) {

                $f = $fieldMap[$n['kode']] ?? null;

                if ($f) {

                    $row[$f] = (float)$n['nilai'];
                }
            }

            $batch[] = $row;
        }

        $res = $this->post('/ml/predict-batch', [
            'siswa' => $batch
        ]);

        if (!empty($res['hasil'])) {

            foreach ($res['hasil'] as $i => &$h) {

                $h['siswa_id'] = $batch[$i]['_id'] ?? null;
            }

            unset($h);
        }

        return $res;
    }

    private function get(string $ep): array {

        $url = $this->apiBase . $ep;

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => $this->timeout,
        ]);

        $body = curl_exec($ch);

        $err = curl_error($ch);

        curl_close($ch);

        if ($err) {

            throw new Exception("cURL Error: $err");
        }

        $data = json_decode($body, true);

        if ($data === null) {

            throw new Exception("Response bukan JSON valid");
        }

        return $data;
    }

    private function post(string $ep, array $payload): array {

        $url  = $this->apiBase . $ep;

        $json = json_encode($payload);

        $ch = curl_init($url);

        curl_setopt_array($ch, [

            CURLOPT_RETURNTRANSFER => true,

            CURLOPT_POST => true,

            CURLOPT_POSTFIELDS => $json,

            CURLOPT_TIMEOUT => $this->timeout,

            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($json)
            ],
        ]);

        $body = curl_exec($ch);

        $err = curl_error($ch);

        curl_close($ch);

        if ($err) {

            throw new Exception("cURL Error: $err");
        }

        $data = json_decode($body, true);

        if ($data === null) {

            throw new Exception("Response bukan JSON valid");
        }

        return $data;
    }
}