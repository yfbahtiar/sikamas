<?php
// ntalakan session
session_start();
if (!isset($_SESSION['sikamas'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    // header('Location:login.php');
    exit;
}

// include func
include_once("../function.php");

// persiapkan variabel session ambil dari login
$username = $_SESSION['username'];
$fullname = $_SESSION['fullname'];

### ini untuk user.php
if (isset($_GET['newUser'])) {
    $usernameCheck = $_GET['newUser'];
    $cekusername = mysqli_query($conn, "SELECT * FROM user WHERE username = '$usernameCheck'");
    if (mysqli_fetch_assoc($cekusername)) {
        echo "stop";
        exit;
    } else {
        echo "lanjut";
        exit;
    }
}

if (isset($_POST['submitAddUser'])) {
    $uss = trim(strtolower(htmlspecialchars($_POST['username'])));
    $fullname = trim(htmlspecialchars($_POST['fullname']));
    $role_id = $_POST['role_id'];
    $pas = $_POST['password'];
    $password = password_hash($pas, PASSWORD_DEFAULT);
    $sql = $conn->query("INSERT INTO user (username, fullname, password, role_id) VALUES ('$uss', '$fullname', '$password', '$role_id')");
    if (!$sql) {
        $_SESSION['pesan'] = 'Gagal menambahkan user.';
        echo "<script>window.location.href = 'index.php?page=user';</script>";
        exit;
    } else {
        $_SESSION['pesan'] = "$fullname Berhasil ditambahkan.";
        echo "<script>window.location.href = 'index.php?page=user';</script>";
        exit;
    }
}

if ($_GET['act'] == 'hapusUser' && !empty($_GET['username'])) {
    $username = $_GET['username'];
    $sql = $conn->query("DELETE FROM user WHERE username = '$username'");
    if (!$sql) {
        $_SESSION['pesan'] = 'Gagal menghapus user.';
        echo "<script>window.location.href = 'index.php?page=user';</script>";
        exit;
    } else {
        $_SESSION['pesan'] = 'Berhasil menghapus user.';
        echo "<script>window.location.href = 'index.php?page=user';</script>";
        exit;
    }
}

if (isset($_POST['submitEditUser'])) {
    $username = $_POST['username'];
    $fullname = trim(htmlspecialchars($_POST['fullname']));
    $role_id = $_POST['role_id'];
    $pas = $_POST['password'];
    if ($pas == '')
        $sql = $conn->query("UPDATE user SET fullname = '$fullname', role_id = '$role_id' WHERE username = '$username'");
    else {
        $password = password_hash($pas, PASSWORD_DEFAULT);
        $sql = $conn->query("UPDATE user SET fullname = '$fullname', password = '$password', role_id = '$role_id' WHERE username = '$username'");
    }
    if (!$sql) {
        $_SESSION['pesan'] = 'Gagal update user.';
        echo "<script>window.location.href = 'index.php?page=user';</script>";
        exit;
    } else {
        $_SESSION['pesan'] = 'Berhasil update user.';
        echo "<script>window.location.href = 'index.php?page=user';</script>";
        exit;
    }
}

### ini untuk profile.php
if (isset($_POST['profileChangeName'])) {
    $username = $_POST['username'];
    $fullname = trim(htmlspecialchars($_POST['fullname']));
    $sql = $conn->query("UPDATE user SET fullname = '$fullname' WHERE username = '$username'");
    if (!$sql) {
        $_SESSION['pesan'] = 'Gagal update nama.';
        echo "<script>window.location.href = 'index.php?page=profile';</script>";
        exit;
    } else {
        $_SESSION['pesan'] = 'Berhasil update nama, silahkan untuk re-login.';
        echo "<script>window.location.href = 'index.php?page=profile';</script>";
        exit;
    }
}

if (isset($_POST['profileChangePassword'])) {
    $username = $_POST['username'];
    $pas = $_POST['password'];
    $password = password_hash($pas, PASSWORD_DEFAULT);
    $sql = $conn->query("UPDATE user SET password = '$password' WHERE username = '$username'");
    if (!$sql) {
        $_SESSION['pesan'] = 'Gagal update password.';
        echo "<script>window.location.href = 'index.php?page=profile';</script>";
        exit;
    } else {
        $_SESSION['pesan'] = 'Berhasil update password, silahkan untuk re-login.';
        echo "<script>window.location.href = 'index.php?page=profile';</script>";
        exit;
    }
}

### ini untuk kegiatan.php
if (isset($_GET['newKegiatan'])) {
    $kegiatanCheck = $_GET['newKegiatan'];
    $cekTersedia = mysqli_query($conn, "SELECT * FROM kegiatan WHERE nama = '$kegiatanCheck'");
    if (mysqli_fetch_assoc($cekTersedia)) {
        echo "stop";
        exit;
    } else {
        echo "lanjut";
        exit;
    }
}

if (isset($_POST['submitAddKegiatan'])) {
    $namaKegiatan = trim(htmlspecialchars($_POST['kegiatan']));
    $sql = $conn->query("INSERT INTO kegiatan (nama) VALUES ('$namaKegiatan')");
    if (!$sql) {
        $_SESSION['pesan'] = 'Gagal menambahkan kegiatan.';
        echo "<script>window.location.href = 'index.php?page=kegiatan';</script>";
        exit;
    } else {
        $_SESSION['pesan'] = "$namaKegiatan Berhasil ditambakan.";
        echo "<script>window.location.href = 'index.php?page=kegiatan';</script>";
        exit;
    }
}

if ($_GET['act'] == 'hapusKegiatan' && !empty($_GET['idKegiatan'])) {
    $idKegiatan = $_GET['idKegiatan'];
    $sql = $conn->query("DELETE FROM kegiatan WHERE id_kegiatan = '$idKegiatan'");
    if (!$sql) {
        $_SESSION['pesan'] = 'Gagal menghapus kegiatan.';
        echo "<script>window.location.href = 'index.php?page=kegiatan';</script>";
        exit;
    } else {
        $_SESSION['pesan'] = 'Berhasil menghapus kegiatan.';
        echo "<script>window.location.href = 'index.php?page=kegiatan';</script>";
        exit;
    }
}

if (isset($_POST['submitEditKegiatan'])) {
    $kegiatan =  trim(htmlspecialchars($_POST['kegiatan']));
    $id_kegiatan = $_POST['id_kegiatan'];
    $sql = $conn->query("UPDATE kegiatan SET nama = '$kegiatan' WHERE id_kegiatan = '$id_kegiatan'");
    if (!$sql) {
        $_SESSION['pesan'] = 'Gagal update nama kegiatan.';
        echo "<script>window.location.href = 'index.php?page=kegiatan';</script>";
        exit;
    } else {
        $_SESSION['pesan'] = 'Berhasil update nama kegiatan.';
        echo "<script>window.location.href = 'index.php?page=kegiatan';</script>";
        exit;
    }
}

### ini untuk kas.php
if (isset($_POST['submitAddKas'])) {
    // print_r($_POST);
    // die;

    $kegiatan = $_POST['kegiatan'];
    $jenis = $_POST['jenis'];
    if ($jenis == 'masuk') {
        $masuk = reset_rupiah($_POST['nominal']);
        $keluar = 0;
    } elseif ($jenis == 'keluar') {
        $masuk = 0;
        $keluar = reset_rupiah($_POST['nominal']);
    }
    $tgl = $_POST['tgl'];
    $ket = trim(htmlspecialchars($_POST['ket']));
    $pj = trim(htmlspecialchars($_POST['pj']));

    if ($kegiatan == '')
        $sql = $conn->query("INSERT INTO kas (id_kegiatan, jenis, masuk, keluar, tgl, ket, pj) VALUES (NULL, '$jenis', '$masuk', '$keluar', '$tgl', '$ket', '$pj')");
    else
        $sql = $conn->query("INSERT INTO kas (id_kegiatan, jenis, masuk, keluar, tgl, ket, pj) VALUES ('$kegiatan', '$jenis', '$masuk', '$keluar', '$tgl', '$ket', '$pj')");


    if (!$sql) {
        $_SESSION['pesan'] = 'Gagal menyimpan data kas.';
        echo "<script>window.location.href = 'index.php?page=kas';</script>";
        exit;
    } else {
        $_SESSION['pesan'] = 'Berhasil menyimpan data kas.';
        echo "<script>window.location.href = 'index.php?page=kas';</script>";
        exit;
    }
}

if ($_GET['act'] == 'hapusKas' && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql = $conn->query("DELETE FROM kas WHERE id = '$id'");
    if (!$sql) {
        $_SESSION['pesan'] = 'Gagal menghapus kas.';
        echo "<script>window.location.href = 'index.php?page=kas';</script>";
        exit;
    } else {
        $_SESSION['pesan'] = 'Berhasil menghapus kas.';
        echo "<script>window.location.href = 'index.php?page=kas';</script>";
        exit;
    }
}

?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SIKAMAS - Sistem Informasi Kas Masjid">
    <meta name="author" content="Mark Otto, Jacob Thornton, Bootstrap contributors, and @menpc3o as templating admin dashboard">
    <meta name="keyword" content="sikamas, kas, masjid, kas online">
    <meta name="generator" content="Jekyll v3.8.5">

    <title>SIKAMAS ADMINISTRATOR</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/img/ico.png'); ?>" type="image/x-icon">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
    <!-- Custom styles for this template -->
    <link href="<?= base_url('assets/css/dashboard.css'); ?>" rel="stylesheet">
    <!-- dataTables -->
    <link href="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vendor/datatables/responsive.bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vendor/datatables/buttons.dataTables.min.css'); ?>" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow fixed-top py-1">
        <a class="navbar-brand px-1" href="<?= base_url(); ?>">SIKAMAS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <ul class="nav d-block d-md-none">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php?page=dashboard">
                        <span data-feather="home"></span>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=kegiatan">
                        <span data-feather="layers"></span>
                        Kegiatan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=kas">
                        <span data-feather="bar-chart-2"></span>
                        Kas
                    </a>
                </li>
                <?php if ($_SESSION['role_id'] == 1) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=user">
                            <span data-feather="users"></span>
                            User
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=profile">
                        <span data-feather="settings"></span>
                        My Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url(); ?>">
                        <span data-feather="globe"></span>
                        Versi Pengunjung
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=logout">
                        <span data-feather="log-out"></span>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
        <div class="d-none d-md-block ml-auto text-white">
            Halo, <span class="font-weight-bold"><?= $fullname; ?></span>
        </div>
    </nav>

    <!-- CONTAINER FLUID ALL PAGE -->
    <div class="container-fluid">
        <!-- ROW ALL PAGE -->
        <div class="row">
            <!-- SIDEBAR -->
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <!-- MENU LIST -->
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?= ($_GET['page'] == 'dashboard' || empty($_GET['page'])) ? 'active' : ''; ?>" href="index.php?page=dashboard">
                                <span data-feather="home"></span>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($_GET['page'] == 'kegiatan') ? 'active' : ''; ?>" href="index.php?page=kegiatan">
                                <span data-feather="layers"></span>
                                Kegiatan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($_GET['page'] == 'kas') ? 'active' : ''; ?>" href="index.php?page=kas">
                                <span data-feather="bar-chart-2"></span>
                                Kas
                            </a>
                        </li>
                        <?php if ($_SESSION['role_id'] == 1) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= ($_GET['page'] == 'user') ? 'active' : ''; ?>" href="index.php?page=user">
                                    <span data-feather="users"></span>
                                    User
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul> <!-- END OF MENU LIST -->
                    <hr> <!-- HROZONTAL RIW -->
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?= ($_GET['page'] == 'profile') ? 'active' : ''; ?>" href="index.php?page=profile">
                                <span data-feather="settings"></span>
                                My Profile
                            </a>
                        </li>
                    </ul>
                    <hr> <!-- HROZONTAL RIW -->
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>">
                                <span data-feather="globe"></span>
                                Versi Pengunjung
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=logout">
                                <span data-feather="log-out"></span>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav> <!-- END OF SIDEBAR -->

            <!-- MAIN ROLE -->
            <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4">
                <div class="my-3">
                    <?php
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                        switch ($page) {
                            case 'dashboard':
                                include "dashboard.php";
                                break;
                            case 'kegiatan':
                                include "kegiatan.php";
                                break;
                            case 'kas':
                                include "kas.php";
                                break;
                            case 'user':
                                include "user.php";
                                break;
                            case 'profile':
                                include "profile.php";
                                break;
                            case 'logout':
                                include "logout.php";
                                break;
                            default:
                                include "notfound.php";
                                break;
                        }
                    } else {
                        include "dashboard.php";
                    }
                    ?>
                </div>
            </main> <!-- END OF MAIN ROLE -->

        </div> <!-- END OF ROW -->
    </div> <!-- END OF CONTAINER-FLUID -->

    <!-- standart bootstrap -->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/popper.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <!-- feather icon -->
    <script src="<?= base_url('assets/vendor/feather/feather.min.js'); ?>"></script>
    <!-- chart -->
    <script src="<?= base_url('assets/vendor/chart.js/Chart.min.js'); ?>"></script>
    <!-- datables -->
    <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.buttons.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/datatables/buttons.print.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/datatables/buttons.html5.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/datatables/jszip.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/datatables/pdfmake.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/datatables/vfs_fonts.js"></script>
    <!-- styleRupiah -->
    <script src="<?= base_url('assets/'); ?>js/rupiah.js"></script>
    <!-- custom style -->
    <script src="<?= base_url('assets/js/dashboard.js'); ?>"></script>

    <?php if (empty($_GET['page']) || $_GET['page'] == 'dashboard') : ?>
        <script>
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';

            function number_format(number, decimals, dec_point, thousands_sep) {
                // *     example: number_format(1234.56, 2, ',', ' ');
                // *     return: '1 234,56'
                number = (number + '').replace(',', '').replace(' ', '');
                var n = !isFinite(+number) ? 0 : +number,
                    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                    s = '',
                    toFixedFix = function(n, prec) {
                        var k = Math.pow(10, prec);
                        return '' + Math.round(n * k) / k;
                    };
                // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                }
                if ((s[1] || '').length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1).join('0');
                }
                return s.join(dec);
            }


            (function() {
                'use strict'
                // Graphs
                var ctx = document.getElementById('myChart')
                // eslint-disable-next-line no-unused-vars
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [<?php foreach ($rekapBulanan as $dc) {
                                        echo '"' . monthSqlToIndo($dc['bulan']) . ' ' . $dc['tahun'] . '",';
                                    } ?>],
                        datasets: [{
                            label: "Jumlah",
                            lineTension: 0.3,
                            backgroundColor: "rgba(78, 115, 223, 0.05)",
                            borderColor: "rgba(78, 115, 223, 1)",
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointBorderColor: "rgba(78, 115, 223, 1)",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                            data: [<?php foreach ($rekapBulanan as $dc) {
                                        echo '"' . $dc['saldo'] . '",';
                                    } ?>]
                        }]
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    maxTicksLimit: 5
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    maxTicksLimit: 7,
                                    callback: function(value, index, values) {
                                        return number_format(value);
                                    }
                                },
                                gridLines: {
                                    color: "rgb(234, 236, 244)",
                                    zeroLineColor: "rgb(234, 236, 244)",
                                    drawBorder: false,
                                    borderDash: [2],
                                    zeroLineBorderDash: [2]
                                }
                            }]
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            titleMarginBottom: 10,
                            titleFontColor: '#6e707e',
                            titleFontSize: 14,
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            intersect: false,
                            mode: 'index',
                            caretPadding: 10,
                            callbacks: {
                                label: function(tooltipItem, chart) {
                                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                                }
                            }
                        }
                    }
                })
            }())
        </script>
    <?php endif; ?>

</body>

</html>