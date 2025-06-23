{{-- filepath: resources/views/livewire/admin/input-nilai.blade.php --}}
<div>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="card-title mb-0">
                Input Nilai Ujian Santri
            </h2>
        </div>
        <div class="card-body">
            @if (session()->has('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form wire:submit.prevent="simpanNilai">
                <div class="row mb-3">
                    <div class="col-md-1">
                        <label>Kelas</label>
                        <input type="text" class="form-control" value="{{ $kelas->nama ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label>Nama Guru</label>
                        <input type="text" class="form-control" value="{{ $guru->name ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label>Mata Pelajaran</label>
                        <select class="form-select" wire:model="mataPelajaranId" wire:change="loadNilai">
                            <option value="">Pilih Mata Pelajaran</option>
                            @foreach ($listMataPelajaran as $mapel)
                                <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                            @endforeach
                        </select>
                        @error('mataPelajaranId')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label>Semester</label>
                        <select class="form-select" wire:model="semester" wire:change="loadNilai">
                            <option value="">Pilih Semester</option>
                            @foreach ($listSemester as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </select>
                        @error('semester')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label>Tahun</label>
                        <select class="form-select" wire:model="tahun" wire:change="loadNilai">
                            <option value="">Tahun</option>
                            @foreach ($listTahun as $th)
                                <option value="{{ $th }}">{{ $th }}</option>
                            @endforeach
                        </select>
                        @error('tahun')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                @if ($mataPelajaranId && $semester && $tahun)
                    <div class="alert alert-info">
                        <strong>Info:</strong> Semester {{ $listSemester[$semester] ?? '' }} - {{ $tahun }} -
                        {{ $listMataPelajaran->find($mataPelajaranId)->nama ?? '' }}
                    </div>
                @endif

                <hr class="my-3">

                @if (count($murids) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama Santri</th>
                                    <th>UAS</th>
                                    <th>Nilai Rata-rata Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($murids as $index => $murid)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $murid->nama }}</td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm text-center"
                                                wire:model.live="nilai.{{ $murid->id }}.uas" min="0"
                                                max="100" placeholder="0-100">
                                        </td>
                                        @if ($index === 0)
                                            <td class="text-center fw-bold bg-light" rowspan="{{ count($murids) }}">
                                                {{ $this->getRataRataKelas() }}
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    {{-- <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="card border-info">
                                <div class="card-body">
                                    <h6 class="card-title text-info">Statistik Kelas</h6>
                                    <div class="row">
                                        <div class="col-4">
                                            <small class="text-muted">Rata-rata UTS:</small>
                                            <div class="fw-bold text-info">{{ $this->getRataRataUts() }}</div>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-muted">Rata-rata UAS:</small>
                                            <div class="fw-bold text-warning">{{ $this->getRataRataUas() }}</div>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-muted">Rata-rata Keseluruhan:</small>
                                            <div class="fw-bold text-success">{{ $this->getRataRataKeseluruhan() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-secondary">
                                <div class="card-body">
                                    <h6 class="card-title text-secondary">Informasi</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li><small><i class="fas fa-info-circle text-info"></i> Nilai UTS dan UAS:
                                                0-100</small></li>
                                        <li><small><i class="fas fa-calculator text-warning"></i> Rata-rata Siswa: (UTS
                                                + UAS) ÷ 2</small></li>
                                        <li><small><i class="fas fa-chart-line text-success"></i> Rata-rata Kelas:
                                                Jumlah semua nilai ÷ Jumlah siswa</small></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <div class="mt-3 text-end">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-save"></i> Simpan Nilai
                        </button>
                        <button class="btn btn-secondary ms-2" type="button" wire:click="loadNilai">
                            <i class="fas fa-refresh"></i> Refresh Data
                        </button>
                    </div>
                @else
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Tidak ada data siswa!</strong><br>
                        Pastikan kelas sudah memiliki siswa yang terdaftar.
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
