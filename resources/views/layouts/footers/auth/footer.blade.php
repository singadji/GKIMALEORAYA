<?php
    $identitas = DB::table('identitaswebs')->first();
?>

<!-- Footer -->
<footer class="footer pt-0">
    <div class="row align-items-center justify-content-lg-between">
      <div class="col-lg-6">
        <div class="copyright text-center  text-lg-left  text-muted">
        &copy;     {{$identitas->nama_website}}, <script>
                        document.write(new Date().getFullYear())
                    </script>
          - Coded by <a href="https://www.sif.upj.ac.id/" target="_blank" rel="noopener noreferrer" href="#">SIF Universitas Pembangunan Jaya</a>.
        </div>
      </div>
      <div class="col-lg-6">
       
      </div>
    </div>
  </footer>
