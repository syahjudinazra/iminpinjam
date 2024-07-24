@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container w-50 p-3">
        <div class="row addDataForms">
            <div class="d-flex justify-content-between mb-2">
                <h1 class="h3 mb-3 text-gray-800">Edit Data Barang Dipinjam</h1>
                <div class="d-flex align-items-center gap-3">
                    <a href="/pinjam/Dipinjam" class="btn btn-danger btn-sm font-weight-bold text-white">
                        Back
                    </a>
                </div>
            </div>
            <hr style="width: -webkit-fill-available;">
            <form method="POST" action="{{ route('pinjam.updateDipinjam', $pinjam->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="tanggal" class="form-label font-weight-bold">Tanggal</label>
                    <input type="date" class="form-control shadow-none" id="tanggal" name="tanggal"
                        value="{{ $pinjam->tanggal }}">
                </div>
                <div class="mb-3">
                    <label for="serialnumber" class="form-label font-weight-bold">Serial Number</label>
                    <input type="text" class="form-control shadow-none" id="serialnumber" name="serialnumber"
                        value="{{ $pinjam->serialnumber }}">
                </div>
                <div class="form-group mb-3">
                    <label class="font-weight-bold" for="device">Device</label>
                    <select class="form-select form-control-chosen shadow-none" name="device" id="device" required>
                        <option value="Null">Pilih Model</option>
                        @foreach ($pinjamsDevice as $device)
                            <option value="{{ $device->name }}" {{ $pinjam->device == $device->name ? 'selected' : '' }}>
                                {{ $device->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="ram" class="form-label font-weight-bold">RAM</label>
                    <input type="text" class="form-control shadow-none" id="ram" name="ram"
                        value="{{ $pinjam->ram }}">
                </div>
                <div class="mb-3">
                    <label for="android" class="form- font-weight-bold">Android</label>
                    <input type="text" class="form-control shadow-none" id="android" name="android"
                        value="{{ $pinjam->android }}">
                </div>
                <div class="mb-3">
                    <label for="customer" class="form-label font-weight-bold">Customer</label>
                    <input type="text" class="form-control shadow-none" id="customer" name="customer"
                        value="{{ $pinjam->customer }}">
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label font-weight-bold">Alamat</label>
                    <textarea class="form-control shadow-none" id="alamat" name="alamat" rows="3">{{ $pinjam->alamat }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="sales" class="form-label font-weight-bold">Sales</label>
                    <input type="text" class="form-control shadow-none" id="sales" name="sales"
                        value="{{ $pinjam->sales }}">
                </div>
                <div class="mb-3">
                    <label for="telp" class="form-label font-weight-bold">No Telp</label>
                    <input type="number" class="form-control shadow-none" id="telp" name="telp"
                        value="{{ $pinjam->telp }}">
                </div>
                <div class="mb-3">
                    <label for="pengirim" class="form-label font-weight-bold">Pengirim</label>
                    <input type="text" class="form-control shadow-none" id="pengirim" name="pengirim"
                        value="{{ $pinjam->pengirim }}">
                </div>
                <div class="mb-3">
                    <label for="kelengkapankirim" class="form-label font-weight-bold">Kelengkapan
                        Kirim</label>
                    <textarea class="form-control shadow-none" id="kelengkapankirim" name="kelengkapankirim" rows="3">{{ $pinjam->kelengkapankirim }}</textarea>
                </div>
                <div class="mb-3" hidden>
                    <label for="status" class="form-label font-weight-bold">Status</label>
                    <input type="text" class="form-control shadow-none" id="status" name="status"
                        value="{{ $pinjam->status }}" readonly>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection
