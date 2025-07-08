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
                @if (Auth::user()->hasRole('admin'))
                @else
                    <div class="row mb-3">
                        <div class="col-md-1">
                            <label>Kelas</label>
                            <input type="text" class="form-control" value="{{ $kelas->nama ?? '-' }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Wali Kelas</label>
                            <input type="text" class="form-control"
                                value="{{ auth()->user()->hasRole('guru') ? auth()->user()->name : '-' }}" readonly>
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
                @endif

                @if (Auth::user()->hasRole('admin'))
                    <div class="alert alert-danger text-center">
                        <i class="fas fa-exclamation-circle"></i>
                        <strong>Anda login sebagai Admin.</strong><br>
                        Admin tidak bertugas untuk menginput nilai.
                    </div>
                @elseif (count($murids) > 0)
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
                                            <td class="text-center fw-bold bg-light align-middle fs-4"
                                                rowspan="{{ count($murids) }}">
                                                {{ $this->getRataRataKelas() }}
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

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
