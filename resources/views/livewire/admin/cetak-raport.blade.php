<div>
    <div class="d-print-none mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Cetak Raport - {{ $kelas->nama }}</h2>
            <div>
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print"></i> Cetak
                </button>
                <a href="{{ route('raport') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="alert alert-info">
            <strong>Semester:</strong> {{ $semester }} | 
            <strong>Tahun Ajaran:</strong> {{ $tahun }} |
            <strong>Jumlah Murid:</strong> {{ count($murids) }}
        </div>
    </div>

    @foreach($raportData as $muridId => $data)
        <div class="card mb-4" style="page-break-after: always;">
            <div class="card-header bg-primary text-white">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0">RAPORT PESERTA DIDIK</h5>
                        <small>MDTA Fathul Uluum</small>
                    </div>
                    <div class="col-md-6 text-end">
                        <strong>{{ $data['murid']->nama }}</strong><br>
                        <small>Kelas: {{ $kelas->nama }}</small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="120">Nama</td>
                                <td>: {{ $data['murid']->nama }}</td>
                            </tr>
                            <tr>
                                <td>Kelas</td>
                                <td>: {{ $kelas->nama }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="120">Semester</td>
                                <td>: {{ $semester }}</td>
                            </tr>
                            <tr>
                                <td>Tahun Ajaran</td>
                                <td>: {{ $tahun }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th width="50">No</th>
                                <th>Mata Pelajaran</th>
                                <th width="100">Nilai</th>
                                <th width="150">Rata-rata Kelas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($mataPelajarans as $mapel)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td>{{ $mapel->nama }}</td>
                                    <td class="text-center">
                                        @if(isset($data['nilai'][$mapel->id]))
                                            {{ $data['nilai'][$mapel->id]['uas'] }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $this->getRataRataKelas() }}</td>
                                </tr>
                            @endforeach
                            <tr class="table-secondary">
                                <td colspan="4" class="text-center">
                                    <strong>Jumlah: {{ $data['total_nilai'] }}</strong>
                                </td>
                            </tr>
                            <tr class="table-info">
                                <td colspan="4" class="text-center">
                                    Peringkat kelas ke <strong>{{ $data['peringkat'] ?? '-' }}</strong> dari {{ count($murids) }} Murid
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6>Ketidakhadiran:</h6>
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td>Sakit</td>
                                <td class="text-center" width="50">{{ $data['absensi']['sakit'] }}</td>
                            </tr>
                            <tr>
                                <td>Izin</td>
                                <td class="text-center">{{ $data['absensi']['izin'] }}</td>
                            </tr>
                            <tr>
                                <td>Tanpa Keterangan</td>
                                <td class="text-center">{{ $data['absensi']['alpha'] }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center mt-4">
                            <p>Wali Kelas</p>
                            <br><br><br>
                            <p><strong>{{ $kelas->guru->name }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<style>
@media print {
    .d-print-none {
        display: none !important;
    }
    
    .card {
        border: 1px solid #000 !important;
        box-shadow: none !important;
    }
    
    .table-bordered {
        border: 1px solid #000 !important;
    }
    
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #000 !important;
    }
}
</style>