<div class="container-fluid  mt--6">
    <div class="row">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-body">
            @if(isset($item))
            <div class="table-responsive p-4" style="overflow-x:auto; overflow-y:auto;"  id="DW">
              {!! $Hjudul !!}
                @if($detail == 'atestasi')
                    <table data-excluded-columns="0" style="line-height: 1.3; width:100%; color:#333333;" class="display table align-items-center mb-2 table-hover data-table nowrap" id="dataTable">
                          <thead>
                              <tr>
                                  <th class="text-uppercase font-weight-bolder" width="10">#</th>
                                  <th class="text-uppercase font-weight-bolder" width="30px">N I A</th>
                                  <th class="text-uppercase font-weight-bolder ps-2">Nama Jemaat</th>
                                  <th class="text-uppercase font-weight-bolder ps-2">L/P</th>
                                  <th class="text-uppercase font-weight-bolder ps-2">Alamat Domisili</th>
                                  <th class="text-uppercase font-weight-bolder ps-2">Wil.</th>
                                  <th class="text-uppercase font-weight-bolder ps-2">No. Telepon/HP</th>
                                  <th class="text-uppercase font-weight-bolder ps-2">Tanggal Atestasi</th>
                                  <th class="text-uppercase font-weight-bolder ps-2">Gereja Tujuan</th>
                                  <!-- <th class=""></th> -->
                              </tr>
                          </thead>
                          <tbody>
                              @php $no = 1; @endphp
                              @foreach($item as $item)
                                  @php
                                      $isKK = $item->kkJemaat ? true : false;
                                  @endphp
                                  <tr onclick="window.location='{{ route('administrasi.data-jemaat.show', $item->id_jemaat) }}';" style="cursor: pointer;">
                                      <td class="align-middle">{!! $no !!}</td>
                                      <td class="text-center font-weight-bold" width="30px" style="word-wrap: break-word; white-space: normal !important;">
                                          {!!  $item->nia !!}
                                      </td>
                                      <td class="align-left">
                                          {!!  $item->nama_jemaat !!}
                                          @if($item->status_aktif == "Meninggal Dunia")
                                              <sup><i class="fa fa-solid fa-cross" style="color:purple;"></i></sup>
                                          @endif
                                          @if($item->status_aktif == "Atestasi")
                                              <sup><i class="fa fa-solid fa-share" style="color:red"></i></sup>
                                          @endif
                                      </td>
                                      <td class="align-left">
                                          {!!  $item->gender !!}
                                      </td>
                                      <td class="text-left">
                                          @if($isKK)
                                              {{ $item->kkJemaat->alamat }} <!-- Alamat dari KK Jemaat -->
                                          @elseif ($item->hubunganKeluarga && $item->hubunganKeluarga->kkJemaat)
                                              {{ $item->hubunganKeluarga->kkJemaat->alamat }} <!-- Alamat dari Hubungan Keluarga -->
                                          @else
                                              Tidak Diketahui
                                          @endif
                                      </td>
                                      <td class="test-center">
                                          @if($isKK)
                                              {{ $item->kkJemaat->id_group_wilayah }} <!-- Alamat dari KK Jemaat -->
                                          @elseif ($item->hubunganKeluarga && $item->hubunganKeluarga->kkJemaat)
                                              {{ $item->hubunganKeluarga->kkJemaat->id_group_wilayah }} <!-- Alamat dari Hubungan Keluarga -->
                                          @else
                                              Tidak Diketahui
                                          @endif
                                      </td>
                                      <td class="text-center">
                                          {!!  $item->telepon !!}
                                      </td>
                                      <td class="text-left">
                                            {{ $item->atestasiJemaatKeluar?->tanggal ? \Carbon\Carbon::parse($item->atestasiJemaatKeluar->tanggal)->translatedFormat('d F Y'): 'Tidak Diketahui' }}
                                      </td>

                                        <td class="text-left">
                                            {{ $item->atestasiJemaatKeluar?->gereja ?? 'Tidak Diketahui' }}  
                                        </td>
                                  </tr>
                                  @php $no++; @endphp
                              @endforeach
                          </tbody>
                      </table>
                @else
                      <table data-excluded-columns="0" style="line-height: 1.3; width:100%; color:#333333;" class="display table align-items-center mb-2 table-hover data-table nowrap" id="dataTable">
                          <thead>
                              <tr>
                                  <th class="text-uppercase font-weight-bolder" width="10">#</th>
                                  <th class="text-uppercase font-weight-bolder" width="30px">N I A</th>
                                  <th class="text-uppercase font-weight-bolder ps-2">Nama Jemaat</th>
                                  <th class="text-uppercase font-weight-bolder ps-2">L/P</th>
                                  <th class="text-uppercase font-weight-bolder ps-2">Alamat Domisili</th>
                                  <th class="text-uppercase font-weight-bolder ps-2">Wil.</th>
                                  <th class="text-uppercase font-weight-bolder ps-2">No. Telepon/HP</th>
                                  <th class="text-uppercase font-weight-bolder ps-2">Tanggal Terdaftar</th>
                                  <!-- <th class=""></th> -->
                              </tr>
                          </thead>
                          <tbody>
                              @php $no = 1; @endphp
                              @foreach($item as $item)
                                  @php
                                      $isKK = $item->kkJemaat ? true : false;
                                  @endphp
                                  <tr onclick="window.location='{{ route('administrasi.data-jemaat.show', $item->id_jemaat) }}';" style="cursor: pointer;">
                                      <td class="align-middle">{!! $no !!}</td>
                                      <td class="text-center font-weight-bold" width="30px" style="word-wrap: break-word; white-space: normal !important;">
                                          {!!  $item->nia !!}
                                      </td>
                                      <td class="align-left">
                                          {!!  $item->nama_jemaat !!}
                                          @if($item->status_aktif == "Meninggal Dunia")
                                              <sup><i class="fa fa-solid fa-cross" style="color:purple;"></i></sup>
                                          @endif
                                          @if($item->status_aktif == "Atestasi")
                                              <sup><i class="fa fa-solid fa-share" style="color:red"></i></sup>
                                          @endif
                                      </td>
                                      <td class="align-left">
                                          {!!  $item->gender !!}
                                      </td>
                                      <td class="text-left">
                                          @if($isKK)
                                              {{ $item->kkJemaat->alamat }} <!-- Alamat dari KK Jemaat -->
                                          @elseif ($item->hubunganKeluarga && $item->hubunganKeluarga->kkJemaat)
                                              {{ $item->hubunganKeluarga->kkJemaat->alamat }} <!-- Alamat dari Hubungan Keluarga -->
                                          @else
                                              Tidak Diketahui
                                          @endif
                                      </td>
                                      <td class="align-left">
                                          @if($isKK)
                                              {{ $item->kkJemaat->id_group_wilayah }} <!-- Alamat dari KK Jemaat -->
                                          @elseif ($item->hubunganKeluarga && $item->hubunganKeluarga->kkJemaat)
                                              {{ $item->hubunganKeluarga->kkJemaat->id_group_wilayah }} <!-- Alamat dari Hubungan Keluarga -->
                                          @else
                                              Tidak Diketahui
                                          @endif
                                      </td>
                                      <td class="text-center">
                                          {!!  $item->telepon !!}
                                      </td>
                                      <td class="text-left">
                                        {{ $item->tanggal_terdaftar ? \Carbon\Carbon::parse($item->tanggal_terdaftar)->translatedFormat('d F Y'): 'Tidak Diketahui' }}
                                      </td>
                                  </tr>
                                  @php $no++; @endphp
                              @endforeach
                          </tbody>
                      </table>
                @endif
                  </div>
            @else
              <div id="chartContainer">
                <canvas id="chartPie"></canvas>
              </div>
                <script>
                    var ctx = document.getElementById('chartPie').getContext('2d');
                    var chart = new Chart(ctx, {
                        type: 'pie', // Bisa diubah ke 'bar' atau 'doughnut'
                        data: {
                            labels: ['Aktif', 'Atestasi', 'KK Aktif'],
                            datasets: [{
                                label: 'Jumlah Jemaat',
                                data: [{{ $Jaktif }}, {{ $Jatestasi }}, {{ $Jkk }}],
                                backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false, // Supaya bisa diatur ukuran
                            plugins: {
                                legend: {
                                    position: 'bottom', // Supaya legend tidak memakan banyak tempat
                                    labels: {
                                        font: {
                                            size: 10 // Ukuran teks lebih kecil
                                        }
                                    }
                                }
                            }
                        }
                    });
                </script>
            @endif
        </div>
      </div>
    </div>
  </div>