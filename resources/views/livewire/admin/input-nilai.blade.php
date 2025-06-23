<div>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="card-title mb-0">
                Input Nilai Ujian Santri
            </h2>
            <input type="file" name="" id="" class="form-control w-25">
        </div>
        <div class="card-body">
            <div class="col-6">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td>Kelas</td>
                            <td>: 1</td>
                        </tr>
                        <tr>
                            <td>Mata Pelajaran</td>
                            <td>: Bahasa Indonesia</td>
                        </tr>
                        <tr>
                            <td>Nama Guru</td>
                            <td>: Tantan Sutandi</td>
                        </tr>
                        <tr>
                            <td>Semester</td>
                            <td>
                                <select class="form-select form-select-sm" aria-label="Default select example">
                                    <option selected>Semester</option>
                                    <option value="1">Ganjil</option>
                                    <option value="2">Genap</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <hr class="my-3">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>Nama Santri</th>
                            <th>Tugas 1</th>
                            <th>Tugas 2</th>
                            <th>Tugas 3</th>
                            <th>UTS</th>
                            <th>Nilai Rata-rata</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tantan Sutandi</td>
                            <td>
                                <input type="number" class="form-control form-control-sm">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm">
                            </td>
                            <td class="text-center fw-bold">86,70</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning">Edit</button>
                                <button class="btn btn-sm btn-danger">Reset</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
