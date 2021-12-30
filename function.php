<?php

// mematikan semua error reporting
error_reporting(0);

// set locale time
date_default_timezone_set('Asia/Jakarta');

// koneksi db
$conn = mysqli_connect("localhost", "root", "", "sikamas") or die("gagal konek db:(");

// base url
function base_url($link = null)
{
    $url = 'http://localhost/sikamas/';
    if ($link != null) {
        $toUrl = $url . $link;
        return $toUrl;
    } else {
        return $url;
    }
}

// reset rupiah to int
function reset_rupiah($rupiah)
{
    $pecah = explode('.', $rupiah);
    $return        = implode('', $pecah);
    return  $return;
}

// fungsi tammpil bulan indo
function month($month, $format = "mmmm")
{
    if ($format == "mmmm") {
        $fm = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    } elseif ($format == "mmm") {
        $fm = array("Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des");
    }

    return $fm[$month - 1];
}

// fungsi tammpil hari indo
function day($day, $format = "dddd")
{
    if ($format == "dddd") {
        $fd = array("Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu", "Minggu");
    } elseif ($format == "ddd") {
        $fd = array("Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min");
    }

    return $fd[$day - 1];
}

function monthSqlToIndo($month)
{
    // $toArr = str_replace("0", "", $month);
    $toArr = ltrim($month, '0');;
    $fm = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    return $fm[$toArr - 1];
}

// Outputnya : Februari
// month(2);

// Outputnya : Feb
// month(2, 'mmm');

// Outputnya : 16 Mei 2018
// date("d") . " " . month(date("n")) . " " . date("Y");

// Outputnya : Rabu, 16 Mei 2018
// day(date("N")) . ", " . date("d") . " " . month(date("n")) . " " . date("Y");

// Outputnya : Rab, 16 Mei 2018
// day(date("N"), 'ddd') . ", " . date("d") . " " . month(date("n")) . " " . date("Y");

// $tanggal = "2018-04-01"; // Set tanggal 1 April 2018

//TANGGAL 01-04-2018 (Format Full)
// date("d", strtotime($tanggal)) . " " . month(date("n", strtotime($tanggal))) . " " . date("Y", strtotime($tanggal));

// TANGGAL 01-04-2018 (Format Singkatan)
//date("d", strtotime($tanggal)) . " " . month(date("n", strtotime($tanggal)), 'mmm') . " " . date("Y", strtotime($tanggal));
