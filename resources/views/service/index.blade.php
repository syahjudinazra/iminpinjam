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
                <div class="d-flex align-items-center gap-3">
                    <a type="button" class="btn btn-success btn-sm font-weight-bold text-white" data-bs-toggle="modal"
                        data-target="#exportModal"><i class="fa-regular fa-calendar-days" style="color: #ffffff;"></i>
                        Export By Date
                    </a>
                    <a href="{{ route('export.allservice') }}" class="btn btn-success btn-sm font-weight-bold text-white"><i
                            class="fa-solid fa-download" style="color: #ffffff;"></i>
                        Export All
                    </a>
                </div>

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
                        <label class="form-check-label" for="customer">Customer</label>
                    </div>
                </div>
                <div class="form-group" hidden>
                    <label class="font-weight-bold" for="status">Status</label><br />
                    <div class="form-check form-check-inline">
                        <input class="form-check-input mt-1" type="radio" id="antrian" name="status[]" value="antrian"
                            checked>
                        <label class="form-check-label" for="antrian">Antrian</label>
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
                        @foreach ($serviceDevice as $device)
                            <option value="{{ $device->name }}">{{ $device->name }}
                            </option>
                        @endforeach
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
                    <textarea type="text" class="form-control shadow-none" id="catatan" name="catatan" required>
Tanggal Pembelian:
Kelengkapan:</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/service/tambahData.js') }}"></script>
@endpush
