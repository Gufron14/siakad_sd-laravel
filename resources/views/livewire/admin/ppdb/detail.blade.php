<div>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="card-title mb-0">
                Detail Calon Peserta Didik
            </h3>
            <a href="{{ route('ppdb') }}" class="btn btn-primary fw-bold">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali</a>
        </div>
        <div class="card-body">
            <div class="d-flex gap-4">
                <div class="col">
                    <label for="" class="form-label text-uppercase">data calon peserta didik</label>
                    <div class="table-responsive">
                        <table class="table border">
                            <tbody>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>{{ $ppdb->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <th>Tempat, Tanggal Lahir</th>
                                    <td>{{ $ppdb->tempat_lahir }}, {{ $ppdb->tanggal_lahir->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $ppdb->alamat_siswa }}</td>
                                </tr>
                                <tr>
                                    <th>Anak Ke</th>
                                    <td>{{ $ppdb->anak_ke }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Saudara Kandung</th>
                                    <td>{{ $ppdb->jumlah_saudara }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col">
                    <label for="" class="form-label text-uppercase">data orang tua calon peserta didik</label>
                    <div class="table-responsive">
                        <table class="table border">
                            <tbody>
                                <tr>
                                    <th>Nama Ayah</th>
                                    <td>{{ $ppdb->nama_ayah }}</td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan Ayah</th>
                                    <td>{{ $ppdb->pekerjaan_ayah }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Ibu</th>
                                    <td>{{ $ppdb->nama_ibu }}</td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan Ibu</th>
                                    <td>{{ $ppdb->pekerjaan_ibu}}</td>
                                </tr>
                                <tr>
                                    <th>Nomor Telepon</th>
                                    <td>{{ $ppdb->nomor_telepon }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $ppdb->alamat_ortu}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <button class="btn btn-danger fw-bold">Tolak Peserta</button>
            <button class="btn btn-primary fw-bold">Terima Peserta</button>
        </div>
    </div>
</div>
