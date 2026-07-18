<div class="col-xl-4">
        <div class="card">
          <div class="card-header bg-transparent">
            <div class="row align-items-center">
              <div class="col">
                <h6 class="text-uppercase text-muted ls-1 mb-1">Data Jemaat</h6>
                <h5 class="h3 mb-0">Statistik Jemaat</h5>
              </div>
            </div>
          </div>
          <div class="card-body" style="height:700px">
            <div class="chart">
              <div id="chartContainer">
                <canvas id="grafik"></canvas>
              </div>
              <script>
                var ctx = document.getElementById('grafik').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Aktif', 'Pasif', 'KK Aktif','Atestasi Keluar'],
                        datasets: [{
                            label: 'Jumlah Jemaat',
                            data: [{{ $jJ['total_jemaat'] }}, {{ $jJ['pasif'] }}, {{ $jJ['jemaat_kk'] }}, {{$jJ['atestasi_keluar']}}],
                            backgroundColor: ['#36A2EB', '#FFCE56', '#0a9905', '#e71313'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom', 
                                labels: {
                                    font: {
                                        size: 10
                                    }
                                }
                            }
                        }
                    }
                });
            </script>
            </div>
          </div>
        </div>
      </div>
<div class="col-xl-8">
        <div class="card">
          <div class="card-header border-0">
            <div class="row align-items-center">
              <div class="col">
                <h3 class="mb-0">Akumulasi Data Jemaat</h3>
                <div class="mb-0"><br>
                <form method="get" class="row g-3 mb-4" action="">
                    <div class="col-auto">
                        <label class="form-control-label">Tahun Awal</label>
                        <input type="number" name="tahun_awal" value="{{ $tahunAwal }}" class="form-control form-control-sm" />
                    </div>
                    <div class="col-auto">
                        <label class="form-control-label">Tahun Akhir</label>
                        <input type="number" name="tahun_akhir" value="{{ $tahunAkhir }}" class="form-control form-control-sm" />
                    </div>
                    <div class="col-auto align-self-end">
                        <button class="btn btn-primary btn-sm" type="submit">Tampilkan</button>
                    </div>
                </form>
            </div>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table align-items-center wrap table-flush table-hover" style="line-height: 1.3;" id="">
            <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>Keterangan</th>
            @for ($tahun = $tahunAwal; $tahun <= $tahunAkhir; $tahun++)
                <th>Data {{ $tahun }}</th>
            @endfor
        </tr>
    </thead>
    <tbody>
      @php
        $genderGrouped = collect($lapGender)->groupBy('kategori');
      @endphp
      @foreach ($genderGrouped as $kategori => $items)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $kategori }}</td>
            @for ($tahun = $tahunAwal; $tahun <= $tahunAkhir; $tahun++)
                @php
                    $jumlah = collect($items)->where('tahun', $tahun)->first()->jumlah ?? 0;
                @endphp
                <td class="text-center">{{ $jumlah }}</td>
            @endfor
        </tr>
      @endforeach
      <thead class="thead-light">
        <tr style="font-weight: bold;">
            <th></th>
            <th class="text-center">TOTAL ANGGOTA</th>
            @for ($tahun = $tahunAwal; $tahun <= $tahunAkhir; $tahun++)
                <th class="text-center">{{ $totalGender[$tahun] ?? 0 }}</th>
            @endfor
        </tr>
      </thead>
      {{-- Simpatisan --}}
      @php
        $statusGrouped = collect($lapStatus)->groupBy('kategori');
      @endphp
      @foreach ($statusGrouped as $kategori => $items)
        <tr>
          <td>{{ $loop->iteration + 2 }}</td> {{-- lanjut dari nomor 3 --}}
          <td>{{ $kategori }}</td>
          @for ($tahun = $tahunAwal; $tahun <= $tahunAkhir; $tahun++)
              @php
                  $jumlah = collect($items)->where('tahun', $tahun)->first()->jumlah ?? 0;
              @endphp
              <td class="text-center">{{ $jumlah }}</td>
          @endfor
        </tr>
      @endforeach

        {{-- Total Anggota + Non Anggota --}}
      <thead class="thead-light">
        <tr style="font-weight: bold;">
            <th></th>
            <th class="text-center">TOTAL (ANGGOTA + NON ANGGOTA)</th>
            @for ($tahun = $tahunAwal; $tahun <= $tahunAkhir; $tahun++)
                <th class="text-center">{{ $totalAll[$tahun] ?? 0 }}</th>
            @endfor
        </tr>
      </thead>

        {{-- Umur --}}
        @foreach ($lapUmur as $kategori => $items)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $kategori }}</td>
                @for ($tahun = $tahunAwal; $tahun <= $tahunAkhir; $tahun++)
                    @php
                        $jumlah = collect($items)->where('tahun', $tahun)->first()->jumlah ?? 0;
                    @endphp
                    <td class="text-center">{{ $jumlah }}</td>
                @endfor
            </tr>
        @endforeach

        {{-- Total Bawah --}}
      <thead class="thead-light">
        <tr style="font-weight: bold;">
            <th></th>
            <th class="text-center">Total</th>
            @for ($tahun = $tahunAwal; $tahun <= $tahunAkhir; $tahun++)
                <th class="text-center">{{ $totalTahun[$tahun] ?? 0 }}</th>
            @endfor
        </tr>
      </thead>

    </tbody>
            </table>
          </div>
        </div>
      </div>