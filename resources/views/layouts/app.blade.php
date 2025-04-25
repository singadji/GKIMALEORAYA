<?php
  $identitas = DB::table('identitaswebs')->first();
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

.dt-custom-buttons {
    justify-content: start; /* pastikan tombol ke kiri */
}

.dataTables_filter label {
    white-space: nowrap;
}
.dataTables_length {
  display: block !important;
}
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
    <div class="modal fade" id="laporanModal" tabindex="-1" aria-labelledby="laporanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="laporanModalLabel">Masukkan Judul Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="judulLaporanInput" class="form-label">Judul Laporan</label>
                    <input type="text" class="form-control judulLaporanInput" id="judulLaporanInput" placeholder="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="btnConfirmExcel">Export Excel</button>
                <button type="button" class="btn btn-primary" id="btnConfirmCetak">Cetak</button>
            </div>
        </div>
    </div>
</div>
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
let table = $('#dataTable').DataTable({
    scrollX: false,
    autoWidth: true,
    responsive: true,
    searching: true,
    fixedHeader: true,
    dom: "<'row mb-2'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
     "<'row'<'col-sm-12'tr>>" +
     "<'row'<'col-sm-6'i><'col-sm-6'p>>",
    buttons: [
        {
            extend: 'excel',
            title: null,
            filename: function () {
                return $('#judulLaporanInput').val() || 'Laporan';
            },
            className: 'd-none buttons-excel',
        },
        {
                extend: 'print',
                title: '',
                className: 'd-none buttons-print',
                customize: function (win) {
                    let judul = $('#judulLaporanInput').val() || 'Laporan Tanpa Judul';
                    $(win.document.body).prepend(
                        '<h2 style="text-align:center; margin-top:20px;">' + judul + '</h2>'
                    );
                }
        },
        {
            extend: 'copy',
            text: '<i class="fas fa-copy"></i> Copy',
            className: 'btn btn-warning btn-sm',
            title: ''
        },
        {
            text: '<i class="fas fa-file-excel"></i> Export Excel',
            className: 'btn btn-success btn-sm',
            action: function () {
                $('#judulLaporanInput').val('');
                $('#btnConfirmCetak').hide();
                $('#btnConfirmExcel').show();
                $('#laporanModal').modal('show');
            }
        },
        {
            text: '<i class="fas fa-print"></i> Cetak',
            className: 'btn btn-primary btn-sm',
            action: function () {
                $('#judulLaporanInput').val('');
                $('#btnConfirmExcel').hide();
                $('#btnConfirmCetak').show();
                $('#laporanModal').modal('show');
            }
        }
    ],
    lengthMenu: [[10, 50, 100, -1], [10, 50, 100, "Semua"]],
    pageLength: 10,
    language: {
        lengthMenu: "Tampilkan _MENU_ data per halaman",
        zeroRecords: "Tidak ada data ditemukan",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
        infoFiltered: "(disaring dari total _MAX_ data)",
        search: "Cari:",
        paginate: {
            previous: "←",
            next: "→"
        },
        emptyTable: "Data tidak ada."
    }
});

$('#btnConfirmExcel').on('click', function () {
    $('#laporanModal').modal('hide');
    table.button('.buttons-excel').trigger();
});

$('#btnConfirmCetak').on('click', function () {
    $('#laporanModal').modal('hide');
    table.button('.buttons-print').trigger();
});

</script>
<script>
$(document).ready(function () {
    const table = $('.dataTableMin').DataTable({
        paging: false,
        searching: false,
        info: false,
        autoWidth: true,
        responsive: true,
        scrollX: false,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: null,
                filename: () => $('#judulLaporanInput').val() || 'Laporan',
                className: 'd-none buttons-excel',
            },
            {
                text: '<i class="fas fa-file-excel"></i> Export Excel',
                className: 'btn btn-success btn-sm',
                action: function () {
                    $('#judulLaporanInput').val('');
                    $('#btnConfirmCetak').hide();
                    $('#btnConfirmExcel').show();
                    $('#laporanModal').modal('show');
                }
            }
        ]
    });

    // Saat klik konfirmasi modal
    $('#btnConfirmExcel').on('click', function () {
        $('#laporanModal').modal('hide');
        table.button('.buttons-excel').trigger();
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputs = document.querySelectorAll('.tanggal-terformat');

        inputs.forEach(function (input) {
            const defaultValue = input.dataset.default;

            input.addEventListener('focus', function () {
                this.type = 'date';
                this.value = defaultValue || '';
            });

            input.addEventListener('blur', function () {
                if (this.value) {
                    const tanggal = new Date(this.value);
                    if (!isNaN(tanggal.getTime())) {
                        const options = { day: 'numeric', month: 'long', year: 'numeric' };
                        const formatted = tanggal.toLocaleDateString('id-ID', options);
                        this.dataset.default = this.value;
                        this.type = 'text';
                        this.value = formatted;
                    }
                } else {
                    // Kembalikan ke nilai awal jika tidak memilih tanggal baru
                    if (defaultValue) {
                        const tanggal = new Date(defaultValue);
                        const options = { day: 'numeric', month: 'long', year: 'numeric' };
                        const formatted = tanggal.toLocaleDateString('id-ID', options);
                        this.type = 'text';
                        this.value = formatted;
                    } else {
                        this.type = 'text';
                        this.value = '';
                    }
                }
            });
        });
    });
</script>
</body>
</html>