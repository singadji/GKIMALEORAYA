
      
    <div class="col-xl-7">
        <div class="card">
          <div class="card-header border-0">
            <div class="row align-items-center">
              <div class="col">
                <h3 class="mb-0">Penambahan dan Pengurangan Jumlah Keanggotaan per Tahun PURJ</h3>
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
                        <th class="text-center">No.</th>
                        <th class="text-left">Entitas Informasi Penambahan dan <br>Pengurangan Jumlah Keanggotaan</th>
                        @for ($tahun = $tahunAwal; $tahun <= $tahunAkhir; $tahun++)
                            <th class="text-center">Data<br>{{ $tahun }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporan as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->kategori }}</td>
                            @for ($tahun = $tahunAwal; $tahun <= $tahunAkhir; $tahun++)
                                @php $field = "Data $tahun"; @endphp
                                <td class="text-center">{{ $item->$field ?? 0 }}</td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-xl-5">
        <div class="card">
          <div class="card-header bg-transparent">
            <div class="row align-items-center">
              <div class="col">
                <h6 class="text-uppercase text-muted ls-1 mb-1">Demografi Jemaat</h6>
                <h5 class="h3 mb-0">Statistik</h5>
              </div>
            </div>
          </div>
          <div class="card-body" style="height:495px">
            <!-- Chart -->
            <div class="chart">
                <div id="chartContainer">
                    <canvas id="grafikKeanggotaan"></canvas>
                </div>
                @php
                    // Warna untuk setiap kategori
                    $warnaKategori = [
                        'Anggota Baptis' => 'rgba(52, 152, 219, 0.8)',    // Biru cerah
                        'Anggota Sidi' => 'rgba(41, 128, 185, 0.8)',      // Biru medium
                        'Atestasi Masuk' => 'rgba(31, 97, 141, 0.8)',     // Biru tua
                        'Atestasi Keluar' => 'rgba(127, 140, 141, 0.8)',   // Abu tua
                        'Pindah dari Gereja lain' => 'rgba(189, 195, 199, 0.8)', // Abu terang
                        'Pindah ke Gereja lain' => 'rgba(149, 165, 166, 0.8)', // Abu sedang
                        'Jumlah Anggota yang Meninggal' => 'rgba(231, 76, 60, 0.8)', // Merah
                    ];

                    // Mengolah kategori menjadi nama pendek untuk referensi warna
                    $namaKategoriPendek = [
                        'Anggota Baptis' => 'Anggota Baptis',
                        'Anggota Sidi' => 'Anggota Sidi',
                        'Atestasi Masuk' => 'Atestasi Masuk',
                        'Atestasi Keluar' => 'Atestasi Keluar',
                        'Pindah dari Gereja lain' => 'Pindah dari Gereja lain',
                        'Pindah ke Gereja lain' => 'Pindah ke Gereja lain',
                        'Jumlah Anggota yang Meninggal' => 'Jumlah Anggota yang Meninggal',
                    ];
                @endphp

                <script>
                    var ctx = document.getElementById('grafikKeanggotaan').getContext('2d');

                    var keanggotaanChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: @json($tahunG), // Tahun sebagai label sumbu X
                            datasets: [
                                @foreach ($dataG as $kategori => $values)
                                {
                                    label: '{{ $kategori }}',
                                    data: [
                                        @foreach ($tahunG as $thn)
                                            {{ $values["Data $thn"] ?? 0 }},
                                        @endforeach
                                    ],
                                    backgroundColor: '{{ $warnaKategori[$kategori] }}',
                                    borderWidth: 1
                                },
                                @endforeach
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Grafik Jumlah Jemaat Berdasarkan Kategori Keanggotaan'
                                },
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        font: {
                                            size: 12
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Jumlah Jemaat'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Tahun'
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