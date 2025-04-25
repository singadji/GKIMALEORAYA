<div class="col-xl-12">
        <div class="card">
          <div class="card-header bg-transparent">
            <div class="row align-items-center">
              <div class="col">
                <h6 class="text-uppercase text-muted ls-1 mb-1">Demografi Jemaat</h6>
                <h5 class="h3 mb-0">Statistik</h5>
              </div>
            </div>
          </div>
          <div class="card-body">
            <!-- Chart -->
            <div class="chart">
              <div id="chartContainer">
                <canvas id="grafikUmur"></canvas>
              </div>
              @php
                  $warnaKategori = [
                    'Anak' => 'rgba(52, 152, 219, 0.8)',    // Biru cerah
                    'Remaja' => 'rgba(41, 128, 185, 0.8)',  // Biru medium
                    'Pemuda' => 'rgba(31, 97, 141, 0.8)',   // Biru tua
                    'Dewasa Muda' => 'rgba(127, 140, 141, 0.8)', // Abu tua
                    'Dewasa' => 'rgba(189, 195, 199, 0.8)', // Abu terang
                    'Lansia' => 'rgba(149, 165, 166, 0.8)', // Abu sedang
                  ];

                  // Mapping nama panjang ke pendek
                  $namaKategoriPendek = [
                      'Jumlah Anggota Berusia 0-12 thn (Anak)' => 'Anak',
                      'Jumlah Anggota Berusia 13-17 thn (Remaja)' => 'Remaja',
                      'Jumlah Anggota Berusia 18-29 thn (Pemuda)' => 'Pemuda',
                      'Jumlah Anggota Berusia 30-40 thn (Dewasa Muda)' => 'Dewasa Muda',
                      'Jumlah Anggota Berusia 41-60 thn (Dewasa)' => 'Dewasa',
                      'Jumlah Anggota Berusia 61 thn ke atas (Lansia)' => 'Lansia',
                  ];
              @endphp
              <script>
                  var ctx = document.getElementById('grafikUmur').getContext('2d');

                  var usiaChart = new Chart(ctx, {
                      type: 'bar',
                      data: {
                          labels: @json($tahun), // Tahun sebagai label sumbu X
                          datasets: [
                              @foreach ($data as $kategori => $values)
                              {
                                  label: '{{ $kategori }}',
                                  data: [
                                      @foreach ($tahun as $thn)
                                          {{ $values["Data $thn"] ?? 0 }},
                                      @endforeach
                                  ],
                                  backgroundColor: '{{ $warnaKategori[$namaKategoriPendek[$kategori]] }}',
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
                                  text: 'Grafik Jumlah Jemaat Berdasarkan Kelompok Umur'
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