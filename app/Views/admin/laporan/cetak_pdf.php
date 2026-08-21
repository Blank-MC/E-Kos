<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= esc($title); ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <style>
        body {
            font-family: sans-serif;
            padding: 30px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="header">
        <h2 class="fw-bold mb-1"><?= esc($pengaturan['nama_kos'] ?? 'E-KOS'); ?></h2>
        <p class="mb-1"><?= esc($pengaturan['alamat'] ?? 'Alamat Kos'); ?> | Telp: <?= esc($pengaturan['no_telp'] ?? '-'); ?></p>
        <h4 class="fw-bold mt-3">LAPORAN PENDAPATAN KOS</h4>
    </div>

    <div class="mb-3 text-end no-print">
        <button onclick="window.print()" class="btn btn-primary btn-sm">Cetak / Simpan PDF</button>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th class="text-center" style="width: 50px;">No</th>
                <th>Periode</th>
                <th>Penghuni</th>
                <th>Kamar</th>
                <th class="text-end">Jumlah</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $total = 0;
            foreach ($pendapatan as $p) :
                $total += $p['jumlah'];
            ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td><?= esc($p['periode_bulan']); ?></td>
                    <td><?= esc($p['nama_penghuni'] ?? '-'); ?></td>
                    <td><?= esc($p['nama_kamar'] ?? '-'); ?></td>
                    <td class="text-end fw-bold">Rp <?= number_format($p['jumlah'], 0, ',', '.'); ?></td>
                    <td class="text-center">LUNAS</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="table-secondary fw-bold">
                <td colspan="4" class="text-end">TOTAL PENDAPATAN</td>
                <td colspan="2" class="text-start text-success fs-5">Rp <?= number_format($total, 0, ',', '.'); ?></td>
            </tr>
        </tfoot>
    </table>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>