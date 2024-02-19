<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Ranking Recruitment</h1>
        </div>

        <?php

        // Matriks perbandingan berpasangan untuk kriteria-kriteria
        // ini ketetapan karna hasilnya dari 3 kriteria sesuai perhitungan pakar ahap
        $comparisonMatrix = array(
            array(1, 3, 5),
            array(1 / 3, 1, 3),
            array(1 / 5, 1 / 3, 1)
        );

        // Jumlah kriteria
        $n = count($comparisonMatrix);

        // Menghitung vektor eigen
        $eigenVector = array();
        for ($i = 0; $i < $n; $i++) {
            $sum = 0;
            for ($j = 0; $j < $n; $j++) {
                $sum += $comparisonMatrix[$j][$i];
            }
            $eigenVector[] = $sum;
        }

        // Normalisasi vektor eigen
        $sumEigen = array_sum($eigenVector);
        $normalizedEigenVector = array();
        foreach ($eigenVector as $eigenValue) {
            $normalizedEigenVector[] = $eigenValue / $sumEigen;
        }


        $this->db->select('*');
        $this->db->from('tbl_lamaran');
        $this->db->where('tbl_lamaran.education !=', NULL);
        $query = $this->db->get();
        $candidates = $query->result_array();

        // Bobot kriteria
        $criteriaWeights = $normalizedEigenVector;

        // Hitung nilai total untuk setiap kandidat menggunakan metode SAW
        foreach ($candidates as &$candidate) {
            $totalScore = 0;
            foreach ($criteriaWeights as $index => $weight) {
                $totalScore += $candidate["education"] * $weight;
            }
            $candidate["totalScore"] = $totalScore;
        }

        // Urutkan kandidat berdasarkan nilai total secara descending
        usort($candidates, function ($a, $b) {
            return $b["totalScore"] <=> $a["totalScore"];
        });


        ?>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>List Data Ranking Recruitment Mengunakan Metode SPK & SAW</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">
                                            <h4 class="text-white">Bobot Relatif (W)</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <table class=" table-bordered">
                                                    <thead class="text-center">
                                                        <tr class="bg-primary">
                                                            <th class="text-white">Bobot Relative AHP </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center">

                                                        <?php foreach ($normalizedEigenVector as $weight) { ?>
                                                            <tr>
                                                                <td>
                                                                    <?= $weight ?>
                                                                </td>
                                                            </tr>
                                                        <?php   } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">
                                            <h4 class="text-white">List Data Ranking Recruitment SAW</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <table class="table table-bordered">
                                                    <thead class="text-center">
                                                        <tr class="bg-primary">
                                                            <th class="text-white">Peringkat </th>
                                                            <th class="text-white">Nama Lengkap</th>
                                                            <th class="text-white">Total Score</th>
                                                            <th class="text-white">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center">
                                                        <?php foreach ($candidates as $index => $candidate) { ?>
                                                            <tr>
                                                                <td>
                                                                    <?= 'Peringkat ' . ($index + 1) ?>
                                                                </td>
                                                                <td>
                                                                    <?= $candidate["nama_lengkap"] ?>
                                                                </td>
                                                                <td>
                                                                    <?= $candidate["totalScore"] ?>
                                                                </td>
                                                                <td>
                                                                    <a href="<?= base_url('spk/kirim_interview/' . $candidate['id_lamaran']) ?>" class="btn btn-warning">Send Interview</a>
                                                                </td>
                                                            </tr>
                                                        <?php   } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>