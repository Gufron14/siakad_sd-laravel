<div>
    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h2 class="card-title mb-0">
                Tambah Peserta Didik Baru
            </h2>
        </div>
        <div class="card-body p-4">
            {{-- Flash Messages --}}
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form wire:submit.prevent="kirimPendaftaran">
                {{-- DATA SISWA --}}
                <label for="" class="form-label text-secondary text-secondary fw-bold">DATA SISWA</label>
                <div class="d-flex gap-3">
                    <div class="col">
                        <div class="form-group mb-3">
                            <label for="" class="form-label text-secondary">Nama Lengkap</label>
                            <input type="text" wire:model="nama_lengkap"
                                class="form-control @error('nama_lengkap') is-invalid @enderror">
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group mb-3">
                            <label for="" class="form-label text-secondary">Tempat, tanggal lahir</label>
                            <div class="input-group">
                                <input type="text" wire:model="tempat_lahir" placeholder="Tempat Lahir"
                                    class="form-control @error('tempat_lahir') is-invalid @enderror">
                                <input type="date" wire:model="tanggal_lahir"
                                    class="form-control @error('tanggal_lahir') is-invalid @enderror">
                            </div>
                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <label for="" class="form-label text-secondary">Jenis Kelamin</label>
                        <select wire:model="jenis_kelamin"
                            class="form-select @error('jenis_kelamin') is-invalid @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <div class="col-md-2">
                        <div class="form-group mb-3">
                            <label for="" class="form-label text-secondary">Anak Ke</label>
                            <input type="number" wire:model="anak_ke"
                                class="form-control @error('anak_ke') is-invalid @enderror">
                            @error('anak_ke')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-3">
                            <label for="" class="form-label text-secondary">Jml. Saudara Kandung</label>
                            <input type="number" wire:model="jumlah_saudara"
                                class="form-control @error('jumlah_saudara') is-invalid @enderror">
                            @error('jumlah_saudara')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group mb-3">
                            <label for="" class="form-label text-secondary">Alamat Lengkap</label>
                            <input type="text" wire:model="alamat_siswa"
                                class="form-control @error('alamat_siswa') is-invalid @enderror">
                            @error('alamat_siswa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- DATA ORANG TUA --}}
                <label for="" class="form-label text-secondary text-secondary fw-bold">DATA ORANG TUA</label>
                <div class="d-flex gap-3">
                    <div class="col">
                        <div class="form-group mb-3">
                            <label for="" class="form-label text-secondary">Nama Ayah</label>
                            <input type="text" wire:model="nama_ayah"
                                class="form-control @error('nama_ayah') is-invalid @enderror">
                            @error('nama_ayah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group mb-3">
                            <label for="" class="form-label text-secondary">Pekerjaan Ayah</label>
                            <input type="text" wire:model="pekerjaan_ayah"
                                class="form-control @error('pekerjaan_ayah') is-invalid @enderror">
                            @error('pekerjaan_ayah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <div class="col">
                        <div class="form-group mb-3">
                            <label for="" class="form-label text-secondary">Nama Ibu</label>
                            <input type="text" wire:model="nama_ibu"
                                class="form-control @error('nama_ibu') is-invalid @enderror">
                            @error('nama_ibu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group mb-3">
                            <label for="" class="form-label text-secondary">Pekerjaan Ibu</label>
                            <input type="text" wire:model="pekerjaan_ibu"
                                class="form-control @error('pekerjaan_ibu') is-invalid @enderror">
                            @error('pekerjaan_ibu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <div class="col">
                        <div class="form-group mb-3">
                            <label for="" class="form-label text-secondary">Alamat Lengkap</label>
                            <input type="text" wire:model="alamat_ortu"
                                class="form-control @error('alamat_ortu') is-invalid @enderror">
                            @error('alamat_ortu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group mb-3">
                            <label for="" class="form-label text-secondary">Nomor Telepon</label>
                            <input type="number" wire:model="nomor_telepon"
                                class="form-control @error('nomor_telepon') is-invalid @enderror">
                            @error('nomor_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <a href="{{ route('ppdb') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success fw-bold">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
