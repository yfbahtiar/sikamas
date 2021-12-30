<?php
// qwery umum
$kegiatans = $conn->query("SELECT * FROM kegiatan");
// hitung jml usernay
$jml_kegiatan = ($kegiatans) ? mysqli_num_rows($kegiatans) : 0;
?>
<!-- HEADING PAGE -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kegiatan</h1>
    <span class="d-inline"><span data-feather="activity"></span>&nbsp;<span class="font-weight-bold"><?= $jml_kegiatan; ?></span></span>
</div> <!-- END OF HEADING PAGE -->

<?php
// <!-- session pesan jika ada -->
if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
    echo '<div id="pesan" class="alert alert-warning" style="display:none;">' . $_SESSION['pesan'] . '</div>';
}
$_SESSION['pesan'] = '';
// <!-- end of sesssion pesan -->
?>

<!-- form add kegiatan -->
<div class="mb-3">
    <form class="form-row align-items-center" action="index.php" method="POST">
        <div class="col-auto mb-2">
            <label class="sr-only" for="addNamaKegiatan">Nama Kegiatan</label>
            <input type="text" name="kegiatan" id="addNamaKegiatan" class="form-control" autocomplete="off" placeholder="Nama Kegiatan" required>
        </div>
        <div class="col-auto mb-2">
            <button type="submit" class="btn btn-primary" name="submitAddKegiatan" disabled>Add Kegiatan</button>
        </div>
    </form>
</div>

<!-- tabel kegiatannya bos -->
<div class="mb-3">
    <table class="table table-hover table-striped dtableExportResponsive">
        <thead>
            <tr class="text-center">
                <th scope="col">#</th>
                <th scope="col">Kegiatan</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($kegiatans as $k) : ?>
                <tr>
                    <td scope="row" class="text-center"><?= $no++; ?></td>
                    <td><?= $k['nama']; ?></td>
                    <td class="text-center">
                        <a href="" class="btn btn-sm btn-warning" data-nama="<?= $k['nama']; ?>" data-idkegiatan="<?= $k['id_kegiatan']; ?>" id="editKegiatan" data-toggle="modal" data-target="#editKegiatanModal">Edit</a>
                        <a href="index.php?act=hapusKegiatan&idKegiatan=<?= $k['id_kegiatan']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus <?= $k['nama']; ?>?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- modal edit kegiatan -->
<div class="modal fade" id="editKegiatanModal" tabindex="-1" role="dialog" aria-labelledby="editKegiatanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKegiatanModalLabel">Edit Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="index.php" method="POST">
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="editKegiatanNama">Nama Kegiatan</label>
                        <input type="text" class="form-control" name="kegiatan" id="editKegiatanNama" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id_kegiatan" id="id_kegiatan">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="submitEditKegiatan">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>