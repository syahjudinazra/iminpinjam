@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container w-50 p-3">
        <div class="row addDataForms">
            <div class="d-flex justify-content-between mb-2">
                <h1 class="h3 mb-3 text-gray-800">Lihat Data Barang Dikembalikan</h1>
                <div class="d-flex align-items-center gap-3">
                    <a href="/pinjam/kembali" class="btn btn-danger btn-sm font-weight-bold text-white">
                        Back
                    </a>
                </div>
            </div>
            <hr style="width: -webkit-fill-available;">
            <div class="form-group">
                <label for="tanggal" class="form- font-weight-bold">Tanggal</label>
                <input type="date" class="form-control shadow-none" id="tanggal" name="tanggal"
                    value="{{ $pinjam->tanggal }}" readonly>
            </div>
            <div class="form-group">
                <label for="serialnumber" class="form-label font-weight-bold">Serial Number</label>
                <input type="text" class="form-control shadow-none" id="serialnumber" name="serialnumber"
                    value="{{ $pinjam->serialnumber }}" readonly>
            </div>
            <div class="form-group">
                <label for="device" class="form-label font-weight-bold">Device</label>
                <input type="text" class="form-control shadow-none" id="device" name="device"
                    value="{{ $pinjam->device }}" readonly>
            </div>
            <div class="form-group">
                <label for="ram" class="form-label font-weight-bold">RAM</label>
                <input type="text" class="form-control shadow-none" id="ram" name="ram"
                    value="{{ $pinjam->ram }}" readonly>
            </div>
            <div class="form-group">
                <label for="android" class="form-label font-weight-bold">Android</label>
                <input type="text" class="form-control shadow-none" id="android" name="android"
                    value="{{ $pinjam->android }}" readonly>
            </div>
            <div class="form-group">
                <label for="customer" class="form-label font-weight-bold">Customer</label>
                <input type="text" class="form-control shadow-none" id="customer" name="customer"
                    value="{{ $pinjam->customer }}" readonly>
            </div>
            <div class="form-group">
                <label for="alamat" class="form-label font-weight-bold">Alamat</label>
                <textarea class="form-control shadow-none" id="alamat" name="alamat" rows="3" readonly>{{ $pinjam->alamat }}</textarea>
            </div>
            <div class="form-group">
                <label for="sales" class="form-label font-weight-bold">Sales</label>
                <input type="text" class="form-control shadow-none" id="sales" name="sales"
                    value="{{ $pinjam->sales }}" readonly>
            </div>
            <div class="form-group">
                <label for="telp" class="form-label font-weight-bold">No Telp</label>
                <input type="number" class="form-control shadow-none" id="telp" name="telp"
                    value="{{ $pinjam->telp }}" readonly>
            </div>
            <div class="form-group">
                <label for="pengirim" class="form-label font-weight-bold">Pengirim</label>
                <input type="text" class="form-control shadow-none" id="pengirim" name="pengirim"
                    value="{{ $pinjam->pengirim }}" readonly>
            </div>
            <div class="form-group">
                <label for="kelengkapankirim" class="form-label font-weight-bold">Kelengkapan Kirim</label>
                <textarea class="form-control shadow-none" id="kelengkapankirim" name="kelengkapankirim" rows="3" readonly>{{ $pinjam->kelengkapankirim }}</textarea>
            </div>
            <div class="form-group">
                <label for="tanggalkembali" class="form-label font-weight-bold">Tanggal Kembali</label>
                <input type="date" class="form-control shadow-none" id="tanggalkembali" name="tanggalkembali"
                    value="{{ $pinjam->tanggalkembali }}" readonly>
            </div>
            <div class="form-group">
                <label for="penerima" class="form-label font-weight-bold">Penerima</label>
                <input type="text" class="form-control shadow-none" id="penerima" name="penerima"
                    value="{{ $pinjam->penerima }}" readonly>
            </div>
            <div class="form-group">
                <label for="kelengkapankembali" class="form-label font-weight-bold">Kelengkapan
                    Kembali</label>
                <textarea class="form-control shadow-none" id="kelengkapankembali" name="kelengkapankembali" rows="3"
                    readonly>{{ $pinjam->kelengkapankembali }}</textarea>
            </div>
        </div>
    </div>
    </div>
@endsection
