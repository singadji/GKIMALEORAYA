@php
 $usession = Auth::user()->role_id;

 if($usession == "0"){
    $mods = DB::select('select m.*, Deriv1.Count from moduls m LEFT OUTER JOIN (SELECT moduls.par, COUNT(*) AS Count from moduls GROUP BY moduls.par) Deriv1 ON m.id_modul = Deriv1.par WHERE aktif="Y"');
 }else{
    $mods = DB::table('moduls')
        ->where(function ($query) {
            $query->where('role_id', Auth::user()->role_id)
            ->orWhere('role_id', '0');
        })
        ->where('aktif', '=', 'Y')
        ->get();
 }
@endphp

<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scroll-wrapper scrollbar-inner" style="position: relative;"><div class="scrollbar-inner scroll-content" style="height: 1012px; margin-bottom: 0px; margin-right: 0px; max-height: none;">
        <div class="sidenav-header  d-flex  align-items-center">
            <a class="navbar-brand" href="{{ asset('admin/home') }}">
            <img src="{{ asset('assets/img/logo.png') }}" class="navbar-brand-img" alt="...">
            </a>
            <div class=" ml-0 ">
                <div class="sidenav-toggler d-none d-xl-block active" data-action="sidenav-unpin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="navbar-inner">
        <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="{{ asset('admin/home') }}">
            <i class="ni ni-shop text-primary"></i>
            <span class="nav-link-text">Dashboards</span>
        </a>
    </li>
    @foreach($mods as $mod)
        @if($mod->par == 0 && $mod->link_modul == '#') <!-- Top-level parent -->
            <li class="nav-item parentset">
                <a class="nav-link" href="#navbar-{{$mod->slug}}" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-{{$mod->slug}}">
                    <i class="ni ni-{{ $mod->icon }}"></i>
                    <span class="nav-link-text">{{ $mod->nama_modul }}</span>
                </a>
                <div class="collapse" id="navbar-{{$mod->slug}}">
                    <ul class="nav nav-sm flex-column">
                        @foreach($mods as $sub)
                            @if($sub->par == $mod->id_modul && $sub->link_modul == '#') <!-- Second-level parent -->
                                <li class="nav-item">
                                    <a class="nav-link" href="#navbar-{{$sub->slug}}" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-{{$sub->slug}}">
                                        <span class="sidenav-mini-icon"> {{$sub->icon}} </span>
                                        <span class="sidenav-normal"> {{$sub->nama_modul}} </span>
                                    </a>
                                    <div class="collapse" id="navbar-{{$sub->slug}}">
                                        <ul class="nav nav-sm flex-column">
                                            @foreach($mods as $child)
                                                @if($child->par == $sub->id_modul) <!-- Third-level item -->
                                                    <li class="nav-item">
                                                        <a href="{{ asset($child->folder . '/' . $child->slug) }}" class="nav-link {{ str_contains(request()->url(), $child->link_modul) ? 'active' : '' }}">
                                                            <span class="sidenav-mini-icon"> {{$child->icon}} </span>
                                                            <span class="sidenav-normal" style="margin-left:-40px"> {{$child->nama_modul}} </span>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            @elseif($sub->par == $mod->id_modul) <!-- Second-level clickable link -->
                                <li class="nav-item">
                                    <a href="{{ asset($sub->folder . '/' . $sub->slug) }}" class="nav-link {{ str_contains(request()->url(), $sub->link_modul) ? 'active' : '' }}">
                                        <span class="sidenav-mini-icon"> {{$sub->icon}} </span>
                                        <span class="sidenav-normal"> {{$sub->nama_modul}} </span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </li>
        @endif
    @endforeach
</ul>

        </div>

    </div>
    <div class="scroll-element scroll-x">
        <div class="scroll-element_outer">
            <div class="scroll-element_size"></div>
            <div class="scroll-element_track"></div>
            <div class="scroll-bar" style="width: 0px; left: 0px;"></div>
        </div>
    </div>
    <div class="scroll-element scroll-y">
            <div class="scroll-element_outer">
                <div class="scroll-element_size"></div>
                <div class="scroll-element_track"></div>
                <div class="scroll-bar" style="height: 0px;"></div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $(".nav-link.active").closest(".parentset").find("a").first().attr('aria-expanded', 'true');
        const as = $(".nav-link.active").closest(".parentset").find('.collapse').first();
        as.addClass("show");
        as.find('.collapse').first().addClass("show");

        // $(".nav-link.active").closest(".parentset").find("a").first().click();
    });
    </script>
  </nav>  