<div class="col-md-12">
    @if (Session::has('success'))
    <div class="alert alert-success alert-dismissible text-white" role="alert">
        <span>{{ Session::get('success') }}</span>
        <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> -->
    </div>
    @endif

    @if (Session::has('failed'))
    <div class="alert alert-danger alert-dismissible text-white" role="alert">
        <strong>Oops, terjadi kesalahan. </strong>
        <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> -->
        <span>{{ Session::get('failed') }}</span>
    </div>
    @endif

    @if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible text-white" role="alert">
        <span>{{ Session::get('error') }}</span>
        <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> -->
    </div>
    @endif

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            setInterval(destroyAlert, 7000);

            function destroyAlert() {
                $('.alert-dismissible').fadeOut(500);
            }
        });
    </script>
</div>