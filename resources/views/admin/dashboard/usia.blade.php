<div class="col-xl-8">
        <div class="card">
          <div class="card-header border-0">
            <div class="row align-items-center">
              <div class="col">
                <h3 class="mb-0">Demografi Jemaat</h3>
                <div class="mb-0"><br>
                <form method="get" class="row g-3 mb-4" action="">
                    <div class="col-auto">
                        <label class="form-control-label">Tahun Awal</label>
                        <input type="number" name="tahunawal" value="{{ $tahun_Awal }}" class="form-control form-control-sm" />
                    </div>
                    <div class="col-auto">
                        <label class="form-control-label">Tahun Akhir</label>
                        <input type="number" name="tahunakhir" value="{{ $tahun_Akhir }}" class="form-control form-control-sm" />
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
            <!-- Projects table -->
            <table class="table align-items-center table-flush table-hover" style="line-height: 0.5;" id="">
              <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Kategori Usia</th>
                        @foreach ($tahun as $thn)
                            <th class="text-center">Data {{ $thn }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php $no=1; @endphp
                    @foreach ($data as $kategori => $tahunData)
                        <tr>
                            <td class="">{{ $no }}</td>
                            <td class="">{{ $kategori }}</td>
                            @foreach ($tahun as $thn)
                                <td class="text-center">{{ $tahunData["Data $thn"] ?? 0 }}</td>
                            @endforeach
                        </tr>
                        @php $no++; @endphp
                    @endforeach
                </tbody>
                <tfooter>
                <tr class="fw-bold table-secondary thead-light">
                      <th class="text-center"></th>
                      <th class="text-center">TOTAL</th>
                      @foreach ($tahun as $thn)
                          <th class="text-center">{{ $totalPerTahun[$thn] ?? 0 }}</th>
                      @endforeach
                  </tr>
                </tfooter>
            </table>
          </div>
        </div>
      </div>
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
          <div class="card-body">
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
                            data: [{{ $Jaktif }}, {{ $Jpasif }}, {{ $Jkk }}, {{$Jatestasi}}],
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