<div>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @elseif (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="card-title mb-0">
                Absensi Santri
            </h2>
        </div>
        <div class="card-body">
            @if (Auth::user()->hasRole('admin'))
                <div class="alert alert-danger text-center">
                    <i class="fas fa-exclamation-circle"></i>
                    <strong>Anda login sebagai Admin.</strong><br>
                    Admin tidak bertugas untuk melakukan Absensi.
                </div>
            @else
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Absensi</label>
                        <input type="date" class="form-control" wire:model.live="tanggal">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Semester</label>
                        <select class="form-select" wire:model="semester">
                            <option value="">-- Pilih Semester --</option>
                            <option value="ganjil">Ganjil</option>
                            <option value="genap">Genap</option>
                        </select>
                    </div>

                    @if ($isGuru && $userKelas)
                        <!-- Guru: Show class info only -->
                        <div class="col-md-3">
                            <label class="form-label">Kelas</label>
                            <div class="form-control bg-light">
                                <strong>{{ $userKelas->nama }}</strong>
                                <small class="text-muted">(Kelas Anda)</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Wali Kelas</label>
                            <input type="text" class="form-control bg-light"
                                value="{{ auth()->user()->hasRole('guru') ? auth()->user()->name : '-' }}" readonly>
                        </div>
                    @else
                        <!-- Admin/Staff: Show class dropdown -->
                        <div class="col-md-4">
                            <label class="form-label">Kelas</label>
                            <select class="form-select" wire:model.live="kelas_id">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>

                <hr class="my-3">

                @if ($murids->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%">No</th>
                                    <th width="25%">Nama Santri</th>
                                    <th width="15%">Kelas</th>
                                    <th width="55%">Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($murids as $index => $murid)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $murid->nama }}</td>
                                        <td class="text-center">{{ $murid->kelas->nama }}</td>
                                        <td>
                                            <div class="d-flex gap-4 justify-content-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="absensi_{{ $murid->id }}" value="hadir"
                                                        id="hadir_{{ $murid->id }}"
                                                        wire:model="absensi.{{ $murid->id }}">
                                                    <label class="form-check-label" for="hadir_{{ $murid->id }}">
                                                        <span class="badge bg-success">Hadir</span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="absensi_{{ $murid->id }}" value="izin"
                                                        id="izin_{{ $murid->id }}"
                                                        wire:model="absensi.{{ $murid->id }}">
                                                    <label class="form-check-label" for="izin_{{ $murid->id }}">
                                                        <span class="badge bg-warning">Izin</span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="absensi_{{ $murid->id }}" value="sakit"
                                                        id="sakit_{{ $murid->id }}"
                                                        wire:model="absensi.{{ $murid->id }}">
                                                    <label class="form-check-label" for="sakit_{{ $murid->id }}">
                                                        <span class="badge bg-info">Sakit</span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="absensi_{{ $murid->id }}" value="alfa"
                                                        id="alfa_{{ $murid->id }}"
                                                        wire:model="absensi.{{ $murid->id }}">
                                                    <label class="form-check-label" for="alfa_{{ $murid->id }}">
                                                        <span class="badge bg-danger">Alfa</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-primary fw-bold" wire:click="simpanAbsensi">
                            <i class="bx bx-save"></i> Simpan Absensi
                        </button>
                    </div>
                @else
                    <div class="text-center py-4">
                        <div class="alert alert-info">
                            <i class="bx bx-info-circle"></i>
                            Silakan pilih kelas terlebih dahulu untuk menampilkan daftar santri
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
