<div>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="card-title mb-0">
                Laporan Peserta Didik
            </h2>
            {{-- Cetak Semua Raport Murid --}}
            <button class="btn btn-success fw-bold" wire:click="cetakSemuaRaport" 
                    @if(!$selectedSemester || !$selectedTahun) disabled @endif>
                <i class="fas fa-print me-1"></i>
                Cetak Semua Raport
            </button>
        </div>
        <div class="card-body">
            @if (Auth::user()->hasRole('admin'))                
                <div class="alert alert-danger text-center">
                    <i class="fas fa-exclamation-circle"></i>
                    <strong>Anda login sebagai Admin.</strong><br>
                    Admin tidak bertugas untuk mengelola Raport.
                </div>
            @else
                @if(!$kelas)
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Anda belum memiliki kelas yang diajar.</strong><br>
                        Silakan hubungi admin untuk mendapatkan kelas.
                    </div>
                @else
                    <div class="alert alert-info">
                        <strong>Kelas:</strong> {{ $kelas->nama }} | 
                        <strong>Jumlah Murid:</strong> {{ count($murids) }}
                    </div>

                    {{-- Filter Section --}}
                    <div class="d-flex gap-3 mb-4">
                        <div class="col">
                            <div class="form-group">
                                <label for="" class="form-label">Nama Murid</label>
                                <select wire:model.live="selectedMurid" class="form-select">
                                    <option value="">Pilih Murid</option>
                                    @foreach($murids as $murid)
                                        <option value="{{ $murid->id }}">{{ $murid->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="" class="form-label">Semester</label>
                                <select wire:model.live="selectedSemester" class="form-select">
                                    <option value="">Pilih Semester</option>
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="" class="form-label">Tahun Ajaran</label>
                                <select wire:model.live="selectedTahun" class="form-select">
                                    <option value="">Pilih Tahun</option>
                                    @foreach($listTahun as $tahun)
                                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    @if($selectedMurid && $selectedSemester && $selectedTahun)
                        {{-- Debug info (hapus setelah testing) --}}
                        <div class="alert alert-info d-none">
                            Selected Murid: {{ $selectedMurid }}<br>
                            Selected Semester: {{ $selectedSemester }}<br>
                            Selected Tahun: {{ $selectedTahun }}<br>
                            Nilai Data Count: {{ count($nilaiData) }}<br>
                            Mata Pelajaran Count: {{ count($mataPelajarans) }}<br>
                            @if(count($nilaiData) > 0)
                                <strong>Nilai Data:</strong>
                                @foreach($nilaiData as $mapelId => $data)
                                    <br>Mapel ID {{ $mapelId }}: {{ $data['uas'] }}
                                @endforeach
                            @endif
                        </div>

                        {{-- Tampilkan Nilai Murid --}}
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Angka</th>
                                        <th>Nilai Rata-rata Kelas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @forelse($mataPelajarans as $mapel)
                                        <tr class="text-center">
                                            <td>{{ $no++ }}</td>
                                            <td class="text-start">{{ $mapel->nama }}</td>
                                            <td>
                                                @if(isset($nilaiData[$mapel->id]))
                                                    {{ $nilaiData[$mapel->id]['uas'] }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $this->getRataRataKelas() }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada mata pelajaran</td>
                                        </tr>
                                    @endforelse
                                    <tr>
                                        <td colspan="4"><strong>Jumlah: {{ $this->getTotalNilai() }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            Peringkat kelas ke &nbsp; 
                                            <span class="badge bg-primary">
                                                {{ $this->getPeringkat() ?? '-' }} 
                                                @if($this->getPeringkat())
                                                    ({{ ucwords($this->numberToWords($this->getPeringkat())) }})
                                                @endif
                                            </span>  
                                            &nbsp; dari {{ count($murids) }} Murid
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <td rowspan="4" colspan="2" class="text-center"><strong>Ketidakhadiran</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Sakit</td>
                                        <td class="text-center">{{ $absensiData['sakit'] ?? 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td>Izin</td>
                                        <td class="text-center">{{ $absensiData['izin'] ?? 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanpa Keterangan</td>
                                        <td class="text-center">{{ $absensiData['alpha'] ?? 0 }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                @endif
            @endif

            @if(session()->has('error'))
                <div class="alert alert-danger mt-3">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
</div>
