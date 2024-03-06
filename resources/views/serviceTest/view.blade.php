@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container w-50 p-3">
        <div class="row addDataForms">
            <div class="d-flex justify-content-between mb-2">
                <h1 class="h3 mb-3 text-gray-800">Lihat Data Service</h1>
                <div class="d-flex align-items-center gap-3">
                    <a href="/serviceTest" class="btn btn-danger btn-sm font-weight-bold text-white">
                        Back
                    </a>
                </div>
            </div>
            <hr style="width: -webkit-fill-available;">
            <div class="form-group">
                <label for="pemilik" class="form-label font-weight-bold">Pemilik</label>
                <input type="text" class="form-control shadow-none" id="pemilik" name="pemilik"
                    value="{{ $serviceTest->pemilik }}" readonly>
            </div>
            <div class="form-group">
                <label for="pelanggan" class="form-label font-weight-bold">Pelanggan</label>
                <input type="text" class="form-control shadow-none" id="pelanggan" name="pelanggan"
                    value="{{ $serviceTest->pelanggan }}" readonly>
            </div>
            <div class="form-group">
                <label for="device" class="form-label font-weight-bold">Tipe Device</label>
                <input type="text" class="form-control shadow-none" id="device" name="device"
                    value="{{ $serviceTest->device }}" readonly>
            </div>
            <div class="form-group">
                <label for="serialnumber" class="form-label font-weight-bold">Serial Number</label>
                <input type="text" class="form-control shadow-none" id="serialnumber" name="serialnumber"
                    value="{{ $serviceTest->serialnumber }}" readonly>
            </div>
            <div class="form-group">
                <label for="pemakaian" class="form-label font-weight-bold">Pemakaian</label>
                <input type="text" class="form-control shadow-none" id="pemakaian" name="pemakaian"
                    value="{{ $serviceTest->pemakaian }}" readonly>
            </div>
            <div class="form-group">
                <label for="kerusakan" class="form-label font-weight-bold">Kerusakan</label>
                <textarea class="form-control shadow-none" id="kerusakan" name="kerusakan" rows="3" readonly>{{ $serviceTest->kerusakan }}</textarea>
            </div>
            <div class="form-group">
                <label for="perbaikan" class="form-label font-weight-bold">Perbaikan</label>
                <textarea class="form-control shadow-none" id="perbaikan" name="perbaikan" rows="3" readonly>{{ $serviceTest->perbaikan }}</textarea>
            </div>
            <div class="form-group">
                <label for="teknisi" class="form-label font-weight-bold">Teknisi</label>
                <input type="text" class="form-control shadow-none" id="teknisi" name="teknisi"
                    value="{{ $serviceTest->teknisi }}" readonly>
            </div>
            <div class="form-group">
                <label for="nosparepart" class="form-label font-weight-bold">No SparePart</label>
                <input type="text" class="form-control shadow-none" id="nosparepart" name="nosparepart"
                    value="{{ $serviceTest->nosparepart }}" readonly>
            </div>
            <div class="form-group">
                <label for="snkanibal" class="form-label font-weight-bold">SN Kanibal</label>
                <input type="text" class="form-control shadow-none" id="snkanibal" name="snkanibal"
                    value="{{ $serviceTest->snkanibal }}" readonly>
            </div>
            <div class="form-group">
                <label for="tanggalmasuk" class="form-label font-weight-bold">Tanggal Masuk</label>
                <input type="date" class="form-control shadow-none" id="tanggalmasuk" name="tanggalmasuk"
                    value="{{ $serviceTest->tanggalmasuk }}" readonly>
            </div>
            <div class="form-group">
                <label for="tanggalkeluar" class="form-label font-weight-bold">Tanggal Selesai</label>
                <input type="date" class="form-control shadow-none" id="tanggalkeluar" name="tanggalkeluar"
                    value="{{ $serviceTest->tanggalkeluar }}" readonly>
            </div>
            <div class="form-group">
                <label for="catatan" class="form-label font-weight-bold">Catatan</label>
                <textarea class="form-control shadow-none" id="catatan" name="catatan" rows="3" readonly>{{ $serviceTest->catatan }}</textarea>
            </div>
        </div>
    </div>
@endsection
