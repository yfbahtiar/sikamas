<?php
// qwery umum
$kas = $conn->query("SELECT kas.*, kegiatan.nama AS nama_kegiatan FROM kas LEFT JOIN kegiatan ON kas.id_kegiatan = kegiatan.id_kegiatan ORDER BY kas.tgl DESC");
// statistik kas
$duitKas = $conn->query("SELECT SUM(masuk) AS masuk, SUM(keluar) AS keluar, (SUM(masuk) - SUM(keluar)) AS saldo FROM kas")->fetch_assoc();
// label kegiatan
$kegiatans = $conn->query("SELECT * FROM kegiatan");
?>
<!-- HEADING PAGE -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kas</h1>
    <span class="d-inline"><span data-feather="bar-chart"></span>&nbsp;<span class="font-weight-bold"><?= 'Saldo : Rp ' . number_format($duitKas['saldo']) . ',-'; ?></span></span>
</div> <!-- END OF HEADING PAGE -->

<?php
// <!-- session pesan jika ada -->
if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
    echo '<div id="pesan" class="alert alert-warning" style="display:none;">' . $_SESSION['pesan'] . '</div>';
}
$_SESSION['pesan'] = '';
// <!-- end of sesssion pesan -->
?>

<div class="d-block d-md-flex justify-content-between mb-3">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal">
        <span data-feather="plus-circle"></span>
        Tambah Data Kas
    </button>
    <button type="button" class="btn btn-info mb-2">
        Kas Masuk <span class="badge badge-light"><?= 'Rp ' . number_format($duitKas['masuk']) . ',-'; ?></span>
    </button>
    <button type="button" class="btn btn-secondary mb-2">
        Kas Keluar <span class="badge badge-light"><?= 'Rp ' . number_format($duitKas['keluar']) . ',-'; ?></span>
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Kas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="index.php" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis">Jenis Kas</label>
                                <select name="jenis" class="form-control" id="jenisKas" required>
                                    <option value="" disabled>Pilih Opsi</option>
                                    <option value="masuk">Masuk</option>
                                    <option value="keluar">Keluar</option>
                                </select>
                            </div>
                            <div class="form-group d-none" id="kegiatanInputDiv">
                                <label for="kegiatan">Kegiatan</label>
                                <input type="text" name="kegiatan" id="kegiatan" class="form-control" list="kegiatanList">
                                <datalist id="kegiatanList">
                                    <?php foreach ($kegiatans as $k) : ?>
                                        <option value="<?= $k['id_kegiatan']; ?>"><?= $k['nama']; ?></option>
                                    <?php endforeach; ?>
                                </datalist>
                                <small class="text-danger ml-1">Ketik lalu tunggu rekomendasi muncul, jika ada.</small>
                            </div>
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input class="form-control" type="date" name="tgl" required>
                            </div>
                            <div class="form-group">
                                <label>Nominal</label>
                                <input class="form-control" name="nominal" type="text" autocomplete="off" onkeyup="convertToRupiah(this);" required>
                                <small class="text-danger ml-1">Masukkan tanpa titik.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pj">Penanggung Jawab</label>
                                <input type="text" name="pj" id="pj" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea class="form-control" rows="5" name="ket" maxlength="100"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="submitAddKas">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- tabel kegiatannya bos -->
<div class="mb-3">
    <table class="table table-hover table-striped dtableExportResponsive">
        <thead>
            <tr class="text-center">
                <th scope="col">#</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Kegiatan</th>
                <th scope="col">Masuk</th>
                <th scope="col">Keluar</th>
                <th scope="col">PJ</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($kas as $k) : ?>
                <tr class="<?= ($k['masuk']) ? 'table-success' : 'table-danger'; ?>">
                    <td scope="row" class="text-center"><?= $no++; ?></td>
                    <td>
                        <?php
                        $tgl = $k['tgl'];
                        echo date("d", strtotime($tgl)) . " " . month(date("n", strtotime($tgl))) . " " . date("Y", strtotime($tgl));
                        ?>
                    </td>
                    <td><?= $k['nama_kegiatan']; ?></td>
                    <td align="right"><?php echo number_format($k['masuk']) . ",-"; ?></td>
                    <td align="right"><?php echo number_format($k['keluar']) . ",-"; ?></td>
                    <td><?= $k['pj']; ?></td>
                    <td class="text-center">
                        <a href="index.php?act=hapusKas&id=<?= $k['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>