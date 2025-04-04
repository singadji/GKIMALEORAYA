<?php
  $identitas = DB::table('identitaswebs')->first();
  //$mods = DB::select('select m.*, Deriv1.Count from moduls m LEFT OUTER JOIN (SELECT moduls.par, COUNT(*) AS Count from moduls GROUP BY moduls.par) Deriv1 ON m.id_modul = Deriv1.par WHERE aktif="Y"');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
  
  <title>
    <?php echo $identitas->nama_website ?>
</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('argon/css/nucleo.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('argon/css/all.min.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('argon/css/fontawesome.min.css') }}" type="text/css">

  <link href="{{asset('argon/css/docs-soft.css') }}" rel="stylesheet" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">

<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
<link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="{{ asset('argon/plugins/custom/datatables/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('argon/plugins/custom/datatables/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('argon/plugins/custom/datatables/select.bootstrap4.min.css') }}">

<link rel="stylesheet" href="{{ asset('argon/plugins/custom/datatables/select2.min.css') }}">

  <link id="pagestyle" href="{{ asset('argon/css/argon-dashboard.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

<style type="text/css">
.freeze-column {
            position: sticky;
            left: 0;
            z-index: 3;
        }

        .freeze-header {
            position: sticky;
            top: 0;
            z-index: 4;
        }
@keyframes chartjs-render-animation{from{opacity:.99}to{opacity:1}}.chartjs-render-monitor{animation:chartjs-render-animation 1ms}.chartjs-size-monitor,.chartjs-size-monitor-expand,.chartjs-size-monitor-shrink{position:absolute;direction:ltr;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1}.chartjs-size-monitor-expand>div{position:absolute;width:1000000px;height:1000000px;left:0;top:0}.chartjs-size-monitor-shrink>div{position:absolute;width:200%;height:200%;left:0;top:0}
</style>
</head>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>


<body class="g-sidenav-show g-sidenav-pinned">
  
  
  <!-- Sidenav -->
  @guest
    @yield('content')
    @endguest

    @auth
    @if (in_array(request()->route()->getName(), ['sign-in-static', 'sign-up-static', 'login', 'register',
    'recover-password', 'rtl', 'virtual-reality']))
    @yield('content')
    @else
    @if (!in_array(request()->route()->getName(), ['profile', 'profile-static']))
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    @elseif (in_array(request()->route()->getName(), ['profile-static', 'profile']))
    <div class="position-absolute w-100 min-height-300 top-0"
        style="background-image: url('https://cdn1-production-images-kly.akamaized.net/6i2Dz97SC2Ns3GZKN9Qvi478kfY=/1200x675/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/1706641/original/005955300_1505121617-Biji-Kopi7.jpg'); background-position-y: 50%;">
        <span class="mask bg-primary opacity-10"></span>
    </div>
    @endif
    @include('sweetalert::alert')
    @include('layouts.navbars.auth.sidenav')
    <main class="main-content border-radius-lg">
        @yield('content')
    </main>
    @include('components.fixed-plugin')
    @endif
    @endauth
  <!-- Main content -->

  </div>
    
  </div>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{asset('argon/js/argon-dashboard.js')}}"></script>
    @stack('js');

<script src="{{ asset('argon/js/ckeditor.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.body.addEventListener('click', function (e) {
            const button = e.target.closest('[data-confirm-update]');
            if (button) {
                e.preventDefault(); // Prevent the default action
                const url = button.getAttribute('href'); // Get the update URL from the link
                const message = button.getAttribute('data-confirm-update'); // Get the custom message

                Swal.fire({
                    title: 'Konfirmasi!',
                    text: message, // Use the custom message from data-confirm-update
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to the update URL if confirmed
                        window.location.href = url;
                    }
                });
            }
        });
    });      
</script>

<script>
		document.querySelectorAll('input[type-currency="IDR"]').forEach((element) => {
		element.addEventListener('keyup', function(e) {
		let cursorPostion = this.selectionStart;
			let value = parseInt(this.value.replace(/[^,\d]/g, ''));
			let originalLenght = this.value.length;
			if (isNaN(value)) {
			this.value = "";
			} else {    
			this.value = value.toLocaleString('id-ID', {
				currency: 'IDR',
				style: 'currency',
				minimumFractionDigits: 0
			});
			cursorPostion = this.value.length - originalLenght + cursorPostion;
			this.setSelectionRange(cursorPostion, cursorPostion);
			}
		});
		});
	</script>


  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{ asset('argon/plugins/custom/datatables/jquery.min.js') }}"></script>
  <script src="{{ asset('argon/plugins/custom/datatables/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('argon/plugins/custom/datatables/js.cookie.js') }}"></script>
  <script src="{{ asset('argon/plugins/custom/datatables/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ asset('argon/plugins/custom/datatables/jquery-scrollLock.min.js') }}"></script>

   <!-- Specific Page JS goes HERE  -->
  <script src="{{ asset('argon/plugins/custom/datatables/select2.min.js') }}"></script>
  <script src="{{ asset('argon/plugins/custom/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('argon/plugins/custom/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('argon/plugins/custom/datatables/dataTables.select.min.js') }}"></script>
  <script src="{{ asset('argon/plugins/custom/datatables/quill.min.js') }}"></script>

  <script src="{{ asset('argon/plugins/custom/datatables/Chart.min.js') }}"></script>
  <script src="{{ asset('argon/plugins/custom/datatables/Chart.extension.js') }}"></script>

  <script src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.print.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Argon JS -->
  <script src="https://appsrv1-147a1.kxcdn.com/argon-dashboard-pro/js/argon.js?v=1.2.0"></script><div class="backdrop d-xl-none" data-action="sidenav-unpin" data-target="undefined"></div><div style="left: -1000px; overflow: scroll; position: absolute; top: -1000px; border: none; box-sizing: content-box; height: 200px; margin: 0px; padding: 0px; width: 200px;"><div style="border: none; box-sizing: content-box; height: 200px; margin: 0px; padding: 0px; width: 200px;"></div></div>
  <!-- Demo JS - remove this in your project -->
  <script src="{{ asset('argon/plugins/custom/datatables/demo.min.js') }}"></script>

<script>
$(document).ready(function() {
    var tableElement = $('#dataTable');

    // Ambil nilai dari atribut data-excluded-columns
    var excludedColumns = tableElement.data('excluded-columns')
        ? tableElement.data('excluded-columns').split(',').map(Number)
        : []; // Jika tidak ada, gunakan array kosong

    var table = tableElement.DataTable({
        scrollX: false,
        info: true,
        autoWidth: true,
        responsive: true,
        searching: true,
        fixedHeader: true,
        //dom: '<"top"<"length-and-buttons"lB>f>rt<"bottom"ip><"clear">', // Struktur baru untuk layout
        //buttons: ['excel', 'print'],
        lengthMenu: [ [10, 50, 100, -1], [10, 50, 100, "semua"] ],
        pageLength: 10,
        language: {  
            paginate: {  
                previous: "←",
                next: "→",
            },
            emptyTable: "Data tidak ada."
        },
        orderCellsTop: true,
        initComplete: function() {
            var table = this.api();

            // Target specific columns dynamically
            table.columns().every(function(index) {
                var column = this;

                // Lewati kolom yang dikecualikan
                if (excludedColumns.includes(index)) return;

                // Pastikan baris kedua untuk filter ada
                var headerCell = $(column.header()).closest('thead').find('tr:eq(1) td').eq(index);

                 // Buat dan tambahkan dropdown
                //   var select = $('<select class="form-control form-control-sm"><option value="">All</option></select>')
                //       .appendTo(headerCell)
                //       .on('change', function() {
                //           var val = $.fn.dataTable.util.escapeRegex($(this).val());
                //           column
                //               .search(val ? '^' + val + '$' : '', true, false) // Regex filter
                //               .draw();
                //       });

                //   // Isi dropdown dengan data unik
                //   column.data().unique().sort().each(function(d) {
                //       if (d) {
                //           select.append('<option value="' + d + '">' + d + '</option>');
                //       }
                //   });
                var input = $('<input type="text" class="form-control form-control-sm" placeholder="Cari...">')
                    .appendTo(headerCell)
                    .on('keyup change clear', function() {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column
                            .search(val, true, false) // Non-strict search
                            .draw();
                });
            });
        }
    });

    // Pastikan baris kedua pada thead tersedia
    var thead = $('#dataTable thead');
    if (thead.find('tr').length < 2) {
        var secondRow = $('<tr>').appendTo(thead);
        thead.find('tr:eq(0) th').each(function() {
            secondRow.append('<td></td>');
        });
    }
});

</script>
</body>
</html>