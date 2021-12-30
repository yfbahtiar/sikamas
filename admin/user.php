<?php
// qwery umum
$users = $conn->query("SELECT username, fullname, role_id FROM user");
// hitung jml usernay
$jml_user = ($users) ? mysqli_num_rows($users) : 0;
?>
<!-- HEADING PAGE -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">User</h1>
    <span class="d-inline"><span data-feather="users"></span>&nbsp;<span class="font-weight-bold"><?= $jml_user; ?></span></span>
</div> <!-- END OF HEADING PAGE -->

<?php
// <!-- session pesan jika ada -->
if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
    echo '<div id="pesan" class="alert alert-warning" style="display:none;">' . $_SESSION['pesan'] . '</div>';
}
$_SESSION['pesan'] = '';
// <!-- end of sesssion pesan -->
?>

<!-- form add user -->
<div class="mb-3">
    <form class="form-row align-items-center" action="index.php" method="POST">
        <div class="col-auto mb-2">
            <label class="sr-only" for="usernameAddUser">Username</label>
            <input type="text" name="username" id="usernameAddUser" class="form-control" autocomplete="off" placeholder="Username" required>
        </div>
        <div class="col-auto mb-2">
            <label class="sr-only" for="fullname">Fullname</label>
            <input type="text" name="fullname" id="fullname" class="form-control" autocomplete="off" placeholder="Fullname" required>
        </div>
        <div class="col-auto mb-2">
            <label class="sr-only" for="role_id">Role User</label>
            <select name="role_id" id="role_id" class="form-control" required>
                <option value="" disabled>Pilih Role</option>
                <option value="1">Super User</option>
                <option value="2">Admin</option>
            </select>
        </div>
        <div class="col-auto mb-2">
            <div class="input-group">
                <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                <span class="input-group-text input-group-prepend" id="showPass" style="border-top-right-radius: .25rem; border-bottom-right-radius: .25rem; border-top-left-radius: 0; border-bottom-left-radius: 0; border-left: 0; cursor: pointer;">
                    <span id="toggle">lihat</span>
                </span>
            </div>
        </div>
        <div class="col-auto mb-2">
            <button type="submit" class="btn btn-primary" name="submitAddUser" disabled>Add User</button>
        </div>
    </form>
</div>

<!-- tabel usernya bos -->
<div class="mb-3">
    <table class="table table-hover table-striped dtableExportResponsive">
        <thead>
            <tr class="text-center">
                <th scope="col">#</th>
                <th scope="col">Username</th>
                <th scope="col">Fullname</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($users as $u) : ?>
                <tr>
                    <td scope="row" class="text-center"><?= $no++; ?></td>
                    <td><?= $u['username']; ?></td>
                    <td><?= $u['fullname']; ?></td>
                    <td class="text-center">
                        <a href="" class="btn btn-sm btn-warning" data-fullname="<?= $u['fullname']; ?>" data-username="<?= $u['username']; ?>" data-roleid="<?= ($u['role_id'] == 1) ? 'Super User' : 'Admin'; ?>" id="editUser" data-toggle="modal" data-target="#editUserModal">Edit</a>
                        <a href="index.php?act=hapusUser&username=<?= $u['username']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus <?= $u['username']; ?>?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- modal edit user -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="index.php" method="POST">
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="editFullname">Fullname</label>
                        <input type="text" class="form-control" name="fullname" id="editFullname" autocomplete="off">
                    </div>
                    <div class="form-group mb-2">
                        <label for="role_id">Role User</label>
                        <select name="role_id" id="editRole_id" class="form-control" required>
                            <option value="" disabled>Pilih Role</option>
                            <option value="1">Super User</option>
                            <option value="2">Admin</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="editPassword">Password</label>
                        <input type="text" class="form-control" name="password" id="editPassword" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="username" id="editUsername">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="submitEditUser">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>