<?php
session_start();
if (isset($_SESSION['sikamas'])) {
    echo "<script>window.location.href = 'index.php?page=dashboard';</script>";
    // header('location:user.php');
}
include_once('../function.php');
if (isset($_POST['submit'])) {
    $uss = trim(htmlspecialchars($_POST['username']));
    $pas = $_POST["password"];
    $cekuser = $conn->query("SELECT * FROM user WHERE username = '$uss'");
    if (mysqli_num_rows($cekuser) === 1) {
        $row = mysqli_fetch_assoc($cekuser);
        if (password_verify($pas, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['role_id'] = $row['role_id'];
            $_SESSION['sikamas'] = true;
            $_SESSION['pesan'] = 'Selamat datang ' . $_SESSION['fullname'];
            //echo "<script>window.location.href = 'login.php';</script>";
            if (isset($_GET['rdr'])) {
                $rdr = $_GET['rdr'];
                echo "<script>window.location.href = '" . urldecode($rdr) . "';</script>";
                // header('location:' . urldecode($_GET['rdr']));
                exit;
            } else {
                echo "<script>window.location.href = 'index.php?page=dashboard';</script>";
                // header('location: index.php?page=dashboard');
                exit;
            }
        }
    }
    $_SESSION['pesan'] = 'Username / Password salah';
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="Login page to admin SIKAMAS">
    <meta name="keywords" content="admin, sikamas, kas, masjid, kas online">
    <meta name="author" content="@menpc3o">
    <!-- icon -->
    <link rel="icon" href="<?= base_url('assets/img/ico.png'); ?>" type="image/x-icon">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f0f0f0;
        }

        .body-form {
            width: 100%;
            max-width: 400px;
            padding: 15px;
            margin: auto;
        }
    </style>
</head>

<body>
    <form class="body-form" method="post">
        <h3 class="mb-4 font-weight-normal text-center">Halaman Login</h3>
        <?php
        if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
            echo '<div id="pesan" class="alert alert-warning" style="display:none;">' . $_SESSION['pesan'] . '</div>';
        }
        $_SESSION['pesan'] = '';
        ?>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" autocomplete="off" autofocus required>
        </div>
        <div class="form-group mb-2">
            <label for="password" class="w-100">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="form-group form-check mb-3 ml-1">
            <input type="checkbox" class="form-check-input" id="showPass">
            <label class="form-check-label" for="showPass">Tampilkan Password</label>
        </div>
        <button type="submit" class="btn btn-primary btn-block btn-user" name="submit">Login</button>
    </form>

    <!-- standart bootstrap -->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/popper.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $("#pesan").fadeIn('slow');
            }, 200);
            setTimeout(function() {
                $("#pesan").fadeOut('slow');
            }, 5000);
            $('form').submit(function() {
                $('button[type="submit"]').addClass('disabled').html(`<div class="spinner-border spinner-border-sm text-light" role="status"><span class="sr-only">Loading...</span></div>`);
            });
            $('#showPass').on('change', function(event) {
                event.preventDefault();
                if ($('#password').attr("type") == "text") {
                    $('#password').attr('type', 'password');
                } else if ($('#password').attr("type") == "password") {
                    $('#password').attr('type', 'text');
                }
            });
        });
    </script>
</body>

</html>