const host = window.location.origin + '/sikamas/';

$(document).ready(function () {
  // tampilkan session pesan jika ada
  setTimeout(function () {
    $("#pesan").fadeIn('slow');
  }, 200);
  setTimeout(function () {
    $("#pesan").fadeOut('slow');
  }, 5000);

  // replace feather
  (function () {
    'use strict'
    feather.replace()
  }())

  // declare dtables
  var buttonCommon = {
    init: function (dt, node, config) {
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

  // add user
  $('#usernameAddUser').keyup(function (e) {
    e.preventDefault();
    var newUSer = $('#usernameAddUser').val();
    if (newUSer != '') {
      $.ajax({
        url: 'index.php?newUser=' + newUSer,
        data: {
          newUSer: newUSer
        },
        type: 'get',
        success: function (resp) {
          if (resp == 'lanjut') {
            $('#usernameAddUser').removeClass(' is-invalid').addClass(' is-valid');
            $('button[name="submitAddUser"]').prop('disabled', false);
          } else if (resp == 'stop') {
            $('#usernameAddUser').removeClass(' is-valid').addClass(' is-invalid');
            $('button[name="submitAddUser"]').prop('disabled', true);
          }
        }
      });
    } else {
      $('#usernameAddUser').removeClass(' is-invalid').removeClass(' is-valid').addClass(' is-invalid');
      $('button[name="submitAddUser"]').prop('disabled', true);
    }
  });

  // efek buka tutup password
  $('#showPass').on('click', function (event) {
    event.preventDefault();
    if ($('#password').attr("type") == "text") {
      $('#password').attr('type', 'password');
      $('#toggle').text('lihat');
    } else if ($('#password').attr("type") == "password") {
      $('#password').attr('type', 'text');
      $('#toggle').text('tutup');
    }
  });

  // rubah value edit form jika editUser di klik
  $(document).on('click', '#editUser', function () {
    $('#editFullname').val($(this).data('fullname'));
    $('#editRole_id option:contains("' + $(this).data('roleid') + '")').text($(this).data('roleid') + ' (terakhir dipilih)').attr('selected', true);
    $('#editUsername').val($(this).data('username'));
  });

  // profile
  $('#showPassChangePassword').on('change', function (event) {
    event.preventDefault();
    if ($('#password').attr("type") == "text") {
      $('#password').attr('type', 'password');
    } else if ($('#password').attr("type") == "password") {
      $('#password').attr('type', 'text');
    }
  });


  // kegiatan
  $('#addNamaKegiatan').keyup(function (e) {
    e.preventDefault();
    var newKegiatan = $('#addNamaKegiatan').val();
    if (newKegiatan != '') {
      $.ajax({
        url: 'index.php?newKegiatan=' + newKegiatan,
        data: {
          newKegiatan: newKegiatan
        },
        type: 'get',
        success: function (resp) {
          if (resp == 'lanjut') {
            $('#addNamaKegiatan').removeClass(' is-invalid').addClass(' is-valid');
            $('button[name="submitAddKegiatan"]').prop('disabled', false);
          } else if (resp == 'stop') {
            $('#addNamaKegiatan').removeClass(' is-valid').addClass(' is-invalid');
            $('button[name="submitAddKegiatan"]').prop('disabled', true);
          }
        }
      });
    } else {
      $('#addNamaKegiatan').removeClass(' is-invalid').removeClass(' is-valid').addClass(' is-invalid');
      $('button[name="submitAddKegiatan"]').prop('disabled', true);
    }
  });

  // rubah value edit form jika editKEgiatan di klik
  $(document).on('click', '#editKegiatan', function () {
    $('#editKegiatanNama').val($(this).data('nama'));
    $('#id_kegiatan').val($(this).data('idkegiatan'));
  });

  // kas
  $('#jenisKas').change(function () {
    var selected = $('#jenisKas option:selected').text();
    switch (selected) {
      case 'Masuk':
        $('#kegiatanInputDiv').addClass('d-none').fadeOut('slow');
        break;
      case 'Keluar':
        $('#kegiatanInputDiv').removeClass('d-none').fadeIn('slow');
        break;
    }
  });

});
