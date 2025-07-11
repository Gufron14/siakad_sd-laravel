<div>
    @if(auth()->user()->type === 'admin')
        <!-- Dashboard Admin -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboard Admin</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Siswa</span>
                                <h4 class="mb-3">
                                    <span class="counter-value" data-target="{{ $totalSiswa ?? 0 }}">{{ $totalSiswa ?? 0 }}</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0 text-end dash-widget">
                                <div id="mini-chart1" data-colors='["#1c84ee", "#33c38e"]' class="apex-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Guru</span>
                                <h4 class="mb-3">
                                    <span class="counter-value" data-target="{{ $totalGuru ?? 0 }}">{{ $totalGuru ?? 0 }}</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0 text-end dash-widget">
                                <div id="mini-chart2" data-colors='["#1c84ee", "#33c38e"]' class="apex-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Kelas</span>
                                <h4 class="mb-3">
                                    <span class="counter-value" data-target="{{ $totalKelas ?? 0 }}">{{ $totalKelas ?? 0 }}</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0 text-end dash-widget">
                                <div id="mini-chart3" data-colors='["#1c84ee", "#33c38e"]' class="apex-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Pendaftar PPDB</span>
                                <h4 class="mb-3">
                                    <span class="counter-value" data-target="{{ $totalPPDB ?? 0 }}">{{ $totalPPDB ?? 0 }}</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0 text-end dash-widget">
                                <div id="mini-chart4" data-colors='["#1c84ee", "#33c38e"]' class="apex-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Pendaftar PPDB Terbaru</h4>
                        <div class="flex-shrink-0">
                            <a href="{{ route('ppdb') }}" class="btn btn-sm btn-soft-primary">
                                Lihat Semua <i class="mdi mdi-arrow-right align-middle"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-nowrap align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Tanggal Daftar</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentPPDB ?? [] as $ppdb)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-xs me-3">
                                                    <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                        {{ substr($ppdb->nama_lengkap, 0, 1) }}
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">{{ $ppdb->nama_lengkap }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $ppdb->created_at->format('d M Y') }}</td>
                                        <td>
                                            @if($ppdb->status === 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($ppdb->status === 'diterima')
                                                <span class="badge bg-success">Diterima</span>
                                            @else
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4">
                                            <div class="text-muted">Belum ada pendaftar PPDB</div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="col-xl-4">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Quick Actions</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('murid') }}" class="btn btn-soft-primary">
                                <i class="bx bx-user-plus me-2"></i>Kelola Siswa
                            </a>
                            <a href="{{ route('guru') }}" class="btn btn-soft-info">
                                <i class="bx bx-user-check me-2"></i>Kelola Guru
                            </a>
                            <a href="{{ route('kelas') }}" class="btn btn-soft-success">
                                <i class="bx bx-home me-2"></i>Kelola Kelas
                            </a>
                            <a href="{{ route('admin.ppdb') }}" class="btn btn-soft-warning">
                                <i class="bx bx-clipboard me-2"></i>Kelola PPDB
                            </a>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

    @elseif(auth()->user()->type === 'guru')
        <!-- Dashboard Guru -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboard Guru</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Welcome Card -->
        <div class="row">
            <div class="col-12">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h4 class="text-white mb-1">Selamat Datang, {{ auth()->user()->name }}!</h4>
                                <p class="text-white-50 mb-0">
                                    @if($kelasGuru)
                                        Anda mengajar kelas {{ $kelasGuru->nama }}
                                    @else
                                        Anda belum ditugaskan ke kelas manapun
                                    @endif
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="bx bx-user-circle display-4 text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Siswa di Kelas</span>
                                <h4 class="mb-3">
                                    <span class="counter-value">{{ $jumlahSiswa ?? 0 }}</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title rounded-circle bg-primary">
                                        <i class="bx bx-user font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Hadir Hari Ini</span>
                                <h4 class="mb-3">
                                    <span class="counter-value">{{ $hadirHariIni ?? 0 }}</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded-circle bg-success">
                                    <span class="avatar-title rounded-circle bg-success">
                                        <i class="bx bx-check-circle font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Tidak Hadir</span>
                                <h4 class="mb-3">
                                    <span class="counter-value">{{ $tidakHadir ?? 0 }}</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded-circle bg-danger">
                                    <span class="avatar-title rounded-circle bg-danger">
                                        <i class="bx bx-x-circle font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jadwal Hari Ini & Quick Actions -->
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Jadwal Hari Ini</h4>
                    </div>
                    <div class="card-body">
                        @if($jadwalHariIni && count($jadwalHariIni) > 0)
                            <div class="table-responsive">
                                <table class="table table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Jam</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Kelas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($jadwalHariIni as $jadwal)
                                        <tr>
                                            <td>{{ $jadwal['jam'] }}</td>
                                            <td>{{ $jadwal['mata_pelajaran'] }}</td>
                                            <td>{{ $jadwal['kelas'] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="text-muted">Tidak ada jadwal hari ini</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- <div class="col-xl-4">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Quick Actions</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('guru.presensi') }}" class="btn btn-soft-primary">
                                <i class="bx bx-user-plus me-2"></i>Kelola Presensi
                            </a>
                            <a href="{{ route('guru.nilai') }}" class="btn btn-soft-info">
                                <i class="bx bx-user-check me-2"></i>Kelola Nilai
                            </a>
                            <a href="{{ route('guru.jadwal') }}" class="btn btn-soft-success">
                                <i class="bx bx-home me-2"></i>Kelola Jadwal
                            </a>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    @endif
</div>
