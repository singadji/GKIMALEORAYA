@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Content Management'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                @if ($errors->any())
                <div class="alert alert-danger" style="color:#fff; font-size:10pt">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
				<form role="form" method="POST" action="" enctype="multipart/form-data">
                        @csrf
					<div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="d-flex align-items-center">
                                <h6 class="mb-0">New Menu</h6>
								<button type="submit" class="btn bg-gradient-success shadow  btn-sm ms-auto">Save</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Nama Menu</label>
                                        <input class="form-control" type="text" name="nama_menu" placeholder="mis: Menu1" @if(isset($menu)) value="{{ $menu->nama_menu }}" @else value="{{ old('nama_menu') }}" @endif required>
                                    </div>
                                </div>
                                <div class="col-md-3">
									<div class="form-group">
										<label for="exampleFormControlSelect1">Parent</label>
										<select class="form-control" name="parent" id="exampleFormControlSelect1" required>
											<option value="0" class="">Pilih</option>
											<?php 
												foreach($parent as $parent){?>
													<option value="<?=$parent->id?>" <?php if((isset($menu)) && ($menu->id_parent == $parent->id)) echo 'selected="selected"'?>><?=$parent->nama_menu?></option>
												<?php }
											?>
										</select>
									</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Link</label>
                                        <input type="text" name="link_menu" class="form-control" id="" maxlength="100" size="100" placeholder="jika file: public/files/namafile atau menu-1" @if(isset($menu)) value="{{ $menu->link_menu }}" @else value="{{ old('link_menu') }}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Posisi</label>
                                        <input type="text" name="posisi" class="form-control" id="" maxlength="100" size="100" placeholder="Posisi" @if(isset($menu)) value="{{ $menu->posisi }}" @else value="{{ old('posisi') }}" @endif required>
                                    </div>
                                </div>
								<div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Isi Menu</label>
                                        <textarea style="height: 600px" name="isi_menu" class="form-control ckeditor"> @if(isset($menu)) {{ $menu->isi_menu }} @else {{ old('isi_menu') }} @endif</textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Backgroud Header (<font style="color:red">W: 1920px, H: 690px</font>)</label>
                                        <input type="file" name="header" class="form-control" accept="image/png">
                                        <?php
                                            if(isset($menu)) {
                                                if($menu->header_img){
                                                ?>
                                                <img src="{{ asset('images/menu/'.$menu->header_img) }}" alt="" style="width:100%; max-width: 200px;">
                                            <?php
                                                }
                                            }
                                        ?> 
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Gambar</label>
                                        <input type="file" name="images" class="form-control" accept="image/gif,image/jpeg,image/jpg,image/png">
                                        <?php
                                            if(isset($menu)) {
                                                if($menu->gambar){
                                                ?>
                                                <img src="{{ asset('images/menu/'.$menu->gambar) }}" alt="" style="width:100%; max-width: 200px;">
                                            <?php
                                                }
                                            }
                                        ?> 
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Video</label>
                                        <input type="file" name="video" class="form-control" accept="video/mp4, video/mov">
                                        <?php
                                            if(isset($menu)) {
                                                if($menu->video){
                                                print($menu->video);
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">File</label>
                                        <input type="file" name="dokumen" class="form-control" accept="application/msword, application/pdf">
                                        <?php
                                            if(isset($menu)) {
                                                if($menu->dokumen){
                                                ?>
                                                <?=$menu->dokumen?>
                                            <?php
                                                }
                                            }
                                        ?> 
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Aktif</label>
                                        <div class="form-check">
                                        <label class="custom-control-label">
                                            <input class="form-check-input" type="radio" name="aktif" id="" value="Y"<?php if(isset($menu)&& $menu->publish == 'Y') echo 'checked';?>>YA
                                        </label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label">
                                            <input class="form-check-input" type="radio" name="aktif" id="" value="T" <?php if(isset($menu)&& $menu->publish == 'T') echo 'checked';?> >TIDAK
                                        </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</form>
				</div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>

@endsection
