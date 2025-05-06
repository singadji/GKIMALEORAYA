<?php
    use Illuminate\Support\Facades\DB;

	use App\Models\menu;
	
    $menu    = new menu();
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
  
  <link href="assets/img/favicon.png" rel="icon">
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

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Eterna
  * Template URL: https://bootstrapmade.com/eterna-free-multipurpose-bootstrap-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center dark-background">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:contact@example.com">contact@example.com</a></i>
          <i class="bi bi-phone d-flex align-items-center ms-4"><span>+1 5589 55488 55</span></i>
        </div>
        <div class="social-links d-none d-md-flex align-items-center">
          <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>
    </div><!-- End Top Bar -->

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
												<li class="dropdown"> <a class="" href="#"><span>{{ Str::words($menu['nama_menu']) }}</span> <i class="bi bi-chevron-down"></i></a>
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
								$arrayMenu[$menua->id] = array("id" => $menua->id, "id_parent" => $menua->id_parent, "nama_menu" => $menua->nama_menu, "link_menu" => $menua->link_menu, "isi_menu" => $menua->isi_menu, "dokumen" => $menua->dokumen); 
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
    @include('includes.footer')
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

  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>