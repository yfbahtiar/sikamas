<!-- HEADING PAGE -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">My Profile</h1>
</div> <!-- END OF HEADING PAGE -->

<?php
// <!-- session pesan jika ada -->
if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
    echo '<div id="pesan" class="alert alert-warning" style="display:none;">' . $_SESSION['pesan'] . '</div>';
}
$_SESSION['pesan'] = '';
// <!-- end of sesssion pesan -->
?>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card">
            <img src="<?= base_url('assets/img/profile/default.jpg'); ?>" alt="foto" class="card-img-top">
            <div class="card-body text-center">
                <h5 class="card-title"><?= $username; ?></h5>
                <hr class="my-1">
                <p class="card-text"><?= $fullname; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Ganti Nama</h5>
            </div>
            <form action="index.php" method="POST">
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="fullname">Fullname Baru</label>
                        <input type="text" name="fullname" id="fullname" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="username" value="<?= $username; ?>">
                        <button type="submit" class="btn btn-small btn-primary w-100" name="profileChangeName">Ganti Nama</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Ganti Password</h5>
            </div>
            <form action="index.php" method="POST">
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="password">Password Baru</label>
                        <input type="password" name="password" id="password" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group form-check mb-3 ml-1">
                        <input type="checkbox" class="form-check-input" id="showPassChangePassword">
                        <label class="form-check-label" for="showPassChangePassword">lihat</label>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="username" value="<?= $username; ?>">
                        <button type="submit" class="btn btn-small btn-primary w-100" name="profileChangePassword">Ganti Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>