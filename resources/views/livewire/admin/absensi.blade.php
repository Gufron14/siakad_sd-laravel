<div>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="card-title mb-0">
                Absensi Santri
            </h2>
        </div>
        <div class="card-body">
            <div class="d-flex gap-3">
                <div>
                    <label class="form-label">Tanggal Absensi</label>
                    <input type="date" class="form-control">
                </div>
                <div>
                    <label class="form-label">Semester</label>
                    <select class="form-select" aria-label="Default select example">
                        <option selected disabled>-- Pilih Semester --</option>
                        <option value="">Ganjil</option>
                        <option value="">Genap</option>
                    </select>
                </div>
            </div>

            <hr class="my-3">

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>Nama Santri</th>
                            <th>Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td class="d-flex gap-5 justify-content-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radioDefault"
                                        id="radioDefault1">
                                    <label class="form-check-label" for="radioDefault1">
                                        Hadir
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radioDefault"
                                        id="radioDefault2" checked>
                                    <label class="form-check-label" for="radioDefault2">
                                        Izin
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radioDefault"
                                        id="radioDefault2" checked>
                                    <label class="form-check-label" for="radioDefault2">
                                        Sakit
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radioDefault"
                                        id="radioDefault2" checked>
                                    <label class="form-check-label" for="radioDefault2">
                                        Alfa
                                    </label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-end">
                <button class="btn btn-primary fw-bold">Simpan Absensi</button>
            </div>
        </div>
    </div>
</div>
