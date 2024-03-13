@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container w-50 p-3">
        <div class="row addDataForms">
            <div class="d-flex justify-content-between mb-2">
                <h1 class="h3 mb-3 text-gray-800">Lihat Data Service Antrian Pelanggan</h1>
                <div class="d-flex align-items-center gap-3">
                    <a href="/service/antrianPelanggan" class="btn btn-danger btn-sm font-weight-bold text-white">
                        Back
                    </a>
                </div>
            </div>
            <hr style="width: -webkit-fill-available;">
            <div class="form-group">
                <label for="pemilik" class="form-label font-weight-bold">Pemilik</label>
                <input type="text" class="form-control shadow-none" id="pemilik" name="pemilik"
                    value="{{ $service->pemilik }}" readonly>
            </div>
            <div class="form-group">
                <label for="pelanggan" class="form-label font-weight-bold">Pelanggan</label>
                <input type="text" class="form-control shadow-none" id="pelanggan" name="pelanggan"
                    value="{{ $service->pelanggan }}" readonly>
            </div>
            <div class="form-group">
                <label for="device" class="form-label font-weight-bold">Tipe Device</label>
                <input type="text" class="form-control shadow-none" id="device" name="device"
                    value="{{ $service->device }}" readonly>
            </div>
            <div class="form-group">
                <label for="serialnumber" class="form-label font-weight-bold">Serial Number</label>
                <input type="text" class="form-control shadow-none" id="serialnumber" name="serialnumber"
                    value="{{ $service->serialnumber }}" readonly>
            </div>
            <div class="form-group">
                <label for="pemakaian" class="form-label font-weight-bold">Pemakaian</label>
                <input type="text" class="form-control shadow-none" id="pemakaian" name="pemakaian"
                    value="{{ $service->pemakaian }}" readonly>
            </div>
            <div class="form-group">
                <label for="kerusakan" class="form-label font-weight-bold">Kerusakan</label>
                <textarea class="form-control shadow-none" id="kerusakan" name="kerusakan" rows="3" readonly>{{ $service->kerusakan }}</textarea>
            </div>
            <div class="form-group">
                <label for="tanggalmasuk" class="form-label font-weight-bold">Tanggal Masuk</label>
                <input type="date" class="form-control shadow-none" id="tanggalmasuk" name="tanggalmasuk"
                    value="{{ $service->tanggalmasuk }}" readonly>
            </div>
            <div class="form-group">
                <label for="catatan" class="form-label font-weight-bold">Catatan</label>
                <textarea class="form-control shadow-none" id="catatan" name="catatan" rows="3" readonly>{{ $service->catatan }}</textarea>
            </div>
        </div>
    </div>
@endsection
