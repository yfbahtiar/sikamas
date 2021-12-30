<?php
// statistik kas
$duitKas = $conn->query("SELECT SUM(masuk) AS masuk, SUM(keluar) AS keluar, (SUM(masuk) - SUM(keluar)) AS saldo FROM kas")->fetch_assoc();
// data statistik bulanan
$rekapBulanan = $conn->query("SELECT DATE_FORMAT(kas.tgl , '%m') AS bulan, YEAR(kas.tgl) AS tahun, (SUM(kas.masuk) - SUM(kas.keluar)) AS saldo FROM kas GROUP BY MONTH(kas.tgl) ORDER BY kas.tgl ASC LIMIT 5");
?>

<?php
// <!-- session pesan jika ada -->
if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
    echo '<div id="pesan" class="alert alert-warning" style="display:none;">' . $_SESSION['pesan'] . '</div>';
}
$_SESSION['pesan'] = '';
// <!-- end of sesssion pesan -->
?>

<!-- HEADING PAGE -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <span class="d-inline">
        <span data-feather="calendar"></span>&nbsp;
        <?= day(date("N")) . ", " . date("d") . " " . month(date("n")) . " " . date("Y"); ?>
    </span>
</div> <!-- END OF HEADING PAGE -->

<canvas class="my-4 w-100" id="myChart"></canvas>

<h2>Rekap Bulanan</h2>
<div class="mt-3">
    <table class="table table-hover table-striped mt-3 dtableExportResponsive">
        <thead>
            <tr class="text-center">
                <th>#</th>
                <th>Bulan</th>
                <th>Jumlah</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $saldo = 0;
            foreach ($rekapBulanan as $k) :
                $saldo = $saldo + $k['saldo'];
            ?>
                <tr>
                    <td scope="row" class="text-center"><?= $no++; ?></td>
                    <td><?= monthSqlToIndo($k['bulan']) . ' ' . $k['tahun']; ?></td>
                    <td align="right"><?php echo number_format($k['saldo']) . ",-"; ?></td>
                    <td align="right"><?php echo number_format($saldo) . ",-"; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>