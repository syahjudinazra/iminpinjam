@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container-fluid">
        <div class="row">


        </div>
    </div>

    <!-- Export Excel Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Export Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('export.service') }}" method="GET" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group py-4 px-2 d-flex justify-content-center gap-4">
                        <label for="start_date mt-2">Start Date:</label>
                        <input type="date" id="start_date" name="start_date">

                        <label for="end_date mt-2">End Date:</label>
                        <input type="date" id="end_date" name="end_date">
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-success btn-sm" type="submit"><i
                                class="fas fa-download fa-sm text-white-50"></i>Export
                            Excel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tambah Data -->
    <div class="container w-50 p-3">
        <div class="row addDataForms">
            <div class="d-flex justify-content-between mb-2">
                <h1 class="h3 mb-3 text-gray-800">Tambah Data Service</h1>
                <button type="button" class="btn btn-success btn-sm font-weight-bold text-white" data-bs-toggle="modal"
                    data-target="#exportModal"><i class="fa-solid fa-download" style="color: #ffffff;"></i>
                    Export Excel
                </button>

            </div>
            <hr style="width: -webkit-fill-available;">
            <form class="mb-4" method="post" action="/service" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="font-weight-bold" for="serialnumber">Serial Number</label>
                    <input type="text" class="form-control shadow-none" id="serialnumber" name="serialnumber"
                        placeholder="Masukan Serial Number" value="{{ old('serialnumber') }}" required>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="tanggalmasuk">Tanggal Masuk</label>
                    <input type="date" class="form-control shadow-none" id="tanggalmasuk" name="tanggalmasuk"
                        value="{{ old('tanggalmasuk') }}" required>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="pemilik">Pemilik</label><br />
                    <div class="form-check form-check-inline">
                        <input class="form-check-input mt-1" type="radio" id="stock" name="pemilik[]" value="stock">
                        <label class="form-check-label" for="stock">Stock</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input mt-1" type="radio" id="customer" name="pemilik[]"
                            value="customer">
                        <label class="form-check-label" for="customer">Pelanggan</label>
                    </div>
                </div>
                <div class="form-group" hidden>
                    <label class="font-weight-bold" for="status">Status</label><br />
                    <div class="form-check form-check-inline">
                        <input class="form-check-input mt-1" type="radio" id="pending" name="status[]" value="pending"
                            checked>
                        <label class="form-check-label" for="pending">Pending</label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="pelanggan">Pelanggan</label>
                    <input type="text" class="form-control shadow-none" id="pelanggan" name="pelanggan"
                        placeholder="Masukan Pelanggan" value="{{ old('pelanggan') }}" required>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="device">Tipe Device</label>
                    <select class="form-select form-control-chosen shadow-none" name="device" id="device" required>
                        <option value="Null">Pilih Tipe Device</option>
                        <option value="D1">D1</option>
                        <option value="D1-Pro">D1 Pro</option>
                        <option value="D1w">D1w-702</option>
                        <option value="D2-402">D2-402</option>
                        <option value="D3-501">D3-501</option>
                        <option value="D3-503">D3-503</option>
                        <option value="D3-504">D3-504</option>
                        <option value="D3-505">D3-505</option>
                        <option value="D3-506">D3-506</option>
                        <option value="D3-504 lama">D3-504 lama</option>
                        <option value="D3-505 lama">D3-505 lama</option>
                        <option value="D3-506 lama">D3-506 lama</option>
                        <option value="D4-502">D4-502</option>
                        <option value="D4-503">D4-503</option>
                        <option value="D4-504">D4-504</option>
                        <option value="D4-505">D4-505</option>
                        <option value="M2-202">M2-202</option>
                        <option value="K1-101">K1-101</option>
                        <option value="K1-201">K1-201</option>
                        <option value="M2-202">M2-202</option>
                        <option value="M2-203">M2-203</option>
                        <option value="M2 Pro">M2 Pro</option>
                        <option value="M2 Max">M2 Max</option>
                        <option value="S1-701">S1-701</option>
                        <option value="Swan 1">Swan 1</option>
                        <option value="Swan 1K">Swan 1K</option>
                        <option value="Swan 1 Pro">Swan 1 Pro</option>
                        <option value="Swift 1">Swift 1</option>
                        <option value="Swift 1 Pro">Swift 1 Pro</option>
                        <option value="Swift 2">Swift 2</option>
                        <option value="Swift 2 Pro">Swift 2 Pro</option>
                        <option value="Falcon 1">Falcon 1</option>
                        <option value="Crane 1 16">Crane 1 16</option>
                        <option value="Crane 1 21.5">Crane 1 21.5</option>
                        <option value="Crane 1 27">Crane 1 27</option>
                        <option value="Crane 1 32">Crane 1 32</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="pemakaian">Lama Pemakaian</label>
                    <select class="form-select shadow-none" name="pemakaian" id="pemakaian" required>
                        <option value="Null">Pilih Lama Pemakaian</option>
                        <option value="Baru Di Unboxing">Baru Di Unboxing</option>
                        <option value="7 Hari Kurang">7 Hari Kurang</option>
                        <option value="1 Tahun Kurang">1 Tahun Kurang</option>
                        <option value="1 Tahun Lebih">1 Tahun Lebih</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="kerusakan">Kerusakan</label>
                    <textarea type="text" class="form-control shadow-none" id="kerusakan" name="kerusakan"
                        placeholder="Masukan Kerusakan" required>{{ old('kerusakan') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="catatan">Catatan</label>
                    <textarea type="text" class="form-control shadow-none" id="catatan" name="catatan"
                        placeholder="Masukan Catatan" required>{{ old('catatan') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/service/tambahData.js') }}"></script>
@endpush
