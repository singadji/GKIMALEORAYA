<?php
    use Illuminate\Support\Facades\DB;

	use App\Models\Menu;
	
  $menu    = new Menu();
	$site_config = DB::table('identitaswebs')->first();
  $menuList = $menu->tree();
  $nav_menu  = $menu->getMenu();
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <title>{{$site_config->nama_website}}</title>

  <!-- mobile responsive meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

		<!-- Web Fonts  -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light%7CPlayfair+Display:400" rel="stylesheet" type="text/css">

  
  <link href="{{asset('assets/img/favicon.png')}}" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

  <script src="https://code.highcharts.com/highcharts.js"></script>

		<script src="https://code.highcharts.com/modules/drilldown.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		<script src="https://code.highcharts.com/modules/export-data.js"></script>
		
		<script src="https://rawgit.com/mholt/PapaParse/master/papaparse.js"></script>

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet">
  
  <link rel="stylesheet" href="{{ asset('argon/plugins/custom/datatables/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('argon/plugins/custom/datatables/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('argon/plugins/custom/datatables/select.bootstrap4.min.css') }}">

<link rel="stylesheet" href="{{ asset('argon/plugins/custom/datatables/select2.min.css') }}">

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-1XNB1JHVKD"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
  			function gtag(){dataLayer.push(arguments);}
  			gtag('js', new Date());
		 	gtag('config', 'G-1XNB1JHVKD');
		</script>


     <style>
    .form-container {
        display: flex;
        align-items: center;
        width: 100%;
    }

    #form {
        width: 100%;
    }

    .btn-sm.btn {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        width: 100%;
        text-align: left;
        padding: 10px;
    }

    .member-info {
        flex: 1;
    }

    .member-info h3, .member-info p, .member-info strong {
        margin: 0;
    }

    .highcharts-figure,
			.highcharts-data-table table {
				min-width: 310px;
				max-width: 100%;
				margin: 1em auto;
			}

			#container {
				height: 600px;
			}

			.highcharts-data-table table {
				font-family: Verdana, sans-serif;
				border-collapse: collapse;
				border: 1px solid #ebebeb;
				margin: 10px auto;
				text-align: center;
				width: 100%;
				max-width: 100%;
			}

			.highcharts-data-table caption {
				padding: 1em 0;
				font-size: 1.2em;
				color: #555;
			}

			.highcharts-data-table th {
				font-weight: 600;
				padding: 0.5em;
			}

			.highcharts-data-table td,
			.highcharts-data-table th,
			.highcharts-data-table caption {
				padding: 0.5em;
			}

			.highcharts-data-table thead tr,
			.highcharts-data-table tr:nth-child(even) {
				background: #f8f8f8;
			}

			.highcharts-data-table tr:hover {
				background: #f1f7ff;
			}

			/* (A) TABLE WRAPPER */
			#DW {
			width: 100%;
			max-height: 100%;
			overflow: auto;
			}

			/* (B) STICKY HEADERS */
			#dataTable th {
			position: sticky;
			top: 0;
			z-index: 2;
      font-size:14pt;
      font-weight:bold;
			}
			#dataTable th[scope=row] {
			left: 0;
			z-index: 1;
			}

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
</style>
</head>

<body class="index-page">

  <header id="header" class="header sticky-top">

    <div class="branding">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <img src="{{ asset('assets/img/logo.png') }}" alt="">
          <!-- <h1 class="sitename">Eterna<br></h1> -->
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <?php //if (!function_exists('createTreeView')) {
										function createTreeView($array, $currentParent, $currLevel = 0, $prevLevel = -1) {
											foreach ($array as $menuId => $menu) {
											//echo $currentParent;
										if ($currentParent == $menu['id_parent']) {
											//if ($currLevel > $prevLevel) echo "<ul>";
								//if ($currLevel == $prevLevel) echo " </li> ";
											if($menu['isi_menu']==''){
								}
											$target='';
												if($menu['dokumen'] !='') $target='_blank';
																											
								if ($menu['link_menu']=='#'){?>
												<li class="dropdown"> <a class="" href="#"><span>{{ Str::words($menu['nama_menu']) }}</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
											<?php }
											else{?>
												<li> <a class="" href="{{ asset($menu['link_menu']) }}">{{ Str::words($menu['nama_menu']) }} </a>
											<?php } 
								if ($currLevel <> $prevLevel) { $prevLevel = $currLevel; }
								$currLevel++; 
											echo '<ul class="">';
									createTreeView ($array, $menuId, $currLevel, $prevLevel);		
								echo '</ul>';
								$currLevel--;              
											}  
							}
							//if ($currLevel == $prevLevel) echo " </li>";
							} 
            //}
							$arrayMenu = array();
							foreach($nav_menu as $menua){
								$arrayMenu[$menua->id_menu] = array("id_menu" => $menua->id_menu, "id_parent" => $menua->id_parent, "nama_menu" => $menua->nama_menu, "link_menu" => $menua->link_menu, "isi_menu" => $menua->isi_menu, "dokumen" => $menua->dokumen); 
							}
							createTreeView($arrayMenu, 0);
						?>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

      </div>

    </div>

  </header>

  <main class="main">

  @yield('halaman')

  </main>

  <footer id="footer" class="footer position-relative dark-background">

    <div class="container footer-top">
      <div class="row gy-4">
      <div class="col-lg-4 col-md-4 footer-links">
        
      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Gereja Kristen Indonesia Maleo Raya, Bintaro</strong> <span>All Rights Reserved</span></p>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

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


<script>
$(document).ready(function() {
    var table = $('#dataTable').DataTable({
        responsive: true,
        fixedHeader: true,
        lengthMenu: [ [50, 100, -1], [50, 100, "All"] ],
        lengthChange: false,
        searching: false,
        pageLength: 50,
        language: {  
            paginate: {  
                previous: "←",
                next: "→",
            }  
        },
    });
});
</script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>