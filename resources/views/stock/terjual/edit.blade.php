@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container w-50 p-3">
        <div class="row addDataForms">
            <div class="d-flex justify-content-between mb-2">
                <h1 class="h3 mb-3 text-gray-800">Edit Data Barang Terjual</h1>
                <div class="d-flex align-items-center gap-3">
                    <a href="/stock/terjual" class="btn btn-danger btn-sm font-weight-bold text-white">
                        Back
                    </a>
                </div>
            </div>
            <hr style="width: -webkit-fill-available;">
            <form method="POST" action="{{ route('stock.updateTerjual', $stock->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="serialnumber" class="form-label font-weight-bold">Serial Number</label>
                    <input type="text" class="form-control shadow-none" id="serialnumber" name="serialnumber"
                        value="{{ $stock->serialnumber }}">
                </div>
                <div class="form-group mb-3">
                    <label class="font-weight-bold" for="tipe">Tipe Device</label><br />
                    <select id="tipe" class="form-control form-control-chosen shadow-none" name="tipe" required>
                        <option value="Null">Pilih Tipe Device</option>
                        @foreach ($stockDevice as $device)
                            <option value="{{ $device->name }}" {{ $stock->tipe == $device->name ? 'selected' : '' }}>
                                {{ $device->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label class="font-weight-bold" for="sku">SKU</label><br />
                    <select id="sku" class="form-control form-control-chosen shadow-none" name="sku" required>
                        <option value="Null">Pilih SKU</option>
                        @foreach ($stockDevice as $device)
                            <option value="{{ $device->name }}" {{ $stock->sku == $device->name ? 'selected' : '' }}>
                                {{ $device->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="noinvoice" class="form-label font-weight-bold">No Invoice</label>
                    <input type="text" class="form-control shadow-none" id="noinvoice" name="noinvoice"
                        value="{{ $stock->noinvoice }}">
                </div>
                <div class="mb-3">
                    <label for="tanggalmasuk" class="form-label font-weight-bold">Tanggal Masuk</label>
                    <input type="date" class="form-control shadow-none" id="tanggalmasuk" name="tanggalmasuk"
                        value="{{ $stock->tanggalmasuk }}">
                </div>
                <div class="mb-3">
                    <label for="tanggalkeluar" class="form-label font-weight-bold">Tanggal Keluar</label>
                    <input type="date" class="form-control shadow-none" id="tanggalkeluar" name="tanggalkeluar"
                        value="{{ $stock->tanggalkeluar }}">
                </div>
                <div class="mb-3">
                    <label for="pelanggan" class="form-label font-weight-bold">Pelanggan</label>
                    <input type="text" class="form-control shadow-none" id="pelanggan" name="pelanggan"
                        value="{{ $stock->pelanggan }}">
                </div>
                <div class="form-group mb-3">
                    <label class="font-weight-bold" for="lokasi">Lokasi</label><br />
                    <select id="lokasi" class="form-control form-control-chosen shadow-none" name="lokasi" required>
                        <option value="Null">Pilih Lokasi</option>
                        @foreach ($stockLokasi as $lok)
                            <option value="{{ $lok->name }}" {{ $stock->lokasi == $lok->name ? 'selected' : '' }}>
                                {{ $lok->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label font-weight-bold">Keterangan</label>
                    <input type="text" class="form-control shadow-none" id="keterangan" name="keterangan"
                        value="{{ $stock->keterangan }}">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Status</label><br />
                    <div class="form-check form-check-inline">
                        <input class="form-check-input mt-1" type="radio" id="gudang" name="status" value="Gudang"
                            {{ in_array('Gudang', explode(',', $stock->status)) ? 'checked' : '' }}>
                        <label class="form-check-label" for="gudang">Gudang</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input mt-1" type="radio" id="service" name="status" value="Service"
                            {{ in_array('Service', explode(',', $stock->status)) ? 'checked' : '' }}>
                        <label class="form-check-label" for="service">Service</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input mt-1" type="radio" id="dipinjam" name="status" value="Dipinjam"
                            {{ in_array('Dipinjam', explode(',', $stock->status)) ? 'checked' : '' }}>
                        <label class="form-check-label" for="dipinjam">Dipinjam</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input mt-1" type="radio" id="terjual" name="status"
                            value="Terjual" {{ in_array('Terjual', explode(',', $stock->status)) ? 'checked' : '' }}>
                        <label class="form-check-label" for="terjual">Terjual</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection
