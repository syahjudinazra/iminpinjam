@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container w-50 p-3">
        <div class="row addDataForms">
            <div class="d-flex justify-content-between mb-2">
                <h1 class="h3 mb-3 text-gray-800">Lihat Data Barang Gudang</h1>
                <div class="d-flex align-items-center gap-3">
                    <a href="/stock/gudang" class="btn btn-danger btn-sm font-weight-bold text-white">
                        Back
                    </a>
                </div>
            </div>
            <hr style="width: -webkit-fill-available;">
            <div class="form-group">
                <label for="serialnumber" class="form-label font-weight-bold">Serial
                    Number</label>
                <input type="text" class="form-control shadow-none" id="serialnumber" name="serialnumber"
                    value="{{ $stock->serialnumber }}" readonly>
            </div>
            <div class="form-group">
                <label for="tipe" class="form-label font-weight-bold">Tipe
                    Device</label>
                <input type="text" class="form-control shadow-none" id="tipe" name="tipe"
                    value="{{ $stock->tipe }}" readonly>
            </div>
            <div class="form-group">
                <label for="sku" class="form-label font-weight-bold">SKU</label>
                <input type="text" class="form-control shadow-none" id="sku" name="sku"
                    value="{{ $stock->sku }}" readonly>
            </div>
            <div class="form-group">
                <label for="noinvoice" class="form-label font-weight-bold">No
                    Invoice</label>
                <input type="text" class="form-control shadow-none" id="noinvoice" name="noinvoice"
                    value="{{ $stock->noinvoice }}" readonly>
            </div>
            <div class="form-group">
                <label for="tanggalmasuk" class="form-label font-weight-bold">
                    Tanggal Masuk</label>
                <input type="date" class="form-control shadow-none" id="tanggalmasuk" name="tanggalmasuk"
                    value="{{ $stock->tanggalmasuk }}" readonly>
            </div>
            <div class="form-group">
                <label for="tanggalkeluar" class="form-label font-weight-bold">
                    Tanggal Keluar</label>
                <input type="date" class="form-control shadow-none" id="tanggalkeluar" name="tanggalkeluar"
                    value="{{ $stock->tanggalkeluar }}" readonly>
            </div>
            <div class="form-group">
                <label for="pelanggan" class="form-label font-weight-bold">
                    Pelanggan</label>
                <input type="text" class="form-control shadow-none" id="pelanggan" name="pelanggan"
                    value="{{ $stock->pelanggan }}" readonly>
            </div>
            <div class="form-group">
                <label for="lokasi" class="form-label font-weight-bold">
                    Lokasi</label>
                <input type="text" class="form-control shadow-none" id="lokasi" name="lokasi"
                    value="{{ $stock->lokasi }}" readonly>
            </div>
            <div class="form-group">
                <label for="keterangan" class="form-label font-weight-bold">Keterangan</label>
                <textarea class="form-control shadow-none" id="keterangan" name="keterangan" readonly>{{ $stock->keterangan }}</textarea>
            </div>
            <div class="form-group">
                <label for="status" class="form-label font-weight-bold">
                    Status</label>
                <input type="text" class="form-control shadow-none" id="status" name="status"
                    value="{{ $stock->status }}" readonly>
            </div>
        </div>
    </div>
    </div>
@endsection
