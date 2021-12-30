<?php
session_start();
include_once("function.php");
// statistik kas
$duitKas = $conn->query("SELECT SUM(masuk) AS masuk, SUM(keluar) AS keluar, (SUM(masuk) - SUM(keluar)) AS saldo FROM kas")->fetch_assoc();
// data statistik bulanan
$rekapBulanan = $conn->query("SELECT DATE_FORMAT(kas.tgl , '%m') AS bulan, YEAR(kas.tgl) AS tahun, (SUM(kas.masuk) - SUM(kas.keluar)) AS saldo FROM kas GROUP BY MONTH(kas.tgl) ORDER BY kas.tgl ASC LIMIT 5");
$danaKegiatan = $conn->query("SELECT SUM(kas.keluar) AS dana, kegiatan.nama FROM kas JOIN kegiatan ON kas.id_kegiatan = kegiatan.id_kegiatan GROUP BY kas.id_kegiatan");
$kas = $conn->query("SELECT kas.*, kegiatan.nama AS nama_kegiatan FROM kas LEFT JOIN kegiatan ON kas.id_kegiatan = kegiatan.id_kegiatan ORDER BY kas.tgl DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SIKAMAS</title>
  <meta content="SIKAMAS, Sistem Informasi Kas Masjid" name="description">
  <meta content="sikamas, kas, masjid, kas online" name="keywords">

  <!-- Favicons -->
  <link href="<?= base_url('assets/img/ico.png'); ?>" rel="icon">
  <link href="<?= base_url('assets/img/apple-touch-icon.png'); ?>" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url(''); ?>assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="<?= base_url(''); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url(''); ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url(''); ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?= base_url(''); ?>assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<?= base_url(''); ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?= base_url(''); ?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= base_url(''); ?>assets/css/style.css" rel="stylesheet">

  <!-- dataTables -->
  <link href="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/datatables/responsive.bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/datatables/buttons.dataTables.min.css'); ?>" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="<?= base_url(); ?>">SIKAMAS</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar ml-auto">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#rekap">Rekap Bulanan</a></li>
          <li><a class="nav-link scrollto" href="#kegiatan">Kegiatan</a></li>
          <li><a class="nav-link scrollto" href="#saldo">Saldo</a></li>
          <li><a class="nav-link scrollto" href="#laporan">Laporan Kas</a></li>
          <li><a class="nav-link scrollto" href="#contact">Kontak</a></li>
          <li><a class="getstarted scrollto" href="<?= base_url('admin/'); ?>"><?= (isset($_SESSION['sikamas'])) ? '<i class="bi bi-house-door"></i>&nbsp;Dashboard' : '<i class="bi bi-box-arrow-in-right"></i>&nbsp;Login'; ?></a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
          <h1>Selamat Datang</h1>
          <h2>di Sistem Informasi Kas Masjid</h2>
          <div class="d-flex justify-content-center justify-content-lg-start">
            <a href="#rekap" class="btn-get-started scrollto">Get Started</a>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
          <img src="assets/img/hero-img.png" class="img-fluid animated" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= rekap bulanan Section ======= -->
    <section id="rekap" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Rekap Bulanan</h2>
        </div>

        <div class="content">
          <canvas class="my-4 w-100" id="myChart"></canvas>
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
        </div>

      </div>
    </section><!-- End rekap bulanan Section -->

    <!-- ======= kegiatan Section ======= -->
    <section id="kegiatan" class="services section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Kegiatan</h2>
          <p>Berikut ini adalah data mengenai kegiatan yang didanai menggunakan kas masjid.</p>
        </div>

        <div class="row">
          <?php foreach ($danaKegiatan as $dk) : ?>
            <div class="col-xl-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
              <div class="icon-box">
                <h4><?= $dk['nama']; ?></h4>
                <p><?= 'Rp ' . number_format($dk['dana']) . ',-'; ?></p>
              </div>
            </div>
          <?php endforeach; ?>

        </div>

      </div>
    </section><!-- End kegiatan Section -->

    <!-- ======= saldo Section ======= -->
    <section id="saldo" class="cta">
      <div class="container" data-aos="zoom-in">

        <div class="row">
          <div class="col-lg-9 text-center text-lg-start">
            <h3>Saldo</h3>
            <p><?= day(date("N")) . ", " . date("d") . " " . month(date("n")) . " " . date("Y"); ?></p>
          </div>
          <div class="col-lg-3 cta-btn-container text-center">
            <span class="cta-btn align-middle"><?= 'Rp ' . number_format($duitKas['saldo']) . ',-'; ?></span>
          </div>
        </div>

      </div>
    </section><!-- End saldo Section -->

    <!-- ======= laporan kas Section ======= -->
    <section id="laporan" class="pricing">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Laporan Kas</h2>
          <p>Setiap data yang masuk ke kas, selalu terdapat PJ (Penanggung Jawab) agar memudahkan dalam koordinasi.</p>
        </div>

        <table class="table table-hover table-striped dtableExportResponsive">
          <thead>
            <tr class="text-center">
              <th scope="col">#</th>
              <th scope="col">Tanggal</th>
              <th scope="col">Kegiatan</th>
              <th scope="col">Masuk</th>
              <th scope="col">Keluar</th>
              <th scope="col">PJ</th>
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
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

      </div>
    </section><!-- End laporan kas Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Kontak</h2>
          <p>Kontak ini diberikan dalam rangka memudahkan komunikasi kepada Administrator dan takmir guna laporan infak, memberikan infak, dan lain sebagainya.</p>
        </div>

        <div class="row">

          <div class="col-lg-5 d-flex align-items-stretch">
            <div class="info">
              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Call: Pak Ahmad (Takmir)</h4>
                <p>+62 8121 23123 123</p>
              </div>
              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Call: Pak Wardi (Bendahara)</h4>
                <p>+62 8121 12121 121</p>
              </div>
              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Call: Said (Administrator)</h4>
                <p>+62 8000 00001 100</p>
              </div>
            </div>

          </div>

          <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
            <div class="info">
              <div class="address">
                <i class="bi bi-cash-coin"></i>
                <h4>Bank Syariah Indonesia</h4>
                <p class="mb-0">7000 1984 56</p>
                <p>a. n. Muhammad Said Mustofa</p>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3>SIKAMAS</h3>
            <p>
              Masjid Jami' Muslim <br>
              Sukoharjo<br>
              Indonesia <br><br>
              <strong>Phone:</strong> +62 8000 00001 100<br>
              <strong>Email:</strong> info@sikamas.net<br>
            </p>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Social Networks</h4>
            <p>Cras fermentum odio eu feugiat lide par naso tierra videa magna derita valies</p>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
              <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
              <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="container footer-bottom clearfix">
      <div class="copyright">
        &copy; Copyright <strong><span>Arsha</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


  <!-- jquery -->
  <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
  <!-- Vendor JS Files -->
  <script src="<?= base_url(); ?>assets/vendor/aos/aos.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/waypoints/noframework.waypoints.js"></script>
  <!-- Template Main JS File -->
  <script src="<?= base_url(); ?>assets/js/main.js"></script>
  <!-- chart -->
  <script src="<?= base_url('assets/vendor/chart.js/Chart.min.js'); ?>"></script>
  <!-- datables -->
  <script src="<?= base_url(); ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/datatables/dataTables.responsive.min.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/datatables/dataTables.buttons.min.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/datatables/buttons.print.min.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/datatables/buttons.html5.min.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/datatables/jszip.min.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/datatables/pdfmake.min.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/datatables/vfs_fonts.js"></script>

  <script>
    // declare dtables
    var buttonCommon = {
      init: function(dt, node, config) {
        var table = dt.table().context[0].nTable;
        if (table) this.title = $(table).data('export-title')
      },
      title: ''
    };
    $.extend($.fn.dataTable.defaults, {
      "buttons": [
        $.extend(true, {}, buttonCommon, {
          extend: 'excelHtml5',
          exportOptions: {
            columns: ':visible'
          }
        }),
        $.extend(true, {}, buttonCommon, {
          extend: 'pdfHtml5',
          orientation: 'landscape',
          exportOptions: {
            columns: ':visible'
          }
        }),
        $.extend(true, {}, buttonCommon, {
          extend: 'print',
          exportOptions: {
            columns: ':visible'
          },
          orientation: 'landscape'
        })
      ]
    });

    // dtbale with export button
    $('.dtableExportResponsive').DataTable({
      dom: 'Bfrtip',
      scrollY: 300,
      paging: false,
      responsive: true,
      columnDefs: [{
        responsivePriority: 1,
        targets: 1
      }],
      language: {
        "emptyTable": "Tidak ada data yang tersedia pada tabel ini",
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ ",
        "infoEmpty": "Menampilkan 0 sampai 0 dari 0 ",
        "infoFiltered": "(disaring dari _MAX_)",
        "infoThousands": "'",
        "lengthMenu": "Tampilkan _MENU_ data",
        "loadingRecords": "Sedang memuat...",
        "processing": "Sedang memproses...",
        "search": "Cari:",
        "zeroRecords": "Tidak ditemukan data yang sesuai",
        "thousands": "'",
        "paginate": {
          "first": "Pertama",
          "last": "Terakhir",
          "next": "Lanjut",
          "previous": "Mundur"
        }
      }
    });

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

</body>

</html>